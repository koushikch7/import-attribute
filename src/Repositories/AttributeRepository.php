<?php

/**
 * TechDivision\Import\Attribute\Repositories\AttributeRepository
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

namespace TechDivision\Import\Attribute\Repositories;

use TechDivision\Import\Attribute\Utils\MemberNames;
use TechDivision\Import\Attribute\Utils\SqlStatementKeys;
use TechDivision\Import\Repositories\AbstractRepository;

/**
 * Repository implementation to load EAV attribute data.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-attribute
 * @link      http://www.techdivision.com
 */
class AttributeRepository extends AbstractRepository implements AttributeRepositoryInterface
{

    /**
     * The prepared statement to load an existing EAV attribute by its attribute code.
     *
     * @var \PDOStatement
     */
    protected $attributeByAttributeCodeStmt;

    /**
     * The prepared statement to load an existing EAV attribute by its entity type ID and attribute code.
     *
     * @var \PDOStatement
     */
    protected $attributeByEntityTypeIdAndAttributeCodeStmt;

    /**
     * Initializes the repository's prepared statements.
     *
     * @return void
     */
    public function init()
    {

        // initialize the prepared statements
        $this->attributeByAttributeCodeStmt =
            $this->getConnection()->prepare($this->loadStatement(SqlStatementKeys::ATTRIBUTE_BY_ATTRIBUTE_CODE));

        // initialize the prepared statements
        $this->attributeByEntityTypeAndAttributeCodeStmt =
            $this->getConnection()->prepare($this->loadStatement(SqlStatementKeys::ATTRIBUTE_BY_ENTITY_TYPE_ID_AND_ATTRIBUTE_CODE));
    }

    /**
     * Return's the EAV attribute with the passed code.
     *
     * @param string $attributeCode The code of the EAV attribute to return
     *
     * @return array The EAV attribute
     * @deprecated Since 2.0.2
     * @see \TechDivision\Import\Attribute\Repositories\AttributeRepositoryInterface::findOneByEntityIdAndAttributeCode()
     */
    public function findOneByAttributeCode($attributeCode)
    {
        // load and return the EAV attribute with the passed code
        $this->attributeByAttributeCodeStmt->execute(array(MemberNames::ATTRIBUTE_CODE => $attributeCode));
        return $this->attributeByAttributeCodeStmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Return's the EAV attribute with the passed entity type ID and code.
     *
     * @param integer $entityTypeId  The entity type ID of the EAV attribute to return
     * @param string  $attributeCode The code of the EAV attribute to return
     *
     * @return array The EAV attribute
     */
    public function findOneByEntityIdAndAttributeCode($entityTypeId, $attributeCode)
    {

        // initialize the params
        $params = array(
            MemberNames::ENTITY_TYPE_ID => $entityTypeId,
            MemberNames::ATTRIBUTE_CODE => $attributeCode
        );

        // load and return the EAV attribute with the passed params
        $this->attributeByEntityTypeAndAttributeCodeStmt->execute($params);
        return $this->attributeByEntityTypeAndAttributeCodeStmt->fetch(\PDO::FETCH_ASSOC);
    }
}
