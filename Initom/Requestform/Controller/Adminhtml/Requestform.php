<?php

namespace Initom\Requestform\Controller\Adminhtml;

abstract class Requestform extends \Magento\Backend\App\Action
{
    /**
     * Requestform Factory
     * 
     * @var \Initom\Requestform\Model\RequestformFactory
     */
    protected $_requestFactory;

    /**
     * Core registry
     * 
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * Result redirect factory
     * 
     * @var \Magento\Backend\Model\View\Result\RedirectFactory
     */

    /**
     * constructor
     * 
     * @param \Initom\Requestform\Model\RequestformFactory $requestFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\Model\View\Result\RedirectFactory 
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Initom\Requestform\Model\RequestformFactory $requestFactory,
        \Magento\Framework\Registry $coreRegistry
    )
    {
        $this->_requestFactory    = $requestFactory;
        $this->_coreRegistry    = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Init Request
     *
     * @return \Initom\Requestform\Model\Requestform
     */
    protected function _initRequest()
    {
        $requestId  = (int) $this->getRequest()->getParam('id');
        /** @var \Initom\Requestform\Model\Requestform $request */
        $request    = $this->_requestFactory->create();
        if ($requestId) {
            $request->load($requestId);
        }
        $this->_coreRegistry->register('initom_requestform_request', $request);
        return $request;
    }
}
