<?php

namespace Domains\Guests\Actions;

use Symfony\Component\HttpFoundation\Cookie;

class EmptyGuestBasketAction
{
    public static function execute() : Cookie {
        $cookie = cookie('basket_items', null, -1);

        return $cookie;
    }
}
