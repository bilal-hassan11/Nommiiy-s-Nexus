<?php


namespace App\Enums;

enum PaymentOrderStatus: string
{
    case PAID = 'paid';
    case UNPAID = 'unpaid';
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case DELIVERED = 'delivered';
    case PURCHASED_TYPE = 'purchase_order';
    case SALE_TYPE = 'sale_order';
    case ADJUST_TYPE = 'adjust_stock';
    case IN = 'IN';
    case OUT = 'OUT';
    case INBOUND = 'Inbound';
    case OUTBOUND = 'Outbound';
}
