<?php

class WTC_Stores_Model_Stores extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('stores/stores');
    }
}