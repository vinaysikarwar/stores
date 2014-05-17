<?php

class WTC_Stores_Block_Adminhtml_Address_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

	protected $_exportPageSize = 500;

  public function __construct()
  {
      parent::__construct();
      $this->setId('addressGrid');
      $this->setDefaultSort('id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('stores/stores')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
		$this->addColumn('id', array(
          'header'    => Mage::helper('stores')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));
		
		$this->addColumn('country', array(
          'header'    => Mage::helper('stores')->__('Country'),
          'align'     =>'left',
          'index'     => 'country',
      ));
		
		$this->addColumn('city', array(
          'header'    => Mage::helper('stores')->__('City'),
          'align'     =>'left',
          'index'     => 'city',
      ));
	  
	  $this->addColumn('store_name', array(
          'header'    => Mage::helper('stores')->__('Name'),
          'align'     =>'left',
          'index'     => 'store_name',
      ));
	  
	  $this->addColumn('store_address', array(
          'header'    => Mage::helper('stores')->__('Store Address'),
          'align'     =>'left',
          'index'     => 'store_address',
      ));
	  
	  $this->addColumn('website', array(
          'header'    => Mage::helper('stores')->__('Website'),
          'align'     =>'left',
          'index'     => 'website',
      ));
	  
	  
	  

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('stores')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('stores')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		$this->addExportType('*/*/exportCsvEnhanced', Mage::helper('stores')->__('CSV'));
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('stores');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('stores')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('stores')->__('Are you sure?')
        ));

        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }
  
  public function getCsvFileEnhanced()
    {
        $this->_isExport = true;
        $this->_prepareGrid();
        $io = new Varien_Io_File();
        $path = Mage::getBaseDir('var') . DS . 'export' . DS; //best would be to add exported path through config
        $name = md5(microtime());
        $file = $path . DS . $name . '.csv';
        /**
         * It is possible that you have name collision (summer/winter time +1/-1)
         * Try to create unique name for exported .csv file
         */
        while (file_exists($file)) {
            sleep(1);
            $name = md5(microtime());
            $file = $path . DS . $name . '.csv';
        }
        $io->setAllowCreateFolders(true);
        $io->open(array('path' => $path));
        $io->streamOpen($file, 'w+');
        $io->streamLock(true);
        $io->streamWriteCsv($this->_getExportHeaders());
        //$this->_exportPageSize = load data from config
        $this->_exportIterateCollectionEnhanced('_exportCsvItem', array($io));
        if ($this->getCountTotals()) {
            $io->streamWriteCsv($this->_getExportTotals());
        }
        $io->streamUnlock();
        $io->streamClose();
        return array(
            'type'  => 'filename',
            'value' => $file,
            'rm'    => false // can delete file after use
        );
    }
  
  public function _exportIterateCollectionEnhanced($callback, array $args)
    {
        $originalCollection = $this->getCollection();
        $count = null;
        $page  = 1;
        $lPage = null;
        $break = false;
        $ourLastPage = 10;
        while ($break !== true) {
            $collection = clone $originalCollection;
            $collection->setPageSize($this->_exportPageSize);
            $collection->setCurPage($page);
            $collection->load(/*true, true*/);
            if (is_null($count)) {
                $count = $collection->getSize();
                $lPage = $collection->getLastPageNumber();
            }
            if ($lPage == $page || $ourLastPage == $page) {
                $break = true;
            }
            $page ++;
            foreach ($collection as $item) {
                //$item->setState($item->getState(), 'processing'); $item->save();
                call_user_func_array(array($this, $callback), array_merge(array($item), $args));
            }
        }
        /*exit();*/
    }

}