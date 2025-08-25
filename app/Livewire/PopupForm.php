<?php
namespace App\Livewire;

use App\Events\ContactEnquiry as ContactEnquiryEvent;
use App\Models\ContactEnquiry;
use App\Rules\EmailRule;
use App\Rules\NoDangerousTags;
use App\Rules\PhoneRule;
use App\Rules\TextRule;
use Livewire\Component;

class PopupForm extends Component
{
    public $name, $contact, $message, $email;
    public function render()
    {
        return view('livewire.popup-form');
    }

    public function rules()
    {
        return [
            'name'    => ['required', 'max:50', new NoDangerousTags(), new TextRule()],
            'contact' => ['required', 'integer', 'digits_between:8,12', new PhoneRule()],
            'message' => ['required', 'max:500', new NoDangerousTags(), new TextRule()],
            'email'   => [
                'required',
                'max:74',
                'regex:/^[a-zA-Z0-9.@]+$/u',
                'regex:/(.+)@(.+)\.(.+)/i',
                new EmailRule()],
        ];
    }

    public function saveContact()
    {
        $this->validate();
        $data          = new ContactEnquiry();
        $data->name    = $this->name;
        $data->phone   = $this->contact;
        $data->email   = $this->email;
        $data->message = $this->message;
        $data->save();

        ContactEnquiryEvent::dispatch($data);

        return redirect()->route('thankyou.contact');
    }
}
