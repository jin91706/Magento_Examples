<?php
namespace JamesSedillo\JSForm\Model\ResourceModel\Jsform;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /*
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'jamessedillo_jsform_jsform_collection';
    protected $_eventObject = 'jsform_collection';
    */
    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('JamesSedillo\JSForm\Model\Jsform', 'JamesSedillo\JSForm\Model\ResourceModel\Jsform');
    }
}
