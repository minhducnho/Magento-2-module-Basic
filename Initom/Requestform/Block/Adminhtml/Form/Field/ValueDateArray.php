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

class ValueDateArray extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{
    /**
     * Prepare to render
     *
     * @return void
     */
    protected function _prepareToRender()
    {
        $this->addColumn('dayofweek', ['label' => __('Day Of Week')]);
        $this->addColumn('opens', ['label' => __('Opens')]);
        $this->addColumn('closes', ['label' => __('Closes')]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add New Entry');
    }
}