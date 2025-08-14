<?php

namespace App\Livewire\Admin\Faq;

use Livewire\Component;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Enums\AlertMessageType;
use App\Enums\AlertMessage;
use App\Rules\EditorRule;
use App\Rules\TextRule;

class UpdateForm extends Component
{
    public $title,$description,$category;
    public $categories=[],$info;
    protected $listeners = ['refreshFaqEdit'=>'mount','updateEditorValue' => 'updateEditorValue'];
    public function updateEditorValue($modelId, $content)
    {
        if ($modelId == 'description') {
            $this->description = $content;
        }
    }
    public function mount(Faq $data){
        $this->info = $data;
        $this->title = $data->title;
        $this->description = $data->description;
        $this->category = $data->category_id;
        $this->categories = FaqCategory::parent(0)->active()->get();
    }
    public function render()
    {
        return view('livewire.admin.faq.update-form');
    }

    function rules(){
        return [
            'category'=>'required',
            'title'=>['required','unique:faqs,title,'.$this->info->id.',id,deleted_at,NULL','max:200',new TextRule()],
            'description'=>['required',new EditorRule()],
       ];
    }


    function SaveForm(){
        $this->validate();
        $data = Faq::findOrFail($this->info->id);
        $data->title = $this->title;
        $data->description = $this->description;
        $data->category_id = $this->category;
        $data->save();
        $this->dispatch('refreshFaqEdit',data:$data->id);
        $this->dispatch('successtoaster',['title'=>AlertMessageType::UPDATE,'message'=>AlertMessage::UPDATE]);
    }
}
