<?php
namespace App\Livewire\Admin\Banner;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Rules\NoDangerousTags;
use App\Rules\TextRule;
use Livewire\Component;
use Livewire\WithFileUploads;

class SaveForm extends Component
{
    use WithFileUploads;
    public $image_alt, $image;
    public $link;
    public function render()
    {
        return view('livewire.admin.banner.save-form');
    }

    public function rules()
    {
        return [
            'image_alt' => ['required', 'max:200', new TextRule(), new NoDangerousTags()],
            'link'      => ['nullable', 'url', 'max:300'],
            'image'     => [
                'required',
                'mimes:jpeg,png,jpg,webp,mp4',
                'max:60000',
            ],
        ];
    }

    protected $validationAttributes = [
        'link' => 'banner link',
    ];

    public function UpdateForm()
    {
        $this->validate();

        $data = new \App\Models\Banner();
        if (! empty($this->image)) {
            $imageName   = \Image::uploadFile('banner', $this->image);
            $data->image = $imageName;
        }
        $data->image_alt = $this->image_alt;
        $data->url       = $this->link;
        $data->save();
        $this->reset();
        $this->dispatch('successtoaster', ['title' => AlertMessageType::SAVE, 'message' => AlertMessage::SAVE]);
    }
}
