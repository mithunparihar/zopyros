<?php
namespace App\Livewire;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\QuoteEnquiry;
use App\Rules\EmailRule;
use App\Rules\NoDangerousTags;
use App\Events\FreeEstimation;
use App\Rules\PhoneRule;
use App\Rules\TextRule;
use Livewire\Component;

class QuoteForm extends Component
{
    public $name, $contact, $message, $email;
    public $material, $color, $size, $product;
    protected $listeners = [
        'getcolor'    => 'selectedColor',
        'getsize'     => 'selectedSize',
        'getmaterial' => 'selectedMaterial',
    ];
    public function mount(Product $product, $colors = [], $sizes = [], $metals = [])
    {
        $this->product  = $product;
        $this->color    = $colors[0] ?? [];
        $this->size     = $sizes[0] ?? [];
        $this->material = $metals[0] ?? [];
    }

    public function selectedColor(ProductVariant $color)
    {
        $this->color = $color;
    }

    public function selectedSize(ProductVariant $size)
    {
        $this->size = $size;
    }

    public function selectedMaterial(ProductVariant $material)
    {
        $this->material = $material;
    }

    public function render()
    {
        return view('livewire.quote-form');
    }

    public function rules()
    {
        return [
            'name'    => ['required', 'max:50', new NoDangerousTags(), new TextRule()],
            'contact' => ['required', 'integer', 'digits_between:8,12', new PhoneRule()],
            'message' => ['required', 'max:500', new NoDangerousTags(), new TextRule()],
            'email'   => [
                'required',
                'max:74',
                'regex:/^[a-zA-Z0-9.@]+$/u',
                'regex:/(.+)@(.+)\.(.+)/i',
                new EmailRule()],
        ];
    }

    public function saveData()
    {

        $this->validate();

        $data                   = new QuoteEnquiry();
        $data->product_id       = $this->product->id ?? 0;
        $data->color_variant    = ($this->color->variantTypeInfo->title ?? '');
        $data->size_variant     = ($this->size->variantTypeInfo->title ?? '');
        $data->material_variant = ($this->material->variantTypeInfo->title ?? '');
        $data->name             = $this->name;
        $data->contact          = $this->contact;
        $data->email            = $this->email;
        $data->message          = $this->message;
        $data->save();

        FreeEstimation::dispatch($data);
        return redirect()->route('thankyou.quote');
    }
}
