<?php

namespace App\Livewire\Admin\Award;

use Livewire\Component;
use App\Models\Award;
use Livewire\WithFileUploads;
use App\Enums\AlertMessageType;
use App\Enums\AlertMessage;

class UpdateForm extends Component
{
    use WithFileUploads;
    protected $listeners = ['refreshAwardEdit'=>'mount'];
    public $images;
    public $preimages=[];
    public $isPublished;

    public function mount()
    {
        $this->getImages();
    }
    public function render()
    {
        return view('livewire.admin.award.update-form');
    }

    function eliminarImage($index){
        array_splice($this->images, $index, 1);
    }
    function removeImage(Award $imageId){
        $checkProductImages = Award::count();
        if($imageId->is_primary==1 && $checkProductImages > 1){
            $findImage = Award::whereNot('id',$imageId->id)->first();
            Award::whereId($findImage->id)->update(['is_primary' =>1]);
        }
        \Image::removeFile('awards/', $imageId->image);
        $imageId->delete();
        $this->getImages();
        $this->dispatch('successtoaster', ['title' => 'Removed!', 'message' => 'Data removed successfully.']);
    }

    public function togglePublish($id)
    {

        $client = Award::find($id);
        $new = $client->is_publish == 0 ? 1 : 0;
        $client->update(['is_publish'=>$new]);
        $this->dispatch('refreshAwardEdit');
        $this->dispatch('successtoaster', ['title' => 'Status!', 'message' => 'Status change successfully.']);
    }

    public function updated()
    {
        $this->uploadImages();
    }

    public function rules()
    {
        return [
            'images.*' => 'nullable|mimes:jpg,png,jpeg,webp|max:5000',
        ];
    }
    public function validationAttributes()
    {
        return [
            'images.*'=>'image'
        ];
    }


    function uploadImages(){
        $this->validate();
        if (is_array($this->images)) {
            foreach ($this->images as $k => $image) {
                $imageName = \Image::autoheight('awards/',$image);
                $imageData = new Award();
                $imageData->image = $imageName;
                $imageData->sequence = Award::max('sequence') + 1;
                $imageData->save();
            }
            $this->reset('images');
        }
        $this->dispatch('refreshAwardEdit');
        $this->dispatch('successtoaster', ['title' => AlertMessageType::UPDATE, 'message' => AlertMessage::UPDATE]);
    }

    function getImages(){
        $this->preimages = \App\Models\Award::orderBy('sequence','ASC')->get();
    }
    function updateImageOrder($imageIds){
        foreach($imageIds as $sequence => $image){
            $imageData = Award::find($image);
            $imageData->sequence = ($sequence + 1);
            $imageData->save();
        }
        $this->getImages();
    }
}
