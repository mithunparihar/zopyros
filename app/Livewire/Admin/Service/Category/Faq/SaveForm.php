<?php

namespace App\Livewire\Admin\Service\Category\Faq;

use Livewire\Component;
use App\Models\ServiceCategory as Category;
use App\Models\ServiceCategoryFaq as Faq;
use App\Enums\AlertMessageType;
use App\Enums\AlertMessage;
use App\Rules\TextRule;
use App\Rules\EditorRule;

class SaveForm extends Component
{
    public $title,$description,$category;
    protected $listeners = ['updateEditorValue' => 'updateEditorValue'];

    public function mount(Category $data){
        $this->category = $data->id;
    }
    public function updateEditorValue($modelId, $content)
    {
        if ($modelId == 'description') {
            $this->description = $content;
        }
    }
    public function render()
    {
        return view('livewire.admin.service.category.faq.save-form');
    }

    function rules(){
        return [
            'title'=>['required','unique:service_category_faqs,title,NULL,id,deleted_at,NULL,service_category_id,'.$this->category,'max:200',new TextRule()],
            'description'=>['required',new EditorRule()],
       ];
    }

    function SaveForm(){
        $this->validate();
        $data = new Faq();
        $data->title = $this->title;
        $data->description = $this->description;
        $data->service_category_id = $this->category;
        $data->save();
        $this->reset(['title','description']);
        $this->dispatch('emptyEditor');
        $this->dispatch('successtoaster',['title'=>AlertMessageType::SAVE,'message'=>AlertMessage::SAVE]);
    }
}
