<?php

namespace App\Livewire\Admin\Service\Category;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\ServiceCategory as Category;
use App\Rules\EditorRule;
use App\Rules\TextRule;
use Livewire\Component;
use Livewire\WithFileUploads;

class SaveForm extends Component
{
    use WithFileUploads;
    public $title, $description, $image, $short_description;
    public $meta_description, $meta_keywords, $meta_title, $clubs;
    public $parent;
    protected $listeners = ['updateEditorValue' => 'updateEditorValue'];
    public function mount($parent)
    {
        $this->parent = 0;
        if ($parent > 0) {
            $this->parent = $parent;
        }
    }
    public function updateEditorValue($modelId, $content)
    {
        if ($modelId == 'description') {
            $this->description = $content;
        }
    }
    public function render()
    {
        return view('livewire.admin.service.category.save-form');
    }

    public function updated()
    {
        // $this->title = trim($this->title);
    }

    public function rules()
    {
        return [
            'image' => 'required|max:5000|mimes:jpg,png,jpeg,webp',
            'title' => ['required', 'unique:service_categories,title,NULL,id,deleted_at,NULL', 'max:50', new TextRule()],
            'description' => ['required', new EditorRule()],
            'short_description' => ['required', 'max:500', new TextRule()],
            'meta_title' => ['nullable', 'max:200', new TextRule()],
            'meta_keywords' => ['nullable', 'max:500', new TextRule()],
            'meta_description' => ['nullable', 'max:500', new TextRule()],
        ];
    }

    public function validationAttributes()
    {
        return [
            'title' => 'category name',
            'image' => 'thumb image',
            'banner' => 'image',
        ];
    }

    public function SaveForm()
    {
        $this->validate();
        $imageName = \Image::autoheight('service/category/', 250, $this->image);
        $data = new Category();
        $data->image = $imageName;
        $data->title = $this->title;
        $data->slug = $this->title;
        $data->description = $this->description;
        $data->short_description = $this->short_description;
        $data->meta_title = !empty($this->meta_title) ? $this->meta_title : $this->title;
        $data->meta_keywords = !empty($this->meta_keywords) ? $this->meta_keywords : $this->title;
        $data->meta_description = !empty($this->meta_description) ? $this->meta_description : $this->title;
        $data->parent_id = $this->parent;
        $data->sequence = (Category::whereParentId($this->parent)->max('sequence') + 1);
        $data->save();
        $this->reset(['image', 'title', 'description', 'short_description', 'meta_title', 'meta_keywords', 'meta_description']);
        $this->dispatch('emptyEditor');
        $this->dispatch('successtoaster', ['title' => AlertMessageType::SAVE, 'message' => AlertMessage::SAVE]);
    }
}
