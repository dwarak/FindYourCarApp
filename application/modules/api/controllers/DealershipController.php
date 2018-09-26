<?php
class Api_DealershipController extends Zend_Controller_Action
{
	
	public function init()
    {
		
		$this->header = Zend_Controller_Front::getInstance ()->getResponse ();
		$this->header->setHeader ( "Content-Type", "application/json" );
		$this->header->setHeader ( "Method", $_SERVER ['REQUEST_METHOD'] );
		$this->header->setHeader ( "HOST", $_SERVER ['SERVER_NAME'] );
		$this->_filedate = date("Ymd", time());
		
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$this->Rest = new Classes_Rest;
		$this->Auth = new Classes_Auth;
		
		$this->dealership = new Application_Model_Dealership;
		$this->emailus = new Application_Model_Emaildealer;
		$this->contact = new Application_Model_Contactdealer;
	} 
		public function preDispatch() {
			 if (! $this->Auth->authAccepted($this->getRequest()))
			 {
			$encode = json_encode(array('error'=>"Your request is not authenticated."));
				$this->header->setHttpResponseCode ( 401 );
				$respcode = $this->header->getHttpResponseCode ();
				$this->header->setHeader ( "Status", $respcode );
				echo $this->header->setHeader ( "Content-Length", strlen($encode));
				echo $encode;
						
			exit;
			}
		} 

	 public function indexAction()
		{
			// action body
			if (!$this->getRequest()->isPost())
			{
				$encode = json_encode(array('error'=>"This function accepts only POST."));
				$this->header->setHttpResponseCode ( 405 );
				$respcode = $this->header->getHttpResponseCode ();
				$this->header->setHeader ( "Status", $respcode );
				echo $this->header->setHeader ( "Content-Length", strlen($encode));			
				echo $encode;
				exit;
			}
		}  
		 
		
		public function dealerSignupAction(){
			 if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			} 
			$dealershiplist = trim ( $this->getRequest ()->getParam ( 'dealershipname' ) );
			$firstname = trim ( $this->getRequest ()->getParam ( 'firstname' ) );
			$lastname = trim ( $this->getRequest ()->getParam ( 'lastname' ) );
			$email = trim ( $this->getRequest ()->getParam ( 'email' ) );
			$phone = trim ( $this->getRequest ()->getParam ( 'phone' ) );
			$websiteurl = trim ( $this->getRequest ()->getParam ( 'websiteurl' ) );
			$inventory = trim ( $this->getRequest ()->getParam ( 'inventory' ) );
			 
		/*$dealershiplist="testing";
			$firstname ="example";
			$lastname="test";
			$email="salman14711@gmail.com";
			$phone="8679847457";
			$websiteurl="www.google.com"; 
			$inventory ="New";*/
			
			$this->dealership->_dealername=$dealershiplist;
			$this->dealership->_firstname=$firstname;
			$this->dealership->_lastname=$lastname;
			$this->dealership->_email=$email;
			$this->dealership->_phone=$phone;
			$this->dealership->_weburl=$websiteurl;
			$this->dealership->_inventory=$inventory; 
			
			$getview = $this->dealership->dealerlist();
				
				 foreach ($getview as $listview){
						$namedealer = $listview['Dealership_name'];
						$dealerfirstname = $listview['First_name'];
						$dealerlastname = $listview['Last_name'];
						$dealeremail = $listview['Email'];
						$dealerphone = $listview['Phone'];
						$dealerwebsite = $listview['Website_url'];
						$dealerinventory = $listview['Inventory_provide']; 
				}		
			 if($listview){
				//$to = "venkatesh@findyourcarapp.com";
					$to = "Contact@findyourcarapp.onmicrosoft.com";
						//$to = "anbuayyanar371@gmail.com";
						//$to = "salmank1493@gmail.com";
						$subject = "Request for New Dealer";
						$message = "<b>New Dealer Information.</b>";
						$message .= "<h4>Dealership_name:  $namedealer<br>
										First_name:  $dealerfirstname<br>
										Last_name:  $dealerlastname<br>
										Email:  $dealeremail<br>
										Phone:  $dealerphone<br>
										Website_url:  $dealerwebsite<br>
										Inventory_provide:  $dealerinventory</h4>";
						 
						$header = "From:$dealeremail \r\n";
						$header .= "Cc:$dealeremail \r\n";
						$header .= "MIME-Version: 1.0\r\n";
						$header .= "Content-type: text/html\r\n";
						 
						$retval = mail ($to,$subject,$message,$header);
						 
						if( $retval == true ) {
							$result= "Message sent successfully...";
							$encode = json_encode($result);
							echo $encode;
						}else {
							$result= "Message could not be sent...";
							$encode = json_encode($result);
							echo $encode;
						}	
			}else{
				$encode = json_encode($listview);
				echo $encode;
			} 
			
	}
	
	
	
	public function emailUsAction(){
			if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			}
			
			$firstname = trim ( $this->getRequest ()->getParam ( 'firstname' ) );
			$lastname = trim ( $this->getRequest ()->getParam ( 'lastname' ) );
			$email = trim ( $this->getRequest ()->getParam ( 'email' ) );
			$phone = trim ( $this->getRequest ()->getParam ( 'phone' ) );
			$contactpreference = trim ( $this->getRequest ()->getParam ( 'preference' ) );
			
			/*$firstname ="test";
			$lastname="test";
			$email="test1@gmail.com";
			$phone="8679847457";
			$contactpreference="mail phone"; 
			*/
			$this->emailus->_firstname=$firstname;
			$this->emailus->_lastname=$lastname;
			$this->emailus->_email=$email;
			$this->emailus->_phone=$phone;
			$this->emailus->_preference=$contactpreference;
			
			$getview = $this->emailus->emailsend();
				
				 foreach ($getview as $listview){
						$dealerfirstname = $listview['First_name'];
						$dealerlastname = $listview['Last_name'];
						$dealeremail = $listview['Email'];
						$dealerphone = $listview['Phone'];
						$dealerwebsite = $listview['Contact_Preference'];
				}		
			 if($listview){
				//$to = "venkatesh@findyourcarapp.com";
				$to = "Contact@findyourcarapp.onmicrosoft.com";
					//$to = "thowfeeqmohamed3@gmail.com";
						//$to = "anbuayyanar371@gmail.com";
					    //$to = "salmank1493@gmail.com";
						$subject = "Request for New Dealer";
						$message = "<b>New Dealer Information.</b>";
						$message .= "<h4>
										First_name:  $dealerfirstname<br>
										Last_name:  $dealerlastname<br>
										Email:  $dealeremail<br>
										Phone:  $dealerphone<br>
										Contact_Preference:  $dealerwebsite<br>
										</h4>";
						 
						$header = "From:$dealeremail \r\n";
						$header .= "Cc:$dealeremail \r\n";
						$header .= "MIME-Version: 1.0\r\n";
						$header .= "Content-type: text/html\r\n";
						 
						$retval = mail ($to,$subject,$message,$header);
						 
						if( $retval == true ) {
							$result= "Message sent successfully...";
							echo json_encode($result);
							//echo $encode;
						}else {
							$result= "Message could not be sent...";
							echo json_encode($result);
							//echo $encode;
						}	
			}else{
				$encode = json_encode($listview);
				echo $encode;
			} 
			
	}
	
	public function carDetailcontactAction(){
		 if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			}  
			
		 	$fullname = trim ( $this->getRequest ()->getParam ( 'fullname' ) );
			$zipcode = trim ( $this->getRequest ()->getParam ( 'zipcode' ) );
			$email = trim ( $this->getRequest ()->getParam ( 'email' ) );
			$phone = trim ( $this->getRequest ()->getParam ( 'phone' ) );
			
			/* $fullname ="testing";
			$zipcode="600004"; 
			$email="test1@gmail.com";
			$phone="9865265646"; */
			
			
			$this->contact->_fullname=$fullname;
			$this->contact->_zipcode=$zipcode;
			$this->contact->_email=$email;
			$this->contact->_phone=$phone;
			
			$getview = $this->contact->contactlist();
			foreach ($getview as $listview){
						$dealerfirstname = $listview['fullname'];
						$dealerwebsite = $listview['zipcode'];
						$dealeremail = $listview['email'];
						$dealerphone = $listview['phone'];	
				}	
				if($listview){
				//$to = "venkatesh@findyourcarapp.com";
					
					//$to = "Contact@findyourcarapp.onmicrosoft.com";
					//$to = "salmank1493@gmail.com";
						/* $to = "thowfeeqmohamed3@gmail.com";
						$subject = "Request for New Dealer";
						$message = "<b>New Dealer Information.</b>";
						$message .= "<h4>
										Full name:  $dealerfirstname<br>
										Zipcode:  $dealerwebsite<br>
										Email: $dealeremail<br>
										Phone:  $dealerphone<br>
										</h4>";
						 
						$header = "From:$dealeremail \r\n";
						$header .= "Cc:$dealeremail \r\n";
						$header .= "MIME-Version: 1.0\r\n";
						$header .= "Content-type: text/html\r\n"; */
						
						$to = "thowfeeqmohamed3@gmail.com";
						//$to = "Contact@findyourcarapp.onmicrosoft.com";
						$subject = "Request for New Dealer";
						$body = "<div>New Dealer Information.
						<h4>
										Full name:  $dealerfirstname<br>
										Zipcode:  $dealerwebsite<br>
										Email: $dealeremail<br>
										Phone:  $dealerphone<br>
										</h4>
						 </div>";

							$headers = "From:$dealeremail \r\n";
							$headers .='Reply-To: '. $to . "\r\n" ;
							$headers .='X-Mailer: PHP/' . phpversion();
							$headers .= "MIME-Version: 1.0\r\n";
							$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";   
						if(mail($to, $subject, $body,$headers)) {
							$result= "Message sent successfully...";
							echo json_encode($result);
						  } 
						  else 
						  {
							$result= "Message could not be sent...";
							echo json_encode($result);
						  }
						
						
						 
						/* $retval = mail ($to,$subject,$message,$header);
						 
						if( $retval == true ) {
							$result= "Message sent successfully...";
							echo json_encode($result);
							//echo $encode;
						}else {
							$result= "Message could not be sent...";
							echo json_encode($result);
							//echo $encode;
						}	 */
			}else{
				$encode = json_encode($listview);
				echo $encode;
			}  
			
		}


}
?>