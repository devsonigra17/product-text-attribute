<?php
namespace Dev\ProductTextAtt\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

class SaveToOrderObserver implements ObserverInterface
{

protected $_objectManager;
protected $_productRepository;

public function __construct(
    \Magento\Framework\ObjectManagerInterface $objectmanager,
    \Magento\Catalog\Model\Product $productRepository
    )
{
    $this->_objectManager = $objectmanager;
    $this->_productRepository = $productRepository;
}

public function execute(EventObserver $observer)
{
    $order = $observer->getEvent()->getOrder();
    $items = $order->getAllItems();
    foreach ($items as $item)
    {
        $data = $this->_productRepository->load($item->getProductId())->getTextAtt();
        if($data!=NULL)
        {
            $order->setTextAtt($data);
        }
        else {
            $order->setTextAtt(NULL);
        }
    }
    return $this;
}
}