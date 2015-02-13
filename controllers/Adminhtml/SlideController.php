<?php 
class Cfw_Slides_Adminhtml_SlideController
	extends Mage_Adminhtml_Controller_Action
{
	/**
	 * Instantiate our grid container block and add to the page content.
	 * When accessing this admin index page, we will see a grid of all
	 * slides currently available in our Magento instance, along with
	 * a button to add a new one if we wish.
	 */

	public function indexAction() 
	{
		//instantiate the grid container
		$slideBlock = $this->getLayout()->createBlock('cfw_slides_adminhtml/slide');

		// Add the grid container as the only item on this page
		$this->loadLayout()
			->_addContent($slideBlock)
			->renderLayout();
	}


	 /**
	 * This action handles both viewing and editing existing slides.
	 */

	public function editAction() 
	{
		/**
		 * Retrieve existing slide data if an ID was specified.
		 * If not, we will have an empty slide entity ready to be populated.
		 */

		$slide = Mage::getModel('cfw_slides/slide');
		if ($slideId = $this->getRequest()->getParam('id', false)) {
			$slide->load($slideId);
			if ($slide->getId() < 1){

				$this->_getSession()->addError($this->__('This slide no longer exists.'));
				return $this->_redirect('cfw_slides_admin/slide/index');

			} 
		}
		// process $_POST data if the form was submitted
		if ($postData = $this->getRequest()->getPost('slideData')) {
			try {
                //here
				$slide->addData($postData);
				$slide->save();

				$this->_getSession()->addSuccess($this->__('The slide has been saved.'));

				//redirect to remove $_POST data from the request
				return $this->_redirect('cfw_slides_admin/slide/edit',
					array('id' => $slide->getId())
				);
			} catch (Exception $e) {
				Mage::logException($e);
				$this->_getSession()->addError($e->getMessage());
			}
			/**
			 * If we get to here, then something went wrong. Continue to
			 * render the page as before, the difference this time being
			 * that the submitted $_POST data is available.
			 */
		}
		//Make the current slide available to blocks
		Mage::register('current_slide', $slide);

		//Instantiate the form container.
		$slideEditBlock = $this->getLayout()->createBlock('cfw_slides_adminhtml/slide_edit');

		//Add the form container as the only item on this page
		$this->loadLayout()
			->_addContent($slideEditBlock)
			->renderLayout();

	}


	public function deleteAction() 
	{
		$slide = Mage::getModel('cfw_slides/slide');

		if ($slideId = $this->getRequest()->getParam('id', false)) {
			$slide->load($slideId);
		}

		if ($slide->getId() < 1){
			_getSession()->addError($this->__('This slide no longer exists.'));
			return $this->_redirect('cfw_slides_admin/slide/index');
		} 

		try {
			$slide->delete();

			$this->_getSession()->addSuccess(
				$this->__('The slide has been deleted')
			);
		} catch ( Exception $e) {
			Mage::logException($e);
			$this->_getSession()->addError($e->getMessage());
		}

		return $this->_redirect('cfw_slides_admin/slide/index');
		
	}

	/**
	 * Thanks to Ben for pointing out this method was missing. Without
	 * this method the ACL rules configured in adminhtml.xml are ignored.
	 */
	protected function _isAllowed() 
	{
		/**
		 * we include this switch to demonstrate that you can add action
		 * level restrictions in your ACL rules. The isAllowed() method will
		 * use the ACL rule we have configured in our adminhtml.xml file:
		 * - acl
		 * - - resources
		 * - - - admin
		 * - - - - children
		 * - - - - - cfw_slides
		 * - - - - - - children
		 * - - - - - - - slide
		 *
		 * eg. you could add more rules inside slide for edit and delete.
		 */

		$actionName = $this->getRequest()->getActionName();
		switch ($actionName) {
			case 'index':
			case 'edit':
			case 'delete':
				//there is intentionally no break
			default:
				$adminSession = Mage::getSingleton('admin/session');
				$isAllowed = $adminSession->isAllowed('cfw_slides/slide');
				break;
		}
		return $isAllowed;
	}

}