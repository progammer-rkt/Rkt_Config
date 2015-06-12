<?php
/**
 * Rkt_Config extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category       Rkt
 * @package        Rkt_Config
 * @copyright      Copyright (c) 2015
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Config resource model
 *
 * @category    Rkt
 * @package     Rkt_Config
 * @author      Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
 */
class Rkt_Config_Model_Resource_Config extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * constructor
     *
     * @access public
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    public function _construct()
    {
        $this->_init('rkt_config/config', 'entity_id');
    }

    /**
     * Get store ids to which specified item is assigned
     *
     * @access public
     * @param int $configId
     * @return array
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    public function lookupStoreIds($configId)
    {
        $adapter = $this->_getReadAdapter();
        $select  = $adapter->select()
            ->from($this->getTable('rkt_config/config_store'), 'store_id')
            ->where('config_id = ?', (int)$configId);
        return $adapter->fetchCol($select);
    }

    /**
     * Perform operations after object load
     *
     * @access public
     * @param Mage_Core_Model_Abstract $object
     * @return Rkt_Config_Model_Resource_Config
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        if ($object->getId()) {
            $stores = $this->lookupStoreIds($object->getId());
            $object->setData('store_id', $stores);
        }
        return parent::_afterLoad($object);
    }

    /**
     * Retrieve select object for load object data
     *
     * @param string $field
     * @param mixed $value
     * @param Rkt_Config_Model_Config $object
     * @return Zend_Db_Select
     */
    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);
        if ($object->getStoreId()) {
            $storeIds = array(Mage_Core_Model_App::ADMIN_STORE_ID, (int)$object->getStoreId());
            $select->join(
                array('config_config_store' => $this->getTable('rkt_config/config_store')),
                $this->getMainTable() . '.entity_id = config_config_store.config_id',
                array()
            )
            ->where('config_config_store.store_id IN (?)', $storeIds)
            ->order('config_config_store.store_id DESC')
            ->limit(1);
        }
        return $select;
    }

    /**
     * Assign config to store views
     *
     * @access protected
     * @param Mage_Core_Model_Abstract $object
     * @return Rkt_Config_Model_Resource_Config
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        $oldStores = $this->lookupStoreIds($object->getId());
        $newStores = (array)$object->getStores();
        if (empty($newStores)) {
            $newStores = (array)$object->getStoreId();
        }
        $table  = $this->getTable('rkt_config/config_store');
        $insert = array_diff($newStores, $oldStores);
        $delete = array_diff($oldStores, $newStores);
        if ($delete) {
            $where = array(
                'config_id = ?' => (int) $object->getId(),
                'store_id IN (?)' => $delete
            );
            $this->_getWriteAdapter()->delete($table, $where);
        }
        if ($insert) {
            $data = array();
            foreach ($insert as $storeId) {
                $data[] = array(
                    'config_id'  => (int) $object->getId(),
                    'store_id' => (int) $storeId
                );
            }
            $this->_getWriteAdapter()->insertMultiple($table, $data);
        }
        return parent::_afterSave($object);
    }

    /**
     * process multiple select fields
     *
     * @access protected
     * @param Mage_Core_Model_Abstract $object
     * @return Rkt_Config_Model_Resource_Config
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        $scope = $object->getScope();
        if (is_array($scope)) {
            $object->setScope(implode(',', $scope));
        }
        return parent::_beforeSave($object);
    }
}
