<?php

namespace App\Livewire\Admin\Career;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Career;
use App\Enums\AlertMessageType;
use App\Enums\AlertMessage;
use App\Rules\EditorRule;
use App\Rules\TextRule;

class SaveForm extends Component
{
    use WithFileUploads;
    public $title,$location,$salary,$job_type,$short_description,$designation,$description;
    public $meta_description, $meta_keywords, $meta_title;
    protected $listeners = ['updateEditorValue' => 'updateEditorValue'];
    public function render()
    {
        return view('livewire.admin.career.save-form');
    }
    public function updateEditorValue($modelId, $content)
    {
        if ($modelId == 'description') {
            $this->description = $content;
        }
    }


    function rules(){
        return [
            'title'=>['required','unique:careers,alias,NULL,id,deleted_at,NULL','max:100',new TextRule()],
            'description'=>['required',new EditorRule()],
            'designation'=>['required','regex:/^([a-zA-Z\s])+$/u','max:100',new TextRule()],
            'location'=>['required','regex:/^([a-zA-Z\s])+$/u','max:100',new TextRule()],
            'salary'=>['required','max:50',new TextRule()],
            'job_type'=>['required','regex:/^([a-zA-Z\s])+$/u','max:20',new TextRule()],
            'short_description'=>['required','max:300',new TextRule()],
            'meta_title' => ['nullable', 'max:200',new TextRule()],
            'meta_keywords' => ['nullable', 'max:500',new TextRule()],
            'meta_description' => ['nullable', 'max:500',new TextRule()],
        ];
    }

    function SaveForm(){
        $this->validate();
        $data = new Career();
        $data->title = $this->title;
        $data->alias = $this->title;
        $data->location = $this->location;
        $data->salary = $this->salary ?? 0;
        $data->job_type = $this->job_type;
        $data->short_description = $this->short_description;
        $data->designation = $this->designation;
        $data->description = $this->description;
        $data->meta_title = !empty($this->meta_title) ? $this->meta_title : null;
        $data->meta_keywords = !empty($this->meta_keywords) ? $this->meta_keywords : null;
        $data->meta_description = !empty($this->meta_description) ? $this->meta_description : null;
        $data->sequence = (Career::max('sequence') + 1);
        $data->save();
        $this->reset(['location','title','salary','job_type','short_description','description','designation']);
        $this->dispatch('emptyEditor');
        $this->dispatch('successtoaster',['title'=>AlertMessageType::SAVE,'message'=>AlertMessage::SAVE]);
    }
}
