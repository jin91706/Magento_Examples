<?php
namespace JamesSedillo\JSForm\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use JamesSedillo\JSForm\Model\JsformFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;

class Submit extends Action
{
    protected $resultPageFactory;
    protected $jsformFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        JsformFactory $jsformFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->jsformFactory = $jsformFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        try {
            $data = (array)$this->getRequest()->getPost();
            if ($data) {
                $model = $this->jsformFactory->create();
                $model->setData($data)->save();
                $this->messageManager->addSuccessMessage(__("Data Saved Successfully."));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e, __("We can\'t submit your request, Please try again."));
        }
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;

    }
}
