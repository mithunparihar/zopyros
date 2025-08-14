<?php

namespace App\Livewire\Admin\Material;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\Material;
use App\Rules\EditorRule;
use App\Rules\TextRule;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateForm extends Component
{
    use WithFileUploads;
    public $title, $alias, $description, $image, $heading;
    public $meta_description, $meta_keywords, $meta_title;
    public $caseInfo;
    protected $listeners = ['refreshMaterialEdit' => 'mount','updateEditorValue' => 'updateEditorValue'];
    public function mount(Material $data)
    {
        $this->caseInfo = $data;
        $this->title = $data->title;
        $this->alias = $data->alias;
        $this->heading = $data->heading;
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
        return view('livewire.admin.material.update-form');
    }

    public function rules()
    {
        return [
            'image' => 'nullable|max:5000|mimes:jpg,png,jpeg,webp',
            'title' => ['required', 'unique:materials,title,' . $this->caseInfo->id . ',id,deleted_at,NULL', 'max:100', new TextRule()],
            'alias' => ['required', 'unique:materials,alias,' . $this->caseInfo->id . ',id,deleted_at,NULL', 'max:100', new TextRule()],
            'description' => ['required', new EditorRule()],
            'heading' => ['nullable', 'max:200', new TextRule()],
            'meta_title' => ['nullable', 'max:200', new TextRule()],
            'meta_keywords' => ['nullable', 'max:500', new TextRule()],
            'meta_description' => ['nullable', 'max:500', new TextRule()],
        ];
    }

    public function updatedTitle($value)
    {
        $this->title = trim($value);
    }

    public function SaveForm()
    {
        $this->validate();

        $data = \App\Models\Material::findOrFail($this->caseInfo->id);
        if (!empty($this->image)) {
            \Image::removeFile('materials/', $this->caseInfo->image);
            $imageName = \Image::autoheight('materials/', $this->image);
            $data->image = $imageName;
        }
        $data->title = $this->title;
        $data->alias = $this->alias;
        $data->description = $this->description;
        $data->heading = $this->heading;
        $data->meta_title = $this->meta_title;
        $data->meta_keywords = $this->meta_keywords;
        $data->meta_description = $this->meta_description;
        $data->sequence = (\App\Models\Material::max('sequence') + 1);
        $data->save();

        $this->dispatch('refreshMaterialEdit', data: $data->id);
        $this->dispatch('successtoaster', ['title' => AlertMessageType::UPDATE, 'message' => AlertMessage::UPDATE]);
    }
}
