<?php

namespace App\Livewire\Admin\Profile;

use Livewire\Component;
use App\Enums\AlertMessageType;
use App\Enums\AlertMessage;
use App\Rules\EmailRule;
use App\Rules\PhoneRule;
use App\Rules\TextRule;

class InvoiceForm extends Component
{
    public $email,$phonenumber,$address,$preId;
    protected $listeners = ['InvoicePage'=>'mount'];
    public function mount(){
        $this->email = \Content::adminInfo()->invoice_email;
        $this->phonenumber = \Content::adminInfo()->invoice_phone;
        $this->address = \Content::adminInfo()->invoice_address;
        $this->preId = \Content::adminInfo()->id;
    }
    public function render()
    {
        return view('livewire.admin.profile.invoice-form');
    }

    protected function rules()
    {
        return [
            'email' => ['required',new EmailRule()],
            'phonenumber' => ['required',new PhoneRule()],
            'address' => ['required', 'max:300',new TextRule()],
        ];
    }

    protected  $validationAttributes = [
        'phonenumber'=>'phone number'
    ];

    public function UpdateProfile(){
        $this->validate();
        $profiledata = \App\Models\Admin::find($this->preId);
        $profiledata->invoice_email = $this->email;
        $profiledata->invoice_address = $this->address;
        $profiledata->invoice_phone = $this->phonenumber;
        $profiledata->save();
        $this->dispatch('InvoicePage');
        $this->dispatch('successtoaster',['title'=>AlertMessageType::UPDATE,'message'=>AlertMessage::UPDATE]);
    }
}
