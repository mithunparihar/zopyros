<?php
namespace App\Livewire\Admin\Contact;

use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;
use App\Models\Contact;
use App\Rules\EmailRule;
use App\Rules\PhoneRule;
use App\Rules\TextRule;
use Livewire\Component;

class UpdateForm extends Component
{
    public $contact, $email, $address, $title, $google_map;
    public $enquiry_contact;
    public $info;
    public function mount(Contact $data)
    {
        $this->info            = $data;
        $this->contact         = $data->phone;
        $this->email           = $data->email;
        $this->address         = $data->address;
        $this->title           = $data->title;
        $this->google_map      = $data->google_map;
        $this->enquiry_contact = $data->enquiry_contact;
    }

    public function render()
    {
        return view('livewire.admin.contact.update-form');
    }

    public function rules()
    {
        return [
            'contact'         => ['nullable', new PhoneRule()],
            'enquiry_contact' => ['nullable', 'integer', 'digits:10', new PhoneRule()],
            'email'           => ['nullable', new EmailRule()],
            'title'           => ['nullable', 'max:50', new TextRule()],
            'address'         => ['nullable', 'max:200', new TextRule()],
            'google_map'      => [
                'required',
                'regex:/^<iframe[^>]*src=["\']https:\/\/www\.google\.com\/maps\/embed\?[^"\']*["\'][^>]*><\/iframe>/i',
            ],
        ];
    }

    public function validationAttributes()
    {
        return [
            'title'   => 'address title',
            'contact' => 'contact number',
            'email'   => 'email address',
        ];
    }

    public function SaveForm()
    {
        $this->validate();
        $data                  = Contact::find($this->info->id);
        $data->enquiry_contact = $this->enquiry_contact;
        $data->phone           = $this->contact;
        $data->email           = $this->email;
        $data->address         = $this->address;
        $data->title           = $this->title;
        $data->google_map      = $this->google_map;
        $data->save();
        $this->dispatch('successtoaster', ['title' => AlertMessageType::UPDATE, 'message' => AlertMessage::UPDATE]);
    }
}
