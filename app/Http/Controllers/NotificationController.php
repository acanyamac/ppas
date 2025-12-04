<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function get_notifications()
    {
        $all_notifications=auth()->user()->unreadNotifications;
            $html='  <div class="notification-box"><svg>';
            $html.='<use href="'.asset('assets/svg/icon-sprite.svg#star').'"></use> </svg>';

            $html.='<span class="badge rounded-pill badge-success"> '.count(auth()->user()->unreadNotifications ).'</span></div>
                    <div class="onhover-show-div notification-dropdown" style="width: 400px !important;">
                        <h6 class="f-18 mb-0 dropdown-title">Bildirimler </h6>';
            $html.='<ul>';


            if(count($all_notifications)>0)
            {
                foreach ($all_notifications as $notification)
                {
                    $html.='<li class="b-l-primary border-4 toast default-show-toast align-items-start text-dark border-0 fade show" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">';
                    $html.='<div class="d-flex justify-content-between">';
                    $html.='<div class="toast-body" style="width: 400px !important;">';
                    $html.='<p>'.$notification->data["file_name"].' '.$notification->data["message"].'</p>';
                    if(isset($notification->data["url"]))
                    {
                        $html.=' <a class="btn-link" href="'.route('dokuman.download',['path'=>$notification->data["url"]]).'">indir</a>';
                    }
                    $mtt="check_read('".$notification->id."')";
                    $html.=' </div><button style="padding:2px;border:2px solid red;color:red;height:30px;width:30px;background-color: white" onclick="'.$mtt.'" type="button" >X</button>';
                    $html.=' </div></li>';

                }
            }
            $html.=' </ul>';
            $html.='</div>';
            return $html;

    }
    public function checkread(Request $request)
    {
         $s=DB::table('notifications')->where('id',$request->id)->update(['read_at'=>now()]);
        if($s)
        {
            $html=$this->get_notifications();
        }

       return $html;






    }
}
