<?php
class Rkt_Config_IndexController extends Mage_Core_Controller_Front_Action
{

	/**
	 * Use to store config model instance.
	 *
	 * @var Rkt_Config_Model_Config
	 */
	protected $_myModel;

	/**
	 * Default action
	 *
	 * @return void
	 */
	public function indexAction()
	{
		//loading container xml file.
		$this->getMyModel()->loadCustomConfigFiles();

		//load product for test
		$product = Mage::getModel('catalog/product')->load(1);

		//loads all custom config xml files corresponding to product's category
		$config = $this->getMyModel()
			->loadConfigByCategories($product->getCategoryIds());

		//retrieves product options
		var_dump(Mage::getConfig()->getNode('custom_category_config/product_options'));

		die();
	}

	/**
	 * Use to provide singleton instance of config model.
	 *
	 * @access public
	 * @return Rkt_Config_Model_Config
	 * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
	 */
	public function getMyModel()
	{
		if ($this->_myModel == '') {
			$this->_myModel = Mage::getModel('rkt_config/config');
		}
		return $this->_myModel;
	}

}