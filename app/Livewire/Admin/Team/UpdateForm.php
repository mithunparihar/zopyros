<?php

namespace App\Livewire\Admin\Team;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Team;
use App\Enums\AlertMessageType;
use App\Enums\AlertMessage;
use App\Rules\TextRule;

class UpdateForm extends Component
{
    use WithFileUploads;
    public $title, $designation,$description, $image,$bio;
    public $info;
    protected $listeners = ['refreshPartnerEdit' => 'mount'];
    public function mount(Team $data){
        $this->info = $data;
        $this->title = $data->title;
        $this->designation = $data->designation;
        $this->description = $data->description;
    }

    public function render()
    {
        return view('livewire.admin.team.update-form');
    }

    function rules(){
        return [
            'image'=>'nullable|max:5000|mimes:jpg,png,jpeg,webp',
            'title'=>['required','regex:/^([-.a-zA-Z\s])+$/u', 'max:50',new TextRule()],
            'designation' => ['required','max:50',new TextRule()],
        ];
    }

    function SaveForm(){
        $this->validate();
        if(!empty($this->image)){
            \Image::removeFile('team/',$this->info->image);
            $imageName = \Image::autoheight('team/',$this->image);
        }
        $data = Team::find($this->info->id);
        if(!empty($this->image)){ $data->image = $imageName; }
        $data->title = $this->title;
        $data->designation = $this->designation;
        $data->save();
        $this->dispatch('successtoaster',['title'=>AlertMessageType::UPDATE,'message'=>AlertMessage::UPDATE]);
    }
}
