<?php
namespace App\Livewire\Admin\Category;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\Category;
use App\Rules\EditorRule;
use App\Rules\NoDangerousTags;
use App\Rules\TextRule;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class SaveForm extends Component
{
    use WithFileUploads;
    public $title, $heading, $description, $image, $short_description;
    public $meta_description, $meta_keywords, $meta_title, $material;
    public $parent, $level = 1, $parentInfo;
    protected $listeners   = ['updateEditorValue' => 'updateEditorValue'];
    public $materials;
    public function mount($parent)
    {
        $this->parent = 0;
        if ($parent > 0) {
            $this->parentInfo = \App\Models\Category::findorFail($parent);
            $this->parent     = $parent;
            $this->level      = ($this->parentInfo->level + 1);
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
        return view('livewire.admin.category.save-form');
    }

    public function rules()
    {
        $this->title = \Illuminate\Support\Str::squish($this->title);
        return [
            'image'             => 'required|max:5000|mimes:jpg,png,jpeg,webp',
            'title'             => [
                'required',
                'max:50',
                new TextRule(),
                new NoDangerousTags(),
                Rule::unique('categories')->where(function ($query) {
                    $query->whereNULL('deleted_at');
                    $query->where('parent_id', $this->parent);
                    $query->whereRaw('LOWER(TRIM(title)) = ?', [strtolower($this->title)]);
                }),
            ],
            'heading'           => ['nullable', 'unique:categories,heading,NULL,id,deleted_at,NULL', 'max:100', new TextRule(), new NoDangerousTags()],
            'short_description' => ['nullable', 'max:600', new TextRule(), new NoDangerousTags()],
            'description'       => ['required', new EditorRule()],
            'meta_title'        => ['nullable', 'max:100', new TextRule(), new NoDangerousTags()],
            'meta_keywords'     => ['nullable', 'max:500', new TextRule(), new NoDangerousTags()],
            'meta_description'  => ['nullable', 'max:500', new TextRule(), new NoDangerousTags()],
        ];
    }

    public function SaveForm()
    {
        $this->validate();
        $imageName = \Image::autoheight('categories/', $this->image);

        $data                    = new Category();
        $data->image             = $imageName;
        $data->title             = $this->title;
        $data->alias             = $this->title;
        $data->heading           = $this->heading;
        $data->short_description = $this->short_description;
        $data->description       = $this->description;
        $data->meta_title        = $this->meta_title;
        $data->meta_keywords     = $this->meta_keywords;
        $data->meta_description  = $this->meta_description;
        $data->level             = $this->level;
        $data->parent_id         = $this->parent;
        $data->sequence          = (Category::whereParentId($this->parent)->max('sequence') + 1);
        $data->save();
        $this->reset(['image', 'title', 'description', 'short_description', 'meta_title', 'meta_keywords', 'meta_description']);
        $this->dispatch('emptyEditor');
        $this->dispatch('dataSaved');
        $redirectUrl = route('admin.categories.create');
        if ($data->parent_id > 0) {
            $redirectUrl = $redirectUrl . '?parent=' . $data->parent_id;
        }
        $this->dispatch('successtoaster', ['title' => AlertMessageType::SAVE, 'message' => AlertMessage::SAVE]);
    }
}
