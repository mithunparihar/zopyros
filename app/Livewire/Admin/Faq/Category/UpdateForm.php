<?php

namespace App\Livewire\Admin\Faq\Category;

use Livewire\Component;
use App\Models\FaqCategory;
use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Rules\EditorRule;
use App\Rules\TextRule;

class UpdateForm extends Component
{
    public $title,$alias,$info;
    public $heading,$description;
    public $meta_title, $meta_keywords, $meta_description;
    protected $listeners = ['refreshFaqCategoryEdit'=>'mount','updateEditorValue' => 'updateEditorValue'];
    public function updateEditorValue($modelId, $content)
    {
        if ($modelId == 'description') {
            $this->description = $content;
        }
    }
    public function mount(FaqCategory $data){
        $this->info = $data;
        $this->title = $data->title;
        $this->alias = $data->alias;
        $this->heading = $data->heading;
        $this->description = $data->description;
        $this->meta_title = $data->meta_title;
        $this->meta_keywords = $data->meta_keywords;
        $this->meta_description = $data->meta_description;
    }

    public function render()
    {
        return view('livewire.admin.faq.category.update-form');
    }

    function rules(){
        return [
            'title'=>['required','max:100','unique:faq_categories,title,'.$this->info->id.',id,deleted_at,NULL',new TextRule()],
            'heading' => ['required', 'max:200',new TextRule()],
            'description'=>['required',new EditorRule()],
            'meta_title'=>['nullable','max:100',new TextRule()],
            'meta_keywords'=>['nullable','max:300',new TextRule()],
            'meta_description'=>['nullable','max:300',new TextRule()],
        ];
    }


    function validationAttributes(){
        return [
            'title'=>'category name'
        ];
    }

    function SaveForm(){
        $this->validate();
        $data = FaqCategory::findOrFail($this->info->id);
        $data->title = $this->title;
        $data->alias = $this->alias;
        $data->heading = $this->heading;
        $data->description = $this->description;
        $data->meta_title = !empty($this->meta_title) ? $this->meta_title : null;
        $data->meta_keywords = !empty($this->meta_keywords) ? $this->meta_keywords : null;
        $data->meta_description = !empty($this->meta_description) ? $this->meta_description : null;
        $data->save();
        $this->dispatch('refreshFaqCategoryEdit',data:$data->id);
        $this->dispatch('successtoaster',['title'=>AlertMessageType::UPDATE,'message'=>AlertMessage::UPDATE]);
    }
}
