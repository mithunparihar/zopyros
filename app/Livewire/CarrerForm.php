<?php
namespace App\Livewire;

use App\Events\CareerEnquiry as CareerEvent;
use App\Models\Career as CareerModel;
use App\Rules\EmailRule;
use App\Rules\NoDangerousTags;
use App\Rules\PhoneRule;
use App\Rules\TextRule;
use Livewire\Component;
use Livewire\WithFileUploads;

class CarrerForm extends Component
{
    use WithFileUploads;
    public $info;
    public $name, $phone, $message, $email;
    public $resume, $experience;
    public function mount(CareerModel $data)
    {
        $this->info = $data;
    }
    public function render()
    {
        return view('livewire.carrer-form');
    }

    protected function rules()
    {
        return [
            'email'      => [
                'required',
                'max:74',
                'regex:/^[a-zA-Z0-9.@]+$/u',
                'regex:/(.+)@(.+)\.(.+)/i',
                new EmailRule(),
            ],
            'experience' => ['required'],
            'resume'     => ['required', 'mimes:pdf', 'max:5000'],
            'phone'      => ['required', 'numeric', 'digits:10', new PhoneRule()],
            'name'       => ['required', 'regex:/^([a-zA-Z\s])+$/u', 'max:50', new TextRule(), new NoDangerousTags()],
            'message'    => ['required', 'max:300', new TextRule(), new NoDangerousTags()],
        ];
    }

    protected $validationAttributes = [
        'phone' => 'phone no',
    ];

    public function saveCareer()
    {
        $this->validate();

        \Image::makeDirctory('storage/resume/');

        $resumeName       = $this->resume->store('resume', 'public');
        $resumeName       = str_replace('resume/', '', $resumeName);
        $data             = new \App\Models\CareerEnquiry();
        $data->name       = $this->name;
        $data->phone      = $this->phone;
        $data->email      = $this->email;
        $data->resume     = $resumeName;
        $data->message    = $this->message;
        $data->experience = $this->experience;
        $data->save();
        CareerEvent::dispatch($data);
        return redirect()->route('thankyou.career');
    }
}
