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
 * Product Enquiry admin grid block
 *
 * @category    Rkt
 * @package     Rkt_CustomerSupport
 * @author      Ultimate Module Creator
 */
class Rkt_CustomerSupport_Block_Adminhtml_Productenquiry_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * constructor
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('productenquiryGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return Rkt_CustomerSupport_Block_Adminhtml_Productenquiry_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('rkt_customersupport/productenquiry')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return Rkt_CustomerSupport_Block_Adminhtml_Productenquiry_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('rkt_customersupport')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            )
        );
        $this->addColumn(
            'enquiry_code',
            array(
                'header'    => Mage::helper('rkt_customersupport')->__('Enquiry Code'),
                'align'     => 'left',
                'index'     => 'enquiry_code',
            )
        );
        
        $this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('rkt_customersupport')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('rkt_customersupport')->__('Enabled'),
                    '0' => Mage::helper('rkt_customersupport')->__('Disabled'),
                )
            )
        );
        if (!Mage::app()->isSingleStoreMode() && !$this->_isExport) {
            $this->addColumn(
                'store_id',
                array(
                    'header'     => Mage::helper('rkt_customersupport')->__('Store Views'),
                    'index'      => 'store_id',
                    'type'       => 'store',
                    'store_all'  => true,
                    'store_view' => true,
                    'sortable'   => false,
                    'filter_condition_callback'=> array($this, '_filterStoreCondition'),
                )
            );
        }
        $this->addColumn(
            'action',
            array(
                'header'  =>  Mage::helper('rkt_customersupport')->__('Action'),
                'width'   => '100',
                'type'    => 'action',
                'getter'  => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('rkt_customersupport')->__('Edit'),
                        'url'     => array('base'=> '*/*/edit'),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'is_system' => true,
                'sortable'  => false,
            )
        );
        $this->addExportType('*/*/exportCsv', Mage::helper('rkt_customersupport')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('rkt_customersupport')->__('Excel'));
        $this->addExportType('*/*/exportXml', Mage::helper('rkt_customersupport')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return Rkt_CustomerSupport_Block_Adminhtml_Productenquiry_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('productenquiry');
        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label'=> Mage::helper('rkt_customersupport')->__('Delete'),
                'url'  => $this->getUrl('*/*/massDelete'),
                'confirm'  => Mage::helper('rkt_customersupport')->__('Are you sure?')
            )
        );
        $this->getMassactionBlock()->addItem(
            'status',
            array(
                'label'      => Mage::helper('rkt_customersupport')->__('Change status'),
                'url'        => $this->getUrl('*/*/massStatus', array('_current'=>true)),
                'additional' => array(
                    'status' => array(
                        'name'   => 'status',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('rkt_customersupport')->__('Status'),
                        'values' => array(
                            '1' => Mage::helper('rkt_customersupport')->__('Enabled'),
                            '0' => Mage::helper('rkt_customersupport')->__('Disabled'),
                        )
                    )
                )
            )
        );
        return $this;
    }

    /**
     * get the row url
     *
     * @access public
     * @param Rkt_CustomerSupport_Model_Productenquiry
     * @return string
     * @author Ultimate Module Creator
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    /**
     * get the grid url
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    /**
     * after collection load
     *
     * @access protected
     * @return Rkt_CustomerSupport_Block_Adminhtml_Productenquiry_Grid
     * @author Ultimate Module Creator
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    /**
     * filter store column
     *
     * @access protected
     * @param Rkt_CustomerSupport_Model_Resource_Productenquiry_Collection $collection
     * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
     * @return Rkt_CustomerSupport_Block_Adminhtml_Productenquiry_Grid
     * @author Ultimate Module Creator
     */
    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $collection->addStoreFilter($value);
        return $this;
    }
}
