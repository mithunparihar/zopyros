<?php
namespace App\Livewire\Admin\Counter;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\Counter;
use App\Rules\TextRule;
use Livewire\Component;

class UpdateForm extends Component
{
    public $title, $counter;
    public $info;

    public function mount(Counter $counter)
    {
        $this->info    = $counter;
        $this->title   = $counter->title;
        $this->counter = $counter->counter;
    }

    public function render()
    {
        return view('livewire.admin.counter.update-form');
    }

    public function rules()
    {
        return [
            'title'   => ['required', 'unique:counters,title,' . $this->info->id . ',id,deleted_at,NULL', 'max:100', new TextRule()],
            'counter' => ['required', 'integer', 'digits_between:1,7'],
        ];
    }

    public function SaveForm()
    {
        $this->validate();
        $data          = Counter::find($this->info->id);
        $data->title   = $this->title;
        $data->counter = $this->counter;
        $data->save();
        $this->dispatch('successtoaster', ['title' => AlertMessageType::UPDATE, 'message' => AlertMessage::UPDATE]);
    }
}
