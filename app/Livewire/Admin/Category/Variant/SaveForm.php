<?php
namespace App\Livewire\Admin\Category\Variant;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\Category;
use App\Models\CategoryVariant;
use App\Models\Variant;
use App\Rules\TextRule;
use Livewire\Component;

class SaveForm extends Component
{
    public $categoryinfo;
    public $variants = [];
    public $variant, $title;
    public function mount(Category $category)
    {
        $this->categoryinfo = $category;
        $this->variants     = Variant::active()->get();
    }
    public function render()
    {
        return view('livewire.admin.category.variant.save-form');
    }

    protected function rules()
    {
        return [
            'variant' => ['required'],
            'title'   => ['required','unique:category_variants,title,NULL,id,deleted_at,NULL,category_id,'.$this->categoryinfo->id, 'max:50', new TextRule()],
        ];
    }

    public function SaveForm()
    {
        $this->validate();

        $data          = new CategoryVariant();
        $data->title   = $this->title;
        $data->variant_id = $this->variant;
        $data->category_id = $this->categoryinfo->id;
        $data->save();
        $this->reset(['variant', 'title']);
        $this->dispatch('successtoaster', ['title' => AlertMessageType::SAVE, 'message' => AlertMessage::SAVE]);

    }
}
