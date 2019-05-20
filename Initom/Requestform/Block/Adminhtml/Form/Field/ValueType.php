<?php
/**
 * Initom
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Initom license that is
 * available through the world-wide-web at this URL:
 * 
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Initom
 * @package     Initom_Requestform
 * @copyright   Copyright (c) Initom
 * @license     Initom
 */
 
namespace Initom\Requestform\Block\Adminhtml\Form\Field;

/**
 * HTML select element block with blacklist type options
 */
class ValueType extends \Magento\Framework\View\Element\Html\Select
{
    protected $_types = [
        'email' => 'Email Address',
        'domain'=> 'Domain'
    ];

    public function setInputId($value)
    {
        return $this->setId($value);
    }
    
    public function setInputName($value)
    {
        return $this->setName($value);
    }
    
    public function _toHtml()
    {
        foreach ($this->_types as $code => $label) {
            $this->addOption($code, addslashes($label));
        }
        
        return parent::_toHtml();
    }
}