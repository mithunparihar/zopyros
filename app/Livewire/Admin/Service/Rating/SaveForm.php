<?php

namespace App\Livewire\Admin\Service\Rating;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\Service;
use App\Models\ServiceRating;
use App\Models\ServiceRatingImage;
use Livewire\Component;
use Livewire\WithFileUploads;

class SaveForm extends Component
{
    use WithFileUploads;
    public $service, $serviceTitle;
    public $description, $images, $rating;

    public $query = '', $companies;
    public $company_id, $selectedCompany;

    protected $listeners = ['companySelected' => 'setCompanyId', 'setRating' => 'setRating'];
    public function mount(Service $service)
    {
        $this->service = $service;
        $this->serviceTitle = $service->title;
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

    public function eliminarImage($index)
    {
        array_splice($this->images, $index, 1);
    }

    public function render()
    {
        return view('livewire.admin.service.rating.save-form');
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
            'rating' => 'required',
            'images' => 'nullable',
            'images.*' => 'nullable|mimes:jpg,png,jpeg,webp|max:5000',
            'description' => ['required', 'max:1000', function ($attribute, $value, $fail) {\CommanFunction::repeatedValidation($value, $fail);}],
        ];
    }

    public function validationAttributes()
    {
        return [
            'selectedCompany' => 'company',
            'images.*'=>'images'
        ];
    }

    public function SaveForm()
    {

        $this->validate();

        $imageData = new ServiceRating();
        $imageData->service_id = $this->service->id;
        $imageData->user_id = $this->selectedCompany->user_id ?? 0;
        $imageData->message = $this->description;
        $imageData->rating = $this->rating;
        $imageData->save();
        $this->uploadImages($imageData->id);
        $this->reset(['description', 'rating', 'selectedCompany', 'query', 'images']);
        $this->dispatch('removeRating');
        $this->dispatch('successtoaster', ['title' => AlertMessageType::SAVE, 'message' => AlertMessage::SAVE]);
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
