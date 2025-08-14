<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Nav extends Component
{
    protected $listeners = ['ProfileUploadPage'=>'$refresh'];
    public function render()
    {
        return view('livewire.admin.nav');
    }

    public function Logout(){
        flash()->addsuccess('Logout! By '.\Content::adminInfo()->name);
        \Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    function removeNotification($id){
        \Content::adminInfo()->notifications()->where('id', $id)->delete();
        $this->dispatch('ProfileUploadPage');
        $this->dispatch('leftBarPage');
    }

    function redirectData($redirection,$notificationType){
        if($notificationType=='AppNotificationsCareer'){
            $checkNoti = \Content::adminInfo()->unreadnotifications->where('type', 'App\Notifications\Career')->count();
            if ($checkNoti > 0) {
                \Content::adminInfo()->unreadnotifications->where('type', 'App\Notifications\Career')->markAsRead();
            }
        }
        if($notificationType=='AppNotificationsSubscribe'){
            $checkNoti = \Content::adminInfo()->unreadnotifications->where('type', 'App\Notifications\Subscribe')->count();
            if ($checkNoti > 0) {
                \Content::adminInfo()->unreadnotifications->where('type', 'App\Notifications\Subscribe')->markAsRead();
            }
        }
        if($notificationType=='AppNotificationsContact'){
            $checkNoti = \Content::adminInfo()->unreadnotifications->where('type', 'App\Notifications\Contact')->count();
            if ($checkNoti > 0) {
                \Content::adminInfo()->unreadnotifications->where('type', 'App\Notifications\Contact')->markAsRead();
            }
        }

        if($notificationType=='AppNotificationsEstimation'){
            $checkNoti = \Content::adminInfo()->unreadnotifications->where('type', 'App\Notifications\Estimation')->count();
            if ($checkNoti > 0) {
                \Content::adminInfo()->unreadnotifications->where('type', 'App\Notifications\Estimation')->markAsRead();
            }
        }

        return redirect($redirection);
    }
}
