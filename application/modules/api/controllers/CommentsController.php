<?php
class Api_CommentsController extends Zend_Controller_Action
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
		
		$this->comments = new Application_Model_Comments;

	} 
	
		public function userCommentsAction(){
			
			
			//echo "controller";
			//echo $getview = $this->comments->commentlist();
			
			
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
			//echo "controller in";
			
			 $firstname = trim ( $this->getRequest ()->getParam ( 'firstname' ) );
	         $lastname = trim ( $this->getRequest ()->getParam ( 'lastname' ) );
			 $email = trim ( $this->getRequest ()->getParam ( 'email' ) );
			 $phone = trim ( $this->getRequest ()->getParam ( 'phone' ) );
			 $comments = trim ( $this->getRequest ()->getParam ( 'comments' ) );
			 
			/*  $firstname = "test";
			$lastname = "peter";
			$email = "salman14711@gmail.com";
			$phone = "784544";
			$comments = "good"; */
			 
			 $this->comments->_firstname=$firstname;
			$this->comments->_lastname=$lastname;
			$this->comments->_email=$email;
			$this->comments->_phone=$phone;
			$this->comments->_comments=$comments;
			
			 $getview = $this->comments->commentlist();
			 
			 foreach ($getview as $listview){
						 $dealerfirstname = $listview['First_name'];
						 $dealerlastname = $listview['Last_name'];
						 $dealeremail = $listview['Email'];
						 $dealerphone = $listview['Phone'];
						 $dealercomments = $listview['Comments'];
				}	


 if($listview){
				//$to = "venkatesh@findyourcarapp.com";
					$to = "Contact@findyourcarapp.onmicrosoft.com";
						//$to = "anbuayyanar371@gmail.com";
						//$to = "salmank1493@gmail.com";
						$subject = "Comments for New Dealer";
						$message = "<b>User Comments...</b>";
						$message .= "<h4>First_name:  $dealerfirstname<br>
										Last_name:  $dealerlastname<br>
										Email:  $dealeremail<br>
										Phone:  $dealerphone<br>
										Comment:  $dealercomments</h4>";
						 
						$header = "From:$dealeremail \r\n";
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

				 
				 //$to = "venkatesh@findyourcarapp.com";
				//$to = "Contact@findyourcarapp.onmicrosoft.com";
				/* $to = "salmank1493@gmail.com";
					//$to = "thowfeeqmohamed3@gmail.com";
						//$to = "anbuayyanar371@gmail.com";
						$subject = 'Comments for New Dealer';
						$message = '<b>User Comments...</b>';
						$message .= '<h4>
										First_name:  $dealerfirstname<br>
										Last_name:  $dealerlastname<br>
										Email:  $dealeremail<br>
										Phone:  $dealerphone<br>
										Website_url:  $dealercomments</h4>';
						 
						$header = 'From:$dealeremail \r\n';
						//$header .= "Cc:afgh@somedomain.com \r\n";
						$header .= 'MIME-Version: 1.0\r\n';
						$header .= 'Content-type: text/html\r\n';
				
						  $retval = mail ($to,$subject,$message,$header);
						 
						if( $retval == true ) {
							$result= "Message sent successfully...";
							$encode = json_encode($result);
							echo $encode;
						}else {
							$result= "Message could not be sent...";
							$encode = json_encode($result);
							echo $encode;
						} */
		/* 	}else{
				$encode = json_encode("not send mail");
				echo $encode;
			} 
		}    
}   */


}
?>