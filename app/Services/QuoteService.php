<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Quote;
use App\Models\Settings;

class QuoteService
{
    public static function composeCustomerDetails(Customer $customer): array
    {
        return $customer->only(['name', 'email', 'phone', 'address', 'rc', 'nif', 'ai', 'nis']);
    }

    public static function composeIssuerDetails(Settings $settings): array
    {
        return $settings->only(['name', 'email', 'phone', 'address', 'website', 'rc', 'nif', 'ai', 'nis', 'capital', 'bank_account']);
    }

    protected static function generateQuoteNumber()
    {
        $prefix = 'Q'.GeneralService::generateRandomUppercaseString(2); // Q + 2 random chars
        $paddedNumbers = GeneralService::generatePaddedNumber(6);

        return $prefix.$paddedNumbers;
    }

    public static function generateUniqueQuoteNumber()
    {
        do {
            $quoteNumber = self::generateQuoteNumber();
        } while (Quote::where('quote_number', $quoteNumber)->exists());

        return $quoteNumber;
    }
}
