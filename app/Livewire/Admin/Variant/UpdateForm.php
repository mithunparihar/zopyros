<?php
namespace App\Livewire\Admin\Variant;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\Variant as Variants;
use App\Rules\TextRule;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UpdateForm extends Component
{
    public $title;
    public $info;
    protected $listeners = ['refreshVariantEdit' => 'mount'];
    public function mount(Variants $data)
    {
        $this->info  = $data;
        $this->title = $data->title;
    }
    public function render()
    {
        return view('livewire.admin.variant.update-form');
    }

    public function rules()
    {
        $this->title = \Illuminate\Support\Str::squish($this->title);
        return [
            'title' => [
                'required',
                'regex:/^([-.a-zA-Z\s])+$/u',
                'max:50',
                new TextRule(),
                Rule::unique('variants')->where(function ($qery) {
                    $qery->whereNULL('deleted_at');
                    $qery->where('parent_id', $this->info->parent_id);
                    $qery->whereNot('id', $this->info->id);
                    $qery->whereRaw('LOWER(TRIM(title)) = ?', [strtolower(trim($this->title))]);
                }),
            ],
        ];
    }

    public function SaveForm()
    {
        $this->validate();
        $data        = Variants::find($this->info->id);
        $data->title = $this->title;
        $data->save();
        $this->dispatch('refreshVariantEdit', data: $this->info->id);
        $this->dispatch('successtoaster', ['title' => AlertMessageType::UPDATE, 'message' => AlertMessage::UPDATE]);
    }
}
