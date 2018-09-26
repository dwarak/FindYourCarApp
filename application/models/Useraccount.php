<?php
class Application_Model_Useraccount extends Zend_Db_Table_Abstract {

public function __set($name, $value) {
		$this->$name = $value;
}

public function getimagedetails($id) {
	
	$db =Zend_Db_Table_Abstract::getDefaultAdapter();
	
	$sql = "SELECT * FROM dealer_details where Dealer_Id='$id'";
	
	 $stmt = $db->query($sql); 
         $result =  $stmt->fetchAll();
	
	return $result;
}
public function storeimages($data) {
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		//$self = new self ();
		//$sql = "SELECT * FROM dealer_details where Dealer_Id='$data'";
		$result = $db->insertValues ( "dealer_details", $data );
		$stmt = $db->query($sql); 
        $result =  $stmt->fetchAll();
		return $result;
	}
	
public function getlogodetails($id) {
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		//$self = new self ();
		$sql = "SELECT Logo_Image FROM dealer_details where Dealer_Id='$id'";
		//$data = $self->getData ( $sql );
		$stmt = $db->query($sql); 
        $result =  $stmt->fetchAll();
		return $result[0];
		//return $data [0];
	}
public function getimageupdate($Dealer_Id, $data) {
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		//$self = new self ();
		$where = array (
				"Dealer_Id=?" => $Dealer_Id 
		);
		try {
			$result = $db->updateData ( "dealer_details", $data, $where );
			return true;
		} catch ( Exception $e ) {
			echo $e->getMessage ();
			return false;
		}
	}
public function getvideodetails($id) {
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		//$self = new self ();
		$sql = "SELECT Dealer_Id,Logo_Image,DealerPromo,Type FROM dealer_details where Dealer_Id='$id'";
		//$data = $self->getData ( $sql );
		$stmt = $db->query($sql); 
        $data =  $stmt->fetchAll();
		return $data [0];
	}
public function getadvdetails($id, $adpdealerid,$count) {
	$db =Zend_Db_Table_Abstract::getDefaultAdapter();
	
	$sql = "SELECT Adv_ID,Make,Model,Year,Mileage,Price,Banner_Image FROM advertisement
		WHERE User_ID='$id'ORDER BY 'Upload_Date'DESC limit $count,18";
		
	$stmt = $db->query($sql); 
         $data =  $stmt->fetchAll();
	
	
	
	$cdksql = "SELECT Dealer_ID,VIN,Make,Model,Model_Year,MSRP as Price,List_Price as Cost,Image_URL_Pattern,Odometer as Mileage FROM scrapedata
		WHERE  Dealer_ID IN (select Dealer_ID from user_account where UserID='$id')ORDER BY `Last_Modified_Date`DESC limit $count,18";
		
	$stmt1 = $db->query($cdksql); 
         $cdkdata =  $stmt1->fetchAll();
	
	$data1=array_merge($data,$cdkdata);
		return $data1;
	
	
	
	//return $adpdealerid;
	
	
}

public function getcomments($id){
	$db =Zend_Db_Table_Abstract::getDefaultAdapter();
	
	$sql = "select UserName,comment,UserId from comments where ShowroomId='$id' order by date";
	
	$stmt = $db->query($sql); 
         $data =  $stmt->fetchAll();
	return $data;
}


public function getcommentsaccounttype($id){
	
	//$self = new self ();
	$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$sql = "select AccountType,FirstName,Dealer_Name from user_account where UserID='$id'";
		
		$stmt = $db->query($sql); 
         $data =  $stmt->fetchAll();
	return $data;
		
		/* $data = $self->getData ( $sql );
		return $data; */
	
	
	
	
}

public function forunlinkadv($Dealer_Id){
	//return $Dealer_Id;
	$db =Zend_Db_Table_Abstract::getDefaultAdapter();
	$sql = "SELECT * FROM advertisement where Adv_ID='$Dealer_Id'";
	$stmt = $db->query($sql); 
         $data =  $stmt->fetchAll();
	return $data;
	
}



public function forunlinkshowroom($ShowroomId){
	$db =Zend_Db_Table_Abstract::getDefaultAdapter();
	$sql = "SELECT * FROM images where ShowroomId='$ShowroomId'";
	$stmt = $db->query($sql); 
         $data =  $stmt->fetchAll();
	return $data;
	
}

Public function deleteAdv($AdvId) {
	 $db =Zend_Db_Table_Abstract::getDefaultAdapter();
	//return "deleteAdv";
	$sql1 = "DELETE FROM advertisement
        WHERE Adv_ID = '$AdvId'";
	$result = $db->query($sql1); 
         
		 
		$sql2 = "DELETE FROM images
        WHERE ShowroomId = '$AdvId'";
	$result = $db->query($sql2); 
         
	$sql3 = "DELETE FROM creditcarddetails
        WHERE adver_id = '$AdvId'";
	$result = $db->query($sql3); 	 
	
	return $result; 
	
	
}
Public function getdetailsByEmail($Email,$encrypted){
	
	//return $Email;
	//return $encrypted;

		 $db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$sql = "select * from user_account where Email='$Email' && Password='$encrypted'";
		
	$stmt = $db->query($sql); 
         $data =  $stmt->fetchAll();
	return $data; 
	
	
}

Public function updatetoken($UserID,$Device_Token){
	//return "Device_Token";
	$db =Zend_Db_Table_Abstract::getDefaultAdapter();
	
$where = array('UserID = ?' => $UserID);
$data = array('Device_Token'=>$Device_Token);
  $result = $db->update('user_account', $data, $where);
	return $result;
	
	
}

Public function selectresult($UserID, $Device_Token) {
	//return "selectresult";
	$db =Zend_Db_Table_Abstract::getDefaultAdapter();
	
	try {
			$sql = "select UserID,Device_Token from user_account where UserID='$UserID'";
			//$data = $self->getData ( $sql );
			//return $data;
			$stmt = $db->query($sql); 
         $data =  $stmt->fetchAll();
	return $data; 
			
			
		} catch ( Exception $e ) {
			echo $e->getMessage ();
			return false;
		}
	
	
	
}

public function insertuseraccount($data) {
	 
$db =Zend_Db_Table_Abstract::getDefaultAdapter();

try {
$result = $db->insert('user_account', $data);
   $lastinsertvalue = $db->lastInsertId('user_account');
   $sql = "select * from user_account where UserID='$lastinsertvalue'";
	$stmt = $db->query($sql); 
         $finalresult =  $stmt->fetchAll();
	return $finalresult; 
}catch ( Exception $e ) {
			echo $e->getMessage ();
			return false;
		}


}



public function getadpdetails($FB_ID) {
	
	$db =Zend_Db_Table_Abstract::getDefaultAdapter();
	$sql = "select * from user_account where Dealer_ID='$FB_ID'";
		
	$stmt = $db->query($sql); 
         $data =  $stmt->fetchAll();
	return $data; 
	//return "fhdeyer";
	
}

public function forunlink($Dealer_Id) {
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		//$self = new self ();
		$sql = "SELECT * FROM dealer_details where Dealer_Id='$Dealer_Id'";
		//$data = $self->getData ( $sql );
		$stmt = $db->query($sql); 
        $data =  $stmt->fetchAll();
		return $data;
	}


	public function isEmailExists($mailID, $id) {
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		//$self = new self ();
		$sql = "select count(*) as total from user_account where Email='$mailID' and not UserID='$id'";
		$stmt = $db->query($sql); 
        $data =  $stmt->fetchAll();
		return $data;
	}

	public function getusersdetails($emailid) {
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		//$self = new self ();
		$sql = "select * from user_account where Email='$emailid'";
		$stmt = $db->query($sql); 
        $data =  $stmt->fetchAll();
		return $data;
	}

public function Decrypte($string, $key) {
	
		$result = '';
		$string = base64_decode ( $string );
		
		for($i = 0; $i < strlen ( $string ); $i ++) {
			$char = substr ( $string, $i, 1 );
			$keychar = substr ( $key, ($i % strlen ( $key )) - 1, 1 );
			$char = chr ( ord ( $char ) - ord ( $keychar ) );
			$result .= $char;
		}
		
		return $result;
	}
	
public function setuseraccountdata($data) {
	
	 $db =Zend_Db_Table_Abstract::getDefaultAdapter();
	 try {
	$result = $db->insert('user_account', $data);
   $lastinsertvalue = $db->lastInsertId('user_account');

	 $sql = "select * from user_account where UserID='$lastinsertvalue'";
	$stmt = $db->query($sql); 
         $data =  $stmt->fetchAll();
	return $data; 
	 }catch ( Exception $e ) {
			echo $e->getMessage ();
			return false;
		}
	
}






public function storecomments($ShowroomId, $UserId, $UserName, $Comment) {
	
	//return $ShowroomId;
  $db =Zend_Db_Table_Abstract::getDefaultAdapter();
	$data = array (
				"ShowroomId" => $ShowroomId,
				"UserId" => $UserId,
				"UserName" => $UserName,
				"comment" => $Comment,
				"date" => null 
		); 
	
	$result = $db->insert('comments', $data);
	
return $result;
	

	
}



public function getdetails($User_ID) {
	$db =Zend_Db_Table_Abstract::getDefaultAdapter();
	
		$sql = "select * from user_account where UserID='$id'";
		$stmt = $db->query($sql); 
		$data =  $stmt->fetchAll();
		return $data;
	
}

public function updateuseraccount($id, $data) {
	//return "updateuseraccount";
$db =Zend_Db_Table_Abstract::getDefaultAdapter();
	$where = array (
				"UserId=?" => $id 
		);
	
	try {
			/* $result = $self->updateData ( 'user_account', $data, $where ); */
			$result = $db->update('user_account', $data, $where);
			return true;
		} catch ( Exception $e ) {
			echo $e->getMessage ();
			return false;
		}
	
	
	
	
}

public function getcarimages($id) {
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		//$self = new self ();
		$sql = "select image from images where ShowroomId='$id'";
		//$data = $self->getData ( $sql );
		$stmt = $db->query($sql); 
        $data =  $stmt->fetchAll();
		return $data;
	}


public function getcardetails($id) {
	
     //return  "hi";
	$db =Zend_Db_Table_Abstract::getDefaultAdapter();
	$sql = "select * from advertisement where Adv_ID='$id'";
	//$data = $self->getData ( $sql );
	$stmt = $db->query($sql); 
         $data =  $stmt->fetchAll();
		 return  $data[0];
	
}

 public function getadpcardetails($vin, $dealerid) {
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$sql = "select scrapedata.New_Page_URL_Pattern from scrapedata where VIN='$vin' AND Dealer_ID='$dealerid'";
		$stmt = $db->query($sql);
        $data =  $stmt->fetchAll();
		unset ( $data ['0']['Image_Count'] );
		$dealer=explode("/",str_replace(array("http://","https://"),"",$data ['0']["New_Page_URL_Pattern"]));
		$dealer=explode(".",$dealer[0]);		
		$method=$dealer[1];
		$scrape = new Classes_ScrapeThumb;  
		$scrapedata = $scrape->$method($data['0']["New_Page_URL_Pattern"]);
		$data=$scrapedata;  
		return $data;
		
		
	}  
	
	public function newgetadpcardetails($newpage) {
		
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		/* $sql = "select scrapedata.New_Page_URL_Pattern from scrapedata where VIN='$vin' AND Dealer_ID='$dealerid'";
		$stmt = $db->query($sql);
        $data =  $stmt->fetchAll();
		unset ( $data ['0']['Image_Count'] ); */
		$dealer=explode("/",str_replace(array("http://","https://"),"",$newpage));
		$dealer=explode(".",$dealer[0]);		
		$method=$dealer[1];
		$scrape = new Classes_ScrapeThumb;  
		$scrapedata = $scrape->$method($newpage);
		$data=$scrapedata;  
		return $data;  
		
		
	} 
	
	public function getadpcardetailsweb($vin, $dealerid) {
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$sql = "SELECT * FROM scrapedata INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID where scrapedata.VIN='$vin' AND scrapedata.Dealer_ID='$dealerid'";
		$stmt = $db->query($sql);
        $data =  $stmt->fetchAll();
		/*unset ( $data ['0']['Image_Count'] );
		$dealer=explode("/",str_replace(array("http://","https://"),"",$data ['0']["New_Page_URL_Pattern"]));
		$dealer=explode(".",$dealer[0]);		
		$method=$dealer[1];
		$scrape = new Classes_ScrapeThumb;  
		$scrapedata = $scrape->$method($data['0']["New_Page_URL_Pattern"]);
		$data=array($data[0]+$scrapedata);  */
		return $data[0];
	}  
	

 	public function carlistdata($dealerid){
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$rcdk = "SELECT scrapedata.VIN as Adv_ID, scrapedata.VIN, scrapedata.Stock_Number, scrapedata.Dealer_ID, scrapedata.Make, scrapedata.Model, scrapedata.Model_Year as Year, scrapedata.Odometer as Mileage, scrapedata.Exterior_Base_Color as Exterior_Color, scrapedata.Interior_Base_Color as Interior_Color, scrapedata.Stock_Type, scrapedata.Image_URL_Pattern as Banner_Image,scrapedata.Offer_Price,scrapedata.MSRP,scrapedata.List_Price,user_account.City FROM scrapedata INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID WHERE scrapedata.Dealer_ID ='$dealerid' ORDER BY RAND(),`List_Price` DESC LIMIT 4";
		$stmt3= $db->query($rcdk); 
		$cdkdata =  $stmt3->fetchAll();
		return $cdkdata;
	}
	 
	 
public function selectdealerimage(){
	//return "selectdealerimage";
	$db =Zend_Db_Table_Abstract::getDefaultAdapter();
	$sql = "SELECT dealer_details.Logo_Image,user_account.Dealer_Name,user_account.UserID,user_account.Dealer_ID  FROM  dealer_details
		JOIN user_account
		ON dealer_details.Dealer_Id=user_account.UserID WHERE user_account.`AccountType`='Dealership' order by UserID desc limit 20";
		$stmt = $db->query($sql); 
         $data =  $stmt->fetchAll();
		return $data;
	
}


public function getdealernameonly($Dealer_Name) {
	 $db =Zend_Db_Table_Abstract::getDefaultAdapter();
	 $sql = "SELECT * FROM user_account WHERE AccountType='Dealership'		
				and `UserID` IN (select userid from 
				creditcarddetails where start_date<=now() and end_date>now()) or 
				`Dealer_ID` IN (select userid from creditcarddetails where 
				start_date<=now() and end_date>now()) and Dealer_Name like '%$Dealer_Name%'"; 
				$stmt = $db->query($sql); 
         $data =  $stmt->fetchAll(); 
	return $data;
	
}

/* public static function getdealernameonly($Dealer_Name) {
		$self = new self ();
		$sql = "SELECT * FROM user_account WHERE AccountType='Dealership'		
				and `UserID` IN (select userid from 
				creditcarddetails where start_date<=now() and end_date>now()) or 
				`Dealer_ID` IN (select userid from creditcarddetails where 
				start_date<=now() and end_date>now()) and Dealer_Name like '%$Dealer_Name%'";		
		
		if($dealer_Name!='All'&&$dealer_Name!=null)
		$sql=$sql." and Dealer_Name='$dealer_Name'";
		
		$data = $self->getData ( $sql );
		$rdatas = array();
		
		foreach ( $data as $imgdata ) {
			$userid = $imgdata['UserID'];
			$imgsql = "SELECT Logo_Image,DealerPromo FROM dealer_details WHERE  Dealer_Id='$userid'";		
			$imagedata = $self->getData ( $imgsql );
			$imgdata['Logo_Image'] = $imagedata [0] ['Logo_Image'];
			$imgdata['DealerPromo'] = $imagedata [0] ['DealerPromo'];
		$rdatas[] = array_merge ( $imgdata);
		}
		return $rdatas;
	} */
    
	Public function searchdetails($dealer_title, $radius, $lng, $lat, $dealer_Name) {
		//$self = new self ();
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$sql = "SELECT * FROM user_account WHERE AccountType='Dealership' and `Dealer_ID` IN (select userid from creditcarddetails where 
				start_date<=now() and end_date>now()) and Dealer_ID!=''";
		/* $stmt = $db->query($sql);
		$data =  $stmt->fetchAll(); */
		
		if ($dealer_title != 'All' && $dealer_title != null)
			$sql = $sql . " and Dealer_Name like '%$dealer_title%'";
			
		if($dealer_Name!='All'&&$dealer_Name!=null)
		$sql = $sql . " and Dealer_Name like '%$dealer_Name%'";
				
				
				
		$stmt = $db->query($sql);
		$data =  $stmt->fetchAll();
		
		
		
		$final = array ();
		foreach ( $data as $userdata ) 
		{
		if($lng!='0.0000' && $lat!='0.0000')
{
			$theta = $lng - $userdata ['Per_Longitude'];
			$lat2 = $userdata ['Per_Latitude'];
			$dist = sin ( deg2rad ( $lat ) ) * sin ( deg2rad ( $lat2 ) ) + cos ( deg2rad ( $lat ) ) * cos ( deg2rad ( $lat2 ) ) * cos ( deg2rad ( $theta ) );
			$dist = acos ( $dist );
			$dist = rad2deg ( $dist );
			$miles = $dist * 60 * 1.1515;
			$kilo = $miles * 1.609344;
			if ($kilo < $radius)
				$final [] = $userdata;
		}
		else
		{
		      $final[]=$userdata;
		}
      }
      return $final;
	}
	
	public function dealergetdetails($dealerid) {
		// print_r($dealerid);
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		
		$sql = "SELECT Logo_Image as Banner_Image FROM dealer_details where Dealer_Id='$dealerid'";
		$stmt = $db->query($sql);
		$data =  $stmt->fetchAll();
		return $data;
	}

	public function dealergetdetailsdata($dealerid) {
		// print_r($dealerid);
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		
		$sql = "SELECT Logo_Image FROM dealer_details where Dealer_Id='$dealerid'";
		$stmt = $db->query($sql);
		$data =  $stmt->fetchAll();
		return $data;
	}
	
	public function dealercars($Dealerid,$make,$count){
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$sql = "SELECT scrapedata.VIN, scrapedata.Stock_Number,scrapedata.Dealer_ID, scrapedata.Make, scrapedata.Model, scrapedata.Model_Year, scrapedata.Odometer,scrapedata.Transmission_Description, scrapedata.Exterior_Base_Color, scrapedata.Interior_Base_Color, scrapedata.Stock_Type, scrapedata.Image_URL_Pattern,scrapedata.Offer_Price,scrapedata.MSRP,scrapedata.List_Price,user_account.City,user_account.Dealer_Name,user_account.Phone,user_account.Email,user_account.Address,user_account.State,user_account.Location_Latitude,user_account.Location_Longitude,user_account.PostalCode FROM scrapedata  INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID WHERE scrapedata.Dealer_ID ='$Dealerid'";
		
		if($make!='All'&& $make!=null && $make!="")
			$sql=$sql." and scrapedata.Make='$make'";
			
			$sql=$sql."LIMIT $count,30";
			
		$stmt = $db->query($sql);
		$data =  $stmt->fetchAll();
			
		return $data; 
		//echo json_encode($data);
	} 
	
	public function makelist($Dealerid){
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$sql = "SELECT Make FROM scrapedata where Dealer_ID='$Dealerid' GROUP BY Make";
		$stmt = $db->query($sql);
		$data =  $stmt->fetchAll();
		//echo json_encode($data);
		return $data;
	}
	
	public function dealername($Dealerid){
	
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$sql = "SELECT Dealer_Name FROM user_account where Dealer_Id='$Dealerid'";
		$stmt = $db->query($sql);
		$data =  $stmt->fetchAll();
		return $data;
	}
	
	public function cityvalue($Dealerid){
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$sql= "SELECT user_account.City FROM user_account where Dealer_Id='$Dealerid'";
		$stmt = $db->query($sql);
		$rcdkdata =  $stmt->fetchAll();
		//echo json_encode($rcdkdata);
		return $rcdkdata;
			
		}
		
	public function getuserid($Dealerid){
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$sql= "SELECT user_account.userID FROM user_account where Dealer_Id='$Dealerid'";
		$stmt = $db->query($sql);
		$rcdkdata =  $stmt->fetchAll();
		//echo json_encode($rcdkdata);
		return $rcdkdata;
	
	}
	
	
	
}
?>