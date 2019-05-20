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
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Controller\ResultFactory;
use Initom\Requestform\Model\ResourceModel\Requestform\CollectionFactory;

/**
 * Class MassDelete
 * @package Initom\Requestform\Controller\Adminhtml\Requestform
 */
class MassDelete extends Action
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $requestform;

    /**
     * MassDelete constructor.
     * @param Filter $filter
     * @param Action\Context $context
     * @param CollectionFactory $Requestform
     */
    public function __construct(
        Filter $filter,
        Action\Context $context,
        CollectionFactory $requestform
    )
    {
        parent::__construct($context);

        $this->filter = $filter;
        $this->requestform = $requestform;
    }

    /**
     * @return $this|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        try {
            $collection = $this->filter->getCollection($this->requestform->create());
            $deleted = 0;
            foreach ($collection->getItems() as $item) {
                $item->delete();
                $deleted++;
            }
        } catch (\Exception $e) {
            $this->messageManager->addError(
                __('We can\'t process your request right now. %1', $e->getMessage())
            );
            $this->_redirect('adminhtml/requestform/index');
            return;
        }
        $this->messageManager->addSuccessMessage(
            __('A total of %1 record(s) have been deleted.', $deleted)
        );

        return $resultRedirect->setPath('adminhtml/requestform/index');
    }
}
