<?php 
class Cfw_Slides_Block_Adminhtml_Slide_Edit_Form
	extends Mage_Adminhtml_Block_Widget_Form
{
	

	protected function _prepareForm() 
	{
		// Instantiate a new form to display our brand for editing.
		$form = new Varien_Data_Form(array(
			'id' => 'edit_form',
			'action' => $this->getUrl(
				'cfw_slides_admin/slide/edit',
				array(
					'_current' => true,
					'continue' => 0,
				)
			),
			'method' => 'post',
		));
		$form->setUseContainer(true);
		$this->setForm($form);

		//Define a new fieldset. We need only one for our simple entity.
		$fieldset = $form->addFieldset(
			'general',
			array(
				'legend' => $this->__('Slide Details')
			)
		);	

		$slideSingleton = Mage::getSingleton(
			'cfw_slides/slide'
		);


		//Add the editable fields
		$this->_addFieldsToFieldset($fieldset, array(
			'slide_name' => array(
				'label' => $this->__('Slide Name'),
				'input' => 'text',
				'required' => true,
			),
			'carousel_id' => array(
                'label' => $this->__('Carousel'),
                'input' => 'select',
                'required' => true,
                'options' => $slideSingleton->getCarousels(),
            ),
			'foreground_image' => array(
				'label' => $this->__('Foreground Image'),
				'input' => 'image',
				'required' => false,
			),
			'background_image' => array(
				'label' => $this->__('Background Image'),
				'input' => 'editor',
				'required' => true,
				'config' => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
				'wysiwyg' => true,
			),
			'description' => array(
				'label' => $this->__('Text Overlay'),
				'input' => 'editor',
				'required' => false,
				'config' => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
				'wysiwyg' => true,
			),
			'button_text' => array(
				'label' => $this->__('Button Text'),
				'input' => 'text',
				'required' => false,
			),
			'url' => array(
				'label' => $this->__('URL Destination'),
				'input' => 'text',
				'required' => false,
			), 
			'sort_order' => array(
				'label' => $this->__('Sort Order'),
				'input' => 'text',
				'required' => false,
			), 
			'visibility' => array(
                'label' => $this->__('Visibility'),
                'input' => 'select',
                'required' => true,
                'options' => $slideSingleton->getAvailableVisibilies(),
            ),
		));	
		return $this;
	}


	/**
	 * This method makes life a little easier for us by pre-populating
	 * fields with $_POST data where applicable and wrapping our post data
	 * in 'slideData' so that we can easily separate all relevant information
	 * in the controller. You could of course omit this method entirely
	 * and call the $fieldset->addField() method directly.
	 */

	protected function _addFieldsToFieldset(
		Varien_Data_Form_ElementFieldset $fieldset, $fields)
	{
		$requestData = new Varien_Object($this->getRequest()->getPost('slideData'));
		foreach ($fields as $name => $_data) {
			if ($requestValue = $requestData->getData($name)) {
				$_data['value'] = $requestValue;
			}

			//Wrap all fields with slideData group
			$_data['name'] = "slideData[$name]";

			//Generally, label and title are always the same
			$_data['title'] = $_data['label'];

			//If no new value exists, use the existing slide data.
			if (!array_key_exists('value', $_data)) {
				$_data['value'] = $this->_getSlide()->getData($name);
			}

			//Finally, call vanilla functionality to add field.
			$fieldset->addField($name, $_data['input'], $_data);
		}
		return $this;
	}

	/**
	 * Retrieve the existing slide for pre-populating the form fields.
	 * For a new slide entry, this will return an empty slide object.
	 */
	protected function _getSlide() 
	{
		if (!$this->hasData('slide')) {
			//This will have been set in the controller
			$slide = Mage::registry('current_slide');

			//Just in case the controller does not register the slide
			if (!$slide instanceof Cfw_Slides_Model_Slide) {
				$slide = Mage::getModel('cfw_slides/slide');
			}

			$this->setData('slide', $slide);
		}

		return $this->getData('slide');
	}
}