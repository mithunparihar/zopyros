<?php

namespace App\Livewire\Admin\Service\Category\Faq;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\ServiceCategory as Category;
use App\Models\ServiceCategoryFaq as Faq;
use App\Rules\EditorRule;
use App\Rules\TextRule;
use Livewire\Component;

class UpdateForm extends Component
{
    public $title, $description, $category;
    public $info;
    protected $listeners = ['refreshCatFaqEdit' => 'mount','updateEditorValue' => 'updateEditorValue'];

    public function mount(Faq $data)
    {
        $this->info = $data;
        $this->title = $data->title;
        $this->description = $data->description;
        $this->category = $data->service_category_id;
    }
    public function updateEditorValue($modelId, $content)
    {
        if ($modelId == 'description') {
            $this->description = $content;
        }
    }
    public function render()
    {
        return view('livewire.admin.service.category.faq.update-form');
    }

    public function rules()
    {
        return [
            'title' => ['required', 'unique:service_category_faqs,title,' . $this->info->id . ',id,deleted_at,NULL,service_category_id,' . $this->category, 'max:200', new TextRule()],
            'description' => ['required', new EditorRule()],
        ];
    }

    public function updated()
    {
        // $this->title = trim($this->title);
    }

    public function SaveForm()
    {
        $this->validate();
        $data = Faq::findOrFail($this->info->id);
        $data->title = $this->title;
        $data->description = $this->description;
        $data->save();
        $this->dispatch('refreshCatFaqEdit', data: $data->id);
        $this->dispatch('successtoaster', ['title' => AlertMessageType::UPDATE, 'message' => AlertMessage::UPDATE]);
    }
}
