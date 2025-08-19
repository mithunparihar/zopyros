<?php
namespace App\Livewire\Admin\Product;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\Product as Products;
use App\Rules\EditorRule;
use App\Rules\NoDangerousTags;
use App\Rules\TextRule;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateForm extends Component
{
    use WithFileUploads;
    public $info;
    public $title, $alias, $description, $size_category, $specifications;
    public $meta_description, $meta_keywords, $meta_title;
    public $categories         = [];
    public $categoriesArr      = [];
    public $sizeCategoryArr    = [];
    public $inputs, $inputsArr = [
        'colors'        => ['code' => '', 'name' => ''],
        'images'        => [],
        'primary_image' => '',
        'sizes'         => [],
    ];
    protected $listeners = ['refreshProductEdit' => 'mount', 'updateEditorValue' => 'updateEditorValue'];
    public function mount(Products $data)
    {
        $this->info             = $data;
        $this->title            = $data->title;
        $this->alias            = $data->alias;
        $this->specifications   = $data->specification;
        $this->size_category    = $data->size_category;
        $this->description      = $data->description;
        $this->meta_title       = $data->meta_title;
        $this->meta_keywords    = $data->meta_keywords;
        $this->meta_description = $data->meta_description;

        $this->categories = $data->categories()->pluck('category_id')->toArray();

        $this->categoriesArr   = \App\Models\Category::parent(0)->get();
        $this->sizeCategoryArr = \App\Models\Category::whereHas('variants', function ($qty) {
            return $qty->where('variant_id', 1);
        })->get();

        $this->fillData();

    }

    public function fillData()
    {
        $inputsArr = [];

        $sizes = \App\Models\CategoryVariant::whereVariantId(1)->category($this->size_category)->get()->map(function ($item) {
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

        $colors = $this->info->colors()->get();
        foreach ($colors as $color) {
            $variants = $color->variants;
            $sizesArr = [];
            foreach ($sizes as $size) {
                $matchedVariant = $variants->firstWhere('variant_id', $size['id']);
                $sizesArr[]     = [
                    'id'      => $size['id'],
                    'title'   => $size['title'],
                    'sku'     => $matchedVariant->sku ?? '',
                    'mrp'     => $matchedVariant->mrp ?? '',
                    'price'   => $matchedVariant->price ?? '',
                    'stock'   => $matchedVariant->stock ?? '',
                    'publish' => $matchedVariant->is_publish ?? 1,
                    'pre_id'  => $matchedVariant->id ?? '',
                ];
            }

            $inputsArr[] = [
                'colors'        => ['code' => $color->hex, 'name' => $color->name, 'id' => $color->id],
                'pre_images'    => $color->images()->get(),
                'images'        => [],
                'primary_image' => '',
                'sizes'         => $sizesArr,
            ];
        }

        $this->fill([
            'inputs' => collect($inputsArr),
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
            if (count($inputs[$key]['sizes']) == 0) {
                $inputs[$key]['sizes'] = $sizes;
            }
        }
        $this->inputs = collect($inputs);
    }
    public function setPrimaryImage($key, $index)
    {
        $inputs                        = $this->inputs->toArray();
        $inputs[$key]['primary_image'] = $index;

        foreach ($inputs[$key]['pre_images'] as $index => $preImage) {
            $inputs[$key]['pre_images'][$index]['is_primary'] = 0;
        }

        $this->inputs = collect($inputs);
    }

    public function setPrimaryPreImage($key, $preImageIndex)
    {
        $inputs = $this->inputs->toArray();
        foreach ($inputs[$key]['pre_images'] as $index => $preImage) {
            $inputs[$key]['pre_images'][$index]['is_primary'] = 0;
            $this->isPrimaryPreImage($preImage->id, 0);
        }
        $inputs[$key]['pre_images'][$preImageIndex]['is_primary'] = 1;
        $this->isPrimaryPreImage($inputs[$key]['pre_images'][$preImageIndex]['id'], 1);

        $inputs[$key]['primary_image'] = '';
        $this->inputs                  = collect($inputs);

    }

    public function AddMoreColor()
    {
        $this->inputs->push($this->inputsArr);
        $this->catgeorySize($this->size_category);
    }

    public function removeColor($index)
    {
        $inputs = $this->inputs[$index];
        $this->inputs->pull($index);
        if (! empty($inputs['colors']['id'] ?? '')) {
            $colors = \App\Models\ProductColor::find($inputs['colors']['id']);
            foreach ($colors->images as $image) {
                \Image::removeFile('product/', $image->image);
                $image->delete();
            }
            $colors->variants()->delete();
            $colors->delete();
        }
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

    public function render()
    {
        return view('livewire.admin.products.update-form');
    }

    public function rules()
    {
        $rules = [

            'title'                => ['required', 'unique:products,title,' . $this->info->id . ',id,deleted_at,NULL', 'max:300', new TextRule(), new NoDangerousTags()],
            'alias'                => ['required', 'unique:products,alias,' . $this->info->id . ',id,deleted_at,NULL', 'max:300', new TextRule(), new NoDangerousTags()],
            'description'          => ['required', new EditorRule()],
            'specifications'       => ['nullable', new EditorRule()],
            'categories'           => ['required', 'array'],
            'meta_title'           => ['nullable', 'max:300', new TextRule(), new NoDangerousTags()],
            'meta_keywords'        => ['nullable', 'max:500', new TextRule(), new NoDangerousTags()],
            'meta_description'     => ['nullable', 'max:500', new TextRule(), new NoDangerousTags()],

            'inputs.*.colors.name' => ['required', 'distinct', 'max:50', new TextRule(), new NoDangerousTags()],
            'inputs.*.colors.code' => ['required', 'distinct', 'regex:/^#(?:[0-9a-fA-F]{3}){1,2}$/'],
            'inputs.*.images.*'    => ['required', 'max:5000', 'mimes:jpg,png,jpeg,webp'],

            // 'inputs.*.sizes.*.sku'     => ['nullable', 'distinct', 'unique:product_variants,sku,NULL,id,deleted_at,NULL', 'regex:/^[A-Za-z0-9_-]+$/', 'required_with:inputs.*.sizes.*.mrp'],
            // 'inputs.*.sizes.*.mrp'     => ['nullable', 'integer', 'between:1,10000000', 'required_with:inputs.*.sizes.*.price,inputs.*.sizes.*.sku', 'gte:inputs.*.sizes.*.price'],
            // 'inputs.*.sizes.*.price'   => ['nullable', 'integer', 'between:1,10000000', 'required_with:inputs.*.sizes.*.mrp'],
            // 'inputs.*.sizes.*.stock'   => ['nullable', 'integer', 'between:1,10000', 'required_with:inputs.*.sizes.*.price,inputs.*.sizes.*.sku'],
            // 'inputs.*.sizes.*.publish' => ['nullable', 'integer', 'required_with:inputs.*.sizes.*.mrp'],
        ];

        foreach ($this->inputs as $key => $input) {
            foreach ($input['sizes'] as $i => $size) {
                $preId                                 = $size['pre_id'] ?? 'NULL';
                $rules["inputs.$key.sizes.$i.sku"]     = ['nullable', 'distinct', 'unique:product_variants,sku,' . $preId . ',id,deleted_at,NULL,color_id,' . ($input['colors']['id'] ?? 'NULL') . ',product_id,' . $this->info->id, 'regex:/^[A-Za-z0-9_-]+$/', 'required_with:inputs.' . $key . '.sizes.' . $i . '.mrp'];
                $rules["inputs.$key.sizes.$i.mrp"]     = ['nullable', 'integer', 'between:1,10000000', 'required_with:inputs.' . $key . '.sizes.' . $i . '.price'];
                $rules["inputs.$key.sizes.$i.price"]   = ['nullable', 'integer', 'between:1,10000000', 'required_with:inputs.' . $key . '.sizes.' . $i . '.mrp,inputs.' . $key . '.sizes.' . $i . '.sku'];
                $rules["inputs.$key.sizes.$i.stock"]   = ['nullable', 'integer', 'between:1,10000', 'required_with:inputs.' . $key . '.sizes.' . $i . '.sku'];
                $rules["inputs.$key.sizes.$i.publish"] = ['nullable', 'integer', 'required_with:inputs.' . $key . '.sizes.' . $i . '.mrp'];
            }
        }

        return $rules;
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

        $data                   = Products::findOrFail($this->info->id);
        $data->title            = $this->title;
        $data->alias            = $this->alias;
        $data->description      = $this->description;
        $data->meta_title       = $this->meta_title;
        $data->meta_keywords    = $this->meta_keywords;
        $data->meta_description = $this->meta_description;
        $data->save();

        $this->saveColors($data->id);
        $this->saveCategory($data->id);

        $this->dispatch('refreshProductEdit', data: $data->id);
        $this->dispatch('successtoaster', ['title' => AlertMessageType::UPDATE, 'message' => AlertMessage::UPDATE]);
    }

    public function saveCategory($productId)
    {
        if (count($this->categories ?? []) > 0) {

            \App\Models\ProductCategory::whereProductId($productId)->delete();
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
            if (! empty($inputs['colors']['id'] ?? '')) {
                $data = \App\Models\ProductColor::find($inputs['colors']['id'] ?? 0);
            } else {
                $data             = new \App\Models\ProductColor();
                $data->product_id = $productId;
            }
            $data->hex        = $inputs['colors']['code'];
            $data->name       = $inputs['colors']['name'];
            $data->is_publish = 1;
            $data->save();

            $this->saveImage($productId, $data->id, $inputs);
            $this->saveSizes($productId, $data->id, $inputs);
        }
    }

    public function saveImage($productId, $colorId, $inputs)
    {
        \App\Models\ProductImage::where('product_id', $productId)
            ->where('color_id', $colorId)
            ->update(['is_primary' => 0]);

        if (count($inputs['images'] ?? []) > 0) {
            foreach ($inputs['images'] ?? [] as $imk => $image) {
                $imageName        = \Image::autoheight('product/', $image);
                $data             = new \App\Models\ProductImage();
                $data->product_id = $productId;
                $data->color_id   = $colorId;
                $data->image      = $imageName;
                $data->is_primary = ($inputs['primary_image'] == $imk) ? 1 : 0;
                $data->save();
            }

        }

        if (count($inputs['pre_images'] ?? []) > 0) {
            foreach ($inputs['pre_images'] as $pimk => $preImage) {
                $this->isPrimaryPreImage($preImage->id, $preImage->is_primary);
            }
        }
    }

    public function saveSizes($productId, $colorId, $inputs)
    {
        foreach ($inputs['sizes'] ?? [] as $szk => $sizes) {
            if ($sizes['mrp'] > 0 && $sizes['price'] > 0) {

                $check = \App\Models\ProductVariant::where([
                    'product_id' => $productId,
                    'color_id'   => $colorId,
                    'variant_id' => $sizes['id'],
                ])->first();

                if ($check) {
                    $data = \App\Models\ProductVariant::find($check->id);
                } else {
                    $data = new \App\Models\ProductVariant();
                }

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

    public function isPrimaryPreImage($id, $isPrimary)
    {
        $imageModel = \App\Models\ProductImage::find($id);
        if ($imageModel) {
            $imageModel->is_primary = $isPrimary;
            $imageModel->save();
        }
    }
}
