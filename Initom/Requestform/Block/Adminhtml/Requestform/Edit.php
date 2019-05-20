<?php

namespace Initom\Requestform\Block\Adminhtml\Requestform;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry
     * 
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * constructor
     * 
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\Block\Widget\Context $context,
        array $data = []
    )
    {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }

    /**
     * Initialize Request edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Initom_Requestform';
        $this->_controller = 'adminhtml_requestform';
        parent::_construct();
        $this->buttonList->update('save', 'label', __('Save Request'));
        $this->buttonList->add(
            'save-and-continue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => [
                            'event' => 'saveAndContinueEdit',
                            'target' => '#edit_form'
                        ]
                    ]
                ]
            ],
            -100
        );
        $this->buttonList->update('delete', 'label', __('Delete Request'));
    }
    /**
     * Retrieve text for header element depending on loaded request
     *
     * @return string
     */
    public function getHeaderText()
    {
        /** @var \Initom\Requestform\Model\Requestform $request */
        $request = $this->_coreRegistry->registry('initom_requestform_request');
        if ($request->getId()) {
            return __("Edit Request '%1'", $this->escapeHtml($request->getId()));
        }
        return __('New Request');
    }
}
