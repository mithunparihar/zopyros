<?php

namespace App\Livewire\Admin\Profile;

use Livewire\Component;
use App\Rules\EmailRule;

class TwoStepsVerification extends Component
{
    public $verification_email;
    protected $listeners = ['TwoStepsVerificationPage'=>'$refresh','updateTwoFactorAuthentication'=>'disabledTwoFactorAuthentication'];
    public function mount(){
        $this->verification_email = \Content::adminInfo()->two_step_verification_email;
    }
    public function render()
    {
        return view('livewire.admin.profile.two-steps-verification');
    }

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    protected function rules(){
        return [
            'verification_email' => [
                'required',
                'max:74',
                new EmailRule(),
            ]
        ];
    }

    public function EnableTwoStep(){
        $this->validate();
        $data = \App\Models\Admin::find(\Content::adminInfo()->id);
        $data->two_step_verification_email = $this->verification_email;
        $data->two_step_verification = 1;
        $data->save();
        $this->reset('verification_email');
        flash()->addsuccess('Enabled two step verification!');
        return redirect()->route('admin.security');
    }

    public function disabledTwoFactorAuthentication(){
        $data = \App\Models\Admin::find(\Content::adminInfo()->id);
        $data->two_step_verification = 0;
        $data->save();
        flash()->addsuccess('Disabled two step verification!');
        return redirect()->route('admin.security');
    }
}
