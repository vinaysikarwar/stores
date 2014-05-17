<?php
class WTC_AjaxNewsletter_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Newsletter Subscription"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("newsletter subscription", array(
                "label" => $this->__("Newsletter Subscription"),
                "title" => $this->__("Newsletter Subscription")
		   ));

      $this->renderLayout(); 
	  
    }
}