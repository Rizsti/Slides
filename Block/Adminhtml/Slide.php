<?php 
class Cfw_Slides_Block_Adminhtml_Slide
	extends Mage_Adminhtml_Block_Widget_Grid_Container 
{
	protected function _construct() 
	{
		parent::_construct();

		/**
         * The $_blockGroup property tells Magento which alias to use to
         * locate the blocks to be displayed in this grid container.
         * In our example, this corresponds to Slides/Block/Adminhtml.
         */
		$this->_blockGroup = 'cfw_slides_adminhtml';

		/**
         * $_controller is a slightly confusing name for this property.
         * This value, in fact, refers to the folder containing our
         * Grid.php and Edit.php - in our example,
         * Slides/Block/Adminhtml/Slide. So, we'll use 'slide'.
         */
		$this->_controller = 'slide';

		/**
         * The title of the page in the admin panel.
         */
        $this->_headerText = Mage::helper('cfw_slides')
            ->__('Carousel Slides');


	}

	 public function getCreateUrl()
    {
        /**
         * When the "Add" button is clicked, this is where the user should
         * be redirected to - in our example, the method editAction of
         * BrandController.php in Slides module.
         */
        return $this->getUrl(
            'cfw_slides_admin/slide/edit'
        );
    }
}