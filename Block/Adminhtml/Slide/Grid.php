<?php 
class Cfw_Slides_Block_Adminhtml_Slide_Grid
	extends Mage_Adminhtml_Block_Widget_grid
{
	protected function _prepareCollection() 
	{
		/**
         * Tell Magento which collection to use to display in the grid.
         */
		$collection = Mage::getResourceModel(
			'cfw_slides/slide_collection'
		);
		$this->setCollection($collection);

		return parent::_prepareCollection();
	}

	public function getRowUrl($row) 
	{
		 /**
         * When a grid row is clicked, this is where the user should
         * be redirected to - in our example, the method editAction of
         * BrandController.php in BrandDirectory module.
         */
	    return $this->getUrl(
	    	'cfw_slides_admin/slide/edit',
	    	array(
	    		'id' => $row->getId()
	    	)
	    );
	}

	public function _prepareColumns() {
		/**
         * Here, we'll define which columns to display in the grid.
         */

		$this->addColumn('entity_id', array(
			'header' => $this->_getHelper()->__('ID'),
			'type' => 'number',
			'index' => 'entity_id',
		));

        $this->addColumn('name', array(
            'header' => $this->_getHelper()->__('Name'),
            'type' => 'text',
            'index' => 'slide_name',
        ));

        $this->addColumn('url', array(
            'header' => $this->_getHelper()->__('URL'),
            'type' => 'text',
            'index' => 'url',
        ));
		
        $this->addColumn('created_at', array(
            'header' => $this->_getHelper()->__('Created'),
            'type' => 'datetime',
            'index' => 'created_at',
        ));

        $this->addColumn('updated_at', array(
            'header' => $this->_getHelper()->__('Updated'),
            'width' => '50px',
            'type' => 'datetime',
            'index' => 'updated_at',
        ));

        $this->addColumn('sort_order', array(
            'header' => $this->_getHelper()->__('Updated'),
            'type' => 'number',
            'index' => 'sort_order',
        ));

        /**
         * Finally we add an action column with an edit link.
         */
        $this->addColumn('action', array(
            'header' => $this->_getHelper()->__('Action'),
            'width' => '50px',
            'type' => 'action',
            'actions' => array(
                array(
                    'caption' => $this->_getHelper()->__('Edit'),
                    'url' => array(
                        'base' => 'cfw_slides_admin'
                                  . '/slide/edit',
                    ),
                    'field' => 'id'
                ),
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'entity_id',
        ));

        return parent::_prepareColumns();
        
	}

	public function _getHelper() 
	{
		return Mage::helper('cfw_slides');
	}
}