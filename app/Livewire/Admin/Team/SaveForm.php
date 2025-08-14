<?php

namespace App\Livewire\Admin\Team;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\Team;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Rules\TextRule;

class SaveForm extends Component
{
    use WithFileUploads;
    public $title, $designation, $description, $image, $bio;
    public function render()
    {
        return view('livewire.admin.team.save-form');
    }

    public function rules()
    {
        return [
            'image' => 'required|max:5000|mimes:jpg,png,jpeg,webp',
            'title' => ['required', 'regex:/^([-.a-zA-Z\s])+$/u', 'max:50',new TextRule()],
            'designation' => ['required', 'max:50',new TextRule()],
        ];
    }

    public function SaveForm()
    {
        $this->validate();
        $imageName = \Image::autoheight('team/', $this->image);
        $data = new Team();
        $data->image = $imageName;
        $data->title = $this->title;
        $data->designation = $this->designation;
        $data->sequence = (Team::max('sequence') + 1);
        $data->save();
        $this->reset(['image','bio', 'title', 'designation']);
        $this->dispatch('emptyEditor');
        $this->dispatch('successtoaster', ['title' => AlertMessageType::SAVE, 'message' => AlertMessage::SAVE]);
    }
}
