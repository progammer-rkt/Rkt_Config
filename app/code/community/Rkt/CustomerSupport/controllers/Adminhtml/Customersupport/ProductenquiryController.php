<?php
/**
 * Rkt_CustomerSupport extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is a part of a paid extension. You cannot sell the code base without acknowledging the developer team of this extension. You are free to edit the code base once you have purchased this extension. 
 * 
 * For more details, have look into the reference url provided with this file.
 * 
 * @category       Rkt
 * @package        Rkt_CustomerSupport
 * @copyright      Copyright (c) 2015
 * @license        http://www.rktinaction.com/support
 */
/**
 * Product Enquiry admin controller
 *
 * @category    Rkt
 * @package     Rkt_CustomerSupport
 * @author      Ultimate Module Creator
 */
class Rkt_CustomerSupport_Adminhtml_Customersupport_ProductenquiryController extends Rkt_CustomerSupport_Controller_Adminhtml_CustomerSupport
{
    /**
     * init the product enquiry
     *
     * @access protected
     * @return Rkt_CustomerSupport_Model_Productenquiry
     */
    protected function _initProductenquiry()
    {
        $productenquiryId  = (int) $this->getRequest()->getParam('id');
        $productenquiry    = Mage::getModel('rkt_customersupport/productenquiry');
        if ($productenquiryId) {
            $productenquiry->load($productenquiryId);
        }
        Mage::register('current_productenquiry', $productenquiry);
        return $productenquiry;
    }

    /**
     * default action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_title(Mage::helper('rkt_customersupport')->__('Customer Support'))
             ->_title(Mage::helper('rkt_customersupport')->__('Product Enquiries'));
        $this->renderLayout();
    }

    /**
     * grid action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function gridAction()
    {
        $this->loadLayout()->renderLayout();
    }

    /**
     * edit product enquiry - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function editAction()
    {
        $productenquiryId    = $this->getRequest()->getParam('id');
        $productenquiry      = $this->_initProductenquiry();
        if ($productenquiryId && !$productenquiry->getId()) {
            $this->_getSession()->addError(
                Mage::helper('rkt_customersupport')->__('This product enquiry no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getProductenquiryData(true);
        if (!empty($data)) {
            $productenquiry->setData($data);
        }
        Mage::register('productenquiry_data', $productenquiry);
        $this->loadLayout();
        $this->_title(Mage::helper('rkt_customersupport')->__('Customer Support'))
             ->_title(Mage::helper('rkt_customersupport')->__('Product Enquiries'));
        if ($productenquiry->getId()) {
            $this->_title($productenquiry->getEnquiryCode());
        } else {
            $this->_title(Mage::helper('rkt_customersupport')->__('Add product enquiry'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new product enquiry action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * save product enquiry - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('productenquiry')) {
            try {
                $productenquiry = $this->_initProductenquiry();
                $productenquiry->addData($data);
                $productenquiry->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('rkt_customersupport')->__('Product Enquiry was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $productenquiry->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setProductenquiryData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('rkt_customersupport')->__('There was a problem saving the product enquiry.')
                );
                Mage::getSingleton('adminhtml/session')->setProductenquiryData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('rkt_customersupport')->__('Unable to find product enquiry to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete product enquiry - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $productenquiry = Mage::getModel('rkt_customersupport/productenquiry');
                $productenquiry->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('rkt_customersupport')->__('Product Enquiry was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('rkt_customersupport')->__('There was an error deleting product enquiry.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('rkt_customersupport')->__('Could not find product enquiry to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete product enquiry - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massDeleteAction()
    {
        $productenquiryIds = $this->getRequest()->getParam('productenquiry');
        if (!is_array($productenquiryIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('rkt_customersupport')->__('Please select product enquiries to delete.')
            );
        } else {
            try {
                foreach ($productenquiryIds as $productenquiryId) {
                    $productenquiry = Mage::getModel('rkt_customersupport/productenquiry');
                    $productenquiry->setId($productenquiryId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('rkt_customersupport')->__('Total of %d product enquiries were successfully deleted.', count($productenquiryIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('rkt_customersupport')->__('There was an error deleting product enquiries.')
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
     * @author Ultimate Module Creator
     */
    public function massStatusAction()
    {
        $productenquiryIds = $this->getRequest()->getParam('productenquiry');
        if (!is_array($productenquiryIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('rkt_customersupport')->__('Please select product enquiries.')
            );
        } else {
            try {
                foreach ($productenquiryIds as $productenquiryId) {
                $productenquiry = Mage::getSingleton('rkt_customersupport/productenquiry')->load($productenquiryId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d product enquiries were successfully updated.', count($productenquiryIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('rkt_customersupport')->__('There was an error updating product enquiries.')
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
     * @author Ultimate Module Creator
     */
    public function exportCsvAction()
    {
        $fileName   = 'productenquiry.csv';
        $content    = $this->getLayout()->createBlock('rkt_customersupport/adminhtml_productenquiry_grid')
            ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as MsExcel - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportExcelAction()
    {
        $fileName   = 'productenquiry.xls';
        $content    = $this->getLayout()->createBlock('rkt_customersupport/adminhtml_productenquiry_grid')
            ->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as xml - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportXmlAction()
    {
        $fileName   = 'productenquiry.xml';
        $content    = $this->getLayout()->createBlock('rkt_customersupport/adminhtml_productenquiry_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Check if admin has permissions to visit related pages
     *
     * @access protected
     * @return boolean
     * @author Ultimate Module Creator
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('customer/rkt_customersupport/productenquiry');
    }
}
