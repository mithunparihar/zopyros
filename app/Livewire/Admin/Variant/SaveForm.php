<?php
namespace App\Livewire\Admin\Variant;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\Variant as Variants;
use App\Rules\TextRule;
use Livewire\Component;

class SaveForm extends Component
{
    public $title;
    public $parent;
    public function mount()
    {
        $this->parent = request('parent') ?? 0;
    }

    public function render()
    {
        return view('livewire.admin.variant.save-form');
    }

    public function rules()
    {
        return [
            'title' => ['required', 'unique:variants,title,NULL,id,deleted_at,NULL,parent_id,'.$this->parent, 'max:50', new TextRule()],
        ];
    }

    public function SaveForm()
    {
        $this->validate();
        $data             = new Variants();
        $data->title      = $this->title;
        $data->parent_id  = $this->parent;
        $data->is_publish = true;
        $data->save();
        $this->reset(['title']);
        $this->dispatch('emptyEditor');
        $this->dispatch('successtoaster', ['title' => AlertMessageType::SAVE, 'message' => AlertMessage::SAVE]);
    }
}
