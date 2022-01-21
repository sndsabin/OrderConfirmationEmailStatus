<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SNDSABIN\OrderConfirmationEmailStatus\Model\Source\OrderConfirmationEmail;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    /**
     * @return array|\string[][]
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => '1',
                'label' => 'sent'
            ],
            [
                'value' => '0',
                'label' => 'not-sent'
            ]
        ];

    }
}
