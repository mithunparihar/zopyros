<?php
namespace App\Livewire\Admin\Variant;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\Variant as Variants;
use App\Rules\TextRule;
use Illuminate\Validation\Rule;
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
            'title' => [
                'required',
                'max:50',
                'regex:/^([-.a-zA-Z\s])+$/u', 
                new TextRule(),
                Rule::unique('variants')->where(function ($query) {
                    $query->whereNULL('deleted_at');
                    $query->where('parent_id', $this->parent);
                    $query->whereRaw('LOWER(TRIM(title)) = ?', [strtolower(trim($this->title))]);
                }),
            ],
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
