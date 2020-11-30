<?php
namespace JamesSedillo\JSForm\Controller\Index;

use JamesSedillo\JSForm\Model\JsformFactory;
use Magento\Framework\Controller\ResultFactory;

class Delete extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    protected $extensionFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
       \Magento\Framework\App\Action\Context $context,
       \Magento\Framework\View\Result\PageFactory $pageFactory,
       JsformFactory $extensionFactory
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->extensionFactory = $extensionFactory;
        return parent::__construct($context);
    }
    /**
     * View page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
            $data = (array)$this->getRequest()->getParams();
            if ($data) {
                $model = $this->extensionFactory->create()->load($data['id']);
                $model->delete();
                $this->messageManager->addSuccessMessage(__("Record Delete Successfully."));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e, __("We can\'t delete record, Please try again."));
        }
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
    }
}
