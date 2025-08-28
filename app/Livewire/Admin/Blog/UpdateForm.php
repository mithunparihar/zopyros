<?php
namespace App\Livewire\Admin\Blog;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTableContent;
use App\Rules\EditorRule;
use App\Rules\TextRule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use App\Rules\NoDangerousTags;

class UpdateForm extends Component
{
    use WithFileUploads;
    public $title, $post_date, $description, $meta_title, $meta_keywords, $meta_description, $category;
    public $image, $banner;
    public $info, $alias, $short_description;
    public $categories   = [];
    protected $listeners = ['refreshBlogEdit' => 'mount', 'updateEditorValue' => 'updateEditorValue'];

    public $tablecontents      = [];
    public $tablecontentInputs = ['title' => '', 'tag' => '', 'description' => '', 'publish' => 1, 'sequence' => ''];

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
    public function mount(Blog $data)
    {
        $this->info              = $data;
        $this->title             = $data->name;
        $this->alias             = $data->slug;
        $this->category          = $data->category_id;
        $this->post_date         = $data->post_date;
        $this->description       = $data->description;
        $this->meta_title        = $data->meta_title;
        $this->meta_keywords     = $data->meta_keywords;
        $this->meta_description  = $data->meta_description;
        $this->short_description = $data->short_description;
        $this->categories        = BlogCategory::active()->get();

        $this->tabelContentField();
    }

    public function tabelContentField()
    {
        $tableofcontent     = $this->info->tableofcontent()->orderBy('sequence')->get();
        $tablecontentInputs = [];
        if (count($tableofcontent) == 0) {
            $tablecontentInputs = [$this->tablecontentInputs];
        } else {
            foreach ($tableofcontent as $tableofco) {
                $tablecontentInputs[] = [
                    'pre_id'      => $tableofco['id'],
                    'title'       => $tableofco['title'],
                    'tag'         => $tableofco['heading_type'],
                    'description' => $tableofco['description'],
                    'publish'     => $tableofco['is_publish'],
                    'sequence'    => $tableofco['sequence'],
                ];
            }
        }
        $this->fill([
            'tablecontents' => collect($tablecontentInputs),
        ]);
    }

    public function addMoreTable()
    {
        $tablecontentInputs = $this->tablecontentInputs;
        $tablecontentInputs['sequence'] = count($this->tablecontents) + 1;

        $this->tablecontents->push($tablecontentInputs);
        $this->dispatch('addMoreTableScrpt');
    }

    public function removeTableRow($index)
    {
        $tableRow = $this->tablecontents->get($index);
        $this->tablecontents->pull($index);
        if (! empty($tableRow['pre_id'] ?? '')) {
            BlogTableContent::find()->delete($tableRow['pre_id']);
        }
    }

    public function render()
    {
        return view('livewire.admin.blog.update-form');
    }

    public function rules()
    {
        $this->title = \Illuminate\Support\Str::squish($this->title);
        return [
            'post_date'                   => 'required|date',
            'category'                    => 'required',
            'image'                       => 'nullable|max:5000|mimes:jpg,png,jpeg,webp',
            'banner'                      => 'nullable|max:5000|mimes:jpg,png,jpeg,webp',
            'title'                       => [
                'required',
                'max:200', 
                new TextRule(),
                new NoDangerousTags(),
                Rule::unique('blogs')->where(function ($query) {
                    $query->whereNULL('deleted_at');
                    $query->whereNot('id', $this->info->id);
                    $query->whereRaw('LOWER(TRIM(name)) = ?', [strtolower($this->title)]);
                }),
            ],
            'alias'                       => [
                'required', 'regex:/^[- a-z0-9A-Z]+$/u', 'unique:blogs,slug,' . $this->info->id . ',id,deleted_at,NULL', 'max:200', new TextRule(),new NoDangerousTags()],
            'short_description'           => ['nullable', 'max:300', 'min:100', new TextRule(),new NoDangerousTags()],
            'description'                 => ['nullable', new EditorRule()],
            'meta_title'                  => ['nullable', 'max:100', new TextRule(),new NoDangerousTags()],
            'meta_keywords'               => ['nullable', 'max:300', new TextRule(),new NoDangerousTags()],
            'meta_description'            => ['nullable', 'max:300', new TextRule(),new NoDangerousTags()],

            'tablecontents.*.title'       => ['nullable', 'required_with:tablecontents.*.description', 'max:200', new TextRule(),new NoDangerousTags()],
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

    public function updated()
    {
        $this->alias = trim($this->alias);
    }

    public function SaveForm()
    {
        $this->validate();

        $data = Blog::findOrFail($this->info->id);
        if (! empty($this->image)) {
            \Image::removeFile('blog/', $this->info->image);
            $imageName   = \Image::autoheight('blog/', $this->image);
            $data->image = $imageName;
        }
        if (! empty($this->banner)) {
            \Image::removeFile('blog/banner/', $this->info->banner);
            $bannerName   = \Image::autoheight('blog/banner/', $this->banner);
            $data->banner = $bannerName;
        }
        $data->name              = $this->title;
        $data->slug              = $this->alias;
        $data->post_date         = $this->post_date;
        $data->description       = $this->description;
        $data->short_description = $this->short_description;
        $data->category_id       = $this->category;
        $data->meta_title        = ! empty($this->meta_title) ? $this->meta_title : null;
        $data->meta_keywords     = ! empty($this->meta_keywords) ? $this->meta_keywords : null;
        $data->meta_description  = ! empty($this->meta_description) ? $this->meta_description : null;
        $data->save();
        $this->uploadTableContent();
        $this->dispatch('refreshBlogEdit', data: $data->id);
        $this->dispatch('successtoaster', ['title' => AlertMessageType::UPDATE, 'message' => AlertMessage::UPDATE]);
    }

    public function uploadTableContent()
    {
        foreach ($this->tablecontents as $content) {
            if (! empty($content['title'])) {
                if (! empty($content['pre_id'] ?? '')) {
                    $data = BlogTableContent::find($content['pre_id']);
                } else {
                    $data          = new BlogTableContent();
                    $data->blog_id = $this->info->id;
                }
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
