<?php

namespace App\Livewire\Admin\LocationPreference\Service;


use Livewire\Component;
use App\Enums\AlertMessageType;
use App\Enums\AlertMessage;
use App\Models\LocationService;
use App\Rules\TextRule;

class UpdateForm extends Component
{
    protected $listeners = ['LocationServiceEdit' => 'mount'];
    public $info, $title, $alias;
    public function mount(LocationService $data)
    {
        $this->info = $data;
        $this->title = $data->title;
        $this->alias = $data->alias;
    }
    public function render()
    {
        return view('livewire.admin.location-preference.service.update-form');
    }

    public function rules()
    {
        return [
            'title' => ['required', 'max:100','unique:location_services,title,'.$this->info->id.',id,deleted_at,NULL',new TextRule()],
            'alias' => ['required','unique:location_services,alias,'.$this->info->id.',id,deleted_at,NULL', 'max:100',new TextRule()],
        ];
    }

    public function UpdateForm()
    {
        $this->validate();
        $data = LocationService::find($this->info->id);
        $data->title = $this->title;
        $data->alias = $this->alias;
        $data->save();
        $this->dispatch('LocationServiceEdit', data: $data->id);
        $this->dispatch('successtoaster', ['title' => AlertMessageType::UPDATE, 'message' => AlertMessage::UPDATE]);
    }
}
