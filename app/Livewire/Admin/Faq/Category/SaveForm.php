<?php

namespace App\Livewire\Admin\Faq\Category;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\FaqCategory;
use Livewire\Component;
use App\Rules\EditorRule;
use App\Rules\TextRule;

class SaveForm extends Component
{
    public $title, $heading, $description;
    public $meta_title, $meta_keywords, $meta_description;
    public $parentInfo;
    protected $listeners = ['updateEditorValue' => 'updateEditorValue'];
    public function updateEditorValue($modelId, $content)
    {
        if ($modelId == 'description') {
            $this->description = $content;
        }
    }
    public function mount($parent = 0)
    {
        if ($parent > 0) {
            $this->parentInfo = FaqCategory::find($parent);
        }
    }

    public function render()
    {
        return view('livewire.admin.faq.category.save-form');
    }

    public function rules()
    {
        return [
            'title' => ['required', 'max:100', 'unique:faq_categories,title,NULL,id,deleted_at,NULL,parent_id,' . ($this->parentInfo->id ?? 0),new TextRule()],
            'heading' => ['required', 'max:200',new TextRule()],
            'description' => ['required', new EditorRule()],
            'meta_title' => ['nullable', 'max:100',new TextRule()],
            'meta_keywords' => ['nullable', 'max:300',new TextRule()],
            'meta_description' => ['nullable', 'max:300',new TextRule()],
        ];
    }

    public function validationAttributes()
    {
        return [
            'title' => 'category name',
        ];
    }

    public function SaveForm()
    {
        $this->validate();
        $data = new FaqCategory();
        $data->parent_id = $this->parentInfo->id ?? 0;
        $data->title = $this->title;
        $data->alias = $this->title;
        $data->heading = $this->heading;
        $data->description = $this->description;
        $data->meta_title = !empty($this->meta_title) ? $this->meta_title : NULL;
        $data->meta_keywords = !empty($this->meta_keywords) ? $this->meta_keywords : NULL;
        $data->meta_description = !empty($this->meta_description) ? $this->meta_description : NULL;
        $data->save();
        $this->dispatch('emptyEditor');
        $this->reset(['title', 'heading', 'description', 'meta_title', 'meta_keywords', 'meta_description']);
        $this->dispatch('successtoaster', ['title' => AlertMessageType::SAVE, 'message' => AlertMessage::SAVE]);
    }
}
