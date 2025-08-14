<?php

namespace App\Livewire\Admin\Meta;

use Livewire\Component;
use App\Models\Meta;
use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Rules\EditorRule;
use App\Rules\TextRule;

class UpdateForm extends Component
{
    public $meta_title,$meta_keywords,$meta_description,$page,$info;
    public $categories=[];
    protected $listeners = ['refreshMetaEdit'=>'mount'];
    public function mount(Meta $data){
        $this->info = $data;
        $this->page = $data->page;
        $this->meta_title = $data->title;
        $this->meta_keywords = $data->keywords;
        $this->meta_description = $data->description;
    }
    public function render()
    {
        return view('livewire.admin.meta.update-form');
    }

    function rules(){
        return [
            'meta_title'=>['required','max:100',new TextRule()],
            'meta_keywords'=>['nullable','max:500',new TextRule()],
            'meta_description'=>['nullable','max:500',new TextRule()],
        ];
    }

    function SaveForm(){
        $this->validate();

        $data = Meta::findOrFail($this->info->id);
        $data->title = $this->meta_title;
        $data->keywords = !empty($this->meta_keywords) ? $this->meta_keywords : $this->meta_title ;
        $data->description = !empty($this->meta_description) ? $this->meta_description : $this->meta_title ;
        $data->save();
        $this->dispatch('refreshMetaEdit',data:$data->id);
        $this->dispatch('successtoaster',['title'=>AlertMessageType::UPDATE,'message'=>AlertMessage::UPDATE]);
    }
}
