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

class SaveForm extends Component
{
    public $title, $description, $meta_title, $meta_keywords, $meta_description;
    protected $listeners = ['updateEditorValue' => 'updateEditorValue'];

    public function updateEditorValue($modelId, $content)
    {
        if ($modelId == 'description') {
            $this->description = $content;
        }
    }

    public function render()
    {
        return view('livewire.admin.blog.category.save-form');
    }

    public function rules()
    {
        $this->title = \Illuminate\Support\Str::squish($this->title);
        return [
            'title'            => [
                'required',
                'max:100',
                new TextRule(),
                new NoDangerousTags(),
                Rule::unique('blog_categories')->where(function ($query) {
                    $query->whereNULL('deleted_at');
                    $query->whereRaw('LOWER(TRIM(title)) = ?', [strtolower($this->title)]);
                }),
            ],
            'description'      => ['required', new EditorRule()],
            'meta_title'       => ['nullable', 'max:200', new TextRule()],
            'meta_keywords'    => ['nullable', 'max:500', new TextRule()],
            'meta_description' => ['nullable', 'max:500', new TextRule()],
        ];
    }

    public function SaveForm()
    {
        $this->validate();
        $data                   = new BlogCategory();
        $data->title            = $this->title;
        $data->slug             = $this->title;
        $data->content          = $this->description;
        $data->meta_title       = ! empty($this->meta_title) ? $this->meta_title : null;
        $data->meta_keywords    = ! empty($this->meta_keywords) ? $this->meta_keywords : null;
        $data->meta_description = ! empty($this->meta_description) ? $this->meta_description : null;
        $data->save();
        $this->reset(['title', 'description', 'meta_title', 'meta_keywords', 'meta_description']);
        $this->dispatch('emptyEditor');
        $this->dispatch('successtoaster', ['title' => AlertMessageType::SAVE, 'message' => AlertMessage::SAVE]);
    }
}
