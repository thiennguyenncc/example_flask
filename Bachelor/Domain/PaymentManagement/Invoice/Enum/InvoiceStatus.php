<?php

namespace Bachelor\Domain\PaymentManagement\Invoice\Enum;

use Bachelor\Utility\Enums\IntEnum;

/**
 * @method static static Draft()
 * @method static static Open()
 * @method static static Paid()
 * @method static static Void()
 * @method static static UnCollectible()
 *  For status reference https://stripe.com/docs/billing/invoices/overview
 */
final class InvoiceStatus extends IntEnum
{
    const Draft = 1;
    const Open = 2;
    const Paid = 3;
    const Void = 4;
    const UnCollectible = 5;

    /**
     *
     * @param string $status
     * @return int
     */
    public static function translateFromStripe(string $status): int
    {
        $stripe = [
            'draft' => self::Draft,
            'open' => self::Open,
            'paid' => self::Paid,
            'void' => self::Void,
            'uncollectible' => self::UnCollectible,
        ];
        return $stripe[$status] ?? null;
    }

    /**
     *
     * @return array
     */
    public static function UnpaidStatuses(): array
    {
        return [self::Open, self::UnCollectible];
    }
}
