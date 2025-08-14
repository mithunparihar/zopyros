<?php

namespace App\Livewire\Admin\Service;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\Service;
use App\Models\ServiceCategory as Category;
use App\Models\ServiceImage;
use App\Models\ServiceKeyFeature;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ServicePrice;

class UpdateForm extends Component
{
    use WithFileUploads;
    protected $listeners = ['refreshServiceEdit' => 'mount'];
    public $title, $description, $alias, $images;
    public $meta_description, $meta_keywords, $meta_title;
    public $description2;
    public $category;
    public $categories = [], $searchcategory;
    public $features;
    public $info;
    public $mrp, $price;
    public $disabled;
    public $productimages = [];
    public $featuresFillInput = ['title' => '', 'description' => '', 'status' => 1];
    public $typeprices, $typeFillInput = ['title' => '', 'mrp' => '', 'price' => '', 'status' => 1];
    public $companies = [], $searchcompany, $company;

    public function mount(Service $data, $disabled = false)
    {
        $this->disabled = $disabled;
        $this->info = $data;
        $this->title = $data->title;
        $this->alias = $data->alias;
        $this->category = $data->category_id;
        $this->description = $data->description;
        $this->description2 = $data->description2;
        $this->meta_title = $data->meta_title;
        $this->meta_keywords = $data->meta_keywords;
        $this->meta_description = $data->meta_description;
        $this->searchcategory = $data->categoryInfo->title ?? '';
        $this->categories = Category::active()->parent(0)->get();
        $this->companies = \App\Models\Company::whereHas('userInfo', function ($qry) {
            return $qry->active();
        })->limit(30)->get();
        $this->selectCompany($data->userInfo->companyInfo->id ?? 0);
        $this->getImages();

        $featuresFillInput = [];
        if (count($this->info->features) > 0) {
            foreach ($this->info->features as $features) {
                array_push($featuresFillInput, ['title' => $features->title, 'description' => $features->description,'status'=>$features->is_publish, 'preId' => $features->id]);
            }
        } else {
            $featuresFillInput = [$this->featuresFillInput];
        }
        $this->fill([
            'features' => collect($featuresFillInput),
        ]);
        $this->typePrice();
    }

    public function typePrice()
    {
        $typeFillInput = [];

        if (count($this->info->prices) > 0) {
            foreach ($this->info->prices as $prices) {
                array_push($typeFillInput, ['title' => $prices->title, 'mrp' => $prices->mrp, 'price' => $prices->price,'status'=>$prices->is_publish, 'preId' => $prices->id]);
            }
        } else {
            $typeFillInput = [$this->typeFillInput];
        }

        $this->fill([
            'typeprices' => collect($typeFillInput),
        ]);
    }
    public function removePrice($index)
    {
        $Data = $this->typeprices[$index];
        $this->typeprices->pull($index);
        if (($Data['preId'] ?? 0) > 0) {
            ServicePrice::find($Data['preId'])->delete();
        }
    }
    public function addPrice()
    {
        if (count($this->typeprices) == 20) {
            flash()->adderror('Oops! You can only add up to 12 records at once.');
        } else {
            $this->typeprices->push($this->typeFillInput);
        }

    }

    public function updateCategory($category)
    {
        // $this->sizeArr = Size::category($category)->active()->get();
        // $variants = $this->variants;
        // foreach ($variants as $ky => $variants) {
        //     $variants['sizes'] = $this->sizeArr;
        // }
        // $this->fill([
        //     'variants' => collect([$variants]),
        // ]);
    }

    public function render()
    {
        return view('livewire.admin.service.update-form');
    }

    public function removeFeatures($index)
    {
        $Data = $this->features[$index];
        $this->features->pull($index);
        if (($Data['preId'] ?? 0) > 0) {
            ServiceKeyFeature::find($Data['preId'])->delete();
        }
    }
    public function addFeatures()
    {
        if (count($this->features) == 12) {
            flash()->adderror('Oops! You can only add up to 12 records at once.');
        } else {
            $this->features->push($this->featuresFillInput);
        }

    }
    public function setPrimaryImage(ServiceImage $imageId)
    {
        ServiceImage::service($this->info->id)->whereNot('id', $imageId->id)->update(['is_primary' => 0]);
        $imageId->update(['is_primary' => 1]);
        $this->getImages();
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
            } else {
                $images->primary_image = false;
            }
        }
    }
    public function removeImage(ServiceImage $imageId)
    {
        $checkProductImages = ServiceImage::service($this->info->id)->count();
        if ($checkProductImages < 2) {
            $this->dispatch('errortoaster', ['title' => AlertMessageType::SORRY, 'message' => 'Deletion not allowed: This image is required and cannot be removed.']);
        } else {
            if ($imageId->is_primary == 1) {
                $findImage = ServiceImage::service($this->info->id)->whereNot('id', $imageId->id)->first();
                ServiceImage::whereId($findImage->id)->update(['is_primary' => 1]);
            }
            \CommanFunction::removeFile('service/', $imageId->image);
            $imageId->delete();
            $this->getImages();
        }

    }

    public function updated()
    {
        $totalImage = $this->info->images()->count() + count($this->images ?? []);
        if ($totalImage > 6) {
            $this->reset('images');
            $this->dispatch('errortoaster', ['title' => 'Sorry!', 'message' => 'You can`t upload more than 6 images.']);
        } elseif (count($this->images ?? []) > 0) {
            $this->validate();
            $this->uploadImages();
        }
        // $this->title = trim($this->title);
        $this->alias = trim($this->alias);
    }

    public function rules()
    {
        return [
            'company' => ['required'],
            'category' => 'required',
            'images.*' => 'nullable|max:5000|mimes:jpg,png,jpeg,webp',
            'title' => ['required', 'unique:services,title,' . $this->info->id . ',id,deleted_at,NULL', 'max:300', function ($attribute, $value, $fail) {\CommanFunction::repeatedValidation($value, $fail);}],
            'alias' => ['required', 'regex:/^([-a-zA-Z 0-9])+$/u', 'unique:services,alias,' . $this->info->id . ',id,deleted_at,NULL', 'max:300', function ($attribute, $value, $fail) {\CommanFunction::repeatedValidation($value, $fail);}],
            'description' => ['required', function ($attribute, $value, $fail) {\CommanFunction::repeatedValidation2($value, $fail);}],
            'description2' => ['nullable', function ($attribute, $value, $fail) {\CommanFunction::repeatedValidation2($value, $fail);}],
            'meta_title' => ['nullable', 'max:200', function ($attribute, $value, $fail) {\CommanFunction::repeatedValidation($value, $fail);}],
            'meta_keywords' => ['nullable', 'max:500', function ($attribute, $value, $fail) {\CommanFunction::repeatedValidation($value, $fail);}],
            'meta_description' => ['nullable', 'max:500', function ($attribute, $value, $fail) {\CommanFunction::repeatedValidation($value, $fail);}],
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
            'club.required_unless' => 'The club field is required.',
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
            'size.*.quantity' => 'quantity',
            'size.*.mrp' => 'mrp',
            'size.*.price' => 'price',
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
        $data = Service::findOrFail($this->info->id);
        $data->user_id = $this->company;
        $data->title = $this->title;
        $data->alias = $this->alias;
        $data->category_id = $this->category;
        $data->description = $this->description;
        $data->description2 = $this->description2;
        $data->meta_title = !empty($this->meta_title) ? $this->meta_title : $this->title;
        $data->meta_keywords = !empty($this->meta_keywords) ? $this->meta_keywords : $this->title;
        $data->meta_description = !empty($this->meta_description) ? $this->meta_description : $this->title;
        $data->save();

        $this->uploadImages();
        $this->uploadFeatures();
        $this->uploadTypeprices();

        $this->dispatch('refreshServiceEdit', data: $data->id);
        $this->dispatch('successtoaster', ['title' => AlertMessageType::UPDATE, 'message' => AlertMessage::UPDATE]);
    }

    public function uploadImages()
    {
        if (is_array($this->images)) {
            $checkPrimary = ServiceImage::service($this->info->id)->primary()->first();
            foreach ($this->images as $k => $image) {
                $imageName = \CommanFunction::autoheight('service/', 550, $image);
                $imageData = new ServiceImage();
                $imageData->image = $imageName;
                $imageData->service_id = $this->info->id;
                // $imageData->sequence = ($k + 1);
                if (empty($checkPrimary)) {
                    $imageData->is_primary = $k == 0 ? 1 : 0;
                } else {
                    $imageData->is_primary = $image->primary_image ?? 0;
                }
                $imageData->save();
            }
            $this->reset('images');
        }
    }
    public function uploadFeatures()
    {
        if (count($this->features) > 0) {
            foreach ($this->features as $k => $features) {
                if (!empty($features['title'])) {
                    if (($features['preId'] ?? 0) > 0) {
                        $featureData = ServiceKeyFeature::find($features['preId']);
                    } else {
                        $featureData = new ServiceKeyFeature();
                    }
                    $featureData->title = $features['title'];
                    $featureData->description = $features['description'];
                    $featureData->service_id = $this->info->id;
                    $featureData->is_publish = $features['status'] ?? 0;
                    $featureData->save();
                }
            }
        }
    }
    public function uploadTypeprices()
    {
        if (count($this->typeprices) > 0) {
            foreach ($this->typeprices as $k => $typeprices) {
                if (!empty($typeprices['title'])) {
                    if (($typeprices['preId'] ?? 0) > 0) {
                        $featureData = ServicePrice::find($typeprices['preId']);
                    } else {
                        $featureData = new ServicePrice();
                    }
                    $featureData->title = $typeprices['title'] ?? null;
                    $featureData->mrp = $typeprices['mrp'] ?? null;
                    $featureData->price = $typeprices['price'] ?? null;
                    $featureData->service_id = $this->info->id;
                    $featureData->is_publish = $typeprices['status'] ?? 0;
                    $featureData->save();
                }
            }
        }
    }

    public function getImages()
    {
        $this->productimages = ServiceImage::service($this->info->id)->get();
    }
    public function updateImageOrder($imageIds)
    {
        foreach ($imageIds as $sequence => $image) {
            $imageData = ServiceImage::find($image);
            $imageData->sequence = ($sequence + 1);
            $imageData->save();
        }
        $this->getImages();
    }

    public function setcategoryValue($category)
    {
        $cat = Category::find($category);
        $this->category = $category;
        $this->searchcategory = $cat->title;
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
}
