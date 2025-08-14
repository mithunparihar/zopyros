<?php
namespace App\Livewire\Admin\Review;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\SocialReview;
use Livewire\Component;
use Livewire\WithFileUploads;

class SaveForm extends Component
{
    use WithFileUploads;

    public $rating, $reviews, $image, $url_link;
    public function render()
    {
        return view('livewire.admin.review.save-form');
    }

    public function rules()
    {
        return [
            'rating'   => ['required', 'between:1,5', 'numeric'],
            'reviews'  => ['required', 'integer', 'digits_between:1,5'],
            'url_link' => ['required', 'url', 'max:300'],
            'image'    => ['required', 'mimes:jpg,png,jpeg,webp', 'max:5000'],
        ];
    }

    public function SaveForm()
    {
        $this->validate();

        $data           = new SocialReview();
        $data->rating   = $this->rating;
        $data->reviews  = $this->reviews;
        $data->url_link = $this->url_link;
        $data->image    = \Image::autoheight('review/', $this->image);
        $data->save();

        $this->reset(['rating', 'reviews', 'url_link', 'image']);
        $this->dispatch('successtoaster', ['title' => AlertMessageType::SAVE, 'message' => AlertMessage::SAVE]);
    }
}
