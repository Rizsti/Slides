<?php 
class Cfw_Slides_Block_Adminhtml_Slide_Edit
	extends Mage_Adminhtml_Block_Widget_Form_Container
{
	protected function _prepareLayout() 
	{
		parent::_prepareLayout();
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
	        // Mage::app()->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
	    }
	}

	protected function _construct() 
	{
		parent::_construct();
		$this->_blockGroup = 'cfw_slides_adminhtml';
		$this->_controller = 'slide';

		/**
         * The $_mode property tells Magento which folder to use
         * to locate the related form blocks to be displayed in
         * this form container. In our example, this corresponds
         * to Slides/Block/Adminhtml/Slide/Edit/.
         */

		$this->_mode = 'edit';

		$newOrEdit = $this->getRequest()->getParam('id')
			? $this->__('Edit')
			: $this->__('New');
		$this->__headerText = $newOrEdit . ' ' . $this->__('Slide');

	}
}