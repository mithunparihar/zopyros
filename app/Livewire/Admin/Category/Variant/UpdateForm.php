<?php
namespace App\Livewire\Admin\Category\Variant;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\CategoryVariant;
use App\Models\Variant;
use App\Rules\TextRule;
use Livewire\Component;

class UpdateForm extends Component
{
    public $categoryinfo, $info;
    public $variants = [];
    public $variant, $title;
    protected $listeners = ['refreshVariantCatEdit' => 'mount'];

    public function mount(CategoryVariant $data)
    {
        $this->info         = $data;
        $this->title        = $data->title;
        $this->variant      = $data->variant_id;
        $this->categoryinfo = $data->categoryInfo;
        $this->variants     = Variant::active()->get();
    }

    public function render()
    {
        return view('livewire.admin.category.variant.update-form');
    }

    protected function rules()
    {
        return [
            'variant' => ['required'],
            'title'   => ['required', 'unique:category_variants,title,' . $this->info->id . ',id,deleted_at,NULL,category_id,' . $this->categoryinfo->id, 'max:50', new TextRule()],
        ];
    }

    public function SaveForm()
    {
        $this->validate();

        $data              = CategoryVariant::find($this->info->id);
        $data->title       = $this->title;
        $data->variant_id  = $this->variant;
        $data->category_id = $this->categoryinfo->id;
        $data->save();
        $this->dispatch('refreshVariantCatEdit', data: $this->info->id);
        $this->dispatch('successtoaster', ['title' => AlertMessageType::UPDATE, 'message' => AlertMessage::UPDATE]);

    }
}
