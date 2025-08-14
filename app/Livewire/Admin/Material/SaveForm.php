<?php

namespace App\Livewire\Admin\Material;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Rules\EditorRule;
use App\Rules\TextRule;

class SaveForm extends Component
{
    use WithFileUploads;
    public $title,$heading, $description, $image;
    public $meta_description, $meta_keywords, $meta_title;
    protected $listeners = ['updateEditorValue' => 'updateEditorValue'];

    public function render()
    {
        return view('livewire.admin.material.save-form');
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
            'image' => 'required|max:5000|mimes:jpg,png,jpeg,webp',
            'title' => ['required', 'unique:materials,title,NULL,id,deleted_at,NULL', 'max:100', new TextRule()],
            'heading' => ['nullable','max:200', new TextRule()],
            'description' => ['required',new EditorRule()],
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
        $imageName = \Image::autoheight('materials/',$this->image);
        $data = new \App\Models\Material();
        $data->image = $imageName;
        $data->title = $this->title;
        $data->alias = $this->title;
        $data->heading = $this->heading;
        $data->description = $this->description;
        $data->meta_title =  $this->meta_title;
        $data->meta_keywords =  $this->meta_title;
        $data->meta_description =  $this->meta_title;
        $data->sequence = (\App\Models\Material::max('sequence') + 1);
        $data->save();

        $this->dispatch('emptyEditor');
        $this->reset(['image', 'title','description','heading','meta_title','meta_keywords','meta_description']);
        $this->dispatch('successtoaster', ['title' => AlertMessageType::SAVE, 'message' => AlertMessage::SAVE]);
    }
}
