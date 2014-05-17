<?php

class GrapesSoftware_Stores_Block_Adminhtml_Address_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('address_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('stores')->__('Store Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('stores')->__('Store Information'),
          'title'     => Mage::helper('stores')->__('Store Information'),
          'content'   => $this->getLayout()->createBlock('stores/adminhtml_address_edit_tab_form')->toHtml(),
      ));
      
      return parent::_beforeToHtml();
  }
}