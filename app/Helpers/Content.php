<?php
namespace App\Helpers;

class Content
{

    public static function ProjectName()
    {
        return env('APP_NAME');
    }

    public static function UsdCurrency()
    {
        return \App\Models\Country::find(231);
    }

    public static function Currency()
    {
        return 'Rs.';
    }

    public static function DeliveryCharges()
    {
        return '0';
    }

    function supportMail()
    {
        return 'support@fissto.com';
    }
    function cmsData($id)
    {
        return \App\Models\Cms::findOrFail($id);
    }
    function meta($id)
    {
        return \App\Models\Meta::findOrFail($id);
    }

    function metaArr($meta)
    {
        $meta = self::meta($meta);
        return ['metaTitle' => $meta->title, 'metaDescription' => $meta->description, 'metaKeyword' => $meta->keyword];
    }

    public static function adminData()
    {
        return \App\Models\Admin::find(1);
    }

    public static function adminInfo()
    {
        return \Auth::guard('admin')->user();
    }

    public static function userInfo()
    {
        $user = \App\Models\User::find(\Auth::user()->id ?? 0);
        return $user;
    }

    public static function getDefaultCurrency()
    {
        $defaultCurrency = new \App\Http\Controllers\CommanController();
        return $defaultCurrency->getDefaultCurrency();
    }

    function cmsHeading($cmsId)
    {
        switch ($cmsId) {
            case '1':
                return 'About (Home Page)';
                break;
            case '2':
                return 'Category Section (Heading)';
                break;
            case '3':
                return 'Product Section (Heading)';
                break;
            case '4':
                return 'Blog Section (Heading)';
                break;
            case '5':
                return 'Contact Section (Heading)';
                break;
            case '6':
                return 'Testimonial Section (Heading)';
                break;
            case '7':
                return 'About Us (Page Content)';
                break;
            case '8':
                return 'Our Mission (Section Content)';
                break;
            case '9':
                return 'Our Vision (Section Content)';
                break;
            case '10':
                return 'Testimonials (Page Content)';
                break;
            case '11':
                return 'Terms & Conditions (Page Content)';
                break;
            case '12':
                return 'Privacy Policy (Page Content)';
                break;
            case '13':
                return 'Projects (Page Content)';
                break;
            case '14':
                return 'Career (Page Content)';
                break;
            case '15':
                return 'Our Team (Page Content)';
                break;
            case '16':
                return 'Categories (Page Content)';
                break;
            case '17':
                return 'Contact (Page Content)';
                break;
            case '18':
                return 'Our Team (Heading Content)';
                break;
            case '19':
                return 'Case Study (Page Content)';
                break;
            case '20':
                return 'Projects (Page Content)';
                break;
            case '21':
                return 'Services (Page Content)';
                break;
            case '22':
                return 'Roofing Systems Materials (Page Content)';
                break;
            case '23':
                return 'Testimonials (Page Content)';
                break;
            case '24':
                return ' Our Cities (Home Page)';
                break;
            default:
                return 'CMS Edit';
                break;
        }
    }

    function purifierClean($value)
    {
        return \Purifier::clean($value);
    }

    /// SMS

    function loginSMS($otp)
    {
        $html = 'Your login code is: ' . $otp . '. ';
        $html .= 'This code is valid for the next 10 minutes.';
        return $html;
    }

    function orderPlace($orderno)
    {
        $html = "Thank you for your order (#" . $orderno . ")! ";
        $html .= "We’ve received it and will process it shortly. ";
        $html .= "You will receive an update on shipping and delivery soon. ";
        $html .= "If you have any questions, feel free to contact us. Thanks again!";
        return $html;
    }

}
