<?php

namespace App\Livewire\Admin\Gallery;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Gallery;
use App\Enums\AlertMessageType;
use App\Enums\AlertMessage;

class UpdateForm extends Component
{
    use WithFileUploads;
    public $title,$image;
    public $inputs;
    protected $listeners = ['refreshGaleryEdit'=>'mount'];
    public function mount(Gallery $data){
        $this->fill([
            'inputs' => collect([['type'=>$data->type,'image'=>'','url'=>$data->url,'preImage'=>$data->image,'preId'=>$data->id]])
        ]);
    }
    public function render()
    {
        return view('livewire.admin.gallery.update-form');
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
            $data = Gallery::findOrFail($inputs['preId']);
            $data->type = $inputs['type'];
            if($inputs['type']==1 && !empty($inputs['image'])){
                $imageName = \Image::autoheight('gallery/',$inputs['image']);
                $data->image = $imageName;
                $data->url = NULL;
            }
            if($inputs['type']==2){
                $data->url = $inputs['url'];
                $data->image = NULL;
            }
            $data->save();
        }
        $this->dispatch('refreshGaleryEdit',data:$data->id);
        $this->dispatch('successtoaster',['title'=>AlertMessageType::UPDATE,'message'=>AlertMessage::UPDATE]);
    }
}
