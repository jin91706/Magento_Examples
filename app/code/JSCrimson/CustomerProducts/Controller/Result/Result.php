<?php

namespace JSCrimson\CustomerProducts\Controller\Result;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\JsonFactory;

class Result extends \Magento\Framework\App\Action\Action
{

     /**
     * @var Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    protected $resultJsonFactory; 

    /**
     * @param Context     $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        JsonFactory $resultJsonFactory
        )
    {

        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory; 
        return parent::__construct($context);
    }


    public function execute()
    {
        $numone = floatval($this->getRequest()->getParam('priceone'));
        $numtwo = floatval($this->getRequest()->getParam('pricetwo'));
        $sortval = $this->getRequest()->getParam('sortVal');

        $result = $this->resultJsonFactory->create();
        $resultPage = $this->resultPageFactory->create();
        $error = '';

        // Validation
        if (!is_numeric($numone) || $numone < 0) {
            $error = "Value is empty or not a number or is less then zero.";
        }

        if (!is_numeric($numtwo) || $numtwo < 0) {
            $error = "Value is empty or not a number or is less then zero.";
        }

        if ($numone > $numtwo) {
            $error = "Low price can not be greater than High price.";
        }

        $fivetimes = $numone * 5;
        if ($numtwo > $fivetimes) {
            $error = "High price can not be more then 5x greater then Low price";
        }

        $sorts = ["0", "1"];
        if (!in_array($sortval, $sorts) ) {
            $error = "Incorrect sort value";
        }

        $block = $resultPage->getLayout()
                ->createBlock('JSCrimson\CustomerProducts\Block\Index')
                ->setTemplate('JSCrimson_CustomerProducts::result.phtml')
                ->setData('priceone',$numone)
                ->setData('pricetwo',$numtwo)
                ->setData('sortval',$sortval)
                ->toHtml();
        
        if (empty($error)) {
            $result->setData(['output' => $block]);
        } else {
            $result->setData(['output' => $error]);
        }
        
        return $result;
    } 
}