<?php
class Cfw_Slides_Model_Slide
	extends Mage_Core_Model_Abstract
{
	const VISIBILITY_HIDDEN = '0';
	const VISIBILITY_DIRECTORY = '1';

	protected function _construct() 
	{
		 /**
		 * This tells Magento where the related resource model can be found.
		 *
		 * For a resource model, Magento will use the standard model alias -
		 * in this case 'cfw_slidex' - and look in
		 * config.xml for a child node <resourceModel/>. This will be the
		 * location that Magento will look for a model when
		 * Mage::getResourceModel() is called - in our case,
		 * Cfw_Slides_Model_Resource.
		 */
		$this->_init('cfw_slides/slide');	
	}	

	 /**
	 * This method is used in the grid and form for populating the dropdown.
	 */
	public function getAvailableVisibilies()
	{
		return array(
			self::VISIBILITY_HIDDEN
				=> Mage::helper('cfw_slides')
					   ->__('Hidden'),
			self::VISIBILITY_DIRECTORY
				=> Mage::helper('cfw_slides')
					   ->__('Visible'),
		);
	}

	public function getCarousels() {
		$collection = Mage::getModel('cfw_relations/relation')->getCollection();
		$carousels = array();
		foreach ($collection as $carousel) {
			$carousels[$carousel->entity_id] = $carousel->label;
		}
		return $carousels;
	}

	protected function _beforeSave()
	{
		parent::_beforeSave();

		/**
		 * Perform some actions just before a slide is saved.
		 */
		$this->_updateTimestamps();
		$this->_prepareUrlKey();

		return $this;
	}

	protected function _updateTimestamps()
	{
		$timestamp = now();

		/**
		 * Set the last updated timestamp.
		 */
		$this->setUpdatedAt($timestamp);

		/**
		 * If we have a slide new object, set the created timestamp.
		 */
		if ($this->isObjectNew()) {
			$this->setCreatedAt($timestamp);
		}

		return $this;
	}

	protected function _prepareUrlKey()
	{
		/**
		 * In this method, you might consider ensuring
		 * that the URL Key entered is unique and
		 * contains only alphanumeric characters.
		 */

		return $this;
	}


}