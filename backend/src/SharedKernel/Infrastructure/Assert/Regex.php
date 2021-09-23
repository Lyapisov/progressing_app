<?php

namespace App\SharedKernel\Infrastructure\Assert;

class Regex
{
    const UUID = '^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$';
    const PHONE_NUMBER = '^((\+[1-9])+([0-9]){10})$';
    //const INN = '^([0-9]){10})|([0-9]){12})$';
    const INN = '^[0-9]{10}|[0-9]{12}$';
    // https://stackoverflow.com/questions/5066329/regex-for-valid-international-mobile-phone-number
    //TODO: https://stackoverflow.com/questions/2530377/list-of-phone-number-country-codes
    const UNIVERSAL_PHONE_NUMBER = '^((\+[-9])+([0-9]){10})$';
}
