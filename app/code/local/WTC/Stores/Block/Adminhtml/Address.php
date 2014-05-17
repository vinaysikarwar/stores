<?php
class WTC_Stores_Block_Adminhtml_Address extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_address';
		$this->_blockGroup = 'stores';
		$this->_headerText = Mage::helper('stores')->__('Stores Address');
		parent::__construct();
	}
}