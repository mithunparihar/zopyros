<?php

namespace App\Livewire\Admin\Category\Faq;

use Livewire\Component;
use App\Models\Category;
use App\Models\CategoryFaq as Faq;
use App\Enums\AlertMessageType;
use App\Enums\AlertMessage;
use App\Rules\EditorRule;
use App\Rules\TextRule;

class UpdateForm extends Component
{
    public $title,$description,$category;
    public $info;
    protected $listeners = ['refreshCatFaqEdit'=>'mount','updateEditorValue' => 'updateEditorValue'];

    public function mount(Faq $data){
        $this->info = $data;
        $this->title = $data->title;
        $this->description = $data->description;
        $this->category = $data->category_id;
    }

    public function updateEditorValue($modelId, $content)
    {
        if ($modelId == 'description') {
            $this->description = $content;
        }
    }

    public function render()
    {
        return view('livewire.admin.category.faq.update-form');
    }

    function rules(){
        return [
            'title'=>['required','unique:category_faqs,title,'.$this->info->id.',id,deleted_at,NULL,category_id,'.$this->category,'max:200',new TextRule()],
            'description'=>['required',new EditorRule()],
       ];
    }

    public function updated()
    {
        $this->title = trim($this->title);
    }

    function SaveForm(){
        $this->validate();
        $data = Faq::findOrFail($this->info->id);
        $data->title = $this->title;
        $data->description = $this->description;
        $data->category_id = $this->category;
        $data->save();
        $this->dispatch('refreshCatFaqEdit',data:$data->id);
        $this->dispatch('successtoaster',['title'=>AlertMessageType::UPDATE,'message'=>AlertMessage::UPDATE]);
    }
}
