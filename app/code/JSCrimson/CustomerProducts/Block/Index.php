<?php

namespace JSCrimson\CustomerProducts\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use \Magento\Catalog\Model\CategoryFactory;

class Index extends Template
{
    protected $productCollectionFactory;
    protected $categoryFactory;
    protected $imageHelper;
    protected $priceHelper;

    public function __construct(
        Context $context,      
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        CollectionFactory $productCollectionFactory,
        CategoryFactory $categoryFactory,
        \Magento\Catalog\Helper\Image $imageHelper,
        \Magento\Framework\Pricing\Helper\Data $priceHelper,
        array $data = []
    )
    {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->categoryFactory = $categoryFactory;        
        $this->_storeManager = $storeManager;
        $this->imageHelper = $imageHelper;
        $this->priceHelper = $priceHelper;
        parent::__construct($context, $data);
    }

    public function getBaseUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl();
    }

    public function getProducts()
    {
        $sort = $this->getSortval();
        $sortStr = $sort == 0 ? 'ASC' : 'DESC';
        $low = floatval($this->getPriceone());
        $high = floatval($this->getPricetwo());
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*')
            ->addPriceDataFieldFilter('%s >= %s', ['final_price', $low])
            ->addPriceDataFieldFilter('%s <= %s', ['final_price', $high])
            ->addFinalPrice();
        $collection->getSelect()->limit(10);
        $collection->setOrder('price', $sortStr);
        return $collection;
    }

    public function getItemImage($product)
    {
        $image_url = $this->imageHelper->init($product, 'product_thumbnail_image')->getUrl();
        return $image_url;
    }

    public function getProductPrice($product)
    {
        return $this->priceHelper->currency($product->getFinalPrice(), true, false);
    }
}