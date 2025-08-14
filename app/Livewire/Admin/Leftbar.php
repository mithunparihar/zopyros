<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Leftbar extends Component
{
    public $subscribeNotification = 0;
    public $contactCount = 0;
    public $careerCount = 0;
    public $quoteCount=0;
    protected $listeners = ['leftBarPage' => 'getAdmissionCount', 'redirectData' => 'redirectData'];
    public function render()
    {
        $this->getAdmissionCount();
        return view('livewire.admin.leftbar');
    }

    public function getAdmissionCount()
    {
        $this->subscribeNotification = \Content::adminInfo()->unreadnotifications->where('type', 'App\Notifications\Subscribe')->count();
        $this->contactCount = \Content::adminInfo()->unreadnotifications->where('type', 'App\Notifications\Contact')->count();
        $this->careerCount = \Content::adminInfo()->unreadnotifications->where('type', 'App\Notifications\Career')->count();
        $this->quoteCount = \Content::adminInfo()->unreadnotifications->where('type', 'App\Notifications\Estimation')->count();
    }

    public function redirectData($redirection, $notificationType)
    {

        if ($notificationType == 'subscribe') {
            $checkNoti = \Content::adminInfo()->unreadnotifications->where('type', 'App\Notifications\Subscribe')->count();
            if ($checkNoti > 0) {
                \Content::adminInfo()->unreadnotifications->where('type', 'App\Notifications\Subscribe')->markAsRead();
            }
        }
        if ($notificationType == 'contact') {
            $checkNoti = \Content::adminInfo()->unreadnotifications->where('type', 'App\Notifications\Contact')->count();
            if ($checkNoti > 0) {
                \Content::adminInfo()->unreadnotifications->where('type', 'App\Notifications\Contact')->markAsRead();
            }
        }
        if ($notificationType == 'career') {
            $checkNoti = \Content::adminInfo()->unreadnotifications->where('type', 'App\Notifications\Career')->count();
            if ($checkNoti > 0) {
                \Content::adminInfo()->unreadnotifications->where('type', 'App\Notifications\Career')->markAsRead();
            }
        }
        if ($notificationType == 'free-estimation') {
            $checkNoti = \Content::adminInfo()->unreadnotifications->where('type', 'App\Notifications\Estimation')->count();
            if ($checkNoti > 0) {
                \Content::adminInfo()->unreadnotifications->where('type', 'App\Notifications\Estimation')->markAsRead();
            }
        }
        return redirect($redirection);
    }
}
