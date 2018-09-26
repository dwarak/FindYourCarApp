<?php
class Application_Model_Contactdealer extends Zend_Db_Table_Abstract {
	protected $_name = 'contact_dealer';
	
	protected $_fullname;
	protected $_zipcode;
	protected $_email;
	protected $_phone;
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	
	public function contactlist(){
		
				   $insert=array(
		
						'fullname'=>$this->_fullname,
						'zipcode'=>$this->_zipcode,
						'email'=>$this->_email,
						'phone'=>$this->_phone);
						
						
						$lastinsertid = $this->insert($insert);
						$data = $this->select()
								->from(array('a' => $this->_name))
								->where("a.s_id = $lastinsertid")
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