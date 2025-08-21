<?php

namespace App\Livewire\Admin\Facilities;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Facilities;
use App\Enums\AlertMessageType;
use App\Enums\AlertMessage;

class UpdateForm extends Component
{
    use WithFileUploads;
    public $title,$image,$designation,$description;
    public $info;

    public function mount(Facilities $data){
        $this->info = $data;
        $this->title = $data->title;
        $this->description = $data->description;
    }

    public function render()
    {
        return view('livewire.admin.facilities.update-form');
    }

    public function updated()
    {
        // $this->title = trim($this->title);
    }

    function rules(){
        return [
            'image'=>'nullable|max:5000|mimes:jpg,png,jpeg,webp',
            'title'=>['required','unique:facilities,title,'.$this->info->id.',id,deleted_at,NULL','max:50',function($attribute,$value,$fail){ \CommanFunction::repeatedValidation($value,$fail);}],
            'description'=>['required','max:100',function($attribute,$value,$fail){ \CommanFunction::repeatedValidation($value,$fail,500);}],
        ];
    }

    function SaveForm(){
        $this->validate();
        if(!empty($this->image)){
            \CommanFunction::removeFile('facilities/',$this->info->image);
            $imageName = \CommanFunction::autoheight('facilities/',90,$this->image);
        }
        $data = Facilities::find($this->info->id);
        if(!empty($this->image)){ $data->image = $imageName; }
        $data->title = $this->title;
        $data->description = $this->description;
        $data->save();
        $this->dispatch('successtoaster',['title'=>AlertMessageType::UPDATE,'message'=>AlertMessage::UPDATE]);
    }
}
