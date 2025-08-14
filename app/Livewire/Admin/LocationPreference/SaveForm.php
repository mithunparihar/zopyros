<?php

namespace App\Livewire\Admin\LocationPreference;

use Livewire\Component;
use App\Models\Location;
use App\Enums\AlertMessageType;
use App\Enums\AlertMessage;
use Livewire\WithFileUploads;
use App\Rules\EditorRule;
use App\Rules\TextRule;

class SaveForm extends Component
{
    use WithFileUploads;
    protected $listeners = ['customizeLocationAdd'=>'mount','updateEditorValue' => 'updateEditorValue'];
    public $parent,$title;
    public $description, $image;
    public $meta_title, $meta_keywords, $meta_description;
    function mount($parent){
        $this->parent = $parent ;
    }

    public function updateEditorValue($modelId, $content)
    {
        if ($modelId == 'description') {
            $this->description = $content;
        }
    }

    public function render()
    {
        return view('livewire.admin.location-preference.save-form');
    }

    public function rules()
    {
        return [
            'title' => ['required', 'unique:locations,title,NULL,id,deleted_at,NULL,city_id,'.$this->parent, 'max:100',new TextRule()],
            'image' => 'nullable|max:5000|mimes:jpg,png,jpeg,webp',
            'description' => ['nullable',new EditorRule()],
            'meta_title' => ['nullable','max:100',new TextRule()],
            'meta_keywords' => ['nullable','max:500',new TextRule()],
            'meta_description' => ['nullable','max:500',new TextRule()],

        ];
    }


    public function SaveForm()
    {
        $this->validate();
        $data = new Location();
        $data->title = $this->title;
        $data->alias = $this->title;
        $data->city_id = $this->parent ?? 0;
        $data->description = $this->description;
        $data->meta_title = $this->meta_title;
        $data->meta_keywords = $this->meta_keywords;
        $data->meta_description = $this->meta_description;
        if (!empty($this->image)) {
            $imageName = \Image::autoheight('location-preference/', $this->image);
            $data->image = $imageName;
        }
        $data->save();
        $this->dispatch('emptyEditor');
        $this->reset(['description','meta_title','meta_keywords','meta_description','title','image']);
        $this->dispatch('successtoaster', ['title' => AlertMessageType::SAVE, 'message' => AlertMessage::SAVE]);
    }
}
