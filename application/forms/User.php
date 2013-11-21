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
        ->setAttrib('maxlength', 80);
        
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password')
        ->setRequired(true)
        ->addValidator('NotEmpty', true)
        ->addFilter('StripTags')
        ->addFilter('StringTrim')
        ->addValidator('StringLength',false,array(3,20))
        ->setAttrib('size', 30)
        ->setAttrib('maxlength', 80);
        
        $display_name = new Zend_Form_Element_Text('display_name');
        $display_name->setLabel('Display Name')
        ->setRequired(true)
        ->addValidator('NotEmpty', true)
        ->addFilter('StripTags')
        ->addFilter('StringTrim')
        ->addValidator('StringLength',false,array(3,200))
        ->setAttrib('size', 30)
        ->setAttrib('maxlength', 255);
        
        $state = new Zend_Form_Element_Select('state');
        $state->setLabel('State')
        ->setRequired(true)
        ->addValidator('NotEmpty', true)
        ->setmultiOptions(array('1'=>'Activo', '0'=>'Inactivo'))
        ->setAttrib('maxlength', 200)
        ->setAttrib('size', 1);
        
        $idusertype = new Zend_Form_Element_Select('idusertype');
        $idusertype->setLabel('User Type')
        ->setRequired(true)
        ->addValidator('NotEmpty', true)
        ->setmultiOptions($this->_selectOptions())
        ->setAttrib('maxlength', 200)
        ->setAttrib('size', 1);

        $submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton');
		
		$this->addElements(array($id, 
								$email, $password, $display_name, $state,
								$idusertype, $submit));
    }
    
    protected function _selectOptions()
    {
    	$result = array(1=>'Cineasta', 2=>'Productora', 3=>'Jurado');
    	return $result;
    }
}