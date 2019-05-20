<?php
/**
 * Initom
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Initom license that is
 * available through the world-wide-web at this URL:
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

namespace Initom\Requestform\Helper;

class Data
{
    const XML_CONFIG_ENABLE = 'requestform/general/enabled';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function isModuleEnabled($store = null)
    {
        return (bool)$this->scopeConfig->getValue(
            self::XML_CONFIG_ENABLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * Make value readable by \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
     *
     * @param string|array $value
     * @return array
     */
    public function makeArrayFieldValue($value)
    {
        $value = json_decode($value, true);
        unset($value['__empty']);
        return $value;
    }

    /**
     * Make value ready for store
     *
     * @param string|array $value
     * @return string
     */
    public function makeStorableArrayFieldValue($value)
    {
        unset($value['__empty']);
        $value = json_encode($value);
        return $value;
    }
}
