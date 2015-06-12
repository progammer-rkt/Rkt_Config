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
    const ENTITY    = 'rkt_config_config';
    const CACHE_TAG = 'rkt_config_config';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'rkt_config_config';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'config';

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
}
