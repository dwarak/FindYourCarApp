<?php
class Application_Model_Developers extends Zend_Db_Table_Abstract {

	protected $_name = 'developers';
	protected $_developerID;
	protected $_developername;
	protected $_password;
	protected $_email;
	protected $_active;
	protected $_resetToken;
	protected $_resetComplete;

	public function __set($name, $value) {
		$this->$name = $value;
	}
	
    public static function encrypt($plain, $key) {	
		$iv = mcrypt_create_iv(
			mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
			MCRYPT_DEV_URANDOM
		);
		
		$ciphertext = base64_encode(
			$iv .
			mcrypt_encrypt(
				MCRYPT_RIJNDAEL_128,
				hash('sha256', $key, true),
				$plain,
				MCRYPT_MODE_CBC,
				$iv
			)
		);
		
        return $ciphertext;
    }
 
    public static function decrypt($ciphertext, $key) {
		$data = base64_decode($ciphertext);
		$iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));
		
		$plain = rtrim(
			mcrypt_decrypt(
				MCRYPT_RIJNDAEL_128,
				hash('sha256', $key, true),
				substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),
				MCRYPT_MODE_CBC,
				$iv
			),
			"\0"
		);
        return $plain;
    }

	public function addDevelopersInfo()
	{
		$insert=array('developerID'=>null,
				'developername'=>$this->_developername,
				'password'=>$this->_password,
				'email'=>$this->_email,
				'active'=>$this->_active,
				'resetToken'=>$this->_resetToken,
				'resetComplete'=>$this->_resetComplete);
		
		return $this->insert($insert);
		
	}
	
	public function getDevelopersEmail() {
		$email = $this->select()
                ->from(array('a' => $this->_name),array("a.email"))
				->where("a.email = '$this->_email'")
                ->setIntegrityCheck(false);
				
		$emaildata = $this->fetchAll($email);
        if ($emaildata) {
            return $emaildata->toArray();
        } else {
            return false;
        }		
	}
	
	public function login() {
	
		$email = $this->select()
                ->from(array('a' => $this->_name),array("a.developername","a.password","a.developerID"))
				->where("a.email = '$this->_email'")
                ->setIntegrityCheck(false);
				
		$emaildata = $this->fetchAll($email);
        $result = $emaildata->toArray();
		if ($result) {
			if($this->decrypt($result['0']['password'], SHA_ENCRYPTION_KEY)==$this->_password){
				$_SESSION['loggedin'] = true;
				$_SESSION['developername'] = $result['0']['developername'];
				$_SESSION['developerID'] = $result['0']['developerID'];
				return true;
			}
        } else {
            return false;
        }
	}
	
	public function updateToken() {
        $data=array('active'=>$this->_active,'resetComplete'=>'No');

        $where = $this->getAdapter()->quoteInto('email = ?', $this->_email);

        return $this->update($data, $where);
    }	

}