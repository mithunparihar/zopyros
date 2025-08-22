<?php
namespace App\Livewire\Admin\Facilities;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\Facilities;
use App\Rules\TextRule;
use Livewire\Component;
use Livewire\WithFileUploads;

class SaveForm extends Component
{
    use WithFileUploads;
    public $title, $image, $description;
    public function render()
    {
        return view('livewire.admin.facilities.save-form');
    }

    public function rules()
    {
        return [
            'image'       => 'required|max:5000|mimes:jpg,png,jpeg,webp',
            'title'       => ['required', 'unique:facilities,title,NULL,id,deleted_at,NULL', 'max:50', new TextRule()],
            'description' => ['nullable', 'max:50', new TextRule()],
        ];
    }

    public function updated()
    {
        // $this->title = trim($this->title);
    }

    public function SaveForm()
    {
        $this->validate();
        $imageName         = \Image::autoheight('facilities/',$this->image);
        $data              = new Facilities();
        $data->image       = $imageName;
        $data->title       = $this->title;
        $data->description = $this->description;
        $data->save();
        $this->reset(['image', 'title', 'description']);
        $this->dispatch('emptyEditor');
        $this->dispatch('successtoaster', ['title' => AlertMessageType::SAVE, 'message' => AlertMessage::SAVE]);
    }
}
