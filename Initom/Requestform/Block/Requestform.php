<?php
namespace Initom\Requestform\Block;
class Requestform extends \Magento\Framework\View\Element\Template
{
 
    protected $_resource;
 
    protected $_jobCollection = null;
 
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\ResourceConnection $resource,
        array $data = []
    ) {
        $this->_resource = $resource;
 
        parent::__construct(
            $context,
            $data
        );
    }
 
    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
 
        // You can put these informations editable on BO
        $title = __('Requestform ');
        $description = __('Look at the Requestform');
        $keywords = __('Requestform,request');
 
        // $this->getLayout()->createBlock('Magento\Catalog\Block\Breadcrumbs');
 
        // if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {
        //     $breadcrumbsBlock->addCrumb(
        //         'jobs',
        //         [
        //             'label' => $title,
        //             'title' => $title,
        //             'link' => false // No link for the last element
        //         ]
        //     );
        // }
 
        $this->pageConfig->getTitle()->set($title);
        $this->pageConfig->setDescription($description);
        $this->pageConfig->setKeywords($keywords);
 
 
        $pageMainTitle = $this->getLayout()->getBlock('page.main.title');
        if ($pageMainTitle) {
            $pageMainTitle->setPageTitle($title);
        }
 
        return $this;
    }
}