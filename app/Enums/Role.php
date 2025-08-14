<?php
namespace App\Enums;

enum Role: string {
    case BUYER = "Buyer";
    case SELLER = "Seller";
    case ADMIN = "Admin";

    public static function findRole($type)
    {
        if ($type == self::BUYER->value) {
            return self::BUYER->value;
        } elseif ($type == self::SELLER->value) {
            return self::SELLER->value;
        } elseif ($type == self::ADMIN->value) {
            return self::ADMIN->value;
        } else {
            return self::BUYER->value;
        }
    }
}
