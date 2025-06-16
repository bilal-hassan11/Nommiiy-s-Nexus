<?php


namespace App\Enums;

enum TaxDiscountStatus: string
{
    case PERCENTAGE = 'Percentage';
    case FIX_AMOUNT = 'Fixed Amount';
    case INCLUSIVE = 'Inclusive';
    case EXCLUSIVE = 'Exclusive';
}
