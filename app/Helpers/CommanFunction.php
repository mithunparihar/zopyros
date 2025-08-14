<?php
namespace App\Helpers;

use App\Models\LogActivity as LogActivityModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Request;

class CommanFunction
{

    function addLogActivity($userid, $role)
    {
        if (\Agent::isDesktop() == 1) {$system = 'Desktop';}
        if (\Agent::isTablet() == 1) {$system = 'Tablet';}
        if (\Agent::isPhone() == 1) {$system = 'Phone';}
        $log = [];
        $log['role'] = $role;
        $log['url'] = Request::fullUrl();
        $log['method'] = $system . ' / ' . \Agent::platform() . '(' . \Agent::browser() . ')';
        $log['ip'] = Request::ip();
        $log['agent'] = Request::header('user-agent');
        $log['user_id'] = $userid;
        LogActivityModel::create($log);
    }
    function logActivityLists($role = null)
    {
        $listsData = LogActivityModel::latest();
        if ($role) {
            $listsData = $listsData->whereRole($role);
        }
        $listsData = $listsData->paginate(20);
        return $listsData;
    }


    function admingenerateOtp($email)
    {
        $user = \App\Models\Admin::where('email', $email)->first();
        $verificationCode = \App\Models\VerificationCode::where(['user_id' => $user->id, 'role' => 'admin'])->latest()->first();
        $now = \Carbon\Carbon::now();

        $data = new \App\Models\VerificationCode();
        $data->user_id = $user->id;
        $data->otp = $this->generateOtp();
        $data->role = 'admin';
        $data->attempt = 0;
        $data->expire_at = $now->addMinutes(10);
        $data->save();
        return $data;

    }

    function generateOtp($length = null)
    {
        if ($length == 4) {
            $from = 1000;
            $to = 9999;
        } else {
            $from = 100000;
            $to = 999999;
        }
        return rand($from, $to);
    }

    function datetimeformat($date)
    {
        return date('d, M Y (h:i A)', strtotime($date));
    }
    function dateformat($date)
    {
        return date('d, M Y', strtotime($date));
    }
    function timeformat($date)
    {
        return date('h:i A', strtotime($date));
    }
    function datetimedayformat($date)
    {
        return date('D d M, Y (h:i A)', strtotime($date));
    }


    function generateBookingNo()
    {
        $lastOrder = \App\Models\Order::latest()->first();
        if (!$lastOrder) {
            $orderNo = 'FISSORD0001';
        } else {
            $lastNumber = intval(substr($lastOrder->order_number, 6));
            $orderNo = 'FISSORD' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        }
        return $orderNo;
    }

    function generateUserId()
    {
        $lastUser = \App\Models\User::latest()->first();
        if (!$lastUser) {
            $userId = 'FISS0001';
        } else {
            $lastNumber = intval(substr($lastUser->user_id, 5));
            $userId = 'FISS' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        }
        return $userId;
    }


    function getSupportedFiles($type)
    {
        if ($type->value == 'images') {
            return ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        } elseif ($type->value == 'videos') {
            return ['video/mp4'];
        }
        return [];
    }

    public static function seprateText($text)
    {
        $Arr = explode(' ', $text);
        $count = count($Arr);
        $roundof = round($count / 2);
        $string1 = '';
        $string2 = '';
        for ($A = 0; $A < $roundof; $A++) {
            $string1 .= $Arr[$A] . ' ';
        }
        for ($B = $roundof; $B < $count; $B++) {
            $string2 .= $Arr[$B] . ' ';
        }
        return [$string1, $string2];
    }

    public static function int_to_words($number)
    {

        $no = (int) floor($number);

        $point = (int) round(($number - $no) * 100);

        $hundred = null;

        $digits_1 = strlen($no);

        $i = 0;

        $str = array();

        $words = array('0' => '', '1' => 'one', '2' => 'two',

            '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',

            '7' => 'seven', '8' => 'eight', '9' => 'nine',

            '10' => 'ten', '11' => 'eleven', '12' => 'twelve',

            '13' => 'thirteen', '14' => 'fourteen',

            '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',

            '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',

            '30' => 'thirty', '40' => 'forty', '50' => 'fifty',

            '60' => 'sixty', '70' => 'seventy',

            '80' => 'eighty', '90' => 'ninety');

        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');

        while ($i < $digits_1) {

            $divider = ($i == 2) ? 10 : 100;

            $number = floor($no % $divider);

            $no = floor($no / $divider);

            $i += ($divider == 10) ? 1 : 2;

            if ($number) {

                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;

                $hundred = ($counter == 1 && $str[0]) ? '  ' : null;

                $str[] = ($number < 21) ? $words[$number] .

                " " . $digits[$counter] . $plural . " " . $hundred

                :

                $words[floor($number / 10) * 10]

                    . " " . $words[$number % 10] . " "

                    . $digits[$counter] . $plural . " " . $hundred;

            } else {
                $str[] = null;
            }

        }

        $str = array_reverse($str);

        $result = implode('', $str);

        if ($point > 20) {

            $points = ($point) ?

            "" . $words[floor($point / 10) * 10] . " " .

            $words[$point = $point % 10] : '';

        } else {

            $points = $words[$point];

        }

        if ($points != '') {

            return $result . "and  " . $points . " Only";

        } else {

            return $result . "Only";

        }

    }

    function getYoutubeVideoId($url)
    {
        $pattern = '#(?:https?://)?(?:www\.)?(?:youtube\.com/(?:[^/]+/[^/]+|(?:v|e(?:mbed)?)\/|\S*?[?&]v=|shorts/)|youtu\.be/)([a-zA-Z0-9_-]{11})#';
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }
        return false;
    }

    function convertKBtoMBandGB($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        if ($bytes == 0) {return '0 B';}

        $bytes = max($bytes, 0);
        $power = floor(log($bytes, 1024));
        $bytes /= pow(1024, $power);
        return round($bytes, $precision) . ' ' . $units[$power];
    }

    function getNotificationType($notificationType)
    {
        $redirectUrl = '';
        switch ($notificationType['type']) {
            case 'App\Notifications\Contact' :
                $Type = "GI";
                $Message = 'A new get in touch / contact request has been received';
                $class = 'dark';
                $redirectUrl = route('admin.enquiry.contact');
                break;
            case 'App\Notifications\Career':
                $Type = "CA";
                $Message = 'A new career application has been received';
                $class = 'success';
                $redirectUrl = route('admin.enquiry.career');
                break;
            case 'App\Notifications\Subscribe':
                $Type = "SB";
                $Message = 'A new request to subscribe to the newsletter has been received';
                $class = 'info';
                $redirectUrl = route('admin.enquiry.subscribe');
                break;
            case 'App\Notifications\Estimation':
                $Type = "FE";
                $Message = 'A new free estimation request has been received';
                $class = 'primary';
                $redirectUrl = route('admin.enquiry.quote');
                break;
            default:
                # code...
                break;
        }

        return [$Type ?? '', $Message ?? '', $class ?? '', $redirectUrl];
    }

    function getchildData($parent)
    {
        $html = '';
        if ($parent->childs()->count() == 0) {
            $html .= "<div class='catfilter' wire:click='setcategoryValue(" . $parent->id . ")' data-id=" . $parent->id . ">" . $parent->title . "</div>";
        } else {
            $html .= "<div class='catfilter catlist' data-id=" . $parent->id . ">";
            $html .= '<span class="disableds">' . $parent->title . '</span>';
            foreach ($parent->childs as $childs) {
                $html .= $this->getchildData($childs);
            }
            $html .= "</div>";

        }
        return $html;
    }

    function getChildIds($child)
    {
        $ids = [$child->id];
        if (count($child->childs) > 0) {
            foreach ($child->childs as $key => $childs) {
                $moreIds = $this->getChildIds($childs);
                if (count($ids) <= 20) {
                    $ids = array_merge($ids, $moreIds);
                }
            }
        }
        return $ids;
    }

    function generateNameImage($userId, $name)
    {
        $nameParts = explode(" ", $name);
        $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
        $image = ImageManager::gd()->read(public_path('storage/pic.jpg'));
        $image->text($initials, 130, 120, function ($font) {
            $font->filename(public_path('fonts/Arial.ttf')); // Path to a font file
            $font->size(90);
            $font->stroke('ff5500', 1);
            $font->color('fff');
            $font->align('center');
            $font->valign('center');
            $font->wrap(1000);
        });
        $imageName = $userId . '.png';
        $image->save(public_path('storage/user/original/' . $imageName));
        return $imageName;
    }

    function getBusinessType($typeId)
    {
        return \App\Models\BusinessType::find($typeId);
    }
    function getBusinessCategory($typeId)
    {
        return \App\Models\BusinessCategory::find($typeId);
    }
    function getCurrencyInfo($typeId)
    {
        return \App\Models\Country::find($typeId);
    }
    function getPaymentTypeInfo($typeId)
    {
        return \App\Models\PaymentType::find($typeId);
    }
    function getLanguageInfo($typeId)
    {
        return \App\Models\Language::find($typeId);
    }


    function getCategoryOptionDropDown($categories)
    {
        $html = '';
        foreach ($categories as $cate) {
            if ($cate->childs()->active()->count() > 0) {
                $html .= '<optgroup  label="' . $cate->title . '">';
                $html .= $this->getCategoryOptionDropDown($cate->childs()->active()->get());
                $html .= '</optgroup>';
            } else {
                $html .= '<option value="' . $cate->id . '">' . $cate->title . '</option>';
            }

        }
        return $html;
    }

    function cartCount()
    {
        $qty = 0;
        foreach (\Cart::instance('shopping')->content() as $item) {
            $qty += $item->qty;
        }
        return $qty;
    }

}
