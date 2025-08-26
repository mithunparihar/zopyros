<?php

namespace App\Livewire\Admin\Gallery;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Gallery;
use App\Enums\AlertMessageType;
use App\Enums\AlertMessage;

class SaveForm extends Component
{
    use WithFileUploads;
    public $title,$image;
    public $inputs;
    public $fillInput=['type'=>1,'image'=>'','url'=>''];
    protected $listeners = ['refreshGaleryAdd'=>'mount'];
    public function mount(){
        $this->fill([
            'inputs' => collect([$this->fillInput])
        ]);
    }
    function removeGallery($index){
        $this->inputs->pull($index);
    }
    function AddMoreGallery(){
        if(count($this->inputs)==20){
            flash()->Error('You can add only 20 images at a time');
        }else{
            $this->inputs->push($this->fillInput);
        }

    }
    public function render()
    {
        return view('livewire.admin.gallery.save-form');
    }

    function rules(){
        return [
            'inputs.*.type'=>'required|numeric',
            'inputs.*.image'=>'nullable|required_if:inputs.*.type,1|max:5000|mimes:jpg,png,webp,jpeg',
            'inputs.*.url'=>'nullable|required_if:inputs.*.type,2|url|max:300',
        ];
    }

    function messages(){
        return [
            'inputs.*.image.required_if'=>'The image field is required.',
            'inputs.*.url.required_if'=>'The youtube url field is required.'
        ];
    }

    function validationAttributes(){
        return [
            'inputs.*.url'=>'youtube url',
            'inputs.*.image'=>'image',
            'inputs.*.type'=>'banner section'
        ];
    }

    function SaveForm(){
        $this->validate();
        foreach($this->inputs as $inputs){
            $data = new Gallery();
            $data->type = $inputs['type'];
            if($inputs['type']==1){
                $imageName = \Image::autoheight('gallery/',$inputs['image']);
                $data->image = $imageName;
            }
            if($inputs['type']==2){
            $data->url = $inputs['url'];
            }
            $data->save();
        }
        $this->dispatch('refreshGaleryAdd');
        $this->dispatch('successtoaster',['title'=>AlertMessageType::SAVE,'message'=>AlertMessage::SAVE]);
    }
}
