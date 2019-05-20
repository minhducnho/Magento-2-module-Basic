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

class ValueArray extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{
    /**
     * @var \Initom\Requestform\Block\Adminhtml\Form\Field\ValueType _valueTypeRenderer
     */
    protected $_valueTypeRenderer;

    /**
     * Retrieve group column renderer
     *
     * @return Customergroup
     */
    protected function _getValueTypeRenderer()
    {
        if (!$this->_valueTypeRenderer) {
            $this->_valueTypeRenderer = $this->getLayout()->createBlock(
                \Initom\Requestform\Block\Adminhtml\Form\Field\ValueType::class,
                'select_data_type_select',
                ['data' => ['is_render_to_js_template' => true]]
            );
            $this->_valueTypeRenderer->setClass('select_data_type_select');
        }
        return $this->_valueTypeRenderer;
    }
    
    /**
     * Prepare to render
     *
     * @return void
     */
    protected function _prepareToRender()
    {
        $this->addColumn('types', ['label' => __('Types'), 'renderer' => $this->_getValueTypeRenderer()]);
        $this->addColumn('type', ['label' => __('Type'), 'renderer' => $this->_getValueTypeRenderer()]);
        $this->addColumn('values', ['label' => __('Value')]);
        $this->addColumn('value', ['label' => __('Value')]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add New Entry');
    }

    /**
     * Prepare existing row data object
     *
     * @param \Magento\Framework\DataObject $row
     * @return void
     */
    protected function _prepareArrayRow(\Magento\Framework\DataObject $row)
    {
        file_put_contents(BP.'/var/log/_prepareArrayRow.log', print_r($row->getData(), true) . PHP_EOL ,FILE_APPEND);
        $optionExtraAttr = [];
        $optionExtraAttr['option_' . $this->_getValueTypeRenderer()->calcOptionHash($row->getData('types'))] = 'selected="selected"';
        $optionExtraAttr['option_' . $this->_getValueTypeRenderer()->calcOptionHash($row->getData('type'))] = 'selected="selected"';
        $row->setData('option_extra_attrs', $optionExtraAttr);
    }
}