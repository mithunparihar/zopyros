<?php

namespace App\Livewire\Admin\Profile;

use Livewire\Component;
use App\Rules\EmailRule;
class ProfileForm extends Component
{

    public $fullname,$email,$username,$phonenumber,$address,$country,$preId,$mail_received_email;
    public $currency = [];
    public $code,$countrycode;
    protected $listeners = ['ProfilePage'=>'$refresh'];
    public function mount(){
        $this->fullname = \Content::adminInfo()->name;
        $this->email = \Content::adminInfo()->email;
        $this->mail_received_email = \Content::adminInfo()->mail_received_email;
        $this->username = \Content::adminInfo()->username;
        $this->phonenumber = \Content::adminInfo()->phone;
        $this->address = \Content::adminInfo()->address;
        $this->country = \Content::adminInfo()->country_id;
        $this->code = \Content::adminInfo()->ccode;
        $this->countrycode = $country->sortname ?? '';
        $this->currency = \Content::adminInfo()->currency ?? [];

        // $adminIndo = \App\Models\Admin::find( \Content::adminInfo()->id);
        $this->preId = \Content::adminInfo()->id;
    }

    public function render(){
        return view('livewire.admin.profile.profile-form');
    }

    protected function rules()
    {
        return [
            'fullname' => 'required|regex:/^[a-zA-Z\s]*$/|max:255',
            'email' => [
                'required',
                'unique:admins,email,' . $this->preId.',id',
                'max:74',
                new EmailRule(),
            ],
            'username' => 'required|regex:/^[a-zA-Z]+$/u|max:255|unique:admins,username,' . $this->preId.',id',
            'phonenumber' => 'nullable|numeric|digits:10',
            'mail_received_email' => 'required',
            'country' => 'nullable|numeric',
            'currency' => 'nullable',
        ];
    }

    protected $messages  = [
        'phonenumber.required' => 'The phone number field is required.',
        'phonenumber.max' => 'The phone number field must not be greater than 10 digits.',
        'phonenumber.min' => 'The phone number field must not be less than 10 digits.',
        'phonenumber.digits' => 'The phone number field must be 10 digits.',
        'phonenumber.numeric' => 'The phone number field must be a number.'
    ];

    protected  $validationAttributes = [
        'phonenumber'=>'phone number'
    ];

    public function updated($propertyName){
        // $countrydata = \App\Models\Country::find($this->country);
        // if($this->country > 0 && !empty($countrydata)){
        //     $this->code = $countrydata->phonecode;
        //     $this->countrycode = $countrydata->sortname;
        // }
        $this->validateOnly($propertyName);
    }

    public function UpdateProfile(){
        $this->validate();
        $profiledata = \App\Models\Admin::find($this->preId);
        $profiledata->name = $this->fullname;
        $profiledata->username = $this->username;
        $profiledata->phone = $this->phonenumber;
        $profiledata->ccode = $this->code;
        $profiledata->email = $this->email;
        $profiledata->mail_received_email = $this->mail_received_email;
        $profiledata->country_id = $this->country;
        $profiledata->currency = $this->currency;
        $profiledata->save();
        $this->dispatch('successtoaster',['title'=>'Updated!','message'=>'Your profile data has been updated!']);
    }
}
