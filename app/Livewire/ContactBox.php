<?php
namespace App\Livewire;

use App\Rules\EmailRule;
use App\Rules\NoDangerousTags;
use App\Rules\PhoneRule;
use App\Rules\TextRule;
use Livewire\Component;
use App\Models\ContactEnquiry;
use App\Events\ContactEnquiry as ContactEnquiryEvent;

class ContactBox extends Component
{

    public $name, $contact, $subject, $message, $email;
    public function render()
    {
        return view('livewire.contact-box');
    }

    public function rules()
    {
        return [
            'name'    => ['required', 'max:50', new NoDangerousTags(), new TextRule()],
            'contact' => ['required', 'integer', 'digits_between:8,12', new PhoneRule()],
            'subject' => ['required', 'max:100', new NoDangerousTags(), new TextRule()],
            'message' => ['required', 'max:500', new NoDangerousTags(), new TextRule()],
            'email'   => [
                'required',
                'max:74',
                'regex:/^[a-zA-Z0-9.@]+$/u',
                'regex:/(.+)@(.+)\.(.+)/i',
                new EmailRule()],
        ];
    }

    public function saveContact()
    {
        $this->validate();
        $data          = new ContactEnquiry();
        $data->name    = $this->name;
        $data->phone   = $this->contact;
        $data->email   = $this->email;
        $data->subject = $this->subject;
        $data->message = $this->message;
        $data->save();

        ContactEnquiryEvent::dispatch($data);

        return redirect()->route('thankyou.contact');
    }
}
