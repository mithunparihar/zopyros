<?php

namespace App\Livewire\Admin\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Rules\EditorRule;
use App\Rules\TextRule;
use App\Models\Material;
use App\Enums\AlertMessageType;
use App\Enums\AlertMessage;

class UpdateForm extends Component
{
    use WithFileUploads;
    public $title,$heading,$description, $image, $short_description;
    public $meta_description, $meta_keywords, $meta_title, $alias;
    public $parent = 0, $parentInfo, $info;
    protected $listeners = ['refreshCategoryEdit' => 'mount','updateEditorValue' => 'updateEditorValue'];
    public $materials;
    public function mount(Category $data)
    {

        $this->parentInfo = $data->parentInfo;
        $this->info = $data;
        $this->parent = $data->parent_id;
        $this->alias = $data->alias;
        $this->title = $data->title;
        $this->heading = $data->heading;
        $this->short_description = $data->short_description;
        $this->description = $data->description;
        $this->meta_title = $data->meta_title;
        $this->meta_keywords = $data->meta_keywords;
        $this->meta_description = $data->meta_description;
    }

    public function updateEditorValue($modelId, $content)
    {
        if ($modelId == 'description') {
            $this->description = $content;
        }
    }

    public function render()
    {

        return view('livewire.admin.category.update-form');
    }

    public function rules()
    {
        return [
            'image' => 'nullable|required_if:info.image,null|max:5000|mimes:jpg,png,jpeg,webp',
            'title' => ['required', 'unique:categories,title,' . $this->info->id . ',id,deleted_at,NULL', 'max:50', new TextRule()],
            'heading' => ['nullable', 'unique:categories,heading,NULL,id,deleted_at,NULL', 'max:100', new TextRule()],
            'alias' => ['required', 'unique:categories,alias,' . $this->info->id . ',id,deleted_at,NULL', 'max:100',new TextRule()],
            'short_description' => ['nullable', 'max:1000',new TextRule()],
            'description' => ['required',new EditorRule()],
            'meta_title' => ['nullable', 'max:100',new TextRule()],
            'meta_keywords' => ['nullable', 'max:500',new TextRule()],
            'meta_description' => ['nullable', 'max:500',new TextRule()],
        ];
    }

    protected $messages = [
        'image.required_if' => 'The image field is required',
    ];

    protected $validationAttributes = [
        'info.image' => 'image',
    ];


    public function SaveForm()
    {
        $this->validate();
        $data = Category::findOrFail($this->info->id);
        if (!empty($this->image)) {
            \Image::removeFile('categories/', $this->info->image);
            $imageName = \Image::autoheight('categories/', $this->image);
            $data->image = $imageName;
        }
        $data->title = $this->title;
        $data->heading = $this->heading;
        $data->alias = $this->alias;
        $data->short_description = $this->short_description;
        $data->description = $this->description;
        $data->meta_title = $this->meta_title;
        $data->meta_keywords = $this->meta_keywords;
        $data->meta_description = $this->meta_description;
        $data->save();
        $this->dispatch('refreshCategoryEdit', data: $data->id);
        $redirectUrl = route('admin.categories.create');
        if ($data->parent_id > 0) {
            $redirectUrl = $redirectUrl . '?parent=' . $data->parent_id;
        }
        $this->dispatch('successtoaster',['title'=>AlertMessageType::UPDATE,'message'=>AlertMessage::UPDATE]);
    }


}
