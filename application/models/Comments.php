<?php
class Application_Model_Comments extends Zend_Db_Table_Abstract {
	protected $_name = 'contact_us';

	protected $_firstname;
	protected $_lastname;
	protected $_email;
	protected $_phone;  
	protected $_comments;

	
	
	public function __set($name, $value) {
		$this->$name = $value;
	}
	/*  public function commentlist(){
		 $data="model";
		 return $data;
	 } */
		 public function commentlist(){ 
		
				   $insert=array( 
						'First_name'=>$this->_firstname,
						'Last_name'=>$this->_lastname,
						'Email'=>$this->_email,
						'Phone'=>$this->_phone,
						'Comments'=>$this->_comments);
						
						
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
		
		
		/* 
				 public function commentlist($firstname,$lastname,$email,$phone,$comments){ 
	
				   $insert=array( 
						'First_name'=$firstname,
						'Last_name'=$lastname,
						'Email'=$email,
						'Phone'=$phone,
						'Comments'=$comments);
						$lastinsertid = $this->insert($insert);
						 $data = $this->select()
								->from(array('a' => $this->_name))
								->where("a.S_id = $lastinsertid")
								->setIntegrityCheck(false);
								
						$data = $this->fetchAll($data); 
						if ($lastinsertid) {
							return lastinsertid;
						} else {
							return false;
						}	
			
				} */
				
		
		
			
}
?>