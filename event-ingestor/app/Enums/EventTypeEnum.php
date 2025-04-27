<?php

namespace App\Enums;

enum EventTypeEnum: string
{
    case VIEW_PAGE = "view_page";
    case PURCHASE = "purchase";

    case REFUND = "refund";

    case DISCOUNT = "discount";

    case PAYMENT = "payment";

    public static function getType(string $value): ?string
    {
        return match ($value) {
            self::VIEW_PAGE->value => self::VIEW_PAGE->value,
            self::PURCHASE->value => self::PURCHASE->value,
            self::REFUND->value => self::REFUND->value,
            self::DISCOUNT->value => self::DISCOUNT->value,
            self::PAYMENT->value => self::PAYMENT->value,
            default => "none",
        };
    }
}
