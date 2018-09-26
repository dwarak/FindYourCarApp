<?php
class Application_Model_Showroomtest extends Zend_Db_Table_Abstract {
//protected $_name = 'scrapedata';
	//protected $_count;
	//protected $_followingid;
	
/* 	public function __set($name, $value) {
		$this->$name = $value;
		  
	} */
	
	
	public function getfirstshowroomdetails() {
		
			$db =Zend_Db_Table_Abstract::getDefaultAdapter();
        // $sql =  "SELECT * FROM scrapedata LIMIT 30";
        $sql =  "SELECT MSRP as Price,List_Price as Cost,VIN as Adv_ID,Make,Model,Model_Year as Year,Image_URL_Pattern as Banner_Image,Odometer as Mileage,Stock_Type FROM `scrapedata` WHERE `Dealer_ID` IN (select adver_id from creditcarddetails where start_date<=now() and end_date>now()) or `Dealer_ID` IN (select userid from creditcarddetails where start_date<=now() and end_date>now()) and Image_URL_Pattern!=''
		ORDER BY RAND(),`List_Price` DESC LIMIT 0,6";
         $stmt = $db->query($sql); 
         $result =  $stmt->fetchAll();
		 if($result){
			return $result;
		 }
		 else{
			 return false;
		 }
			
	} 
	
	
	Public function getrecentuploaddetails($datayear) {  
		//return "getrecentgetrecent";
		//echo $datayear;
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		
			
	
			$rcdk = "SELECT scrapedata.VIN as Adv_ID, scrapedata.VIN, scrapedata.Stock_Number, scrapedata.Dealer_ID, scrapedata.Make,scrapedata.New_Page_URL_Pattern, scrapedata.Model, scrapedata.Model_Year as Year, scrapedata.Odometer as Mileage, scrapedata.Exterior_Base_Color as Exterior_Color, scrapedata.Interior_Base_Color as Interior_Color, scrapedata.Stock_Type, scrapedata.Image_URL_Pattern as Banner_Image,scrapedata.Offer_Price,scrapedata.MSRP,scrapedata.List_Price,user_account.City,user_account.Phone,user_account.Email FROM scrapedata  INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID WHERE `Model_Year` ='$datayear' and Image_URL_Pattern!='' and scrapedata.Odometer!='' ORDER BY RAND(),`List_Price` DESC LIMIT 6";
			 $stmt3= $db->query($rcdk); 
			 $cdkdata =  $stmt3->fetchAll();
			 /* foreach($cdkdata as $cdkfile){
				$rfinaldatas [] = $cdkfile;
					if($rfinaldatas==$datayear){
					return $rfinaldatas;
					}else{
						
			 } */
			 
			 if(!$cdkdata){
			 $currentdate=date("Y");
			 $rcdk = "SELECT scrapedata.VIN as Adv_ID, scrapedata.VIN, scrapedata.Stock_Number, scrapedata.Dealer_ID, scrapedata.Make, scrapedata.Model, scrapedata.Model_Year as Year, scrapedata.Odometer as Mileage, scrapedata.Exterior_Base_Color as Exterior_Color, scrapedata.Interior_Base_Color as Interior_Color, scrapedata.Stock_Type, scrapedata.Image_URL_Pattern as Banner_Image,scrapedata.Offer_Price,scrapedata.MSRP,scrapedata.List_Price,user_account.City FROM scrapedata  INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID WHERE `Model_Year` ='$currentdate' and Image_URL_Pattern!='' and scrapedata.Odometer!='' ORDER BY RAND(),`List_Price` DESC LIMIT 6";
			 $stmt3= $db->query($rcdk); 
			 $cdkdata =  $stmt3->fetchAll();
			 }
			 return $cdkdata;
			 //echo json_encode($cdkdata);
			
			
		
	}
	
	Public function allcountdetails() {
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		
		$sql = "SELECT count(*) as totalcount FROM `scrapedata` WHERE `Dealer_ID` IN (select adver_id from creditcarddetails where start_date<=now() and end_date>now()) or `Dealer_ID` IN (select userid from creditcarddetails where start_date<=now() and end_date>now()) and Image_URL_Pattern!='' ORDER BY `List_Price` DESC";
		
		  $stmt = $db->query($sql); 
         $result =  $stmt->fetchAll();
		return $result;
		
	}
	
	
	Public function getcountshowroomdetails($count) {
		
		//return $count;
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		
		$sql = "SELECT MSRP as Price,List_Price as Cost,VIN as Adv_ID,Make,Model,Model_Year as Year,Image_URL_Pattern as Banner_Image,Odometer as Mileage,Stock_Type FROM `scrapedata` WHERE `Dealer_ID` IN (select adver_id from creditcarddetails where start_date<=now() and end_date>now()) or `Dealer_ID` IN (select userid from creditcarddetails where start_date<=now() and end_date>now()) and Image_URL_Pattern!='' ORDER BY `List_Price` DESC LIMIT $count,6";  
		
		  $stmt = $db->query($sql); 
         $result =  $stmt->fetchAll();
		return $result;
		 
		
		
		
	}  
	
	
	/* Public function getMatch() {
		
		return "getMatch";
		
	} */
	
	
	Public function getMatch($Make,$Model,$Year,$count,$Price_Sort,$Distance_Sort,$Model_Sort,$lat,$lng,$start_price,$end_price,$pricerag,$yearrange)
	{
		
		
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		//$self=new self();

		$cdk = "SELECT scrapedata.Dealer_ID, MSRP as Price,List_Price as Cost,VIN as Adv_ID,Make,Model,Model_Year as Year,Image_URL_Pattern as Banner_Image,Odometer as Mileage,Stock_Type ,user_account.Dealer_Name
		FROM scrapedata
		INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID";  
		
		
		if($Make!='All'&&$Make!=null)
		 $cdk=$cdk." and scrapedata.Make='$Make'";
		if($Model!='All'&&$Model!=null)
			$cdk=$cdk." and scrapedata.Model='$Model'";
		if($Year!='All'&&$Year!=null)
			$cdk=$cdk." and scrapedata.Model_Year='$Year'";
		
		
		  if($start_price!='All'&&$start_price!=null&&$end_price!='All'&&$end_price!=null)
	       $cdk=$cdk." and scrapedata.List_Price BETWEEN '$start_price' AND '$end_price'";   
	 
		if($Distance_Sort!='All'&&$Distance_Sort!=null)
			$cdk=$cdk." `Odometer` $Distance_Sort,";
		if($Model_Sort!='All'&&$Model_Sort!=null)
			$cdk=$cdk." `Model_Year` $Model_Sort,";
		
		
		
		 
		    
		 if($pricerag=="DESC"||$yearrange=="DESC"){
			 if($pricerag=="DESC"){
		   $cdk=$cdk."  ORDER BY scrapedata.List_Price DESC limit $count,6"; 
			 }
		 
		else{
			$cdk=$cdk."  ORDER BY scrapedata.Model_Year DESC limit $count,6"; 
		  } 
		  
		  } 
		  elseif($pricerag=="ASC"||$yearrange=="ASC"){
			   if($pricerag=="ASC"){
			   $cdk=$cdk."  ORDER BY scrapedata.List_Price ASC limit $count,6"; 
			   }
			  else{
		   $cdk=$cdk."  ORDER BY scrapedata.Model_Year ASC limit $count,6"; 
		  } 
			   
			   
		  }
		else{
			 $cdk=$cdk." and Image_URL_Pattern!='' ORDER BY "; 
			$cdk=$cdk." `Last_Modified_Date` ASC limit $count,6"; 
			
		}
			
			
			
		
			//$cdkdata = $self->getData ( $cdk );
		
		 $stmt = $db->query($cdk); 
         $result =  $stmt->fetchAll();
	
		$datas = array_merge ( $result );
		

		return $datas;

	}
	
	
	public function getMatch1($Make,$Model,$Year,$count,$Price_Sort,$Distance_Sort,$Model_Sort,$lat,$lng,$start_price,$end_price,$pricerag,$yearrange)
	{
		//return "getMatch1";
		
	$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		//$self=new self();

		$cdk = "SELECT scrapedata.Dealer_ID, MSRP as Price,List_Price as Cost,VIN as Adv_ID,Make,Model,Model_Year as Year,Image_URL_Pattern as Banner_Image,Odometer as Mileage,Stock_Type ,user_account.Dealer_Name
FROM scrapedata
INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID";
		if($Make!='All'&&$Make!=null)
		 $cdk=$cdk." and scrapedata.Make='$Make'";
		if($Model!='All'&&$Model!=null)
			$cdk=$cdk." and scrapedata.Model='$Model'";
		if($Year!='All'&&$Year!=null)
			$cdk=$cdk." and scrapedata.Model_Year='$Year'";
		
		
		  if($start_price!='All'&&$start_price!=null&&$end_price!='All'&&$end_price!=null)
	       $cdk=$cdk." and scrapedata.List_Price BETWEEN '$start_price' AND '$end_price'";   
	 
		if($Distance_Sort!='All'&&$Distance_Sort!=null)
			$cdk=$cdk." `Odometer` $Distance_Sort,";
		if($Model_Sort!='All'&&$Model_Sort!=null)
			$cdk=$cdk." `Model_Year` $Model_Sort,";
		
		
		
		 
		    
		 if($pricerag=="DESC"||$yearrange=="DESC"){
			 if($pricerag=="DESC"){
		   $cdk=$cdk."  ORDER BY scrapedata.List_Price DESC limit $count,6"; 
			 }
		 
		else{
			$cdk=$cdk."  ORDER BY scrapedata.Model_Year DESC limit $count,6"; 
		  } 
		  
		  } 
		  elseif($pricerag=="ASC"||$yearrange=="ASC"){
			   if($pricerag=="ASC"){
			   $cdk=$cdk."  ORDER BY scrapedata.List_Price ASC limit $count,6"; 
			   }
			  else{
		   $cdk=$cdk."  ORDER BY scrapedata.Model_Year ASC limit $count,6"; 
		  } 
			   
			   
		  }
		else{
			 $cdk=$cdk." and Image_URL_Pattern!='' ORDER BY "; 
			$cdk=$cdk." `Last_Modified_Date` ASC limit $count,6"; 
			
		}
			
			
			
		
			//$cdkdata = $self->getData ( $cdk );
		
		 $stmt = $db->query($cdk); 
         $result =  $stmt->fetchAll();
	
		$datas = array_merge ( $result );
		

		return $datas;
		
	}
	
	
	
	Public function  selectCar(){
		//return "selectCar";
//	$self=new self();

 $db =Zend_Db_Table_Abstract::getDefaultAdapter();
	
		$make = "SELECT Make FROM scrapedata WHERE Make!= '' and Image_URL_Pattern != '' GROUP BY Make";
		
		//$makedata = $self->getData ( $make );
		$stmt = $db->query($make); 
		$makedata =  $stmt->fetchAll();
		
		$Model = "SELECT Model FROM scrapedata WHERE Model!= '' and Image_URL_Pattern != '' GROUP BY Model";
		
		//$Modeldata = $self->getData ( $Model );
		$stmt = $db->query($Model); 
         $Modeldata =  $stmt->fetchAll();
		
		
		/* $result = array("Make"=>$makedata,"Model"=>$Modeldata);
		

		return $result; */
		
		 $ModelYear = "SELECT Model_Year FROM scrapedata WHERE Model_Year!= '' and Image_URL_Pattern != '' GROUP BY Model_Year";
		
		//$ModelYeardata = $self->getData ( $ModelYear );		
		
		$stmt = $db->query($ModelYear); 
         $ModelYeardata =  $stmt->fetchAll();
		
		$result = array("Make"=>$makedata,"Model"=>$Modeldata,"ModelYear"=>$ModelYeardata);
		
         if ($result) {
            return $result;
        } else {
            return false;
        }  
		 
		
		
		
    }
	
	
	
	//public static function getDealerFromRadius($lat, $lng, $radius) {		//return $lat;				 $self = new self ();		$sql = "SELECT * FROM user_account WHERE `UserID` IN (select userid from 				creditcarddetails where start_date<=now() and end_date>now()) or 				`Dealer_ID` IN (select userid from creditcarddetails where 				start_date<=now() and end_date>now())";				$data = $self->getData ( $sql );				$final = array ();				foreach ( $data as $userdata ) {									$lats = floatval($userdata ['Per_Latitude']);			$lngs = floatval($userdata ['Per_Longitude']);						$theta = $lng - $lngs;						$lat2 = $lats;			$dist = sin ( deg2rad ( $lat ) ) * sin ( deg2rad ( $lat2 ) ) + cos ( deg2rad ( $lat ) ) * cos ( deg2rad ( $lat2 ) ) * cos ( deg2rad ( $theta ) );						$dist = acos ( $dist );			$dist = rad2deg ( $dist );			$miles = $dist * 60 * 1.1515;			$kilo = $miles * 1.609344;						if ($miles < $radius) {				if ($userdata ['Dealer_ID'] != "") {					$final [] = $userdata ['Dealer_ID'];				} elseif ($userdata ['Dealer_ID'] == "") {					$final [] = $userdata ['UserID'];				}			}		}				return $final; 	}
	
	
	
	
	
	public function getNearmeData() {
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
			
			$rcdk = "SELECT  scrapedata.VIN, scrapedata.Stock_Number, scrapedata.Dealer_ID,scrapedata.New_Page_URL_Pattern, scrapedata.Make, scrapedata.Model, scrapedata.Model_Year as Year, scrapedata.Odometer as Mileage, scrapedata.Exterior_Base_Color as Exterior_Color, scrapedata.Interior_Base_Color as Interior_Color, scrapedata.Stock_Type, scrapedata.Image_URL_Pattern as Banner_Image, scrapedata.Offer_Price,scrapedata.MSRP,scrapedata.List_Price, user_account.City,user_account.Phone,user_account.Email FROM scrapedata INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID WHERE Image_URL_Pattern!='' and scrapedata.Odometer!='' and scrapedata.List_Price!='0.00' and scrapedata.Offer_Price!='0.00' ORDER BY RAND(),`List_Price` DESC  LIMIT 12";
			
			$stmt4 = $db->query($rcdk);
			$rdid =  $stmt4->fetchAll(); 
			//return $rdid;
			 foreach ( $rdid as $rfinaldatass ) {
					
						$rfinaldatas [] = $rfinaldatass; 
						
						}
						/*$column=2;
						$dataval=array_chunk($rfinaldatas , $column);*/
			//echo json_encode($dataval);
			return $rfinaldatas; 
		
		
	}
	 public function getDealerFromRadiusTest($lat, $lng, $radius) {
		 
	$db =Zend_Db_Table_Abstract::getDefaultAdapter();
	
	$sql = "SELECT * FROM user_account WHERE `UserID` IN (select userid from 
				creditcarddetails where start_date<=now() and end_date>now()) or 
				`Dealer_ID` IN (select userid from creditcarddetails where 
				start_date<=now() and end_date>now())";
				
	$stmt = $db->query($sql); 
         $data =  $stmt->fetchAll();
	
		//return "getDealerFromRadiusTest";
		
		$final = array ();
		$finaldata = array ();
		$mil = array ();
		$milsort = array ();
		
		foreach ( $data as $userdata ) {
				
			$lats = floatval($userdata ['Per_Latitude']);
			$lngs = floatval($userdata ['Per_Longitude']);
			
			$theta = $lng - $lngs;
			
			$lat2 = $lats;
			$dist = sin ( deg2rad ( $lat ) ) * sin ( deg2rad ( $lat2 ) ) + cos ( deg2rad ( $lat ) ) * cos ( deg2rad ( $lat2 ) ) * cos ( deg2rad ( $theta ) );
			
			$dist = acos ( $dist );
			$dist = rad2deg ( $dist );
			$miles = $dist * 60 * 1.1515;
			$kilo = $miles * 1.609344;
			
			if ($miles < $radius) {
			$mil[] = $miles;
			
				if ($userdata ['Dealer_ID'] != "") {
					$final [] = $userdata ['Dealer_ID'];
				} elseif ($userdata ['Dealer_ID'] == "") {
					$final [] = $userdata ['UserID'];
				}
			}
		}
		$unsort=$mil;
		sort($mil);
		$arrlength = count($mil);
		for($x = 0; $x <  $arrlength; $x++) {
			$milsort[]= $mil[$x];
			
		}
		//echo json_encode($milsort);
		
		$arr=array();$arr1=array();
		foreach (array_values($milsort) as $i => $value) {
		foreach (array_values($unsort) as $j => $value2) {
		if($value == $value2){
		$arr[]=$j;
		}
		}
		}

		foreach (array_values($arr) as $k => $avalue) {
		foreach (array_values($final) as $l => $value3) {
		if($avalue == $l){
		$finaldata[]=$value3;
		}
		}
		}

		return $finaldata;
		
	} 
	 public function sendNotification($ShowroomId, $UserName, $UserId) {
		 
		 //return "UserId";
	$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		 $sql = "select * from advertisement where Adv_ID ='$ShowroomId'";
		 
		 $stmt = $db->query($sql); 
         $userArray =  $stmt->fetchAll();
		// return $data;
		 
		 if (count($userArray)>0) {
				$userid = $userArray [0] ['User_ID'];
				$make = $userArray [0] ['Make'];
				$model = $userArray [0] ['Model'];
				$year = $userArray [0] ['Year'];
				$price = $userArray [0] ['Price'];
				$message = $UserName . " has commented on your Ad - " . " \"" . $userArray [0] ['Year'] . " " . $userArray [0] ['Make'] . " " . $userArray [0] ['Model'] . "\"";
				//return $message;
			} else {
				$cdksql = "SELECT Dealer_ID,Make,Model,Model_Year as Year,List_Price,MSRP FROM scrapedata where VIN='$ShowroomId'";
				//$cdkArray = $self->getData ( $cdksql );
				$stmt1 = $db->query($cdksql); 
         $cdkArray =  $stmt1->fetchAll();
				
				
				$dealerid = $cdkArray [0] ['Dealer_ID'];
				$usersql = "SELECT UserID FROM user_account where Dealer_ID='$dealerid'";
				
				//$userArray = $self->getData ( $usersql );
				
					$stmt2 = $db->query($usersql); 
         $userArray =  $stmt2->fetchAll();
				
				$userid = $userArray [0] ['UserID'];
				$make = $cdkArray [0] ['Make'];
				$model = $cdkArray [0] ['Model'];
				$year = $cdkArray [0] ['Year'];
				$price = $cdkArray [0] ['List_Price'];
				if($price==0)
				$price = $cdkArray [0] ['MSRP'];
				$message = $UserName . " has commented on your Ad - " . " \"" . $cdkArray [0] ['Year'] . " " . $cdkArray [0] ['Make'] . " " . $cdkArray [0] ['Model'] . "\"";
				return $message;
			}
		 
		 
		 
		 
		 
		 
		 
		 
	 }
	 
	public function getDealerFromRadius($lat, $lng, $radius) {
		//return $lat;
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		 //$self = new self ();
		
		$sql = "SELECT * FROM user_account WHERE `UserID` IN (select userid from 
				creditcarddetails where start_date<=now() and end_date>now()) or 
				`Dealer_ID` IN (select userid from creditcarddetails where 
				start_date<=now() and end_date>now())";
		
			$stmt = $db->query($sql); 
         $data =  $stmt->fetchAll();
		//$data = $self->getData ( $sql );
		
		$final = array ();
		
		foreach ( $data as $userdata ) {
			
			
			$lats = floatval($userdata ['Per_Latitude']);
			$lngs = floatval($userdata ['Per_Longitude']);
			
			$theta = $lng - $lngs;
			
			$lat2 = $lats;
			$dist = sin ( deg2rad ( $lat ) ) * sin ( deg2rad ( $lat2 ) ) + cos ( deg2rad ( $lat ) ) * cos ( deg2rad ( $lat2 ) ) * cos ( deg2rad ( $theta ) );
			
			$dist = acos ( $dist );
			$dist = rad2deg ( $dist );
			$miles = $dist * 60 * 1.1515;
			$kilo = $miles * 1.609344;
			
			if ($miles < $radius) {
				if ($userdata ['Dealer_ID'] != "") {
					$final [] = $userdata ['Dealer_ID'];
				} elseif ($userdata ['Dealer_ID'] == "") {
					$final [] = $userdata ['UserID'];
				}
			}
		}
		
		return $final; 
	}
	 
	 
	 public function getDealerFromRadiusDataCount($lat, $lng, $radius, $count){
		 
		 $db =Zend_Db_Table_Abstract::getDefaultAdapter();
		 
		$final = $this->getDealerFromRadius ( $lat, $lng, $radius );
		//return $final;
		
		 $rsql = "SELECT * FROM `advertisement` WHERE `Adv_ID` IN (select adver_id from creditcarddetails where start_date<=now() and end_date>now()) or `User_ID` IN (select userid from creditcarddetails where start_date<=now() and end_date>now()) ORDER BY `Uploaded_Date` DESC";
		 $stmt1 = $db->query($rsql);
		 $rdata =  $stmt1->fetchAll();
         	 
		 
		 	$rcdkadv = "SELECT * FROM `advertisement` WHERE `Adv_ID` IN (SELECT UserID FROM `user_account` WHERE `Dealer_ID` IN (select adver_id from creditcarddetails where start_date<=now() and end_date>now()) or `Dealer_ID` IN (select userid from creditcarddetails where start_date<=now() and end_date>now())) or `User_ID` IN (SELECT UserID FROM `user_account` WHERE `Dealer_ID` IN (select adver_id from creditcarddetails where start_date<=now() and end_date>now()) or `Dealer_ID` IN (select userid from creditcarddetails where start_date<=now() and end_date>now())) ORDER BY `Uploaded_Date` DESC";
			 $stmt2 = $db->query($rcdkadv);
		$rcdkadvdata =  $stmt2->fetchAll(); 
		
		
		$rdatas = $rcdkadvdata + $rdata;
		$rcdk = "SELECT Dealer_ID,MSRP as Price,List_Price as Cost,VIN as Adv_ID,Make,Model,Model_Year as Year,Image_URL_Pattern as Banner_Image,Odometer as Mileage,Stock_Type FROM `scrapedata` WHERE `Dealer_ID` IN (select adver_id from creditcarddetails where start_date<=now() and end_date>now()) or `Dealer_ID` IN (select userid from creditcarddetails where start_date<=now() and end_date>now()) and Image_URL_Pattern!='' ORDER BY RAND(),`List_Price` DESC"; // LIMIT
		  $stmt3 = $db->query($rcdk);
		$rcdkdata =  $stmt3->fetchAll();
		
		$did = "select userid from creditcarddetails where start_date<=now() and end_date>now()";
		 $stmt4 = $db->query($did);
		$rdid =  $stmt4->fetchAll();
		//return $rdid;
		$rfinaldatas = array ();
		$rcdkdata = array ();
		foreach ( $final as $rfinal ) {
			foreach ( $rdid as $rfinaldata ) {
				if ($rfinal == $rfinaldata ['userid']) {
					$rdiddt = $rfinaldata ['userid'];
					$rcdk = "SELECT VIN,Offer_Price, as Adv_ID,Make,Model,Model_Year as Year,Image_URL_Pattern as Banner_Image,Odometer as Mileage,Stock_Type FROM `scrapedata` WHERE `Dealer_ID` ='$rdiddt' and Image_URL_Pattern!='' ORDER BY `List_Price` DESC LIMIT $count,6"; // LIMIT
					                                                                                                                                                                                                                                                                                                          // 0,50";
					//$rcdkdata = $self->getData ( $rcdk );
					$stmt5 = $db->query($rcdk);
	          	$rcdkdata =  $stmt5->fetchAll();
					
					
					if (!$rcdkdata) {
						$rcdk = "SELECT * FROM `advertisement` WHERE `User_ID` ='$rdiddt' ORDER BY `Uploaded_Date` DESC LIMIT 0,6"; // LIMIT
						                                                                                                             // 0,50";
						//$rcdkdata = $self->getData ( $rcdk );
						$stmt6 = $db->query($rcdk);
	          	$rcdkdata =  $stmt6->fetchAll();
						
					}
					foreach ( $rcdkdata as $rfinaldatass ) {
						$rfinaldatas [] = $rfinaldatass;
					}
				}
			} 
		}
		
		if ($rfinaldatas) {
			// $rdatas=array_merge($rdata,$rfinaldatas);
			$rdatas = array_merge ( $rfinaldatas );
			return $rdatas;
		}
		
	 }
	
	
	
	public function getDealerFromRadiusDataMileCount($lat, $lng, $radius, $count, $final){
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$final= $this->getDealerFromRadius($lat,$lng,$radius);
		//return $final;
		
		$rsql = "SELECT * FROM `advertisement` WHERE `Adv_ID` IN (select adver_id from creditcarddetails where start_date<=now() and end_date>now()) or `User_ID` IN (select userid from creditcarddetails where start_date<=now() and end_date>now()) ORDER BY `Uploaded_Date` DESC";
		$stmt1 = $db->query($rsql);
	    $rdata =  $stmt1->fetchAll();
	
		$rcdkadv = "SELECT * FROM `advertisement` WHERE `Adv_ID` IN (SELECT UserID FROM `user_account` WHERE `Dealer_ID` IN (select adver_id from creditcarddetails where start_date<=now() and end_date>now()) or `Dealer_ID` IN (select userid from creditcarddetails where start_date<=now() and end_date>now())) or `User_ID` IN (SELECT UserID FROM `user_account` WHERE `Dealer_ID` IN (select adver_id from creditcarddetails where start_date<=now() and end_date>now()) or `Dealer_ID` IN (select userid from creditcarddetails where start_date<=now() and end_date>now())) ORDER BY `Uploaded_Date` DESC";
		$stmt2 = $db->query($rcdkadv);
	   $rcdkadvdata =  $stmt2->fetchAll();
	   
	  
	    $rdatas = $rcdkadvdata + $rdata;
	   
	   $rcdk = "SELECT Dealer_ID,MSRP as Price,List_Price as Cost,VIN as Adv_ID,Make,Model,Model_Year as Year,Image_URL_Pattern as Banner_Image,Odometer as Mileage,Stock_Type FROM `scrapedata` WHERE `Dealer_ID` IN (select adver_id from creditcarddetails where start_date<=now() and end_date>now()) or `Dealer_ID` IN (select userid from creditcarddetails where start_date<=now() and end_date>now()) and Image_URL_Pattern!='' ORDER BY `List_Price` DESC"; // LIMIT
		   $stmt3 = $db->query($rcdk);
	   $rcdkdata =  $stmt3->fetchAll();
	  
		$did = "select userid from creditcarddetails where start_date<=now() and end_date>now()";
	    $stmt4 = $db->query($did);
	   $rdid =  $stmt4->fetchAll();  

	$rfinaldatas = array ();
		$rcdkdata = array ();
	foreach ( $final as $rfinal ) {
			foreach ( $rdid as $rfinaldata ) {
				if ($rfinal == $rfinaldata ['userid']) {
					$rdiddt = $rfinaldata ['userid'];
					$rcdk = "SELECT Dealer_ID,MSRP as Price,List_Price as Cost,VIN as Adv_ID,Make,Model,Model_Year as Year,Image_URL_Pattern as Banner_Image,Odometer as Mileage,Stock_Type FROM `scrapedata` WHERE `Dealer_ID` ='$rdiddt' and Image_URL_Pattern!='' ORDER BY `List_Price` DESC LIMIT $count,6"; // LIMIT
					                                                                                                                                                                                                                                                                                                          // 0,50";
					//$rcdkdata = $self->getData ( $rcdk );
					$stmt5 = $db->query($rcdk);
	               $rcdkdata =  $stmt5->fetchAll(); 
					if (!$rcdkdata) {
						$rcdk = "SELECT * FROM `advertisement` WHERE `User_ID` ='$rdiddt' ORDER BY `Uploaded_Date` DESC LIMIT 0,6"; // LIMIT
						                                                                                                             // 0,50";																											 
						$stmt6 = $db->query($rcdk);
	               $rcdkdata =  $stmt6->fetchAll();
					}
					foreach ( $rcdkdata as $rfinaldatass ) {
						$rfinaldatas [] = $rfinaldatass;
					}
				}
			}
		}
	
	if ($rfinaldatas) {
			// $rdatas=array_merge($rdata,$rfinaldatas);
			$rdatas = array_merge ( $rfinaldatas );
			return $rdatas;
		}
	
	
	
 
	}
	
	
		
		  public function getFilterCars2($Make,$Model,$Year,$count,$Price_Sort,$Distance_Sort,$Model_Sort,$lat,$lng,$start_price,$end_price,$pricerag,$yearrange,$Dealer_ID,$Mileage1,$Mileage2,$Year_from,$Year_to){
		  
		 $db =Zend_Db_Table_Abstract::getDefaultAdapter();
		
		  //$self=new self();
		 
		 $cdksql="SELECT scrapedata.VIN as Adv_ID,scrapedata.Make, scrapedata.Model, scrapedata.Model_Year as Year , scrapedata.Stock_Type as Conditions, scrapedata.Image_URL_Pattern as Banner_Image, scrapedata.List_Price as Cost, scrapedata.MSRP as List_Price, scrapedata.Odometer as Mileage,user_account.Dealer_Name
FROM scrapedata
INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID
WHERE scrapedata.Dealer_ID = '$Dealer_ID'"; 

if($Make!='All'&&$Make!=null)
			$cdksql=$cdksql." and scrapedata.Make='$Make'";	

	if($Model!='All'&&$Model!=null)
			$cdksql=$cdksql." and scrapedata.Model='$Model'";		
		
		if($Year!='All'&&$Year!=null)			
			$cdksql=$cdksql." and scrapedata.Model_Year='$Year'";	
		
		if($start_price!='All'&&$start_price!=null&&$end_price!='All'&&$end_price!=null)
	       $cdksql=$cdksql." and scrapedata.List_Price BETWEEN '$start_price' AND '$end_price'"; 
		
	 if(($Mileage1!='Any'&&$Mileage2!='Any')&&($Mileage1!=null&&$Mileage2!=null))
	 {
		$cdksql=$cdksql." and CAST( REPLACE(REPLACE( scrapedata.Odometer, ',', '' ),'$','') AS DECIMAL )
BETWEEN '$Mileage1' and '$Mileage2'";
}

//-------

  if(($Year_from!='Any'&&$Year_to!='Any')&&($Year_from!=null&&$Year_to!=null))
  {
		$cdksql=$cdksql." and CAST( REPLACE(REPLACE( scrapedata.Model_Year, ',', '' ),'$','') AS DECIMAL )
BETWEEN '$Year_from' and '$Year_to'";
}
//------		
		
		if($pricerag!='All'&&$pricerag=='DESC')
		{
			$cdksql=$cdksql." and Image_URL_Pattern!='' ORDER BY "; 
 
	$cdksql=$cdksql." scrapedata.List_Price DESC limit $count,6";  
			
			//$cdkresult=$db->getData($cdksql);
			
			/* $stmt = $db->query($cdksql); 
			$result =  $stmt->fetchAll(); */
			
		}
		
		if($Year!='All'&&$Year!=null&&$Year=="DESC"){
			
			$cdksql=$cdksql." and Image_URL_Pattern!='' ORDER BY "; 
 
	$cdksql=$cdksql." scrapedata.Model_Year DESC limit $count,6";  
			
			
			//$cdkresult=$db->getData($cdksql);
			/* 
			$stmt = $db->query($cdksql); 
			$result =  $stmt->fetchAll(); */
			
			
		}			
			
		
			/* if($pricerag!='All'&&$pricerag=='ASC'){
			
			$cdksql=$cdksql." and Image_URL_Pattern!='' ORDER BY "; 
 
	$cdksql=$cdksql." scrapedata.List_Price ASC limit $count,30";  
			
			
			$cdkresult=$self->getData($cdksql);
			
			return $res = $cdkresult;
			
			
		} */
		
		
		
  $cdksql=$cdksql." and Image_URL_Pattern!='' ORDER BY "; 
 
	$cdksql=$cdksql." `Last_Modified_Date` ASC limit $count,6";  
			
			
			//$cdkresult=$self->getData($cdksql);
			$stmt = $db->query($cdksql); 
			$result =  $stmt->fetchAll();
			/* foreach ( $result as $rfinaldatass ) {
						$rfinaldatas [] = $rfinaldatass;
					}
				if ($rfinaldatas) {
				// $rdatas=array_merge($rdata,$rfinaldatas);
				$rdatas = array_merge ( $rfinaldatas );
				return $rdatas;
			} */
			return $result;
			
	
		  }
		  
	public function getDealerFromRadiusData($lat, $lng, $radius) {
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$final = $this->getDealerFromRadius ( $lat, $lng, $radius );
		//echo json_encode($final);
		$datacount = count($final);
		$rcdkdata = array ();
		$rfinaldatas = array ();
		for($i=0;$i<$datacount;$i++){
			if($i<6){
			$datavalue=$final[$i];
			
			 $rcdk = "SELECT scrapedata.VIN as Adv_ID, scrapedata.VIN, scrapedata.Stock_Number, scrapedata.Dealer_ID,scrapedata.New_Page_URL_Pattern, scrapedata.Make, scrapedata.Model, scrapedata.Model_Year as Year, scrapedata.Odometer as Mileage, scrapedata.Exterior_Base_Color as Exterior_Color, scrapedata.Interior_Base_Color as Interior_Color, scrapedata.Stock_Type, scrapedata.Image_URL_Pattern as Banner_Image,scrapedata.Offer_Price,scrapedata.MSRP,scrapedata.List_Price,user_account.City,user_account.Phone,user_account.Email FROM scrapedata  INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID WHERE scrapedata.Dealer_ID ='$datavalue' and scrapedata.Image_URL_Pattern!='' ORDER BY  scrapedata.Offer_Price DESC,RAND() LIMIT 1"; 
			
			$stmt = $db->query($rcdk);
			$rcdkdata =  $stmt->fetchAll();
			
			foreach ( $rcdkdata as $rfinaldatass ) {
						$rfinaldatas [] = $rfinaldatass;
			}
			}
		
		}
		return $rfinaldatas;
		//echo json_encode($rfinaldatas); 
		
		 
	}

Public function getrecentuplocationloaddetails($datayear,$lat, $lng, $radius) {  
		//return "getrecentgetrecent";
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$final = $this->getDealerFromRadius ( $lat, $lng, $radius );
		//echo json_encode($final);
		$datacount = count($final);
		$rcdkdata = array ();
		$rfinaldatas = array ();
		for($i=0;$i<$datacount;$i++){
			if($i<6){
			$datavalue=$final[$i];
			
			 $rcdk = "SELECT scrapedata.VIN as Adv_ID, scrapedata.VIN, scrapedata.Stock_Number,scrapedata.New_Page_URL_Pattern, scrapedata.Dealer_ID, scrapedata.Make, scrapedata.Model, scrapedata.Model_Year as Year, scrapedata.Odometer as Mileage, scrapedata.Exterior_Base_Color as Exterior_Color, scrapedata.Interior_Base_Color as Interior_Color, scrapedata.Stock_Type, scrapedata.Image_URL_Pattern as Banner_Image,scrapedata.Offer_Price,scrapedata.MSRP,scrapedata.List_Price,user_account.City,user_account.Phone,user_account.Email FROM scrapedata  INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID WHERE scrapedata.Dealer_ID ='$datavalue' and `Model_Year` ='$datayear' and scrapedata.Image_URL_Pattern!='' ORDER BY scrapedata.Offer_Price DESC,RAND() LIMIT 1"; 
			
			$stmt = $db->query($rcdk);
			$rcdkdata =  $stmt->fetchAll();
			if(!$rcdkdata){
			 $currentdate=date("Y");
			 $rcdk = "SELECT scrapedata.VIN as Adv_ID, scrapedata.VIN, scrapedata.Stock_Number,scrapedata.New_Page_URL_Pattern, scrapedata.Dealer_ID, scrapedata.Make, scrapedata.Model, scrapedata.Model_Year as Year, scrapedata.Odometer as Mileage, scrapedata.Exterior_Base_Color as Exterior_Color, scrapedata.Interior_Base_Color as Interior_Color, scrapedata.Stock_Type, scrapedata.Image_URL_Pattern as Banner_Image,scrapedata.Offer_Price,scrapedata.MSRP,scrapedata.List_Price,user_account.City FROM scrapedata  INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID WHERE scrapedata.Dealer_ID ='$datavalue' and`Model_Year` ='$currentdate' and Image_URL_Pattern!='' ORDER BY `Offer_Price` DESC,RAND() LIMIT 1";
			 $stmt3= $db->query($rcdk); 
			 $rcdkdata =  $stmt3->fetchAll();
			 }
			foreach ( $rcdkdata as $rfinaldatass ) {
						$rfinaldatas [] = $rfinaldatass;
			}
			}
		
		}
			//echo json_encode($rfinaldatas);
		return $rfinaldatas;
		
	}	
	
	public function getlocationNearmeData($lat, $lng, $radius) {
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		
		$final = $this->getDealerFromRadius ( $lat, $lng, $radius );
		$datacount = count($final);
		$rcdkdata = array ();
		$rfinaldatas = array ();
		for($i=0;$i<$datacount;$i++){
			if($i<6){
			$datavalue=$final[$i];
			
			 $rcdk = "SELECT scrapedata.VIN as Adv_ID, scrapedata.VIN, scrapedata.Stock_Number,scrapedata.New_Page_URL_Pattern, scrapedata.Dealer_ID, scrapedata.Make, scrapedata.Model, scrapedata.Model_Year as Year, scrapedata.Odometer as Mileage, scrapedata.Exterior_Base_Color as Exterior_Color, scrapedata.Interior_Base_Color as Interior_Color, scrapedata.Stock_Type, scrapedata.Image_URL_Pattern as Banner_Image,scrapedata.Offer_Price,scrapedata.MSRP,scrapedata.List_Price,user_account.City,user_account.Phone,user_account.Email FROM scrapedata  INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID WHERE scrapedata.Dealer_ID ='$datavalue' and scrapedata.Image_URL_Pattern!='' ORDER BY RAND() LIMIT 2"; 
			
			$stmt = $db->query($rcdk);
			$rcdkdata =  $stmt->fetchAll();
			
			foreach ( $rcdkdata as $rfinaldatass ) {
						$rfinaldatas [] = $rfinaldatass;
			}
			}
		
		}
		return $rfinaldatas;
		//echo json_encode($rfinaldatas);
	}
	
		public function getdealerdata(){
			$db =Zend_Db_Table_Abstract::getDefaultAdapter();
			
			$rcdk = "SELECT scrapedata.VIN as Adv_ID, scrapedata.VIN, scrapedata.Stock_Number, scrapedata.Dealer_ID, scrapedata.Make, scrapedata.Model,scrapedata.New_Page_URL_Pattern, scrapedata.Model_Year as Year, scrapedata.Odometer as Mileage, scrapedata.Exterior_Base_Color as Exterior_Color, scrapedata.Interior_Base_Color as Interior_Color, scrapedata.Stock_Type, scrapedata.Image_URL_Pattern as Banner_Image, scrapedata.Offer_Price,scrapedata.MSRP,scrapedata.List_Price, user_account.City, user_account.Phone,user_account.Email FROM scrapedata 
			INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID WHERE scrapedata.Image_URL_Pattern!='' and scrapedata.List_Price!='0.00' and scrapedata.Offer_Price!='0.00' and scrapedata.Odometer!='' ORDER BY RAND(),`Offer_Price` DESC LIMIT 6";
			
			
			//$rcdk=$rcdk."ORDER BY scrapedata.Offer_Price DESC"; 
			
			
			$stmt4 = $db->query($rcdk);
			$rdid =  $stmt4->fetchAll(); 
			
			foreach ( $rdid as $rfinaldatass ) {
						$rfinaldatas [] = $rfinaldatass;
			}
			return $rfinaldatas;
			//echo json_encode($rfinaldatas);
	}
	
	public function getCitydata($city,$make){
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$datares=array();
		$rfinaldatas=array();
		/*$datalist="SELECT * FROM user_account WHERE user_account.City ='$city' and user_account.Dealer_Name!='' and user_account.Dealer_ID !='' AND Dealer_ID IN (select userid from creditcarddetails where start_date<=now() and end_date>now())";*/
		$datalist = "select * from user_account where AccountType='Dealership' and `Dealer_ID` IN (select userid from creditcarddetails where 
				start_date<=now() and end_date>now())
				and Dealer_ID!=''";
		if($city!="" ||$city!= null)
			$datalist = $datalist . " and City='$city'";		
		
		if($make!="" ||$make!= null)
			$datalist = $datalist . " and Primary_sell like '%$make%'";
		
		$result=$db->query($datalist);
		$datares=$result->fetchAll();
		//echo json_encode($datares);
		foreach ( $datares as $rfinaldatass ) {
						$rfinaldatas [] = $rfinaldatass;
			}
			return $rfinaldatas;
			//echo json_encode($rfinaldatas);
	}
	
	public function dealergetdetails($dealerid) {
		// print_r($dealerid);
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		//echo $dealerid;
		$sql = "SELECT Logo_Image as Banner_Image,DealerPromo FROM dealer_details where Dealer_Id='$dealerid'";
		$stmt = $db->query($sql);
		$data =  $stmt->fetchAll();
		return $data;
		//echo json_encode($data);
	}
	
	public function getDealerFromRadiuslist($lat, $lng, $radius ,$make) {
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$final = $this->getDealerFromRadius ( $lat, $lng, $radius );
		//echo json_encode($final);
		$rcdkdata = array ();
		$rfinaldatas = array ();
		foreach ( $final as $rfinal ) {
	    $rdata = $rfinal;
		
		 /* $result ="SELECT * FROM user_account WHERE  user_account.Dealer_ID ='$rdata' and user_account.Dealer_Name!='' and user_account.Dealer_ID !='' `Dealer_ID` IN (select userid from creditcarddetails where 
		 start_date<=now() and end_date>now())
		 and Dealer_ID!=''"; */
		 
		 $result = "select * from user_account where  user_account.Dealer_ID ='$rdata' and AccountType='Dealership' and `Dealer_ID` IN (select userid from creditcarddetails where 
				start_date<=now() and end_date>now())
				and Dealer_ID!=''";
				
			if($make!="" ||$make!= null)
			$result = $result . " and Primary_sell like '%$make%'";
		 
		 $stmt = $db->query($result);
		 $rcdkdata =  $stmt->fetchAll(); 
		//echo json_encode($rcdkdata);	
		 foreach ( $rcdkdata as $rfinaldatass ) {
						$rfinaldatas [] = $rfinaldatass;
			}
			}
			return $rfinaldatas;
		//echo json_encode($rfinaldatas); 
		
		}
		
		public function getdealerlist($make){
			$db =Zend_Db_Table_Abstract::getDefaultAdapter();
			$result = "select * from user_account where AccountType='Dealership' and `Dealer_ID` IN (select userid from creditcarddetails where 
				start_date<=now() and end_date>now())
				and Dealer_ID!=''";
			$rdid=array();
			$rfinaldatas=array();
			if($make!="" ||$make!= null)
			$result = $result . " and Primary_sell like '%$make%'";
			
			$stmt4 = $db->query($result);
			$rdid =  $stmt4->fetchAll(); 
			
			foreach ( $rdid as $rfinaldatass ) {
						$rfinaldatas [] = $rfinaldatass;
			}
			return $rfinaldatas;
			//echo json_encode($rfinaldatas); 
	}
	
	public function staticcars(){
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
			$result = "select * from user_account where AccountType='Dealership' and `Dealer_ID` IN (select userid from creditcarddetails where 
				start_date<=now() and end_date>now())
				and Dealer_ID!=''";
			$rdid=array();
			$rfinaldatas=array();
			$stmt4 = $db->query($result);
			$rdid =  $stmt4->fetchAll(); 
			
			foreach ( $rdid as $rfinaldatass ) {
						$rfinaldatas [] = $rfinaldatass;
						}
			return $rfinaldatas;
	}
	
	public function getDealerFromLocation($lat, $lng, $radius,$make,$model,$start_price,$end_price,$pricerag,$Year_between,$Year_from,$Year_to,$mileage_range,$Mileage1,$Mileage2,$Distance_Sort,$count) {
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$final = $this->getDealerFromRadius ( $lat, $lng, $radius );
		//echo json_encode($final);
		$datacount = count($final);
		$rcdkdata = array ();
		$rfinaldatas = array ();
		for($i=0;$i<$datacount;$i++){
			if($i<6){
			$datavalue=$final[$i];
			
			 $rcdk = "SELECT scrapedata.VIN as Adv_ID, scrapedata.VIN, scrapedata.Stock_Number,scrapedata.New_Page_URL_Pattern, scrapedata.Dealer_ID, scrapedata.Make, scrapedata.Model, scrapedata.Model_Year as Year, scrapedata.Odometer as Mileage, scrapedata.Exterior_Base_Color as Exterior_Color, scrapedata.Interior_Base_Color as Interior_Color, scrapedata.Stock_Type, scrapedata.Image_URL_Pattern as Banner_Image,scrapedata.Offer_Price,scrapedata.MSRP,scrapedata.List_Price,user_account.Email,user_account.Phone,user_account.City FROM scrapedata  INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID WHERE scrapedata.Dealer_ID ='$datavalue'"; 

			 if($make!='All' && $make!=null)
			$rcdk=$rcdk." and scrapedata.Make='$make'";
			
			if($model!='All' && $model!=null)
			$rcdk=$rcdk." and scrapedata.Model='$model'";
			
			
			if($start_price!='All'&&$start_price!=null&&$end_price!='All'&&$end_price!=null)
	        $rcdk=$rcdk." and scrapedata.List_Price BETWEEN '$start_price' AND '$end_price'"; 
			
			if($pricerag!='All'&&$pricerag=='DESC')
			{
			$rcdk=$rcdk." and Image_URL_Pattern!='' ORDER BY "; 
 
			$rcdk=$rcdk." scrapedata.List_Price DESC "; 
			}
			if(($Year_from!='Any'&&$Year_to!='Any')&&($Year_from!=null&&$Year_to!=null))
			{
			$rcdk=$rcdk." and CAST( REPLACE(REPLACE( scrapedata.Model_Year, ',', '' ),'$','') AS DECIMAL )
			BETWEEN '$Year_from' and '$Year_to'";
			}
			
			if(($Mileage1!='Any'&&$Mileage2!='Any')&&($Mileage1!=null&&$Mileage2!=null))
			{
			$rcdk=$rcdk." and CAST( REPLACE(REPLACE( scrapedata.Odometer, ',', '' ),'$','') AS DECIMAL )
			BETWEEN '$Mileage1' and '$Mileage2'";
			}
			
			
			if($Distance_Sort=='MintoMax'|| $Distance_Sort=='MaxtoMin'){
				if($Distance_Sort=='MintoMax'){
				$rcdk=$rcdk." ORDER BY scrapedata.Odometer ASC, RAND() limit $count,30";
					}
					elseif($Distance_Sort=='MaxtoMin'){
					$rcdk=$rcdk." ORDER BY scrapedata.Odometer DESC, RAND() limit $count,30";
				}
			}
			
			
			elseif($Distance_Sort=='LowesttoHighest'|| $Distance_Sort=='HighesttoLowest'){
				if($Distance_Sort=='LowesttoHighest'){
				$rcdk=$rcdk." ORDER BY scrapedata.List_Price ASC, RAND() limit $count,30";
					}
					elseif($Distance_Sort=='HighesttoLowest'){
					$rcdk=$rcdk." ORDER BY scrapedata.List_Price DESC, RAND() limit $count,30";
				}
			}
			
			elseif($Distance_Sort=='OldesttoNewest'|| $Distance_Sort=='NewesttoOldest'){
				if($Distance_Sort=='OldesttoNewest'){
				$rcdk=$rcdk." ORDER BY scrapedata.Model_Year ASC, RAND() limit $count,30";
					}
					elseif($Distance_Sort=='NewesttoOldest'){
					$rcdk=$rcdk." ORDER BY scrapedata.Model_Year DESC, RAND() limit $count,30";
				}
			}
			
			else{
			$rcdk=$rcdk." and Image_URL_Pattern!='' ORDER BY "; 
 
			$rcdk=$rcdk." `Last_Modified_Date` ASC,RAND() limit $count,10"; 
			}
			
			$stmt = $db->query($rcdk);
			$rcdkdata =  $stmt->fetchAll();
			
			}
			foreach ( $rcdkdata as $rfinaldatass ) {
						$rfinaldatas [] = $rfinaldatass;
			}
		
		}
		return $rfinaldatas;
		//echo json_encode($rfinaldatas);  
		} 
		
		public function getcardata($make,$model,$year,$start_price,	$end_price,$pricerag,$Year_between,$Year_from,$Year_to,$mileage_range,$Mileage1,$Mileage2,$Distance_Sort,$count){
			$db =Zend_Db_Table_Abstract::getDefaultAdapter();
			
			$cdk = "SELECT scrapedata.VIN as Adv_ID, scrapedata.VIN, scrapedata.Stock_Number,scrapedata.New_Page_URL_Pattern,scrapedata.Stock_Type, scrapedata.Dealer_ID, scrapedata.Make, scrapedata.Model, scrapedata.Model_Year as Year, scrapedata.Odometer as Mileage, scrapedata.Exterior_Base_Color as Exterior_Color, scrapedata.Interior_Base_Color as Interior_Color, scrapedata.Stock_Type, scrapedata.Image_URL_Pattern as Banner_Image, scrapedata.Offer_Price,scrapedata.MSRP,scrapedata.List_Price, user_account.Email,user_account.Phone,user_account.City FROM scrapedata 
			INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID ";
			$rfinaldatas=array();
			$rdid=array();
			
			if($make!='All' && $make!=null)
			$cdk=$cdk." and scrapedata.Make='$make'";
			
			if($model!='All' && $model!=null)
			$cdk=$cdk." and scrapedata.Model='$model'";
			
			if($year!='All' && $year!=null)
			$cdk=$cdk." and scrapedata.Model_Year='$year'";
			
			if($start_price!='All'&&$start_price!=null&&$end_price!='All'&&$end_price!=null)
	        $cdk=$cdk." and scrapedata.List_Price BETWEEN '$start_price' AND '$end_price'"; 
			
			if($pricerag!='All'&&$pricerag=='DESC')
			{
			$cdk=$cdk." and Image_URL_Pattern!='' ORDER BY "; 
 
			$cdk=$cdk." scrapedata.List_Price DESC "; 
			}
			if(($Year_from!='Any'&&$Year_to!='Any')&&($Year_from!=null&&$Year_to!=null))
			{
			$cdk=$cdk." and CAST( REPLACE(REPLACE( scrapedata.Model_Year, ',', '' ),'$','') AS DECIMAL )
			BETWEEN '$Year_from' and '$Year_to'";
			}
			if(($Mileage1!='Any'&&$Mileage2!='Any')&&($Mileage1!=null&&$Mileage2!=null))
			{
			$cdk=$cdk." and CAST( REPLACE(REPLACE( scrapedata.Odometer, ',', '' ),'$','') AS DECIMAL )
			BETWEEN '$Mileage1' and '$Mileage2'";
			}
			
			if($Distance_Sort=='MintoMax'|| $Distance_Sort=='MaxtoMin'){
				if($Distance_Sort=='MintoMax'){
				$cdk=$cdk." ORDER BY scrapedata.Odometer ASC, RAND() limit $count,30";
					}
					elseif($Distance_Sort=='MaxtoMin'){
					$cdk=$cdk." ORDER BY scrapedata.Odometer DESC, RAND() limit $count,30";
				}
			}
			
			
			elseif($Distance_Sort=='LowesttoHighest'|| $Distance_Sort=='HighesttoLowest'){
				if($Distance_Sort=='LowesttoHighest'){
				$cdk=$cdk." ORDER BY scrapedata.List_Price ASC, RAND() limit $count,30";
					}
					elseif($Distance_Sort=='HighesttoLowest'){
					$cdk=$cdk." ORDER BY scrapedata.List_Price DESC, RAND() limit $count,30";
				}
			}
			
			elseif($Distance_Sort=='OldesttoNewest'|| $Distance_Sort=='NewesttoOldest'){
				if($Distance_Sort=='OldesttoNewest'){
				$cdk=$cdk." ORDER BY scrapedata.Model_Year ASC, RAND() limit $count,30";
					}
					elseif($Distance_Sort=='NewesttoOldest'){
					$cdk=$cdk." ORDER BY scrapedata.Model_Year DESC, RAND() limit $count,30";
				}
			}
			else{
			$cdk=$cdk." and Image_URL_Pattern!='' ORDER BY "; 
 
			$cdk=$cdk." `Last_Modified_Date` DESC,RAND() limit $count,30"; 
			}
			$stmt4 = $db->query($cdk);
			$rdid =  $stmt4->fetchAll(); 
				foreach ( $rdid as $rfinaldatass ) {
						$rfinaldatas [] = $rfinaldatass;
						}
			return $rfinaldatas;
		}
		
		/*--------------------website filter ----------------------*/
		
		/* public function getcardataweb($make,$model,$type,$start_price,$end_price,$pricerag,$Year_between,$Year_from,$Year_to,$mileage_range,$Mileage1,$Mileage2,$page,$Distance_Sort){
		
			$db =Zend_Db_Table_Abstract::getDefaultAdapter();
			
			$cdk = "SELECT scrapedata.VIN as Adv_ID, scrapedata.VIN, scrapedata.Stock_Number, scrapedata.Dealer_ID, scrapedata.Make, scrapedata.Model, scrapedata.Model_Year as Year, scrapedata.Odometer as Mileage, scrapedata.Transmission_Description as Transmission,scrapedata.Exterior_Base_Color as Exterior_Color, scrapedata.Interior_Base_Color as Interior_Color, scrapedata.Stock_Type, scrapedata.Image_URL_Pattern as Banner_Image, scrapedata.Offer_Price,scrapedata.MSRP,scrapedata.List_Price, user_account.City,user_account.Phone FROM scrapedata 
			INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID WHERE scrapedata.Image_URL_Pattern!=''";
			$rfinaldatas=array();
			$rdid=array();
			
			if($make!='All' && $make!=null)
			$cdk=$cdk." and scrapedata.Make='$make'";
			
			if($model!='All' && $model!=null)
			$cdk=$cdk." and scrapedata.Model='$model'";
			
			if($type!='All' && $type!=null)
			$cdk=$cdk." and scrapedata.Stock_Type='$type'";
			
			if($year!='All' && $year!=null)
			$cdk=$cdk." and scrapedata.Model_Year='$year'"; 
			
			if($transmission!='All' && $transmission!=null)
			$cdk=$cdk." and scrapedata.Transmission_Description='$transmission'"; 
			
			if($start_price!='All'&&$start_price!=null&&$end_price!='All'&&$end_price!=null)
	        $cdk=$cdk." and scrapedata.List_Price BETWEEN '$start_price' AND '$end_price'"; 
			
			if($pricerag!='All'&&$pricerag=='DESC')
			{
			$cdk=$cdk." and Image_URL_Pattern!='' ORDER BY "; 
 
			$cdk=$cdk." scrapedata.List_Price DESC "; 
			}
			if(($Year_from!='Any'&&$Year_to!='Any')&&($Year_from!=null&&$Year_to!=null))
			{
			$cdk=$cdk." and CAST( REPLACE(REPLACE( scrapedata.Model_Year, ',', '' ),'$','') AS DECIMAL )
			BETWEEN '$Year_from' and '$Year_to'";
			}
			if(($Mileage1!='Any'&&$Mileage2!='Any')&&($Mileage1!=null&&$Mileage2!=null))
			{
			$cdk=$cdk." and CAST( REPLACE(REPLACE( scrapedata.Odometer, ',', '' ),'$','') AS DECIMAL )
			BETWEEN '$Mileage1' and '$Mileage2'";
			}
			
			if($Distance_Sort=='Min_to_Max'|| $Distance_Sort=='Max_to_Min'){
				if($Distance_Sort=='Min_to_Max'){
				$cdk=$cdk." ORDER BY scrapedata.Odometer ASC, RAND() limit $page,20";
					}
					elseif($Distance_Sort=='Max_to_Min'){
					$cdk=$cdk." ORDER BY scrapedata.Odometer DESC, RAND() limit $page,20";
				}
			}
			
			
			elseif($Distance_Sort=='Lowest_to_Highest'|| $Distance_Sort=='Highest_to_Lowest'){
				if($Distance_Sort=='Lowest_to_Highest'){
				$cdk=$cdk." ORDER BY scrapedata.List_Price ASC, RAND() limit $page,20";
					}
					elseif($Distance_Sort=='Highest_to_Lowest'){
					$cdk=$cdk." ORDER BY scrapedata.List_Price DESC, RAND() limit $page,20";
				}
			}
			
			elseif($Distance_Sort=='Oldest_to_Newest'|| $Distance_Sort=='Newest_to_Oldest'){
				if($Distance_Sort=='Oldest_to_Newest'){
				$cdk=$cdk." ORDER BY scrapedata.Model_Year ASC, RAND() limit $page,20";
					}
					elseif($Distance_Sort=='Newest_to_Oldest'){
					$cdk=$cdk." ORDER BY scrapedata.Model_Year DESC, RAND() limit $page,20";
				}
			}
			else{
			$cdk=$cdk." and Image_URL_Pattern!='' ORDER BY "; 
 
			$cdk=$cdk." `Last_Modified_Date` ASC,RAND() limit $page,20"; 
			}
			$stmt4 = $db->query($cdk);
			$rdid =  $stmt4->fetchAll(); 
				foreach ( $rdid as $rfinaldatass ) {
						$rfinaldatas [] = $rfinaldatass;
						}
			return $rfinaldatas;
		} */
		
		public function nonlocationsort($make,$model,$type,$start_price,$end_price,$pricerag,$Year_between,$Year_from,$Year_to,$mileage_range,$Mileage1,$Mileage2,$page,$Distance_Sort){
				$db =Zend_Db_Table_Abstract::getDefaultAdapter();
				//echo $type;
				//echo $Distance_Sort;
				$cdk = "SELECT scrapedata.VIN as Adv_ID, scrapedata.VIN, scrapedata.Stock_Number, scrapedata.Dealer_ID, scrapedata.Make, scrapedata.Model, scrapedata.Model_Year as Year, scrapedata.Odometer as Mileage, scrapedata.Transmission_Description as Transmission,scrapedata.Exterior_Base_Color as Exterior_Color, scrapedata.Interior_Base_Color as Interior_Color, scrapedata.Stock_Type, scrapedata.Image_URL_Pattern as Banner_Image, scrapedata.Offer_Price,scrapedata.MSRP,scrapedata.List_Price, user_account.City,user_account.Phone FROM scrapedata 
				INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID WHERE scrapedata.Image_URL_Pattern!=''";
			
			
				if($make!='All' && $make!=null)
				$cdk=$cdk." and scrapedata.Make='$make'";
			
				if($model!='All' && $model!=null)
				$cdk=$cdk." and scrapedata.Model='$model'";
			
				if($type!='All' && $type!=null)
				$cdk=$cdk." and scrapedata.Stock_Type='$type'";
				
				if($start_price!='All'&&$start_price!=null&&$end_price!='All'&&$end_price!=null)
				$cdk=$cdk." and scrapedata.List_Price >= '$start_price' AND scrapedata.List_Price <= '$end_price'"; 
			
				if($Year_from!='All'&&$Year_from!=null&&$Year_to!='All'&&$Year_to!=null)
				$cdk=$cdk." and scrapedata.Model_Year >= '$Year_from' AND scrapedata.Model_Year <= '$Year_to'"; 
			
				if($Mileage1!='All'&&$Mileage1!=null&&$Mileage2!='All'&&$Mileage2!=null)
				$cdk=$cdk." and scrapedata.Odometer >= '$Mileage1' AND scrapedata.Odometer <= '$Mileage2'"; 
				
				if($Distance_Sort=="Oldest_to_Newest"){
					$currentyear=date('Y');
				$cdk=$cdk." and scrapedata.Model_Year >= '1960' AND scrapedata.Model_Year <= '$currentyear' ORDER BY scrapedata.Model_Year ASC limit $page,20";	
				}elseif($Distance_Sort=="Newest_to_Oldest"){
					$currentyear1=date('Y');
					$cdk=$cdk." and scrapedata.Model_Year >= '1960' AND scrapedata.Model_Year <= '$currentyear1' ORDER BY scrapedata.Model_Year DESC limit $page,20";	
				}
				elseif($Distance_Sort=="Lowest_to_Highest"){
					//echo "coming :".$Distance_Sort;
				$cdk=$cdk." and scrapedata.List_Price >= '100.00' AND scrapedata.List_Price <= '150000.00' ORDER BY scrapedata.List_Price ASC limit $page,20";	
				}elseif($Distance_Sort=="Highest_to_Lowest"){
					$cdk=$cdk." and scrapedata.List_Price >= '100.00' AND scrapedata.List_Price <= '150000.00' ORDER BY scrapedata.List_Price DESC limit $page,20";	
				}
				elseif($Distance_Sort=="Min_to_Max"){
				$cdk=$cdk." and scrapedata.Odometer >= '100' AND scrapedata.Odometer <= '50000' ORDER BY scrapedata.Odometer ASC limit $page,20";	
				}elseif($Distance_Sort=="Max_to_Min"){
					$cdk=$cdk." and scrapedata.Odometer >= '100' AND scrapedata.Odometer <= '50000' ORDER BY scrapedata.Odometer DESC limit $page,20";	
				}
				else{
				$cdk=$cdk." and Image_URL_Pattern!='' ORDER BY "; 
 
				$cdk=$cdk." `Last_Modified_Date` ASC,RAND() limit $page,20"; 
				}
				//echo $cdk;
				$result = $db->query($cdk);
				$finalresult =  $result->fetchAll();
				return $finalresult; 
				//echo json_encode($finalresult);
				 
			}
		
		/* public function countdatamake($make,$model,$type,$start_price,$end_price,$pricerag,$Year_between,$Year_from,$Year_to,$mileage_range,$Mileage1,$Mileage2){
			$db =Zend_Db_Table_Abstract::getDefaultAdapter();
			$cdk = "SELECT COUNT(*)FROM scrapedata where Image_URL_Pattern!=''";
			$rfinaldatas=array();
			$rdid=array();
			$resultdata=0;
			
			if($make!='All' && $make!=null)
			$cdk=$cdk." and scrapedata.Make='$make'";
			
			if($model!='All' && $model!=null)
			$cdk=$cdk." and scrapedata.Model='$model'";
			
			if($year!='All' && $year!=null)
			$cdk=$cdk." and scrapedata.Model_Year='$year'"; 
			
			if($type!='All' && $type!=null)
			$cdk=$cdk." and scrapedata.Stock_Type='$type'";
			
			if($start_price!='All'&&$start_price!=null&&$end_price!='All'&&$end_price!=null)
	        $cdk=$cdk." and scrapedata.List_Price BETWEEN '$start_price' AND '$end_price'"; 
			
			if($pricerag!='All'&&$pricerag=='DESC')
			{
			$cdk=$cdk." and Image_URL_Pattern!='' ORDER BY "; 
 
			$cdk=$cdk." scrapedata.List_Price DESC "; 
			}
			if(($Year_from!='Any'&&$Year_to!='Any')&&($Year_from!=null&&$Year_to!=null))
			{
			$cdk=$cdk." and CAST( REPLACE(REPLACE( scrapedata.Model_Year, ',', '' ),'$','') AS DECIMAL )
			BETWEEN '$Year_from' and '$Year_to'";
			}
			if(($Mileage1!='Any'&&$Mileage2!='Any')&&($Mileage1!=null&&$Mileage2!=null))
			{
			$cdk=$cdk." and CAST( REPLACE(REPLACE( scrapedata.Odometer, ',', '' ),'$','') AS DECIMAL )
			BETWEEN '$Mileage1' and '$Mileage2'";
			}
			 
			$stmt4 = $db->query($cdk);
			$rdid =  $stmt4->fetchAll(); 
				 
			foreach($rdid as $datamake){
			foreach($datamake as $listdata){
				$resultdata = $listdata;
			}
		}
		
			//echo json_encode($rdid);
			return $resultdata;
		} */
		
		public function nonlocationsortcount($make,$model,$type,$start_price,$end_price,$pricerag,$Year_between,$Year_from,$Year_to,$mileage_range,$Mileage1,$Mileage2,$Distance_Sort){
			$db =Zend_Db_Table_Abstract::getDefaultAdapter();
			$cdk = "SELECT COUNT(*)FROM scrapedata where Image_URL_Pattern!=''";
			$rfinaldatas=array();
			$rdid=array();
			$resultdata=0;
			
			if($make!='All' && $make!=null)
			$cdk=$cdk." and scrapedata.Make='$make'";
			
			if($model!='All' && $model!=null)
			$cdk=$cdk." and scrapedata.Model='$model'";
			
			/* if($year!='All' && $year!=null)
			$cdk=$cdk." and scrapedata.Model_Year='$year'"; */
			
			if($type!='All' && $type!=null)
			$cdk=$cdk." and scrapedata.Stock_Type='$type'";
			
			if($start_price!='All'&&$start_price!=null&&$end_price!='All'&&$end_price!=null)
			$cdk=$cdk." and scrapedata.List_Price >= '$start_price' AND scrapedata.List_Price <= '$end_price'"; 
			
			/* if($pricerag!='All'&&$pricerag=='DESC')
			{
			$cdk=$cdk." and Image_URL_Pattern!='' ORDER BY "; 
 
			$cdk=$cdk." scrapedata.List_Price DESC "; 
			} */
			/* if(($Year_from!='Any'&&$Year_to!='Any')&&($Year_from!=null&&$Year_to!=null))
			{
			$cdk=$cdk." and CAST( REPLACE(REPLACE( scrapedata.Model_Year, ',', '' ),'$','') AS DECIMAL )
			BETWEEN '$Year_from' and '$Year_to'";
			}
			if(($Mileage1!='Any'&&$Mileage2!='Any')&&($Mileage1!=null&&$Mileage2!=null))
			{
			$cdk=$cdk." and CAST( REPLACE(REPLACE( scrapedata.Odometer, ',', '' ),'$','') AS DECIMAL )
			BETWEEN '$Mileage1' and '$Mileage2'";
			} */
			if($Year_from!='All'&&$Year_from!=null&&$Year_to!='All'&&$Year_to!=null)
			$cdk=$cdk." and scrapedata.Model_Year >= '$Year_from' AND scrapedata.Model_Year <= '$Year_to'"; 
			
			if($Mileage1!='All'&&$Mileage1!=null&&$Mileage2!='All'&&$Mileage2!=null)
			$cdk=$cdk." and scrapedata.Odometer >= '$Mileage1' AND scrapedata.Odometer <= '$Mileage2'"; 
			
			if($Distance_Sort=="Oldest_to_Newest"){
				$currentyear=date('Y');
				$cdk=$cdk." and scrapedata.Model_Year >= '1960' AND scrapedata.Model_Year <= '$currentyear' ORDER BY scrapedata.Model_Year ASC ";	
				}elseif($Distance_Sort=="Newest_to_Oldest"){
					$currentyear1=date('Y');
					$cdk=$cdk." and scrapedata.Model_Year >= '1960' AND scrapedata.Model_Year <= '$currentyear1' ORDER BY scrapedata.Model_Year DESC ";	
				}
				elseif($Distance_Sort=="Lowest_to_Highest"){
					
				$cdk=$cdk." and scrapedata.List_Price >= '100.00' AND scrapedata.List_Price <= '150000.00' ORDER BY scrapedata.List_Price ASC ";	
				}elseif($Distance_Sort=="Highest_to_Lowest"){
					$cdk=$cdk." and scrapedata.List_Price >= '100.00' AND scrapedata.List_Price <= '150000.00' ORDER BY scrapedata.List_Price DESC ";	
				}
				elseif($Distance_Sort=="Min_to_Max"){
				$cdk=$cdk." and scrapedata.Odometer >= '100' AND scrapedata.Odometer <= '50000' ORDER BY scrapedata.Odometer ASC ";	
				}elseif($Distance_Sort=="Max_to_Min"){
					$cdk=$cdk." and scrapedata.Odometer >= '100' AND scrapedata.Odometer <= '50000' ORDER BY scrapedata.Odometer DESC ";	
				}
			 
			$stmt4 = $db->query($cdk);
			$rdid =  $stmt4->fetchAll(); 
				 /* foreach ( $rdid as $rfinaldatass ) {
						$rfinaldatas [] = $rfinaldatass;
						}  */
			foreach($rdid as $datamake){
				foreach($datamake as $listdata){
					$resultdata = $listdata;
				}
			}
		
			//echo json_encode($rdid);
			return $resultdata;
		}
		
		public function locationsorting($lat, $lng, $radius,$make,$model,$type,$start_price,$end_price,$pricerag,$Year_between,$Year_from,$Year_to,$mileage_range,$Mileage1,$Mileage2,$Distance_Sort){
			$db =Zend_Db_Table_Abstract::getDefaultAdapter();
			$final = $this->getDealerFromRadius ( $lat, $lng, $radius );

			$datacount = count($final);
			$rcdkdata = array ();
			$rfinaldatas = array ();
			for($i=0;$i<$datacount;$i++){
			//if($i<6){
			$datavalue=$final[$i]; 
			
			//$rcdk = "SELECT scrapedata.VIN, scrapedata.Stock_Number, scrapedata.Dealer_ID, scrapedata.Make, scrapedata.Model, scrapedata.Model_Year as Year, scrapedata.Odometer as Mileage,scrapedata.Transmission_Description as Transmission, scrapedata.Exterior_Base_Color as Exterior_Color, scrapedata.Interior_Base_Color as Interior_Color, scrapedata.Stock_Type, scrapedata.Image_URL_Pattern as Banner_Image,scrapedata.Offer_Price,scrapedata.MSRP,scrapedata.List_Price,user_account.City,user_account.Phone FROM scrapedata  INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID WHERE scrapedata.Dealer_ID ='$datavalue'"; 
			$rcdk = "SELECT DISTINCT scrapedata.VIN, scrapedata.Stock_Number, scrapedata.Dealer_ID, scrapedata.Make, scrapedata.Model, scrapedata.Model_Year as Year, scrapedata.Odometer as Mileage,scrapedata.Transmission_Description as Transmission, scrapedata.Exterior_Base_Color as Exterior_Color, scrapedata.Interior_Base_Color as Interior_Color, scrapedata.Stock_Type, scrapedata.Image_URL_Pattern as Banner_Image,scrapedata.Offer_Price,scrapedata.MSRP,scrapedata.List_Price,user_account.City,user_account.Phone FROM scrapedata  INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID WHERE scrapedata.Dealer_ID ='$datavalue'"; 
			
			if($make!='All' && $make!=null)
			$rcdk=$rcdk." and scrapedata.Make='$make'";
		
			if($model!='All' && $model!=null)
			$rcdk=$rcdk." and scrapedata.Model='$model'";
		
			if($type!='All' && $type!=null)
			$rcdk=$rcdk." and scrapedata.Stock_Type='$type'";
		
			if($start_price!='All'&&$start_price!=null&&$end_price!='All'&&$end_price!=null)
			$rcdk=$rcdk." and scrapedata.List_Price >= '$start_price' AND scrapedata.List_Price <= '$end_price'"; 
			
			if($Year_from!='All'&&$Year_from!=null&&$Year_to!='All'&&$Year_to!=null)
			$rcdk=$rcdk." and scrapedata.Model_Year >= '$Year_from' AND scrapedata.Model_Year <= '$Year_to'"; 
		
			if($Mileage1!='All'&&$Mileage1!=null&&$Mileage2!='All'&&$Mileage2!=null)
			$rcdk=$rcdk." and scrapedata.Odometer >= '$Mileage1' AND scrapedata.Odometer <= '$Mileage2'"; 
			
			if($Distance_Sort=="Oldest_to_Newest"){
				//echo "coming :".$Distance_Sort;
				$currentyear=date('Y');
				$rcdk=$rcdk." and scrapedata.Model_Year >= '1960' AND scrapedata.Model_Year <= '$currentyear' ORDER BY scrapedata.Model_Year ASC ";	
				}elseif($Distance_Sort=="Newest_to_Oldest"){
					$currentyear1=date('Y');
					$rcdk=$rcdk." and scrapedata.Model_Year >= '1960' AND scrapedata.Model_Year <= '$currentyear1' ORDER BY scrapedata.Model_Year DESC ";	
				}
				elseif($Distance_Sort=="Lowest_to_Highest"){
				$rcdk=$rcdk." and scrapedata.List_Price >= '100.00' AND scrapedata.List_Price <= '150000.00' ORDER BY scrapedata.List_Price ASC ";	
				}elseif($Distance_Sort=="Highest_to_Lowest"){
					//echo "coming :".$Distance_Sort;
					$rcdk=$rcdk." and scrapedata.List_Price >= '100.00' AND scrapedata.List_Price <= '150000.00' ORDER BY scrapedata.List_Price DESC ";	
				}
				elseif($Distance_Sort=="Min_to_Max"){
				$rcdk=$rcdk." and scrapedata.Odometer >= '100' AND scrapedata.Odometer <= '50000' ORDER BY scrapedata.Odometer ASC ";	
				}elseif($Distance_Sort=="Max_to_Min"){
					$rcdk=$rcdk." and scrapedata.Odometer >= '100' AND scrapedata.Odometer <= '50000' ORDER BY scrapedata.Odometer DESC ";	
				}
				
			
			else{ 
			$rcdk=$rcdk." and Image_URL_Pattern!='' ORDER BY "; 
 
			$rcdk=$rcdk." `Last_Modified_Date` ASC,RAND() "; 
			}
			//echo $rcdk; 
			$stmt = $db->query($rcdk);
			$rcdkdata =  $stmt->fetchAll();
			
			//}
			foreach ( $rcdkdata as $rfinaldatass ) {
						$rfinaldatas [] = $rfinaldatass;
				} 
			}
			
			$size = count($rfinaldatas)-1;
			if($Distance_Sort=="Min_to_Max"){
				for ($i=0; $i<$size; $i++) {
				for ($j=0; $j<$size-$i; $j++) { 
				$k = $j+1;
					if ($rfinaldatas[$k]['Mileage'] < $rfinaldatas[$j]['Mileage']) {
					// Swap elements at indices: $j, $k
					list($rfinaldatas[$j]['Mileage'], $rfinaldatas[$k]['Mileage']) = array($rfinaldatas[$k]['Mileage'], $rfinaldatas[$j]['Mileage']);
						}
					}
				}
			}elseif($Distance_Sort=="Max_to_Min"){
				for ($i=0; $i<$size; $i++) {
				for ($j=0; $j<$size-$i; $j++) {
				$k = $j+1;
					if ($rfinaldatas[$k]['Mileage'] > $rfinaldatas[$j]['Mileage']) {
					// Swap elements at indices: $j, $k
					list($rfinaldatas[$j]['Mileage'], $rfinaldatas[$k]['Mileage']) = array($rfinaldatas[$k]['Mileage'], $rfinaldatas[$j]['Mileage']);
						}
					}
				}
			}elseif($Distance_Sort=="Lowest_to_Highest"){
				//echo "coming :".$Distance_Sort;
				for ($i=0; $i<$size; $i++) {
				for ($j=0; $j<$size-$i; $j++) {
				$k = $j+1;
					if ($rfinaldatas[$k]['List_Price'] < $rfinaldatas[$j]['List_Price']) {
					// Swap elements at indices: $j, $k
					list($rfinaldatas[$j]['List_Price'], $rfinaldatas[$k]['List_Price']) = array($rfinaldatas[$k]['List_Price'], $rfinaldatas[$j]['List_Price']);
						}
					}
				}
			}elseif($Distance_Sort=="Highest_to_Lowest"){
				for ($i=0; $i<$size; $i++) {
				for ($j=0; $j<$size-$i; $j++) {
				$k = $j+1;
					if ($rfinaldatas[$k]['List_Price'] > $rfinaldatas[$j]['List_Price']) {
					// Swap elements at indices: $j, $k
					list($rfinaldatas[$j]['List_Price'], $rfinaldatas[$k]['List_Price']) = array($rfinaldatas[$k]['List_Price'], $rfinaldatas[$j]['List_Price']);
						}
					}
				}
			}elseif($Distance_Sort=="Oldest_to_Newest"){
				for ($i=0; $i<$size; $i++) {
				for ($j=0; $j<$size-$i; $j++) {
				$k = $j+1;
					if ($rfinaldatas[$k]['Year'] < $rfinaldatas[$j]['Year']) {
					// Swap elements at indices: $j, $k
					list($rfinaldatas[$j]['Year'], $rfinaldatas[$k]['Year']) = array($rfinaldatas[$k]['Year'], $rfinaldatas[$j]['Year']);
						}
					}
				}
			}elseif($Distance_Sort=="Newest_to_Oldest"){
				for ($i=0; $i<$size; $i++) {
				for ($j=0; $j<$size-$i; $j++) {
				$k = $j+1;
					if ($rfinaldatas[$k]['Year'] > $rfinaldatas[$j]['Year']) {
					// Swap elements at indices: $j, $k
					list($rfinaldatas[$j]['Year'], $rfinaldatas[$k]['Year']) = array($rfinaldatas[$k]['Year'], $rfinaldatas[$j]['Year']);
						}
					}
				}
			}
		
			return $rfinaldatas;
			//echo json_encode($rfinaldatas);
		} 
		
		
		/* public function getDealerFromLocationweb($lat, $lng, $radius,$make,$model,$type,$start_price,$end_price,$pricerag,$Year_between,$Year_from,$Year_to,$mileage_range,$Mileage1,$Mileage2,$Distance_Sort) {
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$final = $this->getDealerFromRadius ( $lat, $lng, $radius );
		//echo json_encode($final);
		$datacount = count($final);
		$rcdkdata = array ();
		$rfinaldatas = array ();
		for($i=0;$i<$datacount;$i++){
			//if($i<6){
			$datavalue=$final[$i];
			
			//$rcdk = "SELECT scrapedata.VIN, scrapedata.Stock_Number, scrapedata.Dealer_ID, scrapedata.Make, scrapedata.Model, scrapedata.Model_Year as Year, scrapedata.Odometer as Mileage,scrapedata.Transmission_Description as Transmission, scrapedata.Exterior_Base_Color as Exterior_Color, scrapedata.Interior_Base_Color as Interior_Color, scrapedata.Stock_Type, scrapedata.Image_URL_Pattern as Banner_Image,scrapedata.Offer_Price,scrapedata.MSRP,scrapedata.List_Price,user_account.City,user_account.Phone FROM scrapedata  INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID WHERE scrapedata.Dealer_ID ='$datavalue'"; 
			$rcdk = "SELECT DISTINCT scrapedata.VIN, scrapedata.Stock_Number, scrapedata.Dealer_ID, scrapedata.Make, scrapedata.Model, scrapedata.Model_Year as Year, scrapedata.Odometer as Mileage,scrapedata.Transmission_Description as Transmission, scrapedata.Exterior_Base_Color as Exterior_Color, scrapedata.Interior_Base_Color as Interior_Color, scrapedata.Stock_Type, scrapedata.Image_URL_Pattern as Banner_Image,scrapedata.Offer_Price,scrapedata.MSRP,scrapedata.List_Price,user_account.City,user_account.Phone FROM scrapedata  INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID WHERE scrapedata.Dealer_ID ='$datavalue'"; 
			
			 if($make!='All' && $make!=null)
			$rcdk=$rcdk." and scrapedata.Make='$make'";
			
			if($model!='All' && $model!=null)
			$rcdk=$rcdk." and scrapedata.Model='$model'";
			
			if($year!='All' && $year!=null)
			$rcdk=$rcdk." and scrapedata.Model_Year='$year'";
		
			if($type!='All' && $type!=null)
			$rcdk=$rcdk." and scrapedata.Stock_Type='$type'";
			
			if($transmission!='All' && $transmission!=null)
			$rcdk=$rcdk." and scrapedata.Transmission_Description='$transmission'"; 
			
			if($start_price!='All'&&$start_price!=null&&$end_price!='All'&&$end_price!=null)
	        $rcdk=$rcdk." and scrapedata.List_Price BETWEEN '$start_price' AND '$end_price'"; 
			
			if($pricerag!='All'&&$pricerag=='DESC')
			{
			$rcdk=$rcdk." and Image_URL_Pattern!='' ORDER BY "; 
 
			$rcdk=$rcdk." scrapedata.List_Price DESC "; 
			}
			if(($Year_from!='Any'&&$Year_to!='Any')&&($Year_from!=null&&$Year_to!=null))
			{
			$rcdk=$rcdk." and CAST( REPLACE(REPLACE( scrapedata.Model_Year, ',', '' ),'$','') AS DECIMAL )
			BETWEEN '$Year_from' and '$Year_to'";
			}
			
			if(($Mileage1!='Any'&&$Mileage2!='Any')&&($Mileage1!=null&&$Mileage2!=null))
			{
			$rcdk=$rcdk." and CAST( REPLACE(REPLACE( scrapedata.Odometer, ',', '' ),'$','') AS DECIMAL )
			BETWEEN '$Mileage1' and '$Mileage2'";
			}
			
			if($Distance_Sort=='Min_to_Max'|| $Distance_Sort=='Max_to_Min'){
				if($Distance_Sort=='Min_to_Max'){
				$rcdk=$rcdk." ORDER BY scrapedata.Odometer ASC, RAND() ";
					}
					elseif($Distance_Sort=='Max_to_Min'){
					$rcdk=$rcdk." ORDER BY scrapedata.Odometer DESC, RAND() ";
				}
			}
			
			
			elseif($Distance_Sort=='Lowest_to_Highest'|| $Distance_Sort=='Highest_to_Lowest'){
				if($Distance_Sort=='Lowest_to_Highest'){
				$rcdk=$rcdk." ORDER BY scrapedata.List_Price ASC, RAND()  ";
					}
					elseif($Distance_Sort=='Highest_to_Lowest'){
					$rcdk=$rcdk." ORDER BY scrapedata.List_Price DESC, RAND() ";
				}
			}
			
			elseif($Distance_Sort=='Oldest_to_Newest'|| $Distance_Sort=='Newest_to_Oldest'){
				if($Distance_Sort=='Oldest_to_Newest'){
				$rcdk=$rcdk." ORDER BY scrapedata.Model_Year ASC, RAND() ";
					}
					elseif($Distance_Sort=='Newest_to_Oldest'){
					$rcdk=$rcdk." ORDER BY scrapedata.Model_Year DESC, RAND() ";
				}
			}
			
			else{ 
			$rcdk=$rcdk." and Image_URL_Pattern!='' ORDER BY "; 
 
			$rcdk=$rcdk." `Last_Modified_Date` ASC,RAND() "; 
			}
			//echo $rcdk; 
			$stmt = $db->query($rcdk);
			$rcdkdata =  $stmt->fetchAll();
			
			//}
			foreach ( $rcdkdata as $rfinaldatass ) {
						$rfinaldatas [] = $rfinaldatass;
			}
		
		}
		
		return $rfinaldatas;
		//echo json_encode($rfinaldatas);  
		}   */
		
		
		/* public function countdataloc($lat, $lng, $radius,$make,$model,$type,$start_price,$end_price,$pricerag,$Year_between,$Year_from,$Year_to,$mileage_range,$Mileage1,$Mileage2) {
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$final = $this->getDealerFromRadius ( $lat, $lng, $radius );
		//echo json_encode($final);
		$datacount = count($final);
		$rfinaldatas=array();
		$rdid = array ();
		$listcount = array ();
		$resultdata=0;
		for($i=0;$i<$datacount;$i++){
			$datavalue=$final[$i];
			//$rcdk = "SELECT COUNT(*)FROM scrapedata WHERE Dealer_ID='$datavalue'";
			$rcdk = "SELECT COUNT(DISTINCT scrapedata.VIN) FROM scrapedata WHERE Dealer_ID='$datavalue'";
			
			if($make!='All' && $make!=null)
			$rcdk=$rcdk." and scrapedata.Make='$make'";
			
			if($model!='All' && $model!=null)
			$rcdk=$rcdk." and scrapedata.Model='$model'";
			
			if($year!='All' && $year!=null)
			$rcdk=$rcdk." and scrapedata.Model_Year='$year'";
			
			if($type!='All' && $type!=null)
			$rcdk=$rcdk." and scrapedata.Stock_Type='$type'";
			
			if($start_price!='All'&&$start_price!=null&&$end_price!='All'&&$end_price!=null)
	        $rcdk=$rcdk." and scrapedata.List_Price BETWEEN '$start_price' AND '$end_price'"; 
			
			if($pricerag!='All'&&$pricerag=='DESC')
			{
			$rcdk=$rcdk." and Image_URL_Pattern!='' ORDER BY "; 
 
			$rcdk=$rcdk." scrapedata.List_Price DESC "; 
			}
			if(($Year_from!='Any'&&$Year_to!='Any')&&($Year_from!=null&&$Year_to!=null))
			{
			$rcdk=$rcdk." and CAST( REPLACE(REPLACE( scrapedata.Model_Year, ',', '' ),'$','') AS DECIMAL )
			BETWEEN '$Year_from' and '$Year_to'";
			}
			if(($Mileage1!='Any'&&$Mileage2!='Any')&&($Mileage1!=null&&$Mileage2!=null))
			{
			$rcdk=$rcdk." and CAST( REPLACE(REPLACE( scrapedata.Odometer, ',', '' ),'$','') AS DECIMAL )
			BETWEEN '$Mileage1' and '$Mileage2'";
			}
		
			$stmt4 = $db->query($rcdk);
			$rdid =  $stmt4->fetchAll(); 
			foreach($rdid as $dataresult){
			$listcount[] = $dataresult;
			}
		}
		foreach($listcount as $datamake){
			foreach($datamake as $listdata){
				//$listdata.'<br>';
				$resultdata += $listdata;
			}
		}
		return $resultdata;
		//echo $resultdata;
		//echo json_encode($resultdata);
			
	} */
	
	
	public function countdataloc($lat, $lng, $radius,$make,$model,$type,$start_price,$end_price,$pricerag,$Year_between,$Year_from,$Year_to,$mileage_range,$Mileage1,$Mileage2,$Distance_Sort) {
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$final = $this->getDealerFromRadius ( $lat, $lng, $radius );
		//echo json_encode($final);
		$datacount = count($final);
		$rfinaldatas=array();
		$rdid = array ();
		$listcount = array ();
		$resultdata=0;
		for($i=0;$i<$datacount;$i++){
			$datavalue=$final[$i];
			//$rcdk = "SELECT COUNT(*)FROM scrapedata WHERE Dealer_ID='$datavalue'";
			$rcdk = "SELECT COUNT(DISTINCT scrapedata.VIN) FROM scrapedata WHERE Dealer_ID='$datavalue'";
			
			if($make!='All' && $make!=null)
			$rcdk=$rcdk." and scrapedata.Make='$make'";
			
			if($model!='All' && $model!=null)
			$rcdk=$rcdk." and scrapedata.Model='$model'";
			
			/*if($year!='All' && $year!=null)
			$rcdk=$rcdk." and scrapedata.Model_Year='$year'";*/
			
			if($type!='All' && $type!=null)
			$rcdk=$rcdk." and scrapedata.Stock_Type='$type'";
			
			if($start_price!='All'&&$start_price!=null&&$end_price!='All'&&$end_price!=null)
			$rcdk=$rcdk." and scrapedata.List_Price >= '$start_price' AND scrapedata.List_Price <= '$end_price'"; 
			
			if($Year_from!='All'&&$Year_from!=null&&$Year_to!='All'&&$Year_to!=null)
			$rcdk=$rcdk." and scrapedata.Model_Year >= '$Year_from' AND scrapedata.Model_Year <= '$Year_to'"; 
		
			if($Mileage1!='All'&&$Mileage1!=null&&$Mileage2!='All'&&$Mileage2!=null)
			$rcdk=$rcdk." and scrapedata.Odometer >= '$Mileage1' AND scrapedata.Odometer <= '$Mileage2'"; 
			
			if($Distance_Sort=="Oldest_to_Newest"){
				//echo "coming :".$Distance_Sort;
				$currentyear=date('Y');
				$rcdk=$rcdk." and scrapedata.Model_Year >= '1960' AND scrapedata.Model_Year <= '$currentyear' ORDER BY scrapedata.Model_Year ASC ";	
				}elseif($Distance_Sort=="Newest_to_Oldest"){
					$currentyear1=date('Y');
					$rcdk=$rcdk." and scrapedata.Model_Year >= '1960' AND scrapedata.Model_Year <= '$currentyear1' ORDER BY scrapedata.Model_Year DESC ";	
				}
				elseif($Distance_Sort=="Lowest_to_Highest"){
				$rcdk=$rcdk." and scrapedata.List_Price >= '100.00' AND scrapedata.List_Price <= '150000.00' ORDER BY scrapedata.List_Price ASC ";	
				}elseif($Distance_Sort=="Highest_to_Lowest"){
					//echo "coming :".$Distance_Sort;
					$rcdk=$rcdk." and scrapedata.List_Price >= '100.00' AND scrapedata.List_Price <= '150000.00' ORDER BY scrapedata.List_Price DESC ";	
				}
				elseif($Distance_Sort=="Min_to_Max"){
				$rcdk=$rcdk." and scrapedata.Odometer >= '100' AND scrapedata.Odometer <= '50000' ORDER BY scrapedata.Odometer ASC ";	
				}elseif($Distance_Sort=="Max_to_Min"){
					$rcdk=$rcdk." and scrapedata.Odometer >= '100' AND scrapedata.Odometer <= '50000' ORDER BY scrapedata.Odometer DESC ";	
				}
		
			$stmt4 = $db->query($rcdk);
			$rdid =  $stmt4->fetchAll(); 
			foreach($rdid as $dataresult){
			$listcount[] = $dataresult;
			}
		}
		foreach($listcount as $datamake){
			foreach($datamake as $listdata){
				//$listdata.'<br>';
				$resultdata += $listdata;
			}
		}
		return $resultdata;
		//echo $resultdata;
		//echo json_encode($resultdata);
			
	}
		/*---------------------------------------------------------*/
		
		
		
		
		public function cityvalue(){
			$db =Zend_Db_Table_Abstract::getDefaultAdapter();
			$sql= "SELECT user_account.City FROM user_account GROUP by user_account.City";
			$stmt = $db->query($sql);
			$rcdkdata =  $stmt->fetchAll();
			//echo json_encode($rcdkdata);
			return $rcdkdata;
			
		}
		
	public function makelist(){
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$sql = "SELECT scrapedata.Make FROM scrapedata GROUP BY scrapedata.Make";
			$stmt = $db->query($sql);
			$rcdkdata =  $stmt->fetchAll();
			return $rcdkdata;
			//echo json_encode($rcdkdata);
		}
		
	public function makesearchcars($Make,$Dealer_Name,$Dealer_ID){
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$cdk = "SELECT scrapedata.VIN as Adv_ID, scrapedata.VIN, scrapedata.Stock_Number, scrapedata.Dealer_ID, scrapedata.Make, scrapedata.Model, scrapedata.Model_Year as Year, scrapedata.Odometer as Mileage, scrapedata.Exterior_Base_Color as Exterior_Color, scrapedata.Interior_Base_Color as Interior_Color, scrapedata.Stock_Type, scrapedata.Image_URL_Pattern as Banner_Image, scrapedata.Offer_Price,scrapedata.MSRP,scrapedata.List_Price, user_account.Dealer_Name,user_account.Address,user_account.PostalCode,user_account.City,user_account.State,user_account.Dealer_Phone FROM scrapedata 
		INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID";
		
			if($Make!='All' && $Make!=null)
			$cdk=$cdk." and scrapedata.Make='$Make'";
			
			if($Dealer_Name!="" && $Dealer_Name!= null)
			$cdk = $cdk . " and user_account.Dealer_Name like '%$Dealer_Name%'";
			
			if($Dealer_ID!='All' && $Dealer_ID!=null)
			$cdk=$cdk." and scrapedata.Dealer_ID='$Dealer_ID'";
			
			
			//$cdk=$cdk."LIMIT 0,100"; 
			$cdk=$cdk." and Image_URL_Pattern!='' ORDER BY "; 
 
			$cdk=$cdk." `Last_Modified_Date` ASC,RAND() limit 0,100";
		
			$stmt = $db->query($cdk);
			$rcdkdata =  $stmt->fetchAll();
			return $rcdkdata;
			//echo json_encode($rcdkdata);
	}
		
	
		Public function getrecentuploadcars($datayear) {  
		//return "getrecentgetrecent";
		//echo $datayear;
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		
			
	
			$rcdk = "SELECT scrapedata.VIN as Adv_ID, scrapedata.VIN, scrapedata.Stock_Number, scrapedata.Dealer_ID, scrapedata.Make, scrapedata.Model, scrapedata.Model_Year as Year, scrapedata.Odometer as Mileage, scrapedata.Exterior_Base_Color as Exterior_Color, scrapedata.Interior_Base_Color as Interior_Color, scrapedata.Stock_Type, scrapedata.Image_URL_Pattern as Banner_Image,scrapedata.Offer_Price,scrapedata.MSRP,scrapedata.List_Price,user_account.City FROM scrapedata INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID WHERE `Model_Year` ='$datayear' and Image_URL_Pattern!='' ORDER BY `Offer_Price` DESC LIMIT 4";
			 $stmt3= $db->query($rcdk); 
			 $cdkdata =  $stmt3->fetchAll();
			 /* foreach($cdkdata as $cdkfile){
				$rfinaldatas [] = $cdkfile;
					if($rfinaldatas==$datayear){
					return $rfinaldatas;
					}else{
						
			 } */
			 
			 if(!$cdkdata){
			 $currentdate=date("Y");
			 $rcdk = "SELECT scrapedata.VIN as Adv_ID, scrapedata.VIN, scrapedata.Stock_Number, scrapedata.Dealer_ID, scrapedata.Make, scrapedata.Model, scrapedata.Model_Year as Year, scrapedata.Odometer as Mileage, scrapedata.Exterior_Base_Color as Exterior_Color, scrapedata.Interior_Base_Color as Interior_Color, scrapedata.Stock_Type, scrapedata.Image_URL_Pattern as Banner_Image,scrapedata.Offer_Price,scrapedata.MSRP,scrapedata.List_Price,user_account.City FROM scrapedata INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID WHERE `Model_Year` ='$currentdate' and Image_URL_Pattern!='' ORDER BY `Offer_Price` DESC LIMIT 4";
			 $stmt3= $db->query($rcdk); 
			 $cdkdata =  $stmt3->fetchAll();
			 }
			 return $cdkdata;
			 //echo json_encode($cdkdata);
			
		}
		
	public function getdealerdatalist(){
			$db =Zend_Db_Table_Abstract::getDefaultAdapter();
			
			$rcdk = "SELECT scrapedata.VIN as Adv_ID, scrapedata.VIN, scrapedata.Stock_Number, scrapedata.Dealer_ID, scrapedata.Make, scrapedata.Model, scrapedata.Model_Year as Year, scrapedata.Odometer as Mileage, scrapedata.Exterior_Base_Color as Exterior_Color, scrapedata.Interior_Base_Color as Interior_Color, scrapedata.Stock_Type, scrapedata.Image_URL_Pattern as Banner_Image, scrapedata.Offer_Price,scrapedata.MSRP,scrapedata.List_Price,user_account.City FROM scrapedata INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID ORDER BY scrapedata.Offer_Price DESC LIMIT 4";
			
			
			//$rcdk=$rcdk."ORDER BY scrapedata.Offer_Price DESC"; 
			
			
			$stmt4 = $db->query($rcdk);
			$rdid =  $stmt4->fetchAll(); 
			
			foreach ( $rdid as $rfinaldatass ) {
						$rfinaldatas [] = $rfinaldatass;
			}
			return $rfinaldatas;
			//echo json_encode($rfinaldatas);
	}
	
	public function getcarlist($Make,$Model,$Year){
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$rcdk = "SELECT scrapedata.VIN as Adv_ID, scrapedata.VIN, scrapedata.Stock_Number, scrapedata.Dealer_ID, scrapedata.Make, scrapedata.Model, scrapedata.Model_Year as Year, scrapedata.Odometer as Mileage, scrapedata.Exterior_Base_Color as Exterior_Color, scrapedata.Interior_Base_Color as Interior_Color, scrapedata.Stock_Type, scrapedata.Image_URL_Pattern as Banner_Image, scrapedata.Offer_Price,scrapedata.MSRP,scrapedata.List_Price FROM scrapedata WHERE scrapedata.`Make` ='$Make' AND scrapedata.`Model`='$Model' AND scrapedata.`Model_Year`='$Year' LIMIT 1";
			$stmt4 = $db->query($rcdk);
			$rdid =  $stmt4->fetchAll();
			return $rdid[0];
			//echo json_encode($rdid);
			
	}	
	
	public function dealerlist(){
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
			$sql= "SELECT user_account.Dealer_Name FROM user_account GROUP by user_account.Dealer_Name";
			$stmt = $db->query($sql);
			$rcdkdata =  $stmt->fetchAll();
			//echo json_encode($rcdkdata);
			return $rcdkdata;
		}
	public function carmatch($Make,$Model,$Year){
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$rcdk = "SELECT scrapedata.VIN as Adv_ID, scrapedata.VIN, scrapedata.Stock_Number, scrapedata.Dealer_ID, scrapedata.Make, scrapedata.Model, scrapedata.Model_Year as Year, scrapedata.Odometer as Mileage, scrapedata.Exterior_Base_Color as Exterior_Color, scrapedata.Interior_Base_Color as Interior_Color, scrapedata.Stock_Type, scrapedata.Image_URL_Pattern as Banner_Image, scrapedata.Offer_Price,scrapedata.MSRP,scrapedata.List_Price,user_account.City FROM scrapedata INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID WHERE scrapedata.`Make` ='$Make' AND scrapedata.`Model`='$Model' AND scrapedata.`Model_Year`='$Year' ORDER BY RAND(),`List_Price` LIMIT 1";
			$stmt4 = $db->query($rcdk);
			$rdid =  $stmt4->fetchAll();
			return $rdid;
	
	}
	
	public function selectvin($Vin){
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$rcdk = "SELECT scrapedata.VIN as Adv_ID, scrapedata.VIN, scrapedata.Stock_Number, scrapedata.Dealer_ID, scrapedata.Make, scrapedata.Model, scrapedata.Model_Year as Year, scrapedata.Odometer as Mileage, scrapedata.Exterior_Base_Color as Exterior_Color, scrapedata.Interior_Base_Color as Interior_Color, scrapedata.Stock_Type, scrapedata.Image_URL_Pattern as Banner_Image, scrapedata.Offer_Price,scrapedata.MSRP,scrapedata.List_Price FROM scrapedata WHERE scrapedata.`VIN` ='$Vin' LIMIT 1";
			$stmt4 = $db->query($rcdk);
			$rdid =  $stmt4->fetchAll();
			return $rdid;
	}
public function getmakemodelyear(){
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$modelresult=array();
		$yearresult=array();
		  $rcdk = "SELECT Make FROM scrapedata  GROUP BY scrapedata.Make";
		$stmt4 = $db->query($rcdk);
		$rdid =  $stmt4->fetchAll();  
		//$rdid=array("Acura","Audi");
		foreach($rdid as $resultmakes){
		 if($resultmakes['Make']!=""&& $resultmakes['Make']!="null" && $resultmakes['Make']!=null){
		$makedata= $resultmakes['Make'];		
		$modelsresult = array();
		$rcdk = "SELECT Model FROM scrapedata WHERE scrapedata.Make='$makedata'  GROUP BY scrapedata.Model";
			$stmt = $db->query($rcdk);
			$rdidata =  $stmt->fetchAll();
			foreach($rdidata as $resultmodels){
				$modeldata = $resultmodels['Model'];
				$yearresultdata =array();
				$rcdkdata = "SELECT Model_Year FROM scrapedata WHERE scrapedata.Make='$makedata' and scrapedata.Model='$modeldata'  GROUP BY scrapedata.Model_Year";
				$stmt1 = $db->query($rcdkdata);
				$rdidatayear =  $stmt1->fetchAll();
				foreach($rdidatayear as $resultyear){
					$yearedmunds['year'] = $resultyear['Model_Year'];
					$yearresultdata[] = $yearedmunds;
				}
				$modelsedmunds['name'] = $resultmodels['Model'];
				$modelsedmunds['year']=$yearresultdata;
				$modelsresult[] = $modelsedmunds;
			}
		   $modelresult["name"]=$makedata;
		   $modelresult['models']=$modelsresult;
		   $makemodel[]=$modelresult;
		  
		}
			}
			return $makemodel;
		//echo json_encode(array("makes" =>$makemodel));  
	}
	
		Public function showroomcar($datayear) {  
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$rcdk = "SELECT scrapedata.VIN as Adv_ID, scrapedata.VIN, scrapedata.Stock_Number, scrapedata.Dealer_ID, scrapedata.Make, scrapedata.Model, scrapedata.Model_Year as Year, scrapedata.Odometer as Mileage, scrapedata.Exterior_Base_Color as Exterior_Color, scrapedata.Interior_Base_Color as Interior_Color, scrapedata.Stock_Type, scrapedata.Image_URL_Pattern as Banner_Image,scrapedata.Offer_Price,scrapedata.MSRP,scrapedata.List_Price,user_account.City FROM scrapedata INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID WHERE `Model_Year` ='$datayear' and Image_URL_Pattern!='' and List_Price!='0.00' and Odometer!='0.00' ORDER BY RAND() LIMIT 4";
		$stmt3= $db->query($rcdk); 
		$cdkdata =  $stmt3->fetchAll();
		return $cdkdata; 
	}
	
		/*public function locationbasedcars($locationdata){
			//echo $locationdata;
			$db =Zend_Db_Table_Abstract::getDefaultAdapter();
			$final = "select * from scrapedata where scrapedata.Dealer_ID IN (";
		//	$final = "select * from scrapedata where scrapedata.Dealer_ID='$locationdata'";
			$lenth = count($locationdata);
			//echo $lenth;
			//echo $locationdata;
			for ($i = 0; $i < $lenth; $i++) {
				
				if($i==$lenth-1){
					$final = $final.$locationdata[$i].")";
				}else{
					$final = $final.$locationdata[$i].",";
				}
				echo $final;
			}
		
				$result = $db->query($final);
				$finalresult =  $result->fetchAll();
				return $finalresult;   
			}*/
			
			/* public function locationbasedcarlist($locationdata,$count){
				//echo $locationdata; 
				//echo $count;
				$db =Zend_Db_Table_Abstract::getDefaultAdapter();
				$final = "select scrapedata.VIN as Adv_ID, scrapedata.VIN, scrapedata.Stock_Number, scrapedata.Dealer_ID, scrapedata.Make, scrapedata.Model, scrapedata.Model_Year as Year, scrapedata.Odometer as Mileage, scrapedata.Exterior_Base_Color as Exterior_Color, scrapedata.Interior_Base_Color as Interior_Color, scrapedata.Stock_Type, scrapedata.Image_URL_Pattern as Banner_Image,scrapedata.Offer_Price,scrapedata.MSRP,scrapedata.List_Price,user_account.Email,user_account.Phone,user_account.City FROM scrapedata  INNER JOIN user_account ON user_account.Dealer_ID = scrapedata.Dealer_ID  where scrapedata.Dealer_ID='$locationdata'";
				$final =$final."ORDER BY scrapedata.List_Price ASC limit $count,20";
				
				$result = $db->query($final);
				$finalresult =  $result->fetchAll();
				//return $finalresult; 
				echo json_encode($finalresult);
			} */
}
?>
