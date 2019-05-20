<?php

namespace Initom\Requestform\Controller\Adminhtml\Requestform;

class Edit extends \Initom\Requestform\Controller\Adminhtml\Requestform
{
    /**
     * Backend session
     * 
     * @var \Magento\Backend\Model\Session
     */
    protected $_session;

    /**
     * Page factory
     * 
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * Result JSON factory
     * 
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_resultJsonFactory;

    /**
     * constructor
     * 
     * @param \Magento\Backend\Model\Session $backendSession
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Initom\Requestform\Model\RequestformFactory $requestFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Initom\Requestform\Model\RequestformFactory $requestFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Registry $coreRegistry
    )
    {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_resultJsonFactory = $resultJsonFactory;
        parent::__construct($context, $requestFactory, $coreRegistry);
    }

    /**
     * is action allowed
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Initom_Requestform::index');
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        /** @var \Initom\Requestform\Model\Requestform $request */
        $request = $this->_initRequest();
        $data = '';
        /** @var \Magento\Backend\Model\View\Result\Page|\Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Initom_Requestform::index');
        if ($id) {
            $request->load($id);
            $resultPage->getConfig()->getTitle()->prepend(__('Edit Request '.$request->getName()));
            if (!$request->getId()) {
                $this->messageManager->addError(__('This Request no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setPath(
                    '*/*/edit',
                    [
                        'id' => $request->getId(),
                        '_current' => true
                    ]
                );
                return $resultRedirect;
            }
        }
        $title = $request->getId() ? $request->getName() : __('New Request');
        $resultPage->getConfig()->getTitle()->prepend($title);
        if (empty($data)) {
            $data = $this->_session->getData('initom_requestform_request_data', true);
        }
        if (!empty($data)) {
            $request->setData($data);
        }
        return $resultPage;
    }
}
