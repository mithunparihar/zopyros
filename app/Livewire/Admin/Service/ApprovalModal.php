<?php

namespace App\Livewire\Admin\Service;

use Livewire\Component;
use App\Models\Service;

class ApprovalModal extends Component
{
    public $productInfo;
    public $reason,$status;
    protected $listeners = ['approvalProduct' => 'requestProduct'];
    public function render()
    {
        return view('livewire.admin.service.approval-modal');
    }

    public function requestProduct(Service $product){
        $this->productInfo = $product;
    }

    public function rules(){
        return [
            'status' => ['required'],
            'reason' => ['nullable','required_if:status,2','max:500',function ($attribute, $value, $fail) {\CommanFunction::repeatedValidation($value, $fail);}]
        ];
    }

    protected $messages=[
        'reason.required_if' => 'The reason field is required.'
    ];

    function ApprovalStatus(){
        $this->validate();

        $data = Service::findOrFail($this->productInfo->id);
        $data->approval_status = $this->status;
        $data->approval_date = \Carbon\Carbon::now();
        $data->disapproved_reason = $this->reason;
        $data->save();
        flash()->addsuccess('Service Approval Status Updated.');
        return redirect()->route('admin.services.lists.index');
    }
}