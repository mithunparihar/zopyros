<?php

namespace App\Livewire\Admin\Service;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\ServiceCategory;
use App\Models\Service;
use App\Models\ServiceImage;
use App\Models\ServiceKeyFeature;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ServicePrice;

class SaveForm extends Component
{
    use WithFileUploads;
    public $title, $description, $images;
    public $meta_description, $meta_keywords, $meta_title;
    public $description2;
    public $category;
    public $categories = [],$searchcategory;
    public $features;
    public $featuresFillInput = ['title' => '', 'description' => '','status'];
    public $typeprices, $typeFillInput = ['title' => '', 'mrp' => '', 'price' => '', 'status' => 1];
    public $primaryImageIndex;
    public $mrp, $price;
    public $companies = [], $searchcompany, $company;
    protected $listeners = ['refreshServiceAdd' => 'mount'];
    public function mount()
    {
        $this->categories = ServiceCategory::active()->parent(0)->get();
        $this->fill([
            'features' => collect([$this->featuresFillInput]),
        ]);

        $this->fill([
            'typeprices' => collect([$this->typeFillInput]),
        ]);

        $this->companies = \App\Models\Company::whereHas('userInfo', function ($qry) {
            return $qry->active();
        })->limit(30)->get();
    }

    public function searchCompany($value)
    {
        $this->companies = \App\Models\Company::whereHas('userInfo', function ($qry) use ($value) {
            return $qry->active()->where('user_id', 'LIKE', '%' . $value . '%');
        })->orwhere('name', 'LIKE', '%' . $value . '%')->limit(30)->get();

        if (empty($value)) {
            $this->company = '';
            $this->searchcompany = '';
        }
    }

    public function selectCompany($companyId)
    {
        $company = \App\Models\Company::whereHas('userInfo', function ($qry) {
            return $qry->active();
        })->find($companyId);

        if (!empty($company)) {
            $this->company = $company->userInfo->id ?? 0;
            $this->searchcompany = $company->name . ' (#' . $company->userInfo->user_id . ')';
        }

    }

    function updateCategory(){

    }

    public function removePrice($index)
    {
        $Data = $this->typeprices[$index];
        $this->typeprices->pull($index);
    }
    public function addPrice()
    {
        if (count($this->typeprices) == 20) {
            flash()->Error('You can add only 20 records at a time');
        } else {
            $this->typeprices->push($this->typeFillInput);
        }

    }

    public function render(){
        return view('livewire.admin.service.save-form');
    }

    public function removeFeatures($index)
    {
        $Data = $this->features[$index];
        $this->features->pull($index);
    }
    public function addFeatures()
    {
        if (count($this->features) == 12) {
            flash()->adderror('Oops! You can only add up to 12 records at once.');
        } else {
            $this->features->push($this->featuresFillInput);
        }

    }
    public function updated()
    {
        if (count($this->images ?? []) > 6) {
            $this->reset('images');
            $this->dispatch('errortoaster', ['title' => 'Sorry!', 'message' => 'You can`t upload more than 6 images.']);
        }
    }

    public function eliminarImage($index)
    {
        array_splice($this->images, $index, 1);
    }
    public function setPreviewImagePrimary($index)
    {
        foreach ($this->images as $key => $images) {
            if ($key == $index) {
                $images->primary_image = true;
                $this->primaryImageIndex = $index;
            } else {
                $images->primary_image = false;
            }
        }
    }

    public function rules()
    {
        return [
            'company' => ['required'],
            'category' => 'required',
            'images' => 'required',
            'images.*' => 'nullable|max:5000|mimes:jpg,png,jpeg,webp',
            'title' => ['required', 'unique:products,title,NULL,id,deleted_at,NULL', 'max:300', function ($attribute, $value, $fail) {\CommanFunction::repeatedValidation($value, $fail);}],
            'description' => ['required', function ($attribute, $value, $fail) {\CommanFunction::repeatedValidation2($value, $fail);}],
            'description2' => ['nullable', function ($attribute, $value, $fail) {\CommanFunction::repeatedValidation2($value, $fail);}],
            'meta_title' => ['nullable', 'max:200', function ($attribute, $value, $fail) {\CommanFunction::repeatedValidation($value, $fail);}],
            'meta_keywords' => ['nullable', 'max:500', function ($attribute, $value, $fail) {\CommanFunction::repeatedValidation($value, $fail);}],
            'meta_description' => ['nullable', 'max:500', function ($attribute, $value, $fail) {\CommanFunction::repeatedValidation($value, $fail);}],
            // 'mrp' => ['required','between:1,100000'],
            // 'price' => ['required','between:1,100000','lte:mrp'],
            'features.*.title' => ['nullable', 'required_with:features.*.description', 'max:100', function ($attribute, $value, $fail) {\CommanFunction::repeatedValidation($value, $fail);}],
            'features.*.description' => ['nullable', 'required_with:features.*.title', 'max:500', function ($attribute, $value, $fail) {\CommanFunction::repeatedValidation2($value, $fail);}],

            'typeprices.*.title' => ['required', 'max:100', function ($attribute, $value, $fail) {\CommanFunction::repeatedValidation($value, $fail);}],
            'typeprices.*.mrp' => ['required', 'integer', 'between:0,100000000'],
            'typeprices.*.price' => ['required', 'integer', 'between:0,100000000', 'lte:typeprices.*.mrp'],
        ];
    }

    public function messages()
    {
        return [
            'typeprices.*.mrp.between' => 'The mrp field must be between 0 and 1cr.',
            'typeprices.*.price.between' => 'The price field must be between 0 and 1cr.',
        ];
    }

    public function validationAttributes()
    {
        return [
            'title' => 'product name',
            'price' => 'selling price',
            'description2' => 'specifications',
            'images.*' => 'image',
            'features.*.title' => 'key feature title',
            'features.*.description' => 'key feature description',
            'features.*.status' => 'status',

            'typeprices.*.title' => 'title',
            'typeprices.*.mrp' => 'mrp',
            'typeprices.*.price' => 'price',
            'typeprices.*.status' => 'status',
        ];
    }

    public function SaveForm()
    {
        $this->validate();
        $data = new Service();
        $data->title = $this->title;
        $data->alias = $this->title;
        $data->user_id = $this->company;
        // $data->mrp = $this->mrp;
        // $data->price = $this->price;
        $data->category_id = $this->category;
        $data->description = $this->description;
        $data->description2 = $this->description2;
        $data->meta_title = !empty($this->meta_title) ? $this->meta_title : $this->title;
        $data->meta_keywords = !empty($this->meta_keywords) ? $this->meta_keywords : $this->title;
        $data->meta_description = !empty($this->meta_description) ? $this->meta_description : $this->title;

        $data->approval_status = 1;
        $data->approval_date = \Carbon\Carbon::now();

        $data->save();

        if (is_array($this->images)) {
            foreach ($this->images as $k => $image) {
                $imageName = \CommanFunction::autoheight('service/', 550, $image);
                $imageData = new ServiceImage();
                $imageData->image = $imageName;
                $imageData->service_id = $data->id;
                if ($this->primaryImageIndex == $k) {
                    $imageData->is_primary = 1;
                } elseif (empty($this->primaryImageIndex)) {
                    $imageData->is_primary = $k == 0 ? 1 : 0;
                }

                $imageData->save();
            }
        }
        $this->uploadFeatures($data->id);
        $this->uploadTypeprices($data->id);
        $this->reset('images');
        $this->reset(['mrp','price', 'title','searchcompany','company', 'description', 'description2', 'meta_title', 'meta_keywords', 'meta_description', 'category']);
        $this->dispatch('emptyEditor');
        $this->dispatch('refreshServiceAdd');

        $this->dispatch('successtoaster', ['title' => AlertMessageType::SAVE, 'message' => AlertMessage::SAVE]);
    }

    public function uploadFeatures($product)
    {
        if (count($this->features) > 0) {
            foreach ($this->features as $k => $features) {
                if (!empty($features['title'])) {
                    $featureData = new ServiceKeyFeature();
                    $featureData->title = $features['title'];
                    $featureData->description = $features['description'];
                    $featureData->service_id = $product;
                    $featureData->is_publish = $features['status'] ?? 0;
                    $featureData->save();
                }
            }
        }
    }

    public function uploadTypeprices($product)
    {
        if (count($this->typeprices) > 0) {
            foreach ($this->typeprices as $k => $typeprices) {
                if (!empty($typeprices['title'])) {
                    $featureData = new ServicePrice();
                    $featureData->title = $typeprices['title'] ?? null;
                    $featureData->mrp = $typeprices['mrp'] ?? null;
                    $featureData->price = $typeprices['price'] ?? null;
                    $featureData->service_id = $product;
                    $featureData->is_publish = $typeprices['status'] ?? 0;
                    $featureData->save();
                }
            }
        }
    }

    function setcategoryValue($category){
        $cat = ServiceCategory::find($category);
        $this->category = $category;
        $this->searchcategory = $cat->title;
    }
}
