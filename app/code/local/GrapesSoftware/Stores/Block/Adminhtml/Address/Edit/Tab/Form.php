<?php

class GrapesSoftware_Stores_Block_Adminhtml_Address_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('view_form', array('legend'=>Mage::helper('stores')->__('Store information')));
	  $fieldset->addField('country', 'text', array(
          'label'     => Mage::helper('stores')->__('Country'),
          'class'     => 'required-entry',
          'name'      => 'country',
		));
		
		$fieldset->addField('city', 'text', array(
          'label'     => Mage::helper('stores')->__('City'),
          'class'     => 'required-entry',
          'name'      => 'city',
		));
		
		$fieldset->addField('store_name', 'text', array(
          'label'     => Mage::helper('stores')->__('Store Name'),
          'class'     => 'required-entry',
          'name'      => 'store_name',
		));
		
		$fieldset->addField('store_address', 'text', array(
          'label'     => Mage::helper('stores')->__('Store Address'),
          'class'     => 'required-entry',
          'name'      => 'store_address',
		));
		
		$fieldset->addField('website', 'text', array(
          'label'     => Mage::helper('stores')->__('Website'),
          'class'     => 'required-entry',
          'name'      => 'website',
		));
		
	  
		if ( Mage::getSingleton('adminhtml/session')->getStoresData() )
		{
          $form->setValues(Mage::getSingleton('adminhtml/session')->getStoresData());
          Mage::getSingleton('adminhtml/session')->setStoresData(null);
		} elseif ( Mage::registry('stores_data') ) {
          $form->setValues(Mage::registry('stores_data')->getData());
		}
		return parent::_prepareForm();
	}
}