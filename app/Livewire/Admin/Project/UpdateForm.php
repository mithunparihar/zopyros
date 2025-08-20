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

class UpdateForm extends Component
{
    use WithFileUploads;
    public $info, $images;
    public $title, $image, $type, $description, $description_2, $slug;
    public $meta_title, $meta_keywords, $meta_description;
    protected $listeners = ['updateEditorValue' => 'updateEditorValue', 'reloadInspiration' => 'mount'];
    public $primaryImageIndex, $preImages;
    public function updateEditorValue($modelId, $content)
    {
        if ($modelId == 'description') {
            $this->description = $content;
        }
        if ($modelId == 'description_2') {
            $this->description_2 = $content;
        }
    }

    public function mount(Project $data)
    {
        $this->info             = $data;
        $this->title            = $data->title;
        $this->slug             = $data->slug;
        $this->location         = $data->location;
        $this->type             = $data->type_id;
        $this->description      = $data->description;
        $this->description_2    = $data->description_2;
        $this->meta_title       = $data->meta_title;
        $this->meta_keywords    = $data->meta_keywords;
        $this->meta_description = $data->meta_description;
        $this->getImages();
    }

    public function render()
    {
        return view('livewire.admin.project.update-form');
    }

    public function setPrimaryImage(ProjectImage $imageId)
    {
        ProjectImage::gallery($this->info->id)->whereNot('id', $imageId->id)->update(['is_primary' => 0]);
        $imageId->update(['is_primary' => 1]);
        $this->getImages();
    }

    public function getImages()
    {
        $this->preImages = ProjectImage::gallery($this->info->id)->get();
    }

    public function removeImage(ProjectImage $imageId)
    {
        $checkProductImages = ProjectImage::gallery($this->info->id)->count();
        if ($checkProductImages < 2) {
            $this->dispatch('errortoaster', ['title' => AlertMessageType::SORRY, 'message' => 'Deletion not allowed: This image is required and cannot be removed.']);
        } else {
            if ($imageId->is_primary == 1) {
                $findImage = ProjectImage::gallery($this->info->id)->whereNot('id', $imageId->id)->first();
                ProjectImage::whereId($findImage->id)->update(['is_primary' => 1]);
            }
            \Image::removeFile('inspiration/gallery/', $imageId->image);
            $imageId->delete();
            $this->getImages();
        }

    }

    public function eliminarImage($index)
    {
        array_splice($this->images, $index, 1);
    }
    public function setPreviewImagePrimary($index)
    {
        foreach ($this->images as $key => $images) {
            if ($key == $index) {
                $images->primary_image   = true;
                $this->primaryImageIndex = $index;
            } else {
                $images->primary_image = false;
            }
        }
    }

    public function rules()
    {
        return [
            'title'            => ['required', 'unique:projects,title,' . $this->info->id . ',id,deleted_at,NULL', 'max:200', new TextRule()],
            'slug'             => ['required', 'unique:projects,slug,' . $this->info->id . ',id,deleted_at,NULL', 'max:200', new TextRule()],
            'description'      => ['required', new EditorRule(1000)],
            'description_2'    => ['required', new EditorRule()],
            'meta_title'       => ['nullable', 'max:200', new TextRule()],
            'meta_keywords'    => ['nullable', 'max:500', new TextRule()],
            'meta_description' => ['nullable', 'max:500', new TextRule()],
            'images.*'         => 'nullable|max:5000|mimes:jpg,png,webp,jpeg',
        ];
    }

    public function SaveForm()
    {
        $this->validate();
        $data        = Project::find($this->info->id);
        $data->title = $this->title;
        $data->slug  = $this->slug;
        // $data->type_id = $this->type;
        $data->description      = $this->description;
        $data->description_2    = $this->description_2;
        $data->meta_title       = ! empty($this->meta_title) ? $this->meta_title : null;
        $data->meta_keywords    = ! empty($this->meta_keywords) ? $this->meta_keywords : null;
        $data->meta_description = ! empty($this->meta_description) ? $this->meta_description : null;
        $data->save();

        $this->uploadImages($data->id);
        $this->dispatch('reloadInspiration', data: $data->id);
        $this->dispatch('successtoaster', ['title' => AlertMessageType::UPDATE, 'message' => AlertMessage::UPDATE]);

    }

    public function uploadImages($galleryId)
    {
        if (is_array($this->images)) {
            $checkPrimary = ProjectImage::gallery($this->info->id)->primary()->first();

            foreach ($this->images as $k => $image) {
                $imageName             = \Image::autoheight('projects/', $image);
                $imageData             = new ProjectImage();
                $imageData->image      = $imageName;
                $imageData->project_id = $galleryId;
                if (empty($checkPrimary)) {
                    $imageData->is_primary = $k == 0 ? 1 : 0;
                } else {
                    $imageData->is_primary = $image->primary_image ?? 0;
                }

                $imageData->save();
            }
        }
        $this->reset('images');

    }
}
