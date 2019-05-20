<?php

namespace Initom\Requestform\Block\Adminhtml;

class Requestform extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_requestform';
        $this->_blockGroup = 'Initom_Requestform';
        $this->_headerText = __('Request Manager');
        $this->_addButtonLabel = __('Add Request');
        parent::_construct();
    }
}