<?php

namespace App\Livewire\Admin\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
class ProfilePhoto extends Component
{

    use WithFileUploads;
    public $profile;

    protected $listeners = ['ProfileUploadPage'=>'$refresh'];
    public function render(){
        return view('livewire.admin.profile.profile-photo');
    }

    public function ProfileUpload(){

        $this->validate([
            'profile' => 'required|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        \Image::removeFile('admin/',\Content::adminInfo()->profile);

        $profileName = \Image::autoheight('admin/',$this->profile);

        $data = \App\Models\Admin::find(\Content::adminInfo()->id);
        $data->profile = $profileName;
        $data->save();
        $this->dispatch('ProfilePhotoRefresh');
        $this->dispatch('ProfileUploadPage');
        $this->reset('profile');
        $this->dispatch('successtoaster',['title'=>'Updated!','message'=>'Your profile photo has been updated!']);
    }
}
