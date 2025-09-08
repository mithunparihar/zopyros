<?php
namespace App\Livewire\Admin\Blog\Category;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\BlogCategory;
use App\Rules\EditorRule;
use App\Rules\NoDangerousTags;
use App\Rules\TextRule;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UpdateForm extends Component
{
    public $title, $description, $meta_title, $meta_keywords, $meta_description;
    public $info, $alias;
    protected $listeners = ['refreshBlogCategoryEdit' => 'mount', 'updateEditorValue' => 'updateEditorValue'];
    public function mount(BlogCategory $data)
    {
        $this->info             = $data;
        $this->alias            = $data->slug;
        $this->title            = $data->title;
        $this->description      = $data->content;
        $this->meta_title       = $data->meta_title;
        $this->meta_keywords    = $data->meta_keywords;
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
        return view('livewire.admin.blog.category.update-form');
    }

    public function updated()
    {
        // $this->title = trim($this->title);
        $this->alias = trim($this->alias);
    }

    public function rules()
    {
        $this->title = \Illuminate\Support\Str::squish($this->title);
        $this->alias = \Illuminate\Support\Str::squish($this->alias);
        return [
            'title'            => [
                'required',
                'max:100',
                new TextRule(),
                new NoDangerousTags(),
                Rule::unique('blog_categories')->where(function ($query) {
                    $query->whereNULL('deleted_at');
                    $query->whereNot('id', $this->info->id);
                    $query->whereRaw('LOWER(TRIM(title)) = ?', [strtolower($this->title)]);
                }),
            ],
            'alias'            => [
                'required',
                'regex:/^[- a-z0-9A-Z]+$/u',
                'max:100',
                new TextRule(),
                Rule::unique('blog_categories', 'slug')->where(function ($query) {
                    $query->whereNULL('deleted_at');
                    $query->whereNot('id', $this->info->id);
                    $query->whereRaw('LOWER(TRIM(slug)) = ?', [strtolower($this->alias)]);
                }),
            ],
            'description'      => ['required', new EditorRule()],
            'meta_title'       => ['nullable', 'max:100', new TextRule(), new NoDangerousTags()],
            'meta_keywords'    => ['nullable', 'max:300', new TextRule(), new NoDangerousTags()],
            'meta_description' => ['nullable', 'max:300', new TextRule(), new NoDangerousTags()],
        ];
    }

    public function SaveForm()
    {
        $this->validate();
        $data                   = BlogCategory::findOrFail($this->info->id);
        $data->title            = $this->title;
        $data->slug             = $this->alias;
        $data->content          = $this->description;
        $data->meta_title       = ! empty($this->meta_title) ? $this->meta_title : null;
        $data->meta_keywords    = ! empty($this->meta_keywords) ? $this->meta_keywords : null;
        $data->meta_description = ! empty($this->meta_description) ? $this->meta_description : null;
        $data->save();
        $this->dispatch('refreshBlogCategoryEdit', data: $data->id);
        $this->dispatch('successtoaster', ['title' => AlertMessageType::UPDATE, 'message' => AlertMessage::UPDATE]);
    }
}
