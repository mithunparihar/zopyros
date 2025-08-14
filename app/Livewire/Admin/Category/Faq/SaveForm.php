<?php

namespace App\Livewire\Admin\Category\Faq;

use Livewire\Component;
use App\Models\Category;
use App\Models\CategoryFaq as Faq;
use App\Enums\AlertMessageType;
use App\Enums\AlertMessage;
use App\Rules\EditorRule;
use App\Rules\TextRule;

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
        return view('livewire.admin.category.faq.save-form');
    }

    function rules(){
        return [
            'title'=>['required','unique:category_faqs,title,NULL,id,deleted_at,NULL,category_id,'.$this->category,'max:200',new TextRule()],
            'description'=>['required',new EditorRule()],
       ];
    }

    public function updated()
    {
        $this->title = trim($this->title);
    }

    function SaveForm(){
        $this->validate();
        $data = new Faq();
        $data->title = $this->title;
        $data->description = $this->description;
        $data->category_id = $this->category;
        $data->save();
        $this->reset(['title','description']);
        $this->dispatch('emptyEditor');
        $this->dispatch('successtoaster',['title'=>AlertMessageType::SAVE,'message'=>AlertMessage::SAVE]);
    }
}
