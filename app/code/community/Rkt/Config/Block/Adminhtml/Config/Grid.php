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
 * Config admin grid block
 *
 * @category    Rkt
 * @package     Rkt_Config
 * @author      Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
 */
class Rkt_Config_Block_Adminhtml_Config_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    /**
     * constructor
     *
     * @access public
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('configGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return Rkt_Config_Block_Adminhtml_Config_Grid
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('rkt_config/config')
            ->getCollection();

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return Rkt_Config_Block_Adminhtml_Config_Grid
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('rkt_config')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            )
        );
        $this->addColumn(
            'file_name',
            array(
                'header'    => Mage::helper('rkt_config')->__('File Name'),
                'align'     => 'left',
                'index'     => 'file_name',
            )
        );

        $this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('rkt_config')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('rkt_config')->__('Enabled'),
                    '0' => Mage::helper('rkt_config')->__('Disabled'),
                )
            )
        );
        if (!Mage::app()->isSingleStoreMode() && !$this->_isExport) {
            $this->addColumn(
                'store_id',
                array(
                    'header'     => Mage::helper('rkt_config')->__('Store Views'),
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
            'created_at',
            array(
                'header' => Mage::helper('rkt_config')->__('Created at'),
                'index'  => 'created_at',
                'width'  => '120px',
                'type'   => 'datetime',
            )
        );
        $this->addColumn(
            'action',
            array(
                'header'  =>  Mage::helper('rkt_config')->__('Action'),
                'width'   => '100',
                'type'    => 'action',
                'getter'  => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('rkt_config')->__('Edit'),
                        'url'     => array('base'=> '*/*/edit'),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'is_system' => true,
                'sortable'  => false,
            )
        );
        $this->addExportType('*/*/exportCsv', Mage::helper('rkt_config')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('rkt_config')->__('Excel'));
        $this->addExportType('*/*/exportXml', Mage::helper('rkt_config')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return Rkt_Config_Block_Adminhtml_Config_Grid
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('config');
        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label'=> Mage::helper('rkt_config')->__('Delete'),
                'url'  => $this->getUrl('*/*/massDelete'),
                'confirm'  => Mage::helper('rkt_config')->__('Are you sure?')
            )
        );
        $this->getMassactionBlock()->addItem(
            'status',
            array(
                'label'      => Mage::helper('rkt_config')->__('Change status'),
                'url'        => $this->getUrl('*/*/massStatus', array('_current'=>true)),
                'additional' => array(
                    'status' => array(
                        'name'   => 'status',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('rkt_config')->__('Status'),
                        'values' => array(
                            '1' => Mage::helper('rkt_config')->__('Enabled'),
                            '0' => Mage::helper('rkt_config')->__('Disabled'),
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
     * @param Rkt_Config_Model_Config
     * @return string
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
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
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    /**
     * after collection load
     *
     * @access protected
     * @return Rkt_Config_Block_Adminhtml_Config_Grid
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
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
     * @param Rkt_Config_Model_Resource_Config_Collection $collection
     * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
     * @return Rkt_Config_Block_Adminhtml_Config_Grid
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
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
