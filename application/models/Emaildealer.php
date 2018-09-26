<?php
class Application_Model_Emaildealer extends Zend_Db_Table_Abstract {
	protected $_name = 'email_us';
	protected $_firstname;
	protected $_lastname;
	protected $_email;
	protected $_phone;
	protected $_preference;
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	
	public function emailsend(){
		
				   $insert=array(
		
						'First_name'=>$this->_firstname,
						'Last_name'=>$this->_lastname,
						'Email'=>$this->_email,
						'Phone'=>$this->_phone,
						'Contact_Preference'=>$this->_preference);
						
						
						$lastinsertid = $this->insert($insert);
						$data = $this->select()
								->from(array('a' => $this->_name))
								->where("a.S_id = $lastinsertid")
								->setIntegrityCheck(false); 
						$data = $this->fetchAll($data);		
						
						if ($data) {
							return $data->toArray();
						} else {
							return false;
						}	
			
		}
}
?>