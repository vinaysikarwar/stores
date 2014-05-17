<?php

class GrapesSoftware_Stores_Block_Adminhtml_Address_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                  
        $this->_objectId = 'id';
        $this->_blockGroup = 'stores';
        $this->_controller = 'adminhtml_address';
         
        $this->_updateButton('save', 'label', Mage::helper('stores')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('stores')->__('Delete'));
         
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
    }

    public function getHeaderText()
    {
        return Mage::helper('stores')->__('Store Address');
    }
}