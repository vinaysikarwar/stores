<?php

class GrapesSoftware_Stores_Adminhtml_AddressController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
		->_setActiveMenu('stores')
		->_addBreadcrumb(Mage::helper('adminhtml')->__('Stores Information'), Mage::helper('adminhtml')->__('Stores Information'));

		return $this;
	}

	public function indexAction() {
		$this->_initAction()
		->renderLayout();
	}
	
	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('stores/stores')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('stores_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('stores');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Store Information'), Mage::helper('adminhtml')->__('Store Information'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Store Information'), Mage::helper('adminhtml')->__('Store Information'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('stores/adminhtml_address_edit'))
			->_addLeft($this->getLayout()->createBlock('stores/adminhtml_address_edit_tabs'));
			

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('stores')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
	
	public function newAction() {
		$this->_forward('edit');
	}

	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {

			$model = Mage::getModel('stores/stores');
			$model->setData($data)
			->setId($this->getRequest()->getParam('id'));
			try {

				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('stores')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('stores')->__('Unable to find item to save'));
		$this->_redirect('*/*/');
	}

	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('stores/stores');

				$model->setId($this->getRequest()->getParam('id'))
				->delete();

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

	public function massDeleteAction() {
		$managerIds = $this->getRequest()->getParam('id');
		if(!is_array($managerIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
		} else {
			try {
				foreach ($managerIds as $managerId) {
					$manager = Mage::getModel('stores/stores')->load($managerId);
					$manager->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(
				Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($managerIds)
				)
				);
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
		}
		$this->_redirect('*/*/index');
	}
	
	 public function exportCsvEnhancedAction()
    {
        $fileName   = 'stores-' . gmdate('YmdHis') . '.csv';
        $grid       = $this->getLayout()->createBlock('stores/adminhtml_address_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFileEnhanced());
    }
}