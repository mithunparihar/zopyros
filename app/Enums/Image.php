<?php

namespace App\Enums;
enum Image: string
{
    public static function Whatsapp(){
        $imageUrl = Url::IMG->value;
        $generateUrl = $imageUrl."whatsapp.svg";
        return $generateUrl;
    }
}