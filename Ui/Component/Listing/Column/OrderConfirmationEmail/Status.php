<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SNDSABIN\OrderConfirmationEmailStatus\Ui\Component\Listing\Column\OrderConfirmationEmail;

use Magento\Ui\Component\Listing\Columns\Column;

class Status extends Column
{
    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $cssClass = isset($item['is_email_sent']) && $item['is_email_sent'] ? 'btn-success' : 'btn-danger';
                $label = isset($item['is_email_sent']) && $item['is_email_sent'] ? 'sent' : 'not sent';

                $element = '<button type="button" class="btn ';
                $element .= $cssClass . '" disabled>';
                $element .= $label;
                $element .= '</button>';

                $item[$this->getData('name')] = $element;
            }
        }

        return $dataSource;
    }
}
