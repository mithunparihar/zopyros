<?php

namespace App\Livewire\Admin\Service\Rating;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\Service;
use App\Models\ServiceRating;
use App\Models\ServiceRatingImage;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateForm extends Component
{

    use WithFileUploads;
    public $service, $serviceTitle;
    public $description, $images, $rating;
    public $info;
    public $query = '', $companies;
    public $company_id, $selectedCompany;

    protected $listeners = ['companySelected' => 'setCompanyId', 'setRating' => 'setRating', 'refreshData' => 'mount'];
    public function mount(ServiceRating $data)
    {
        $this->images = [];
        $this->info = $data;
        $this->service = $data->serviceInfo;
        $this->serviceTitle = $data->serviceInfo->title;
        $this->description = $data->message;
        $this->rating = $data->rating;
        $this->selectedCompany = $data->user->companyInfo->name ?? null;
        $this->selectedCompany = $this->selectedCompany . ' (#' . $data->user->user_id . ')';
        $this->query = $this->selectedCompany;
        $this->company_id = $data->user_id;
    }

    public function updatedQuery()
    {
        if (!empty($this->query)) {
            $this->companies = \App\Models\Company::where('name', 'like', '%' . $this->query . '%')
                ->limit(5)
                ->get();
        } else {
            $this->companies = [];
        }

    }

    public function render()
    {
        return view('livewire.admin.service.rating.update-form');
    }

    public function eliminarImage($index)
    {
        array_splice($this->images, $index, 1);
    }

    public function removeImage(ServiceRatingImage $imageId)
    {
        $checkProductImages = ServiceRatingImage::rating($this->info->id)->count();
        if ($checkProductImages < 2) {
            $this->dispatch('errortoaster', ['title' => AlertMessageType::SORRY, 'message' => 'Deletion not allowed: This image is required and cannot be removed.']);
        } else {
            \CommanFunction::removeFile('service/rating/', $imageId->image);
            $imageId->delete();
        }

    }

    public function selectCompany($companyId)
    {
        $company = \App\Models\Company::find($companyId);
        if ($company) {
            $this->selectedCompany = $company;
            $this->query = $company->name . '(#' . $company->userInfo->user_id . ')';
            $this->companies = [];
            $this->company_id = $company->user_id;
            $this->dispatch('companySelected', $company->id);
        }
    }

    public function rules()
    {
        return [
            'selectedCompany' => 'required',
            'rating' => 'required|max:',
            'images' => 'nullable',
            'images.*' => 'nullable|mimes:jpg,png,jpeg,webp|max:5000',
            'description' => ['required', 'max:1000', function ($attribute, $value, $fail) {\CommanFunction::repeatedValidation($value, $fail);}],
        ];
    }

    public function validationAttributes()
    {
        return [
            'selectedCompany' => 'company',
            'images.*' => 'images',
        ];
    }

    public function SaveForm()
    {

        $this->validate();

        $imageData = ServiceRating::find($this->info->id);
        $imageData->service_id = $this->service->id;
        $imageData->user_id = $this->company_id ?? 0;
        $imageData->message = $this->description;
        $imageData->rating = $this->rating;
        $imageData->save();
        $this->uploadImages($imageData->id);
        $this->images = [];
        $this->dispatch('refreshData', data: $imageData->id);
        $this->dispatch('successtoaster', ['title' => AlertMessageType::UPDATE, 'message' => AlertMessage::UPDATE]);
    }

    public function uploadImages($ratingId)
    {
        if (is_array($this->images)) {
            foreach ($this->images as $k => $image) {
                $imageName = \CommanFunction::autoheight('service/rating/', 400, $image);
                $imageData = new ServiceRatingImage();
                $imageData->image = $imageName;
                $imageData->service_rating_id = $ratingId;
                $imageData->save();
            }
        }
    }

    public function setRating($rating)
    {
        $this->rating = $rating;
    }
}
