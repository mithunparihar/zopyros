<?php
namespace App\Livewire\Admin\Banner;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\Banner;
use App\Rules\NoDangerousTags;
use App\Rules\TextRule;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateForm extends Component
{
    use WithFileUploads;
    public $image_alt, $image, $link, $heading;
    public $info;
    protected $listeners = ['refreshBlogEdit' => 'mount'];
    public function mount(Banner $data)
    {
        $this->info      = $data;
        $this->preId     = $data->id;
        $this->image_alt = $data->image_alt;
        $this->link      = $data->url;
        $this->heading   = $data->short_description;
    }

    public function render()
    {
        return view('livewire.admin.banner.update-form');
    }

    public function rules()
    {
        return [
            'image_alt' => ['required', 'max:200', new TextRule(), new NoDangerousTags()],
            'heading'   => ['nullable', 'max:200', new TextRule(), new NoDangerousTags()],
            'link'      => ['nullable', 'url', 'max:300'],
            'image'     => [
                'nullable',
                'mimes:jpeg,png,jpg,webp,mp4,webp',
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

        $data = \App\Models\Banner::findOrFail($this->info->id);
        if (! empty($this->image)) {
            \Image::removeFile('banner/', $this->info->image);

            // $extention = $this->image->getClientOriginalExtension();
            $imageName = \Image::uploadFile('banner', $this->image);
            $data->image = $imageName;
        }
        $data->image_alt         = $this->image_alt;
        $data->url               = $this->link;
        $data->short_description = $this->heading;

        $data->save();
        $this->dispatch('refreshBlogEdit', data: $data->id);
        $this->dispatch('successtoaster', ['title' => AlertMessageType::UPDATE, 'message' => AlertMessage::UPDATE]);
    }
}
