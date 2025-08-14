<?php

namespace App\Livewire\Admin\LocationPreference\Service;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\LocationService;
use App\Rules\TextRule;
use Livewire\Component;

class SaveForm extends Component
{
    public $info, $title, $alias;
    public function render()
    {
        return view('livewire.admin.location-preference.service.save-form');
    }

    public function rules()
    {
        return [
            'title' => ['required', 'max:100', 'unique:location_services,title,NULL,id,deleted_at,NULL', new TextRule()],
            'alias' => ['required', 'unique:location_services,alias,NULL,id,deleted_at,NULL', 'max:100', new TextRule()],
        ];
    }

    public function saveForm()
    {
        $this->validate();
        $data = new LocationService();
        $data->title = $this->title;
        $data->alias = $this->alias;
        $data->save();
        $this->dispatch('emptyEditor');
        $this->reset(['title', 'alias']);
        $this->dispatch('successtoaster', ['title' => AlertMessageType::SAVE, 'message' => AlertMessage::SAVE]);
    }
}
