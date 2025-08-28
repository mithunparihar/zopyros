<?php
namespace App\Livewire\Admin\Blog;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTableContent;
use App\Rules\EditorRule;
use App\Rules\NoDangerousTags;
use App\Rules\TextRule;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class SaveForm extends Component
{
    use WithFileUploads;
    public $title, $post_date, $description, $meta_title, $meta_keywords, $meta_description, $category;
    public $short_description;
    public $image, $banner;
    public $categories         = [];
    protected $listeners       = ['updateEditorValue' => 'updateEditorValue', 'refreshBlogAdd' => 'mount'];
    public $tablecontents      = [];
    public $tablecontentInputs = ['title' => '', 'tag' => '', 'description' => '', 'publish' => 1, 'sequence' => 1];

    public function mount()
    {
        $this->categories = BlogCategory::active()->get();

        $this->fill([
            'tablecontents' => collect([$this->tablecontentInputs]),
        ]);
    }

    public function addMoreTable()
    {
        $tablecontentInputs             = $this->tablecontentInputs;
        $tablecontentInputs['sequence'] = count($this->tablecontents) + 1;
        $this->tablecontents->push($tablecontentInputs);
        $this->dispatch('addMoreTableScrpt');
    }

    public function removeTableRow($index)
    {
        $this->tablecontents->pull($index);
    }

    public function updateEditorValue($modelId, $content)
    {
        if ($modelId == 'description') {
            $this->description = $content;
        }

        $explode = explode('.', $modelId);
        if (($explode[0] ?? '') == 'tablecontents') {
            $tableRow              = $this->tablecontents->get($explode[1]);
            $tableRow[$explode[2]] = $content;
            $this->tablecontents   = $this->tablecontents->put($explode[1], $tableRow);
        }
    }

    public function render()
    {
        return view('livewire.admin.blog.save-form');
    }

    public function rules()
    {
        $this->title = \Illuminate\Support\Str::squish($this->title);
        return [
            'post_date'                   => 'required|date',
            'category'                    => 'required',
            'image'                       => 'required|max:5000|mimes:jpg,png,jpeg,webp',
            'banner'                      => 'required|max:5000|mimes:jpg,png,jpeg,webp',
            'title'                       => [
                'required',
                'max:200',
                new TextRule(),
                new NoDangerousTags(),
                Rule::unique('blogs')->where(function ($query) {
                    $query->whereNULL('deleted_at');
                    $query->whereRaw('LOWER(TRIM(name)) = ?', [strtolower($this->title)]);
                }),
            ],
            'short_description'           => ['nullable', 'max:300', 'min:100', new TextRule(), new NoDangerousTags()],
            'description'                 => ['required', new EditorRule()],
            'meta_title'                  => ['nullable', 'max:100', new TextRule(), new NoDangerousTags()],
            'meta_keywords'               => ['nullable', 'max:300', new TextRule(), new NoDangerousTags()],
            'meta_description'            => ['nullable', 'max:300', new TextRule(), new NoDangerousTags()],

            'tablecontents.*.title'       => ['nullable', 'required_with:tablecontents.*.description', 'max:200', new TextRule(), new NoDangerousTags()],
            'tablecontents.*.tag'         => ['nullable', 'required_with:tablecontents.*.title'],
            'tablecontents.*.publish'     => ['nullable', 'required_with:tablecontents.*.title'],
            'tablecontents.*.sequence'    => ['nullable', 'distinct', 'required_with:tablecontents.*.title', 'integer', 'max:100'],
            'tablecontents.*.description' => ['nullable', 'required_with:tablecontents.*.title', new EditorRule()],
        ];
    }

    protected $validationAttributes = [
        'tablecontents.*.title'       => 'table of content title',
        'tablecontents.*.tag'         => 'table of content tag',
        'tablecontents.*.publish'     => 'table of content publish',
        'tablecontents.*.description' => 'table of content description',
        'tablecontents.*.sequence'    => 'table of content sequence',
    ];

    public function SaveForm()
    {
        $this->validate();
        $imageName               = \Image::autoheight('blog/', $this->image);
        $bannerName              = \Image::autoheight('blog/banner/', $this->banner);
        $data                    = new Blog();
        $data->image             = $imageName;
        $data->banner            = $bannerName;
        $data->name              = $this->title;
        $data->slug              = $this->title;
        $data->post_date         = $this->post_date;
        $data->short_description = $this->short_description;
        $data->description       = $this->description;
        $data->category_id       = $this->category;
        $data->meta_title        = ! empty($this->meta_title) ? $this->meta_title : null;
        $data->meta_keywords     = ! empty($this->meta_keywords) ? $this->meta_keywords : null;
        $data->meta_description  = ! empty($this->meta_description) ? $this->meta_description : null;
        $data->save();

        $this->uploadTableContent($data->id);
        $this->reset(['image', 'banner', 'title', 'short_description', 'description', 'post_date', 'category', 'meta_title', 'meta_keywords', 'meta_description']);
        $this->dispatch('successtoaster', ['title' => AlertMessageType::SAVE, 'message' => AlertMessage::SAVE]);
    }

    public function uploadTableContent($blogId)
    {
        foreach ($this->tablecontents as $content) {
            if (! empty($content['title'])) {
                $data               = new BlogTableContent();
                $data->blog_id      = $blogId;
                $data->title        = $content['title'];
                $data->description  = $content['description'];
                $data->heading_type = $content['tag'];
                $data->is_publish   = $content['publish'];
                $data->sequence     = $content['sequence'];
                $data->save();
            }
        }

        $this->dispatch('relaodPage');
        $this->dispatch('emptyEditor');

    }

}
