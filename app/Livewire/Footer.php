<?php
namespace App\Livewire;

use App\Events\Subscribe as SubscribeEvent;
use App\Models\Subscribe;
use App\Rules\EmailRule;
use Livewire\Component;

class Footer extends Component
{
    public $categories = [];
    public $icons=[];
    public $subscribe_email;

    public function mount()
    {
        $this->categories = \App\Models\Category::active()->footer()->get();
        $this->icons = \App\Models\SocialMedia::active()->get();
    }
    public function render()
    {
        return view('livewire.footer');
    }

    public function rules()
    {
        return [
            'subscribe_email' => [
                'required',
                'unique:subscribes,email,NULL,id,deleted_at,NULL',
                'max:74',
                'regex:/^[a-zA-Z0-9.@]+$/u',
                'regex:/(.+)@(.+)\.(.+)/i',
                new EmailRule()],
        ];
    }

    public function saveSubscribe()
    {
        $this->validate();

        $data        = new Subscribe();
        $data->email = $this->subscribe_email;
        $data->save();
        SubscribeEvent::dispatch($data);

        return redirect()->route('thankyou.subscribe');
    }
}
