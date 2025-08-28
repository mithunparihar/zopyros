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

class UpdateForm extends Component
{
    use WithFileUploads;
    public $title, $heading, $description, $image, $short_description;
    public $meta_description, $meta_keywords, $meta_title, $alias;
    public $parent       = 0, $parentInfo, $info;
    protected $listeners = ['refreshCategoryEdit' => 'mount', 'updateEditorValue' => 'updateEditorValue'];
    public $materials;
    public function mount(Category $data)
    {

        $this->parentInfo        = $data->parentInfo;
        $this->info              = $data;
        $this->parent            = $data->parent_id;
        $this->alias             = $data->alias;
        $this->title             = $data->title;
        $this->heading           = $data->heading;
        $this->short_description = $data->short_description;
        $this->description       = $data->description;
        $this->meta_title        = $data->meta_title;
        $this->meta_keywords     = $data->meta_keywords;
        $this->meta_description  = $data->meta_description;
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
        $this->title = \Illuminate\Support\Str::squish($this->title);
        $this->alias = \Illuminate\Support\Str::squish($this->alias);
        return [
            'image'             => 'nullable|required_if:info.image,null|max:5000|mimes:jpg,png,jpeg,webp',
            'title'             => [
                'required',
                'max:50',
                new TextRule(),
                new NoDangerousTags(),
                Rule::unique('categories')->where(function ($query) {
                    $query->whereNULL('deleted_at');
                    $query->whereNot('id', $this->info->id);
                    $query->where('parent_id', $this->info->parent_id);
                    $query->whereRaw('LOWER(TRIM(title)) = ?', [strtolower($this->title)]);
                }),
            ],
            'heading'           => ['nullable', 'unique:categories,heading,NULL,id,deleted_at,NULL', 'max:100', new TextRule(), new NoDangerousTags()],
            'alias'             => ['required', 'unique:categories,alias,' . $this->info->id . ',id,deleted_at,NULL', 'max:100', new TextRule(), new NoDangerousTags()],
            'short_description' => ['nullable', 'max:1000', new TextRule(), new NoDangerousTags()],
            'description'       => ['required', new EditorRule()],
            'meta_title'        => ['nullable', 'max:100', new TextRule(), new NoDangerousTags()],
            'meta_keywords'     => ['nullable', 'max:500', new TextRule(), new NoDangerousTags()],
            'meta_description'  => ['nullable', 'max:500', new TextRule(), new NoDangerousTags()],
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
        if (! empty($this->image)) {
            \Image::removeFile('categories/', $this->info->image);
            $imageName   = \Image::autoheight('categories/', $this->image);
            $data->image = $imageName;
        }
        $data->title             = $this->title;
        $data->heading           = $this->heading;
        $data->alias             = $this->alias;
        $data->short_description = $this->short_description;
        $data->description       = $this->description;
        $data->meta_title        = $this->meta_title;
        $data->meta_keywords     = $this->meta_keywords;
        $data->meta_description  = $this->meta_description;
        $data->save();
        $this->dispatch('refreshCategoryEdit', data: $data->id);
        $redirectUrl = route('admin.categories.create');
        if ($data->parent_id > 0) {
            $redirectUrl = $redirectUrl . '?parent=' . $data->parent_id;
        }
        $this->dispatch('successtoaster', ['title' => AlertMessageType::UPDATE, 'message' => AlertMessage::UPDATE]);
    }

}
