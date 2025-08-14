<?php

namespace App\Livewire\Admin\Faq;

use Livewire\Component;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Enums\AlertMessageType;
use App\Enums\AlertMessage;
use App\Rules\EditorRule;
use App\Rules\TextRule;

class SaveForm extends Component
{
    public $title,$description,$category;
    public $categories=[];
    protected $listeners = ['updateEditorValue' => 'updateEditorValue'];
    public function updateEditorValue($modelId, $content)
    {
        if ($modelId == 'description') {
            $this->description = $content;
        }
    }
    public function mount(){
        $this->categories = FaqCategory::parent(0)->active()->get();
    }

    public function render()
    {
        return view('livewire.admin.faq.save-form');
    }

    function rules(){
        return [
            'category'=>'required',
            'title'=>['required','unique:faqs,title,NULL,id,deleted_at,NULL','max:200',new TextRule()],
            'description'=>['required',new EditorRule()],
       ];
    }

    function SaveForm(){
        $this->validate();
        $data = new Faq();
        $data->title = $this->title;
        $data->description = $this->description;
        $data->category_id = $this->category;
        $data->save();
        $this->reset(['title','description','category']);
        $this->dispatch('emptyEditor');
        $this->dispatch('successtoaster',['title'=>AlertMessageType::SAVE,'message'=>AlertMessage::SAVE]);
    }
}
