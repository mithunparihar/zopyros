<?php

namespace App\Livewire\Admin\Service\Category;

use App\Models\ServiceCategory as Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Rules\EditorRule;
use App\Rules\TextRule;
use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;

class UpdateForm extends Component
{
    use WithFileUploads;
    public $title, $description, $image, $short_description;
    public $meta_description, $meta_keywords, $meta_title, $alias;
    public $parent = 0, $info;
    protected $listeners = ['refreshCategoryEdit' => 'mount','updateEditorValue' => 'updateEditorValue'];
    public function mount(Category $data)
    {
        $this->info = $data;
        $this->parent = $data->parent_id;
        $this->alias = $data->slug;
        $this->title = $data->title;
        $this->description = $data->description;
        $this->short_description = $data->short_description;
        $this->meta_title = $data->meta_title;
        $this->meta_keywords = $data->meta_keywords;
        $this->meta_description = $data->meta_description;
    }
    public function render()
    {
        return view('livewire.admin.service.category.update-form');
    }

    public function updateEditorValue($modelId, $content)
    {
        if ($modelId == 'description') {
            $this->description = $content;
        }
    }

    public function rules()
    {
        return [
            'image' => 'nullable|required_if:info.image,null|max:5000|mimes:jpg,png,jpeg,webp',
            'title' => ['required', 'unique:service_categories,title,' . $this->info->id . ',id,deleted_at,NULL', 'max:50',new TextRule()],
            'alias' => ['required','unique:service_categories,slug,' . $this->info->id . ',id,deleted_at,NULL', 'max:100',new TextRule()],
            'description' => ['required', new EditorRule()],
            'short_description' => ['required', 'max:500',new TextRule()],
            'meta_title' => ['nullable', 'max:200',new TextRule()],
            'meta_keywords' => ['nullable', 'max:500',new TextRule()],
            'meta_description' => ['nullable', 'max:500',new TextRule()],
        ];
    }

    protected $validationAttributes = [
        'title' => 'category name',
        'info.image'=>'image',
        'info.banner'=>'banner',
        'image' => 'thumb image',
        'banner' => 'image',
    ];


    public function SaveForm()
    {
        $this->validate();
        if (empty($this->info->image) && empty($this->image)) {
            $this->addError('image', 'The image field is required.');
        } else {
            $data = Category::findOrFail($this->info->id);
            if (!empty($this->image)) {
                \Image::removeFile('service/category/', $this->info->image);
                $imageName = \Image::autoheight('service/category/', 250, $this->image);
                $data->image = $imageName;
            }
            $data->title = $this->title;
            $data->slug = $this->alias;
            $data->description = $this->description;
            $data->short_description = $this->short_description;
            $data->meta_title = !empty($this->meta_title) ? $this->meta_title : $this->title;
            $data->meta_keywords = !empty($this->meta_keywords) ? $this->meta_keywords : $this->title;
            $data->meta_description = !empty($this->meta_description) ? $this->meta_description : $this->title;
            $data->save();
            $this->dispatch('refreshCategoryEdit', data: $data->id);
            $this->dispatch('successtoaster', ['title' => AlertMessageType::UPDATE, 'message' => AlertMessage::UPDATE]);
        }
    }
}
