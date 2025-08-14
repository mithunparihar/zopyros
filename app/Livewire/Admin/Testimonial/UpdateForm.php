<?php

namespace App\Livewire\Admin\Testimonial;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Testimonial;
use App\Enums\AlertMessageType;
use App\Enums\AlertMessage;
use App\Rules\EditorRule;
use App\Rules\TextRule;

class UpdateForm extends Component
{
    use WithFileUploads;
    public $title,$image,$designation,$description;
    public $info;

    protected $listeners = ['refreshTestimonialEdit'=>'mount','updateEditorValue' => 'updateEditorValue'];
    public function mount(Testimonial $data){
        $this->info = $data;
        $this->title = $data->title;
        $this->designation = $data->designation;
        $this->description = $data->description;
    }
    public function updateEditorValue($modelId, $content)
    {
        if ($modelId == 'description') {
            $this->description = $content;
        }
    }
    public function render()
    {
        return view('livewire.admin.testimonial.update-form');
    }

    function rules(){
        return [
            'image'=>'nullable|max:5000|mimes:jpg,png,jpeg,webp',
            'title'=>['required','regex:/^([a-zA-Z\s])+$/u','max:100',new TextRule()],
            'description'=>['required',new EditorRule()],
            'designation'=>['required']
        ];
    }

    protected $validationAttributes=[
        'designation' => 'rating'
    ];

    function SaveForm(){
        $this->validate();
        if(!empty($this->image)){
            \Image::removeFile('testimonial/',$this->info->image);
            $imageName = \Image::autoheight('testimonial/',$this->image);
        }
        $data = Testimonial::find($this->info->id);
        if(!empty($this->image)){ $data->image = $imageName; }
        $data->title = $this->title;
        $data->designation = $this->designation;
        $data->description = $this->description;
        $data->save();
        $this->dispatch('refreshTestimonialEdit',data:$data->id);
        $this->dispatch('successtoaster',['title'=>AlertMessageType::UPDATE,'message'=>AlertMessage::UPDATE]);
    }
}
