<?php
namespace App\Livewire\Admin\Facilities;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\Facilities;
use App\Rules\TextRule;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateForm extends Component
{
    use WithFileUploads;
    public $title, $image, $designation, $description;
    public $info;

    public function mount(Facilities $data)
    {
        $this->info        = $data;
        $this->title       = $data->title;
        $this->description = $data->description;
    }

    public function render()
    {
        return view('livewire.admin.facilities.update-form');
    }

    public function updated()
    {
        // $this->title = trim($this->title);
    }

    public function rules()
    {
        return [
            'image'       => 'nullable|max:5000|mimes:jpg,png,jpeg,webp',
            'title'       => ['required', 'unique:facilities,title,' . $this->info->id . ',id,deleted_at,NULL', 'max:50', new TextRule()],
            'description' => ['nullable', 'max:50', new TextRule()],
        ];
    }

    public function SaveForm()
    {
        $this->validate();
        if (! empty($this->image)) {
            \Image::removeFile('facilities/', $this->info->image);
            $imageName = \Image::autoheight('facilities/',$this->image);
        }
        $data = Facilities::find($this->info->id);
        if (! empty($this->image)) {$data->image = $imageName;}
        $data->title       = $this->title;
        $data->description = $this->description;
        $data->save();
        $this->dispatch('successtoaster', ['title' => AlertMessageType::UPDATE, 'message' => AlertMessage::UPDATE]);
    }
}
