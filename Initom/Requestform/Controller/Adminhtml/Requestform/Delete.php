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

namespace Initom\Requestform\Controller\Adminhtml\Requestform;

use Magento\Backend\App\Action;
use Initom\Requestform\Model\RequestformFactory;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Delete
 * @package Initom\Requestform\Controller\Adminhtml\Requestform
 */
class Delete extends Action
{

    /**
     * @var RequestformFactory
     */
    protected $requestformFactory;

    /**
     * Delete constructor.
     * @param Action\Context $context
     * @param RequestformFactory $requestformFactory
     */
    public function __construct(
        RequestformFactory $requestformFactory,
        Action\Context $context
    )
    {
        parent::__construct($context);

        $this->requestformFactory = $requestformFactory;
    }

    /**
     * @return $this|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        try {
            $id = $this->getRequest()->getParam('id');
            $this->requestformFactory->create()->load($id)->delete();
        } catch (\Exception $e) {
            $this->messageManager->addError(
                __('We can\'t process your request right now. %1', $e->getMessage())
            );
            $this->_redirect('*/requestform/index');
            return;
        }

        $this->messageManager->addSuccessMessage(
            __('A total of 1 record have been deleted.')
        );

        return $resultRedirect->setPath('*/requestform/index');
    }
}
