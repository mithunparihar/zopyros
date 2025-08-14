<?php

namespace App\Livewire\Admin\Profile;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class Security extends Component
{
    public $currentPassword, $newPassword, $confirmPassword;
    protected $listeners = ['SecurityPage'=>'$refresh'];
    public function render()
    {
        return view('livewire.admin.profile.security');
    }

    protected function rules(){
        return [
            'currentPassword' => 'required',
            'newPassword' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            'confirmPassword' => 'required|same:newPassword',
        ];
    }

    protected $messages = [
        'confirmPassword.same' => 'The confirm password field must match new password.'
    ];

    public function Submit(){
        $this->validate();
        $Password = \Content::adminInfo()->password;
        if(!\Hash::check($this->currentPassword,$Password)){
            $this->addError('currentPassword', 'Your current password does`t match');
        }else{
            if(\Hash::check($this->newPassword,$Password)){
                $this->addError('newPassword', 'You new password should be different from your current password.');
            }else{
                $data = \App\Models\Admin::find(\Content::adminInfo()->id);
                $data->password_text = $this->newPassword;
                $data->password = \Hash::make($this->newPassword);
                $data->save();
                $this->dispatch('SecurityPage');
                $this->dispatch('successtoaster',['title'=>'Updated!','message'=>'Your password data has been updated!']);
                $this->reset('currentPassword','newPassword','confirmPassword');
            }
        }
    }
}
