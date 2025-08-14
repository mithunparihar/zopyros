<?php

namespace App\Livewire\Admin\Project;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Rules\EditorRule;
use App\Rules\TextRule;
use Livewire\Component;
use Livewire\WithFileUploads;

class SaveForm extends Component
{
    use WithFileUploads;
    public $images;
    public $title, $image, $short_description, $description, $type;
    public $meta_title, $meta_keywords, $meta_description;
    protected $listeners = ['updateEditorValue' => 'updateEditorValue'];
    public $primaryImageIndex;
    public function updateEditorValue($modelId, $content)
    {
        if ($modelId == 'description') {
            $this->description = $content;
        }
    }

    public function render()
    {
        return view('livewire.admin.project.save-form');
    }

    public function eliminarImage($index)
    {
        array_splice($this->images, $index, 1);
    }
    public function setPreviewImagePrimary($index)
    {
        foreach ($this->images as $key => $images) {
            if ($key == $index) {
                $images->primary_image = true;
                $this->primaryImageIndex = $index;
            } else {
                $images->primary_image = false;
            }
        }
    }

    public function rules()
    {
        return [
            'title' => ['required', 'unique:projects,title,NULL,id,deleted_at,NULL', 'max:200', new TextRule()],
            'description' => ['required', new EditorRule()],
            'meta_title' => ['nullable', 'max:200', new TextRule()],
            'meta_keywords' => ['nullable', 'max:500', new TextRule()],
            'meta_description' => ['nullable', 'max:500', new TextRule()],
            'images'=>['required'],
            'images.*' => 'required|max:5000|mimes:jpg,png,webp,jpeg',
        ];
    }

    public function SaveForm()
    {
        $this->validate();
        $data = new Project();
        $data->title = $this->title;
        $data->slug = $this->title;
        // $data->type_id = $this->type;
        $data->description = $this->description;
        $data->meta_title = $this->meta_title;
        $data->meta_keywords = $this->meta_keywords;
        $data->meta_description = $this->meta_description;
        $data->save();

        $this->uploadImages($data->id);

        $this->reset(['title', 'title','description', 'meta_title', 'meta_keywords', 'meta_description']);
        $this->dispatch('emptyEditor');
        $this->dispatch('dataSaved');
        $this->dispatch('successtoaster', ['title' => AlertMessageType::SAVE, 'message' => AlertMessage::SAVE]);

    }

    public function uploadImages($galleryId)
    {
        if (is_array($this->images)) {
            foreach ($this->images as $k => $image) {
                $imageName = \Image::autoheight('projects/',$image);
                $imageData = new ProjectImage();
                $imageData->image = $imageName;
                $imageData->project_id = $galleryId;
                if ($this->primaryImageIndex == $k) {
                    $imageData->is_primary = 1;
                } elseif (empty($this->primaryImageIndex) && $k == 0) {
                    $imageData->is_primary = 1;
                } else {
                    $imageData->is_primary = 0;
                }

                $imageData->save();
            }
        }
        $this->reset('images');

    }
}
