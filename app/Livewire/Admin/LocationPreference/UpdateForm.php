<?php

namespace App\Livewire\Admin\LocationPreference;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\Location;
use App\Rules\EditorRule;
use App\Rules\TextRule;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateForm extends Component
{
    use WithFileUploads;
    protected $listeners = ['customizeLocationEdit' => 'mount','updateEditorValue' => 'updateEditorValue'];
    public $info, $parent, $title, $alias;
    public $description, $image;
    public $meta_title, $meta_keywords, $meta_description;

    public function mount(Location $data)
    {
        $this->info = $data;
        $this->parent = $data->city_id;
        $this->title = $data->title;
        $this->alias = $data->alias;
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
        return view('livewire.admin.location-preference.update-form');
    }

    public function rules()
    {
        return [
            'title' => ['required', 'unique:locations,title,' . $this->info->id . ',id,deleted_at,NULL,city_id,' . $this->info->city_id, 'max:100', new TextRule()],
            'alias' => ['required', 'regex:/^[- a-z0-9A-Z]+$/u', 'unique:locations,alias,' . $this->info->id . ',id,deleted_at,NULL', 'max:200', new TextRule()],
            'image' => 'nullable|max:5000|mimes:jpg,png,jpeg,webp',
            'description' => ['nullable', new EditorRule()],
            'meta_title' => ['nullable', 'max:100', new TextRule()],
            'meta_keywords' => ['nullable', 'max:500', new TextRule()],
            'meta_description' => ['nullable', 'max:500', new TextRule()],
        ];
    }

    public function SaveForm()
    {
        $this->validate();
        $data = Location::find($this->info->id);
        $data->title = $this->title;
        $data->alias = $this->alias;
        $data->description = $this->description;
        $data->meta_title = $this->meta_title;
        $data->meta_keywords = $this->meta_keywords;
        $data->meta_description = $this->meta_description;
        if (!empty($this->image)) {
            $imageName = \Image::autoheight('location-preference/', $this->image);
            $data->image = $imageName;
        }
        $data->save();
        $this->dispatch('customizeLocationEdit', data: $data->id);
        $this->dispatch('successtoaster', ['title' => AlertMessageType::UPDATE, 'message' => AlertMessage::UPDATE]);
    }
}
