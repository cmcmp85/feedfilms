<?php

class Application_Form_User extends Zend_Form
{

    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');
        $this->setName('user');

        $id = new Zend_Form_Element_Hidden('iduser');
        $id->addFilter('Int');
        
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email')
		        ->setRequired(true)
		        ->addValidator('NotEmpty', true)
		        ->addFilter('StripTags')
		        ->addFilter('StringTrim')
		        ->addValidator('StringLength',false,array(3,200))
		        ->addValidator('emailAddress', true)
		        ->setAttrib('size', 30)
		        ->setAttrib('maxlength', 80)
		        ->setAttrib('placeholder', 'Email...')
		        ->setDescription('User Description')
		        ->setOptions(array('class'=>'form-control'))
		        ->setDecorators(array(array('ViewScript', array(
		        		'viewScript' => 'forms/_element_text.phtml'
		        ))));
		        ;
        
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password')
        ->setRequired(true)
        ->addValidator('NotEmpty', true)
        ->addFilter('StripTags')
        ->addFilter('StringTrim')
        ->addValidator('StringLength',false,array(3,20))
        ->setAttrib('size', 30)
        ->setAttrib('maxlength', 80)
        ->setOptions(array('class'=>'form-control'))
        ->setDecorators(array(array('ViewScript', array(
		        		'viewScript' => 'forms/_element_text.phtml'
		        ))));
        
        $display_name = new Zend_Form_Element_Text('display_name');
        $display_name->setLabel('Display Name')
        ->setRequired(true)
        ->addValidator('NotEmpty', true)
        ->addFilter('StripTags')
        ->addFilter('StringTrim')
        ->addValidator('StringLength',false,array(3,200))
        ->setAttrib('size', 30)
        ->setAttrib('maxlength', 255)
        ->setOptions(array('class'=>'form-control'))
        ->setDecorators(array(array('ViewScript', array(
		        		'viewScript' => 'forms/_element_text.phtml'
		        ))));
        
        $description = new Zend_Form_Element_Textarea('description');
        $description->setLabel('Description')
        ->setRequired(true)
        ->addValidator('NotEmpty', true)
        ->addFilter('StripTags')
        ->addFilter('StringTrim')
        ->addValidator('StringLength',false,array(3,200))
        ->setAttrib('size', 30)
        ->setAttrib('maxlength', 255)
        ->setOptions(array('class'=>'form-control'))
        ->setDecorators(array(array('ViewScript', array(
        		'viewScript' => 'forms/_element_text.phtml'
        ))));
        
        $nid = new Zend_Form_Element_Text('nid');
        $nid->setLabel('National ID')
        ->setRequired(true)
        ->addValidator('NotEmpty', true)
        ->addFilter('StripTags')
        ->addFilter('StringTrim')
        ->addValidator('StringLength',false,array(3,200))
        ->addValidator('regex', false, array('/^[0-9]{8}[A-Z]$/i'))
        ->addValidator('Db_NorecordExists',true,array('table'=>'users','field'=>'nid'))
        ->setAttrib('size', 30)
        ->setAttrib('maxlength', 255)
        ->setOptions(array('class'=>'form-control'))
        ->setDecorators(array(array('ViewScript', array(
        		'viewScript' => 'forms/_element_text.phtml'
        ))));
        
        $url = new Zend_Form_Element_Text('url');
        $url->setLabel('URL')
	        ->setRequired(true)
	        ->addValidator('NotEmpty', true)
	        ->addFilter('StripTags')
	        ->addFilter('StringTrim')
	        ->addValidator('hostname', true)
	        ->addValidator('StringLength',false,array(3,200))
	        ->setAttrib('size', 30)
	        ->setAttrib('maxlength', 255)
	        ->setOptions(array('class'=>'form-control'))
	        ->setDecorators(array(array('ViewScript', array(
	        		'viewScript' => 'forms/_element_text.phtml'
	        ))));
        
        $state = new Zend_Form_Element_Select('state');
        $state->setLabel('State')
        ->setRequired(true)
        ->addValidator('NotEmpty', true)
        ->setmultiOptions(array('1'=>'Activo', '0'=>'Inactivo'))
        ->setAttrib('maxlength', 200)
        ->setAttrib('size', 1)
        ->setOptions(array('class'=>'form-control'))
        ->setDecorators(array(array('ViewScript', array(
	        		'viewScript' => 'forms/_element_checkbox.phtml'
	        ))));
        
        $idusertype = new Zend_Form_Element_Select('idusertype');
        $idusertype->setLabel('User Type')
        ->setRequired(true)
        ->addValidator('NotEmpty', true)
        ->setmultiOptions($this->_selectOptions())
        ->setAttrib('maxlength', 200)
        ->setAttrib('size', 1)
        ->setOptions(array('class'=>'form-control'))
	->setDecorators(array(array('ViewScript', array(
	        		'viewScript' => 'forms/_element_text.phtml'
	        ))));

        $technology = new Zend_Form_Element_MultiCheckbox('technology');
        $technology->setLabel('Tecnologies:')
        ->setRequired(true)
        ->setValue('php')
        ->addValidator('NotEmpty', true, array('messages'=>array(Zend_Validate_NotEmpty::IS_EMPTY=>'Valor requerido')))
        ->setmultiOptions(array('php'=>'Php', 'java'=>'Java', 'mysql'=>'MySQL'))
        ->setOptions(array('class'=>'form-control'))
        ->setDecorators(array(array('ViewScript', array(
	        		'viewScript' => 'forms/_element_category_multi_checkbox.phtml'
	        ))));
        
        $gender = new Zend_Form_Element_Radio('gender');
        $gender->setLabel('Género')
        ->setValue('1')
        ->setMultiOptions(array('1'=>'Femenino', '0'=>'Masculino'))
        ->setRequired(true)
        ->addValidator('NotEmpty', true)
        ->setOptions(array('class'=>'form-control'))
	->setDecorators(array(array('ViewScript', array(
                            'viewScript' => 'forms/_element_radio.phtml'
	        ))));
        
        $languages = new Zend_Form_Element_Multiselect('languages');
        $languages->setLabel('Languages')
        ->setValue('1')
        ->setMultiOptions(array('0'=>'Español', '1'=>'English','2'=>'Français','3'=>'Deutsch'))
        ->setRequired(true)
        ->addValidator('NotEmpty', true)
        ->setOptions(array('class'=>'form-control'));
        
        $city = new Zend_Form_Element_Select('cities');
        $city->setLabel('City')
        ->setRequired(true)
        ->addValidator('NotEmpty', true)
        ->setmultiOptions(array('0'=>'Madrid', '1'=>'Barcelona','3'=>'Zaragoza'))
        ->setAttrib('maxlength', 200)
        ->setAttrib('size', 1)
        ;
        
		$destination=realpath($_SERVER['DOCUMENT_ROOT']);
        $image = new Zend_Form_Element_File('image');
        $image->setLabel('Image (512kb size, jpg,png,gif)')
        ->addValidator('NotEmpty', true)
        ->setDestination($destination)
        ->addFilter('StripTags')
        ->addFilter('StringTrim')
        ->addValidator('NotExists', false, array($destination))
        ->addValidator('Count', false, array(1))
        ->addValidator('Extension', true, array('jpg,png,gif'))
        ->addValidator('Size', false, array(512000));        
        
    
        
        $submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton');
		
		$this->addElements(array($id, 
                                        $email, $password, $display_name, $state,
                                        $description,$nid,$url,
                                        $idusertype, $technology, $gender,
                                        $languages, $city,
                                        $submit));
    }
    
    protected function _selectOptions()
    {
    	//$result = array(1=>'Cineasta', 2=>'Productora', 3=>'Jurado');
    	//return $result;
    	$result = array();
    	$usertype = new Application_Model_UserTypeMapper();
    	$result=$usertype->fetchAll();
    	
    	
    	return $result;
    }
}
