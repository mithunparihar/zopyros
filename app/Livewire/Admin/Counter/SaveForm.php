<?php
namespace App\Livewire\Admin\Counter;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\Counter;
use App\Rules\TextRule;
use Livewire\Component;

class SaveForm extends Component
{
    public $title, $counter;

    public function render()
    {
        return view('livewire.admin.counter.save-form');
    }

    public function rules()
    {
        return [
            'title'   => ['required', 'unique:counters,title,NULL,id,deleted_at,NULL', 'max:100', new TextRule()],
            'counter' => ['required', 'integer', 'digits_between:1,7'],
        ];
    }

    public function SaveForm()
    {
        $this->validate();
        $data          = new Counter();
        $data->title   = $this->title;
        $data->counter = $this->counter;
        $data->save();
        $this->reset(['counter', 'title']);
        $this->dispatch('successtoaster', ['title' => AlertMessageType::SAVE, 'message' => AlertMessage::SAVE]);
    }
}
