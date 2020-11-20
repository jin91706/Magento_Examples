<?php
namespace JamesSedillo\JSForm\Block;

class Form extends \Magento\Framework\View\Element\Template
{
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    public function getFormAction()
    {
        return $this->getUrl('jsform/index/submit', ['_secure' => true]);
    }
}
