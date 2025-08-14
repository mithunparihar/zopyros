<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class SocialMedia extends Component
{
    protected $listeners = ['socialmediaList'=>'$refresh'];
    public function render()
    {
        return view('livewire.admin.social-media',[
            'lists' => \App\Models\SocialMedia::all()
        ]);
    }

    public function editRecords($id){
        $this->dispatch('editRecordsData',id:$id);
    }

    public function DataStatus($status,$id){
        $data = \App\Models\SocialMedia::find($id);
        $data->is_publish = ($status==1?0:1);
        $data->save();
    }
}
