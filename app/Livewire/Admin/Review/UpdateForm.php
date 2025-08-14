<?php

namespace App\Livewire\Admin\Review;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\SocialReview;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateForm extends Component
{
    use WithFileUploads;
    public $rating, $reviews, $image, $url_link;
    public $info;
    protected $listeners = ['reloadSocialReview'=>'mount'];

    public function mount(SocialReview $data)
    {
        $this->info = $data;
        $this->rating = $data->rating;
        $this->reviews = $data->reviews;
        $this->url_link = $data->url_link;
    }

    public function render()
    {
        return view('livewire.admin.review.update-form');
    }

    public function rules()
    {
        return [
            'rating'   => ['required', 'between:1,5', 'numeric'],
            'reviews'  => ['required', 'integer', 'digits_between:1,5'],
            'url_link' => ['required', 'url', 'max:300'],
            'image'    => ['nullable', 'mimes:jpg,png,jpeg,webp', 'max:5000'],
        ];
    }

    public function SaveForm()
    {
        $this->validate();

        $data           = SocialReview::find($this->info->id);
        $data->rating   = $this->rating;
        $data->reviews  = $this->reviews;
        $data->url_link = $this->url_link;
        if(!empty($this->image)){
            \Image::removeFile('review/', $this->info->image);
            $data->image    = \Image::autoheight('review/', $this->image);
        }
        $data->save();
        $this->dispatch('reloadSocialReview',data:$data->id);
        $this->dispatch('successtoaster', ['title' => AlertMessageType::SAVE, 'message' => AlertMessage::SAVE]);
    }
}
