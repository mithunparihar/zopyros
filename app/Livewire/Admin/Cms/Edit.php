<?php

namespace App\Livewire\Admin\Cms;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\Cms;
use App\Rules\EditorRule;
use App\Rules\TextRule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;
    public $info;
    public $title, $heading, $short_description, $description, $image;
    public $button, $url;
    public $table_title = [];
    public $table_issue_date = [];
    public $table_description = [];
    public $table_file = [];
    public $imageWidth = 1600, $contentLength;

    public $counters, $counterInput = ['heading' => '', 'counter' => '', 'image' => ''];

    protected $listeners = ['refreshCms' => 'mount', 'updateEditorValue' => 'updateEditorValue'];
    public function mount(Cms $data)
    {
        $this->info = $data;
        $this->heading = $this->info->heading;
        $this->title = $this->info->title;
        $this->description = $this->info->description;
        $this->short_description = $this->info->short_description;
        $this->button = $this->info->button_name;
        $this->url = $this->info->url;

        if (in_array($this->info->id, [1, 10, 11, 12])) {$this->imageWidth = 550;}
        if (count($data->counters ?? []) == 0) {
            $counterInput = [$this->counterInput];
        } else {
            $counterInput = $data->counters;

        }
        $this->fill([
            'counters' => collect($counterInput),
        ]);

    }

    public function AddMoreCounter()
    {
        if (count($this->counters) < 4) {
            $this->counters->push(['heading' => '', 'counter' => '', 'image' => '']);
        } else {
            flash()->error('Oops! You can’t add more than 4 records.');
        }
    }

    public function RemoveCounter($index)
    {
        $countersInput = $this->counters[$index];
        $this->counters->pull($index);

        if (!empty($countersInput['pre_image'] ?? '')) {
            \Image::removeFile('counter/', $countersInput['pre_image']);
        }

        $data = Cms::findOrFail($this->info->id);
        $data->counters = $this->counters;
        $data->save();
    }

    public function render()
    {
        return view('livewire.admin.cms.edit');
    }

    public function rules()
    {
        return [
            'url' => ['nullable', 'max:300', 'url'],
            'button' => ['nullable', 'max:100', new TextRule()],
            'title' => ['required', 'max:100', new TextRule()],
            'heading' => ['nullable', 'max:100', new TextRule()],
            'description' => [in_array($this->info->id, [2, 3, 4, 5, 6,10,13,14,15]) ? 'nullable' : 'required', new EditorRule()],
            'short_description' => ['nullable', 'max:1000', new EditorRule()],
            'image' => 'nullable|max:5000|mimes:jpg,png,jpeg,webp',
        ];
    }

    public function UpdateForm()
    {
        $this->validate();
        if (!empty($this->image)) {
            \Image::removeFile('cms/', $this->info->image);
            $imageName = \Image::autoheight('cms/', $this->image);
        }
        $data = Cms::findOrFail($this->info->id);
        $data->title = $this->title;
        $data->heading = $this->heading;
        $data->description = $this->description;
        $data->short_description = $this->short_description;
        if (!empty($this->image)) {$data->image = $imageName;}
        $data->url = $this->url;

        $data->save();
        $this->dispatch('refreshCms', data: $data->id);

        $this->dispatch('successtoaster', ['title' => AlertMessageType::UPDATE, 'message' => AlertMessage::UPDATE]);
    }

    public function updateEditorValue($modelId, $content)
    {
        if ($modelId == 'description') {
            $this->description = $content;
        }
    }

}
