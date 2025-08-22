<?php
namespace App\Livewire\Admin\Product;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\Product as Products;
use App\Rules\EditorRule;
use App\Rules\TextRule;
use App\Rules\NoDangerousTags;
use Livewire\Component;
use Livewire\WithFileUploads;

class SaveForm extends Component
{
    use WithFileUploads;
    public $title, $heading, $description, $specifications;
    public $categories = [], $size_category;
    public $meta_description, $meta_keywords, $meta_title;
    protected $listeners       = ['updateEditorValue' => 'updateEditorValue', 'resetMount' => 'mount'];
    public $categoriesArr      = [];
    public $sizeCategoryArr    = [];
    public $brochure, $technical;
    public $inputs, $inputsArr = [
        'colors'        => ['code' => '', 'name' => ''],
        'images'        => [],
        'primary_image' => '',
        'sizes'         => [],
    ];
    public function mount()
    {
        $this->categoriesArr   = \App\Models\Category::parent(0)->get();
        $this->sizeCategoryArr = \App\Models\Category::whereHas('variants', function ($qty) {
            return $qty->where('variant_id', 1);
        })->get();

        $this->fill([
            'inputs' => collect([$this->inputsArr]),
        ]);
    }
    public function catgeorySize($category)
    {
        $sizes = \App\Models\CategoryVariant::whereVariantId(1)->category($category)->get()->map(function ($item) {
            return [
                'id'      => $item->id,
                'title'   => $item->title,
                'sku'     => '',
                'mrp'     => '',
                'price'   => '',
                'stock'   => '',
                'publish' => 1,
            ];
        })->toArray();
        $inputs = $this->inputs->toArray();
        foreach ($inputs as $key => $value) {
           if(count($inputs[$key]['sizes'])==0){
                $inputs[$key]['sizes'] = $sizes;
            }
        }
        $this->inputs = collect($inputs);
    }
    public function eliminarImage($key, $index)
    {
        $inputs                     = $this->inputs->toArray();

        array_splice($inputs[$key]['images'], $index, 1);
        $this->inputs               = collect($inputs);
    }
    public function setPrimaryImage($key, $index)
    {
        $inputs                        = $this->inputs->toArray();
        $inputs[$key]['primary_image'] = $index;
        $this->inputs                  = collect($inputs);
    }
    public function AddMoreColor()
    {
        $this->inputs->push($this->inputsArr);
        $this->catgeorySize($this->size_category);
    }

    public function removeColor($index)
    {
        $this->inputs->pull($index);
    }

    public function render()
    {
        return view('livewire.admin.products.save-form');
    }

    public function updateEditorValue($modelId, $content)
    {
        if ($modelId == 'description') {
            $this->description = $content;
        }
        if ($modelId == 'specifications') {
            $this->specifications = $content;
        }
    }

    public function rules()
    {
        return [

            'title'                    => ['required', 'unique:products,title,NULL,id,deleted_at,NULL', 'max:300', new TextRule(), new NoDangerousTags()],
            'description'              => ['required', new EditorRule()],
            'specifications'           => ['nullable', new EditorRule()],
            'categories'               => ['required', 'array'],
            'meta_title'               => ['nullable', 'max:300', new TextRule(), new NoDangerousTags()],
            'meta_keywords'            => ['nullable', 'max:500', new TextRule(), new NoDangerousTags()],
            'meta_description'         => ['nullable', 'max:500', new TextRule(), new NoDangerousTags()],

            'brochure'    => ['nullable', 'max:5000', 'mimes:pdf,doc,docx'],
            'technical'    => ['nullable', 'max:5000', 'mimes:pdf,doc,docx'],

            'inputs.*.colors.name'     => ['required', 'distinct', 'max:50', new TextRule(), new NoDangerousTags()],
            'inputs.*.colors.code'     => ['required', 'distinct', 'regex:/^#(?:[0-9a-fA-F]{3}){1,2}$/'],
            'inputs.*.images'          => ['required'],
            'inputs.*.images.*'        => ['required', 'max:5000', 'mimes:jpg,png,jpeg,webp'],

            'inputs.*.sizes.*.sku'     => ['nullable', 'distinct', 'unique:product_variants,sku,NULL,id,deleted_at,NULL', 'regex:/^[A-Za-z0-9_-]+$/', 'required_with:inputs.*.sizes.*.mrp'],
            'inputs.*.sizes.*.mrp'     => ['nullable', 'integer', 'between:1,10000000', 'required_with:inputs.*.sizes.*.price,inputs.*.sizes.*.sku', 'gte:inputs.*.sizes.*.price'],
            'inputs.*.sizes.*.price'   => ['nullable', 'integer', 'between:1,10000000', 'required_with:inputs.*.sizes.*.mrp'],
            'inputs.*.sizes.*.stock'   => ['nullable', 'integer', 'between:1,10000', 'required_with:inputs.*.sizes.*.price,inputs.*.sizes.*.sku'],
            'inputs.*.sizes.*.publish' => ['nullable', 'integer', 'required_with:inputs.*.sizes.*.mrp'],
        ];
    }

    protected $messages = [
        'inputs.*.colors.code.regex' => 'The color must be a valid HEX code (e.g. #abc or #aabbcc).',
    ];

    protected $validationAttributes = [
        'inputs.*.colors.name'     => 'color name',
        'inputs.*.colors.code'     => 'color code',
        'inputs.*.images'          => 'image',
        'inputs.*.images.*'        => 'image',

        'inputs.*.sizes.*.sku'     => 'sku',
        'inputs.*.sizes.*.mrp'     => 'mrp',
        'inputs.*.sizes.*.price'   => 'price',
        'inputs.*.sizes.*.stock'   => 'stock',
        'inputs.*.sizes.*.publish' => 'publish',
    ];

    public function SaveForm()
    {

        $this->validate();
        $data                   = new Products();
        $data->title            = $this->title;
        $data->alias            = $this->title;
        $data->size_category = $this->size_category;
        $data->specification    = $this->specifications;
        $data->description      = $this->description;
        $data->meta_title       = $this->meta_title;
        $data->meta_keywords    = $this->meta_title;
        $data->meta_description = $this->meta_title;
        if ($this->brochure) {
            $data->brochure_doc = \Image::uploadFile('product/brochure', $this->brochure);
        }
        if ($this->technical) {
            $data->technical_doc = \Image::uploadFile('product/technical', $this->technical);
        }
        $data->save();

        $this->saveColors($data->id);
        $this->saveCategory($data->id);

        $this->dispatch('emptyEditor');
        $this->dispatch('resetMount');
        $this->inputs = collect($this->inputsArr);
        $this->reset(['title', 'description', 'categories', 'size_category', 'specifications', 'meta_title', 'meta_keywords', 'meta_description']);
        $this->dispatch('successtoaster', ['title' => AlertMessageType::SAVE, 'message' => AlertMessage::SAVE]);
    }

    public function saveCategory($productId)
    {
        if (count($this->categories ?? []) > 0) {
            foreach ($this->categories as $category) {
                $data              = new \App\Models\ProductCategory();
                $data->product_id  = $productId;
                $data->category_id = $category;
                $data->save();
            }
        }
    }
    public function saveColors($productId)
    {
        foreach ($this->inputs as $key => $inputs) {
            $data             = new \App\Models\ProductColor();
            $data->product_id = $productId;
            $data->hex        = $inputs['colors']['code'];
            $data->name       = $inputs['colors']['name'];
            $data->alias       = $inputs['colors']['name'];
            $data->is_publish = 1;
            $data->save();

            $this->saveImage($productId, $data->id, $inputs);
            $this->saveSizes($productId, $data->id, $inputs);
        }
    }

    public function saveSizes($productId, $colorId, $inputs)
    {
        foreach ($inputs['sizes'] ?? [] as $szk => $sizes) {
            if ($sizes['mrp'] > 0 && $sizes['price'] > 0) {
                $data             = new \App\Models\ProductVariant();
                $data->product_id = $productId;
                $data->color_id   = $colorId;
                $data->variant_id = $sizes['id'];
                $data->sku        = $sizes['sku'];
                $data->mrp        = $sizes['mrp'];
                $data->price      = $sizes['price'];
                $data->stock      = $sizes['stock'];
                $data->is_publish = $sizes['publish'];
                $data->save();
            }
        }
    }
    public function saveImage($productId, $colorId, $inputs)
    {
        if (count($inputs['images'] ?? []) > 0) {
            foreach ($inputs['images'] ?? [] as $imk => $image) {
                $imageName        = \Image::autoheight('product/', $image);
                $data             = new \App\Models\ProductImage();
                $data->product_id = $productId;
                $data->color_id   = $colorId;
                $data->image      = $imageName;
                $data->is_primary = $inputs['primary_image'] == $imk ? 1 : 0;
                $data->save();
            }
        }
    }
}
