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
 * Config model
 *
 * @category    Rkt
 * @package     Rkt_Config
 * @author      Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
 */
class Rkt_Config_Model_Config extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'rkt_config';
    const CACHE_TAG = 'rkt_config';
    const MODULE_NAME = 'Rkt_Config';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'rkt_config';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'config';

    /**
     * Use to store custom xml files.
     *
     * @var array
     */
    protected $_xmlFiles = array();

    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('rkt_config/config');
    }

    /**
     * before save config
     *
     * @access protected
     * @return Rkt_Config_Model_Config
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    protected function _beforeSave()
    {
        parent::_beforeSave();
        $now = Mage::getSingleton('core/date')->gmtDate();
        if ($this->isObjectNew()) {
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
        return $this;
    }

    /**
     * save config relation
     *
     * @access public
     * @return Rkt_Config_Model_Config
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    protected function _afterSave()
    {
        return parent::_afterSave();
    }

    /**
     * get default values
     *
     * @access public
     * @return array
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    public function getDefaultValues()
    {
        $values = array();
        $values['status'] = 1;
        return $values;
    }

    /**
      * get Scope
      *
      * @access public
      * @return array
      * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
      */
    public function getScope()
    {
        if (!$this->getData('scope')) {
            return explode(',', $this->getData('scope'));
        }
        return $this->getData('scope');
    }

    /**
     * Use to load custom configuration files to global configuration
     *
     * @access public
     * @return Rkt_Config_Model_Config
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    public function loadCustomConfigFiles()
    {
        $this->_loadCustomConfigConatainerXml();
        $this->_setValidCategories();
        return $this;
    }

    /**
     * Use to load custom config files based on the category ids passed.
     *
     * @access public
     * @param  mixed                    $categories
     * @return Rkt_Config_Model_Config
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    public function loadConfigByCategories($categories)
    {
        if (is_int($categories)) {
            $categories = array($categories);
        }

        //loading custom category config file, if a custom config
        //file exist for the passed categories.
        if (is_array($categories)) {
            foreach ($categories as $catId) {
                $catId = (int)$catId;
                if ($this->_validCategory($catId)) {
                    $file = $this->_xmlFiles['category_config'][$catId];
                    $this->_addToGlobalConfig($file);
                }
            }
        }
        return $this;
    }

    /**
     * Use to load the custom config container xml file.
     *
     * @access protected
     * @return Rkt_Config_Model_Config
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    protected function _loadCustomConfigConatainerXml()
    {
        //loading custom config xml file to global configuration
        $customXMLFileConfig = Mage::app()->loadCache(self::CACHE_TAG);
        if (!$customXMLFileConfig) {
            //get custom config xml file
            $xmlFile = Mage::getStoreConfig('custom_config_container_xml/file');

            if (is_string($xmlFile)) {
                $this->_addToGlobalConfig($xmlFile);
            }
        }
        return $this;
    }

    /**
     * Use to find custom config files that are corresponds to valid categories.
     *
     * @access protected
     * @return Rkt_Config_Model_Config
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    protected function _setValidCategories()
    {
        /**
         * @var $files Mage_Core_Model_Config_Element
         */
        $files = Mage::getConfig()->getNode('default/category_config_files/files');
        if ($files->hasChildren()) {
            foreach ($files->children() as $key => $item) {
                /**
                 * @var  $item Mage_Core_Model_Config_Element
                 */
                if ($item->is('category_id')) {
                    $catHelper = Mage::helper('catalog/category');
                    $categoryId = (int)$item->category_id;
                    $file = $item->file;

                    //merge custom config file, if and only if category is valid.
                    if ($catHelper->canShow($categoryId)) {
                       $this->_xmlFiles['category_config'][$categoryId] = $file;
                    }
                }
            }
        }
        return $this;
    }

    /**
     * Use to check whether a valid category
     *
     * @access protected
     * @param  int      $categoryId
     * @return boolean
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    protected function _validCategory($categoryId)
    {
        if (key_exists($categoryId, $this->_xmlFiles['category_config'])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Use to extend global configuration with the configurations available
     * in the xml file.
     *
     * @access  private
     * @param   string                   $xmlFile
     * @return  Rkt_Config_Model_Config
     * @author  Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    private function _addToGlobalConfig($xmlFile)
    {
        $mergeToObject = Mage::getConfig();
        $mergeModel = Mage::getModel('core/config_base');

        $configFile = $mergeToObject->getModuleDir('etc', self::MODULE_NAME)
            . DS
            . $xmlFile;

        if ($mergeModel->loadFile($configFile)) {
            $mergeToObject->extend($mergeModel, true);
        }

        return $this;
    }
}
