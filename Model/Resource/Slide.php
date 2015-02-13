<?php 
class Cfw_Slides_Model_Resource_Slide
	extends Mage_Core_Model_Resource_Db_Abstract
{
	protected function _construct()
	{
		/**
         * Tell Magento the database name and primary key field to persist
         * data to. Similar to the _construct() of our model, Magento finds
         * this data from config.xml by finding the <resourceModel/> node
         * and locating children of <entities/>.
         *
         * In this example:
         * - cfw_slides is the model alias
         * - slide is the entity referenced in config.xml
         * - entity_id is the name of the primary key column
         *
         * As a result, Magento will write data to the table
         * 'cfw_slides_slide' and any calls
         * to $model->getId() will retrieve the data from the
         * column named 'entity_id'.
         */
        $this->_init('cfw_slides/slide', 'entity_id');
	}
}