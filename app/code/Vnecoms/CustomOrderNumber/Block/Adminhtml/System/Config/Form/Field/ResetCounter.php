<?php

namespace Vnecoms\CustomOrderNumber\Block\Adminhtml\System\Config\Form\Field;

class ResetCounter extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * (non-PHPdoc).
     *
     * @see \Magento\Config\Block\System\Config\Form\Field::_isInheritCheckboxRequired()
     */
    protected function _isInheritCheckboxRequired(
        \Magento\Framework\Data\Form\Element\AbstractElement $element
    ) {
        return false;
    }

    /**
     * (non-PHPdoc).
     *
     * @see \Magento\Config\Block\System\Config\Form\Field::_renderScopeLabel()
     */
    protected function _renderScopeLabel(
        \Magento\Framework\Data\Form\Element\AbstractElement $element
    ) {
        return '';
    }
}
