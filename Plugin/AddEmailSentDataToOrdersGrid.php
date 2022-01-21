<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SNDSABIN\OrderConfirmationEmailStatus\Plugin;

use Psr\Log\LoggerInterface;

class AddEmailSentDataToOrdersGrid
{
    /** @var LoggerInterface */
    private $logger;

    /**
     * AddEmailSentDataToOrdersGrid constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param \Magento\Framework\View\Element\UiComponent\DataProvider\CollectionFactory $subject
     * @param \Magento\Sales\Model\ResourceModel\Order\Grid\Collection $collection
     * @param $requestName
     * @return mixed
     */
    public function afterGetReport($subject, $collection, $requestName)
    {
        if ($requestName !== 'sales_order_grid_data_source') {
            return $collection;
        }

        if ($collection->getMainTable() === $collection->getResource()->getTable('sales_order_grid')) {
            try {
                $salesOrderTable = $collection->getResource()->getTable('sales_order');
                $collection->getSelect()->join(
                    ['sales_order' => $salesOrderTable],
                    'main_table.entity_id = sales_order.entity_id',
                    ['is_email_sent' => new \Zend_Db_Expr('CASE sales_order.email_sent WHEN 1 THEN 1 ELSE 0 END')]
                );

                $collection->addFilterToMap('is_email_sent', new \Zend_Db_Expr('CASE sales_order.email_sent WHEN 1 THEN 1 ELSE 0 END'));

            } catch (\Exception $exception) {
                $this->logger->log($exception->getMessage());
            }
        }

        return $collection;
    }
}
