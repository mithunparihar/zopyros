<?php

namespace App\Livewire\Admin\Contact;

use App\Models\Contact;
use Livewire\Component;
use App\Rules\TextRule;
use App\Rules\EmailRule;
use App\Rules\PhoneRule;
use App\Enums\AlertMessage;
use App\Enums\AlertMessageType;

class UpdateForm extends Component
{
    public $contact, $email, $address, $title;
    public $info;
    public function mount(Contact $data)
    {
        $this->info = $data;
        $this->contact = $data->phone;
        $this->email = $data->email;
        $this->address = $data->address;
        $this->title = $data->title;
    }

    public function render()
    {
        return view('livewire.admin.contact.update-form');
    }

    public function rules()
    {
        return [
            'contact' => ['nullable', 'regex:/^([,0-9])+$/u', new PhoneRule()],
            'email' => ['nullable', new EmailRule()],
            'title' => ['required', 'max:50',new TextRule()],
            'address' => ['required', 'max:200',new TextRule()],
        ];
    }

    public function validationAttributes()
    {
        return [
            'title' => 'address title',
            'contact' => 'contact number',
            'email' => 'email address',
        ];
    }

    public function SaveForm()
    {
        $this->validate();
        $data = Contact::find($this->info->id);
        $data->phone = $this->contact;
        $data->email = $this->email;
        $data->address = $this->address;
        $data->title = $this->title;
        $data->save();
        $this->dispatch('successtoaster', ['title' => AlertMessageType::UPDATE, 'message' => AlertMessage::UPDATE]);
    }
}
