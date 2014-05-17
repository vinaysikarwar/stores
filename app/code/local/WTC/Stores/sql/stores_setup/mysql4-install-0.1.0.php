<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table ml_city_stores(id int not null auto_increment, country varchar(255),city varchar(255),store_name varchar(255), store_address text, website  varchar(255), primary key(id));
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 