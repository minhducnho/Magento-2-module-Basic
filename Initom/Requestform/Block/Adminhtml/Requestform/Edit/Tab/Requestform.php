<?php
namespace Initom\Requestform\Block\Adminhtml\Requestform\Edit\Tab;
class Requestform extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * Wysiwyg config
     * 
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $_wysiwygConfig;

    /**
     * Country options
     * 
     * @var \Magento\Config\Model\Config\Source\Locale\Country
     */
    protected $_countryOptions;

    /**
     * Country options
     * 
     * @var \Magento\Config\Model\Config\Source\Yesno
     */
    protected $_booleanOptions;

    /**
     * Store
     * 
     * @var Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @var \Magento\Backend\Model\UrlInterface
     */
    protected $_backendUrl;

    /**
     * constructor
     * 
     * @param \Magento\Backend\Model\UrlInterface $backendUrl
     * @param \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig
     * @param \Magento\Config\Model\Config\Source\Locale\Country $countryOptions
     * @param \Magento\Config\Model\Config\Source\Yesno $booleanOptions
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param array $windowSize
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    )
    {
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Initom\Requestform\Model\Requestform $request */
        $request = $this->_coreRegistry->registry('initom_requestform_request');
        $isElementDisabled = false;
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('request_');
        $form->setFieldNameSuffix('request');
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $fieldset = $form->addFieldset(
            'request_form',
            [
                'legend' => __('Request Information'),
                'class'  => 'fieldset-wide'
            ]
        );

        if ($request->getId()) {
            $fieldset->addField('id', 'hidden', array('name' => 'id'));
        }

        $fieldset->addField(
            'subject',
            'text',
            array(
                'name' => 'subject',
                'label' => __('Subject'),
                'title' => __('Subject'),
                'required' => true,
            )
        );

        $requestData = $this->_session->getData('initom_requestform_request_data', true);
        if ($requestData) {
            $request->addData($requestData);
        } else {
            if (!$request->getId()) {
                $request->addData($request->getDefaultValues());
            }
        }
        $form->addValues($request->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Request');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
        return false;
    }
}
