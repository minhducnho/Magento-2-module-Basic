<?php
namespace Initom\Requestform\Controller\Index;

use Magento\Framework\App\Config\ScopeConfigInterface;
class Save extends \Magento\Framework\App\Action\Action
{
    protected $_transportBuilder;
    protected $_requestformModel;
    protected $scopeConfig;
    /**
     * Initialize dependencies.
     *
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        ScopeConfigInterface $scopeConfig,
        \Initom\Requestform\Model\RequestformFactory $requestformModel
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->_requestformModel = $requestformModel;
        $this->_transportBuilder = $transportBuilder;
        parent::__construct($context);
    }

    /**
     * Save newsletter subscription preference action
     *
     * @return void|null
     */
    public function execute()
    {
        $post = $this->getRequest()->getPostValue();
        if (!$post) {
            $this->_redirect('*/*/');
            return;
        }
        try {
            if ($this->getemailtemplate() !='') {
	            $postObject = new \Magento\Framework\DataObject();
	            $postObject->setData($post);
                $transport = $this->_transportBuilder
                ->setTemplateIdentifier($this->getemailtemplate())
                ->setTemplateOptions(
                    [
                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars(['data' => $postObject])
                ->setFrom($this->getemailsender())
                ->addTo('$recipientEmail', '$recipientName')
                ->setReplyTo('$recipientEmail', '$recipientName')
                ->getTransport();
                $transport->sendMessage();
            }

            $_requestformModel = $this->_requestformModel->create();
            $_requestformModel->setData($post);
            $_requestformModel->save();

            $this->messageManager->addSuccess(__('Your inquiry has been submitted successfully.We will contact you back shortly.'));
            $this->_redirect($this->_redirect->getRefererUrl());
            return;
        } catch (\Exception $e) {
            $this->messageManager->addError(
                __('We can\'t process your request right now. Sorry, that\'s all we know.')
            );
            $this->_redirect($this->_redirect->getRefererUrl());
            return;
        }
    }
    public function getemailsender()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_EMAIL_SENDER,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    public function getemailtemplate()
    {
        return '';
        $this->scopeConfig->getValue(
            self::XML_PATH_EMAIL_TEMPLATE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}