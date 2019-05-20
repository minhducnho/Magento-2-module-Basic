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

namespace Initom\Requestform\Model;

use Magento\Framework\App\Area;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\DataObject;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Store\Model\Store;

/**
 * Class Requestform
 * @package Initom\Requestform\Model
 */
class Requestform extends AbstractModel
{
    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $_transportBuilder;

    /**
     * Log constructor.
     * @param Context $context
     * @param Registry $registry
     * @param TransportBuilder $transportBuilder
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        TransportBuilder $transportBuilder,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    )
    {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);

        $this->_transportBuilder = $transportBuilder;
    }

    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init('Initom\Requestform\Model\ResourceModel\Requestform');
    }

    /**
     * Save email logs
     *
     * @param $message
     * @param $status
     */
    public function saveLog($message, $status)
    {
        $headers = $message->getHeaders();

        if (isset($headers['Subject']) && isset($headers['Subject'][0])) {
            $this->setSubject($headers['Subject'][0]);
        }

        if (isset($headers['From']) && isset($headers['From'][0])) {
            $this->setFrom($headers['From'][0]);
        }

        if (isset($headers['To'])) {
            $recipient = $headers['To'];
            if (isset($recipient['append'])) {
                unset($recipient['append']);
            }
            $this->setTo(implode(', ', $recipient));
        }

        if (isset($headers['Cc'])) {
            $cc = $headers['Cc'];
            if (isset($cc['append'])) {
                unset($cc['append']);
            }
            $this->setCc(implode(', ', $cc));
        }

        if (isset($headers['Bcc'])) {
            $bcc = $headers['Bcc'];
            if (isset($bcc['append'])) {
                unset($bcc['append']);
            }
            $this->setBcc(implode(', ', $bcc));
        }

        $body = $message->getBodyHtml();
        if (is_object($body)) {
            $content = htmlspecialchars($body->getRawContent());
        } else {
            $content = htmlspecialchars($message->getBody()->getRawContent());
        }

        $this->setEmailContent($content)
            ->setStatus($status)
            ->save();
    }

    /**
     * @return bool
     */
    public function resendEmail()
    {
        try {
            $data                  = $this->getData();
            $data['email_content'] = htmlspecialchars_decode($data['email_content']);

            $dataObject = new DataObject();
            $dataObject->setData($data);

            $sender = $this->extractEmailInfo($data['from']);
            foreach ($sender as $name => $email) {
                $sender = ['name' => $name, 'email' => $email];
                break;
            }

            $this->_transportBuilder
                ->setTemplateIdentifier('requestform_email_template')
                ->setTemplateOptions(['area' => Area::AREA_FRONTEND, 'store' => Store::DEFAULT_STORE_ID])
                ->setTemplateVars($data)
                ->setFrom($sender);

            /** Add receiver emails*/
            $recipient = $this->extractEmailInfo($data['to']);
            foreach ($recipient as $name => $email) {
                $this->_transportBuilder->addTo($email, $name);
            }

            /** Add cc emails*/
            if (isset($data['cc'])) {
                $ccEmails = $this->extractEmailInfo($data['cc']);
                foreach ($ccEmails as $name => $email) {
                    $this->_transportBuilder->addCc($email, $name);
                }
            }

            /** Add Bcc emails*/
            if (isset($data['bcc'])) {
                $bccEmails = $this->extractEmailInfo($data['bcc']);
                foreach ($bccEmails as $email) {
                    $this->_transportBuilder->addBcc($email);
                }
            }

            $this->_transportBuilder->getTransport()
                ->sendMessage();
        } catch (\Exception $e) {
            $this->_logger->critical($e->getMessage());

            return false;
        }

        return true;
    }

    /**
     * @param $emailList
     * @return array|null
     */
    protected function extractEmailInfo($emailList)
    {
        $emails = explode(', ', $emailList);
        $data   = [];
        foreach ($emails as $email) {
            $emailArray = explode(' <', $email);
            $name       = '';
            if (sizeof($emailArray) > 1) {
                $name  = trim($emailArray[0], '" ');
                $email = trim($emailArray[1], '<>');
            }
            $data[$name] = $email;
        }

        return $data;
    }
}