<?php
namespace JamesSedillo\JSForm\Block;

use JamesSedillo\JSForm\Model\ResourceModel\Jsform\CollectionFactory;

class Showdata extends \Magento\Framework\View\Element\Template
{
    public $collection;
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->collection = $collectionFactory;
        parent::__construct($context, $data);
    }

    public function getCollection()
    {
        $collection = $this->collection->create();
        return $collection;
    }

    public function getDeleteAction()
    {
        return $this->getUrl('jsform/index/delete', ['_secure' => true]);
    }
}
