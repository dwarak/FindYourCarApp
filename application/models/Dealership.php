<?php
class Application_Model_Dealership extends Zend_Db_Table_Abstract {
	protected $_name = 'dealership';
	
	protected $_dealername;
	protected $_firstname;
	protected $_lastname;
	protected $_email;
	protected $_phone;
	protected $_weburl;
	protected $_inventory;
	
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	
	
		public function dealerlist(){
		
				   $insert=array(
		
						'Dealership_name'=>$this->_dealername,
						'First_name'=>$this->_firstname,
						'Last_name'=>$this->_lastname,
						'Email'=>$this->_email,
						'Phone'=>$this->_phone,
						'Website_url'=>$this->_weburl,
						'Inventory_provide'=>$this->_inventory);
						
						
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