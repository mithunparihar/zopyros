<?php

namespace App\Livewire\Admin\Facilities;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Facilities;
use App\Enums\AlertMessageType;
use App\Enums\AlertMessage;

class SaveForm extends Component
{
    use WithFileUploads;
    public $title,$image,$description;
    public function render()
    {
        return view('livewire.admin.facilities.save-form');
    }

    function rules(){
        return [
            'image'=>'required|max:5000|mimes:jpg,png,jpeg,webp',
            'title'=>['required','unique:facilities,title,NULL,id,deleted_at,NULL','max:50',function($attribute,$value,$fail){ \CommanFunction::repeatedValidation($value,$fail);}],
            'description'=>['required','max:100',function($attribute,$value,$fail){ \CommanFunction::repeatedValidation($value,$fail,500);}],
        ];
    }

    public function updated()
    {
        // $this->title = trim($this->title);
    }

    function SaveForm(){
        $this->validate();
        $imageName = \CommanFunction::autoheight('facilities/',90,$this->image);
        $data = new Facilities();
        $data->image = $imageName;
        $data->title = $this->title;
        $data->description = $this->description;
        $data->save();
        $this->reset(['image','title','description']);
        $this->dispatch('emptyEditor');
        $this->dispatch('successtoaster',['title'=>AlertMessageType::SAVE,'message'=>AlertMessage::SAVE]);
    }
}
