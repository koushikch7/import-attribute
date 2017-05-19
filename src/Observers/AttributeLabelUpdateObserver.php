<?php

/**
 * TechDivision\Import\Attribute\Observers\AttributeLabelUpdateObserver
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-attribute
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Attribute\Observers;

use TechDivision\Import\Attribute\Utils\ColumnKeys;
use TechDivision\Import\Attribute\Utils\MemberNames;

/**
 * Observer that update's the EAV attribute label.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-attribute
 * @link      http://www.techdivision.com
 */
class AttributeLabelUpdateObserver extends AttributeLabelObserver
{

    /**
     * Initialize the attribute with the passed attributes and returns an instance.
     *
     * @param array $attr The attribute attributes
     *
     * @return array The initialized attribute
     */
    protected function initializeAttribute(array $attr)
    {

        // load value, store ID
        $storeId = $attr[MemberNames::STORE_ID];

        // load the attribute code from the row
        $attributeCode = $this->getValue(ColumnKeys::ATTRIBUTE_CODE);

        // query whether or not an attribute label
        if ($attributeLabel = $this->loadAttributeLabelByAttributeCodeAndStoreId($attributeCode, $storeId)) {
            return $this->mergeEntity($attributeLabel, $attr);
        }

        // simply return the attributes
        return $attr;
    }

    /**
     * Return's the EAV attribute label with the passed attribute code and store ID.
     *
     * @param string  $attributeCode The attribute code of the EAV attribute label to return
     * @param integer $storeId       The store ID of the EAV attribute label to return
     *
     * @return array The EAV attribute label
     */
    protected function loadAttributeLabelByAttributeCodeAndStoreId($attributeCode, $storeId)
    {
        return $this->getAttributeBunchProcessor()->loadAttributeLabelByAttributeCodeAndStoreId($attributeCode, $storeId);
    }
}