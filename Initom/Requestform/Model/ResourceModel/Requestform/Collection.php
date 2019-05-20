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

namespace Initom\Requestform\Model\ResourceModel\Requestform;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Initom\Requestform\Model\ResourceModel\Requestform
 */
class Collection extends AbstractCollection
{
	/**
     * @type string
     */
    protected $_idFieldName = 'id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Initom\Requestform\Model\Requestform', 'Initom\Requestform\Model\ResourceModel\Requestform');
    }
}
