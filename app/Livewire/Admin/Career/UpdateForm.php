<?php

namespace App\Livewire\Admin\Career;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\Career;
use App\Rules\EditorRule;
use App\Rules\TextRule;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateForm extends Component
{
    use WithFileUploads;
    public $title, $location, $alias, $salary, $job_type, $short_description, $designation, $description;
    public $meta_description, $meta_keywords, $meta_title;
    public $categories = [], $info;
    protected $listeners = ['refreshCareerEdit' => 'mount', 'updateEditorValue' => 'updateEditorValue'];
    public function updateEditorValue($modelId, $content)
    {
        if ($modelId == 'description') {
            $this->description = $content;
        }
    }
    public function mount(Career $data)
    {
        $this->info = $data;
        $this->title = $data->title;
        $this->alias = $data->alias;
        $this->location = $data->location;
        $this->salary = $data->salary;
        $this->job_type = $data->job_type;
        $this->short_description = $data->short_description;
        $this->designation = $data->designation;
        $this->description = $data->description;
        $this->meta_title = $data->meta_title;
        $this->meta_keywords = $data->meta_keywords;
        $this->meta_description = $data->meta_description;
    }
    public function render()
    {
        return view('livewire.admin.career.update-form');
    }

    public function rules()
    {
        return [
            'title' => ['required', 'unique:careers,title,' . $this->info->id . ',id,deleted_at,NULL', 'max:100', new TextRule()],
            'alias' => ['required', 'unique:careers,alias,' . $this->info->id . ',id,deleted_at,NULL', 'max:100', new TextRule()],
            'description' => ['required', new EditorRule()],
            'designation' => ['required', 'regex:/^([a-zA-Z\s])+$/u', 'max:100', new TextRule()],
            'location' => ['required', 'regex:/^([a-zA-Z\s])+$/u', 'max:100', new TextRule()],
            'salary' => ['required', 'max:50', new TextRule()],
            'job_type' => ['required', 'regex:/^([a-zA-Z\s])+$/u', 'max:20', new TextRule()],
            'short_description' => ['required', 'max:300', new TextRule()],
            'meta_title' => ['nullable', 'max:200', new TextRule()],
            'meta_keywords' => ['nullable', 'max:500', new TextRule()],
            'meta_description' => ['nullable', 'max:500', new TextRule()],
        ];
    }

    public function SaveForm()
    {
        $this->validate();
        $data = Career::findOrFail($this->info->id);
        $data->title = $this->title;
        $data->alias = $this->alias;
        $data->location = $this->location;
        $data->salary = $this->salary ?? 0;
        $data->job_type = $this->job_type;
        $data->short_description = $this->short_description;
        $data->designation = $this->designation;
        $data->description = $this->description;
        $data->meta_title = !empty($this->meta_title) ? $this->meta_title : null;
        $data->meta_keywords = !empty($this->meta_keywords) ? $this->meta_keywords : null;
        $data->meta_description = !empty($this->meta_description) ? $this->meta_description : null;
        $data->save();
        $this->dispatch('refreshCareerEdit', data: $data->id);
        $this->dispatch('successtoaster', ['title' => AlertMessageType::UPDATE, 'message' => AlertMessage::UPDATE]);
    }
}
