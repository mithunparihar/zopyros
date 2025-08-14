<?php

namespace App\Livewire\Admin\LocationPreference\PageContent;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\LocationPageContent;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Rules\EditorRule;
use App\Rules\TextRule;

class UpdateForm extends Component
{
    use WithFileUploads;
    protected $listeners = ['LocationPageContentEdit' => 'mount','updateEditorValue' => 'updateEditorValue'];
    public $info,$cityinfo, $location, $description, $description2, $serviceId, $cityId, $image;
    public $meta_title, $meta_keywords, $meta_description;
    public $page_meta_title, $page_meta_keywords, $page_meta_description;
    public $services, $locations;
    public function mount(LocationPageContent $data)
    {
        $this->info = $data;
        $this->description = $data->page_description;
        $this->description2 = $data->page_description_2;
        $this->serviceId = $data->service_id;
        $this->cityId = $data->city_id;
        $this->meta_title = $data->meta_title;
        $this->meta_keywords = $data->meta_keywords;
        $this->meta_description = $data->meta_description;

        $this->page_meta_title = $data->page_meta_title;
        $this->page_meta_keywords = $data->page_meta_keywords;
        $this->page_meta_description = $data->page_meta_description;

        $this->services = \App\Models\LocationService::active()->get();
        $this->locations = \App\Models\Location::city(0)->active()->get();
        $this->getlocationData($this->cityId);
    }

    public function updateEditorValue($modelId, $content)
    {
        if ($modelId == 'description') {
            $this->description = $content;
        }

        if ($modelId == 'description2') {
            $this->description2 = $content;
        }
    }

    function getlocationData($Id){
        $this->cityinfo = \App\Models\Location::find($Id);
        $this->dispatch('generateEditorAgain');
    }

    public function render()
    {
        return view('livewire.admin.location-preference.page-content.update-form');
    }

    public function rules()
    {
        return [
            'serviceId' => ['required'],
            'cityId' => ['required'],
            'image' => 'nullable|max:5000|mimes:jpg,png,jpeg,webp',
            'description' => ['required',new EditorRule()],
            'meta_title' => ['required', 'max:100',new TextRule()],
            'meta_keywords' => ['required', 'max:500',new TextRule()],
            'meta_description' => ['required', 'max:500',new TextRule()],

            'description2' => [(($this->info->location->city_id ?? 0) == 0 ? 'required' : 'nullable'),new EditorRule()],
            'page_meta_title' => [(($this->info->location->city_id ?? 0) == 0 ? 'required' : 'nullable'), 'max:100',new TextRule()],
            'page_meta_keywords' => [(($this->info->location->city_id ?? 0) == 0 ? 'required' : 'nullable'), 'max:500',new TextRule()],
            'page_meta_description' => [(($this->info->location->city_id ?? 0) == 0 ? 'required' : 'nullable'), 'max:500',new TextRule()],

        ];
    }

    protected $validationAttributes = [
        'serviceId' => 'service',
        'cityId' => 'location',
        'description' => 'child page description',
        'description2' => 'description',
    ];

    public function UpdateForm()
    {
        $this->validate();
        $data = LocationPageContent::find($this->info->id);
        $data->page_description = $this->description;
        $data->page_description_2 = $this->description2;
        $data->meta_title = $this->meta_title;
        $data->meta_keywords = $this->meta_keywords;
        $data->meta_description = $this->meta_description;

        $data->page_meta_title = $this->page_meta_title;
        $data->page_meta_keywords = $this->page_meta_keywords;
        $data->page_meta_description = $this->page_meta_description;

        $data->service_id = $this->serviceId;
        $data->city_id = $this->cityId;
        if (!empty($this->image)) {
            \Image::removeFile('location-preference/', $this->info->image);
            $imageName = \Image::autoheight('location-preference/', $this->image);
            $data->image = $imageName;
        }
        $data->save();
        $this->dispatch('LocationPageContentEdit', data: $data->id);
        $this->dispatch('successtoaster', ['title' => AlertMessageType::UPDATE, 'message' => AlertMessage::UPDATE]);
    }
}
