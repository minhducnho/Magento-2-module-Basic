<?php

namespace Initom\Requestform\Controller\Adminhtml\Requestform;

class Save extends \Initom\Requestform\Controller\Adminhtml\Requestform
{
    /**
     * Backend session
     * 
     * @var \Magento\Backend\Model\Session
     */

    /**
     * constructor
     * 
     * @param \Magento\Backend\Model\Session $backendSession
     * @param \Initom\Requestform\Model\RequestformFactory $requestFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Initom\Requestform\Model\RequestformFactory $requestFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Registry $coreRegistry
    )
    {
        parent::__construct($context, $requestFactory, $coreRegistry);
    }

    /**
     * run the action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $data = $this->getRequest()->getPost('request');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $request = $this->_initRequest();
            $request->setData($data);
            
            try {

                $request->save();
                $this->messageManager->addSuccess(__('The request has been saved.'));
                
                if ($this->getRequest()->getParam('back')) {
                    $resultRedirect->setPath(
                        '*/*/edit',
                        [
                            'id' => $request->getId(),
                            '_current' => true
                        ]
                    );
                    return $resultRedirect;
                }
                $resultRedirect->setPath('*/*/');
                return $resultRedirect;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the request.'));
            }
            $this->_getSession()->setInitomRequestformRequestData($data);
            $resultRedirect->setPath(
                '*/*/edit',
                [
                    'id' => $request->getId(),
                    '_current' => true
                ]
            );
            return $resultRedirect;
        }
        $resultRedirect->setPath('*/*/');
        return $resultRedirect;
    }
}
