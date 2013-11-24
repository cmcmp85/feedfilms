<?php

class Application_Model_DbTable_User extends Zend_Db_Table_Abstract
{
       protected $_name = 'users';
    
    public function fetchAll()
    {
    	
    	$select =  $this->select()
             ->from(array('u' => 'users'))
             ->join(array('t'=> 'user_types'),'u.idusertype = t.idusertype',array('type'=>'usertype'));
    	$select->setintegrityCheck(false);
    	$row = $select->query()->fetchAll();
    	
    	//Zend_Debug::dump($row,true);
    	
    	return $row;
    	
    }
    public function find($id)
    {
    	
    	$select =  $this->select()
             ->from(array('u' => 'users'))
             ->where('iduser = ?', $id);
    	$select->setintegrityCheck(false);
    	$row = $select->query()->fetchAll();
    	
    	//Zend_Debug::dump($row,true);
    	
    	return $row;
    	
    }
}