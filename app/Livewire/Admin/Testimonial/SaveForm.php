<?php

namespace App\Livewire\Admin\Testimonial;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Testimonial;
use App\Enums\AlertMessageType;
use App\Enums\AlertMessage;
use App\Rules\EditorRule;
use App\Rules\TextRule;

class SaveForm extends Component
{
    use WithFileUploads;
    public $title,$image,$designation,$description;
    protected $listeners = ['updateEditorValue' => 'updateEditorValue'];
    public function updateEditorValue($modelId, $content)
    {
        if ($modelId == 'description') {
            $this->description = $content;
        }
    }
    public function render()
    {
        return view('livewire.admin.testimonial.save-form');
    }

    function rules(){
        return [
            'image'=>['required','max:5000','mimes:jpg,png,jpeg,webp'],
            'title'=>['required','regex:/^([a-zA-Z\s])+$/u','max:100',new TextRule()],
            'description'=>['required',new EditorRule()],
            'designation'=>['required']
        ];
    }

    protected $validationAttributes=[
        'designation' => 'rating'
    ];

    function SaveForm(){
        $this->validate();
        $imageName = \Image::autoheight('testimonial/',$this->image);
        $data = new Testimonial();
        $data->image = $imageName;
        $data->title = $this->title;
        $data->designation = $this->designation;
        $data->description = $this->description;
        $data->save();
        $this->reset(['image','title','description','designation']);
        $this->dispatch('emptyEditor');
        $this->dispatch('successtoaster',['title'=>AlertMessageType::SAVE,'message'=>AlertMessage::SAVE]);
    }
}
