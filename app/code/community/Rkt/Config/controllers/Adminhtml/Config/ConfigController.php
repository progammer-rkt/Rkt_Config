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
 * Config admin controller
 *
 * @category    Rkt
 * @package     Rkt_Config
 * @author      Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
 */
class Rkt_Config_Adminhtml_Config_ConfigController
    extends Rkt_Config_Controller_Adminhtml_Config
{
    /**
     * init the config
     *
     * @access protected
     * @return Rkt_Config_Model_Config
     */
    protected function _initConfig()
    {
        $configId  = (int) $this->getRequest()->getParam('id');
        $config    = Mage::getModel('rkt_config/config');
        if ($configId) {
            $config->load($configId);
        }
        Mage::register('current_config', $config);
        return $config;
    }

    /**
     * default action
     *
     * @access public
     * @return void
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_title(Mage::helper('rkt_config')->__('Config Files'))
             ->_title(Mage::helper('rkt_config')->__('Configs'));
        $this->renderLayout();
    }

    /**
     * grid action
     *
     * @access public
     * @return void
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    public function gridAction()
    {
        $this->loadLayout()->renderLayout();
    }

    /**
     * edit config - action
     *
     * @access public
     * @return void
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    public function editAction()
    {
        $configId    = $this->getRequest()->getParam('id');
        $config      = $this->_initConfig();
        if ($configId && !$config->getId()) {
            $this->_getSession()->addError(
                Mage::helper('rkt_config')->__('This config no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getConfigData(true);
        if (!empty($data)) {
            $config->setData($data);
        }
        Mage::register('config_data', $config);
        $this->loadLayout();
        $this->_title(Mage::helper('rkt_config')->__('Config Files'))
             ->_title(Mage::helper('rkt_config')->__('Configs'));
        if ($config->getId()) {
            $this->_title($config->getFileName());
        } else {
            $this->_title(Mage::helper('rkt_config')->__('Add config'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new config action
     *
     * @access public
     * @return void
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * save config - action
     *
     * @access public
     * @return void
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('config')) {
            try {
                $config = $this->_initConfig();
                $config->addData($data);
                $config->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('rkt_config')->__('Config was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $config->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setConfigData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('rkt_config')->__('There was a problem saving the config.')
                );
                Mage::getSingleton('adminhtml/session')->setConfigData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('rkt_config')->__('Unable to find config to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete config - action
     *
     * @access public
     * @return void
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $config = Mage::getModel('rkt_config/config');
                $config->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('rkt_config')->__('Config was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('rkt_config')->__('There was an error deleting config.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('rkt_config')->__('Could not find config to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete config - action
     *
     * @access public
     * @return void
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    public function massDeleteAction()
    {
        $configIds = $this->getRequest()->getParam('config');
        if (!is_array($configIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('rkt_config')->__('Please select configs to delete.')
            );
        } else {
            try {
                foreach ($configIds as $configId) {
                    $config = Mage::getModel('rkt_config/config');
                    $config->setId($configId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('rkt_config')->__('Total of %d configs were successfully deleted.', count($configIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('rkt_config')->__('There was an error deleting configs.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass status change - action
     *
     * @access public
     * @return void
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    public function massStatusAction()
    {
        $configIds = $this->getRequest()->getParam('config');
        if (!is_array($configIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('rkt_config')->__('Please select configs.')
            );
        } else {
            try {
                foreach ($configIds as $configId) {
                $config = Mage::getSingleton('rkt_config/config')->load($configId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d configs were successfully updated.', count($configIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('rkt_config')->__('There was an error updating configs.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * export as csv - action
     *
     * @access public
     * @return void
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    public function exportCsvAction()
    {
        $fileName   = 'config.csv';
        $content    = $this->getLayout()->createBlock('rkt_config/adminhtml_config_grid')
            ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as MsExcel - action
     *
     * @access public
     * @return void
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    public function exportExcelAction()
    {
        $fileName   = 'config.xls';
        $content    = $this->getLayout()->createBlock('rkt_config/adminhtml_config_grid')
            ->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as xml - action
     *
     * @access public
     * @return void
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    public function exportXmlAction()
    {
        $fileName   = 'config.xml';
        $content    = $this->getLayout()->createBlock('rkt_config/adminhtml_config_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Check if admin has permissions to visit related pages
     *
     * @access protected
     * @return boolean
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('rkt_config/config');
    }
}
