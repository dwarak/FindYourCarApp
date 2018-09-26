<?php
class Api_ShowroomtestController extends Zend_Controller_Action
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
		
		$this->Showroom = new Application_Model_Showroomtest;
		$this->Useraccount = new Application_Model_Useraccount;
		
		
	}	
	
	/* public function preDispatch() {
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
		}   */ 
		 
		public function getShowroomCarsAction() 
		{
		 
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
		
		$lat = trim ( $this->getRequest ()->getParam ( 'latitude' ) );
		$lng = trim ( $this->getRequest ()->getParam ( 'longitude' ) );
		$area = trim ( $this->getRequest ()->getParam ( 'radius' ) ); 
		/* $lat = "37.564143";
  		$lng = "-122.004179";
 		$area = 200;  */
		/*  $lat = "13.036855";
		$lng = "80.267646";
		$area = 200;  */
		$showroom = array ();
		$recentUpload = array ();
		$dataval = array();
		if($area==""){
			$area = 100;
		}
		if($lat == "" && $lng == ""){
			$detaview = $this->Showroom->getdealerdata( );
			
					foreach ( $detaview as $data ) {
						
						$id = $data ['Adv_ID'];
						
						
						unset ( $data ['UserId'] );
						unset ( $data ['Adv_ID'] );
						unset ( $data ['Condition'] );
						unset ( $data ['Body_Type'] );
						unset ( $data ['Vin_Number'] );
						unset ( $data ['Engine_Type'] );
						unset ( $data ['Title'] );
						unset ( $data ['Warranty'] );
						unset ( $data ['Description'] );
						unset ( $data ['Car_Location'] );
						unset ( $data ['Location_Longitude'] );
						unset ( $data ['Location_Latitude'] );
						unset ( $data ['Ship_Type'] );
						unset ( $data ['Payment_Method'] );
						unset ( $data ['User_ID'] );
						unset ( $data ['Uploaded_Date'] );
						
						$data['Banner_Image'] = str_replace(array("/240x/","x200.","c225",",w_277/","/w_220/h_163/","width=220&height=163&","w=225&amp;h=165"),array("/640x/","x640.","t640",",w_640/","/w_640/h_480/","width=640&height=480&","w=640&amp;h=480"),$data['Banner_Image']);
						
						$showroom [] = $data;
				}	
			}
		else{
		$details = $this->Showroom->getDealerFromRadiusData ( $lat, $lng, $area );
				
				
				// $i = 1;
				foreach ( $details as $datas ) {
					
					$id = $datas ['Adv_ID'];
					
					unset ( $datas ['UserId'] );
					unset ( $datas ['Adv_ID'] );
					unset ( $datas ['Condition'] );
					unset ( $datas ['Body_Type'] );
					unset ( $datas ['Vin_Number'] );
					unset ( $datas ['Engine_Type'] );
					unset ( $datas ['Title'] );
					unset ( $datas ['Warranty'] );
					unset ( $datas ['Description'] );
					unset ( $datas ['Car_Location'] );
					unset ( $datas ['Location_Longitude'] );
					unset ( $datas ['Location_Latitude'] );
					unset ( $datas ['Ship_Type'] );
					unset ( $datas ['Payment_Method'] );
					unset ( $datas ['User_ID'] );
					unset ( $datas ['Uploaded_Date'] );
					
					$datas['Banner_Image'] = str_replace(array("/240x/","x200.","c225",",w_277/","/w_220/h_163/","width=220&height=163&","w=225&amp;h=165"),array("/640x/","x640.","t640",",w_640/","/w_640/h_480/","width=640&height=480&","w=640&amp;h=480"),$datas['Banner_Image']);
					$showroom [] = $datas;
				}
						
			}
			
			if($lat == "" && $lng == ""){
			$datayear=date("Y")+1;
			$recentuploaddetails = $this->Showroom->getrecentuploaddetails($datayear);
			
				foreach ( $recentuploaddetails as $datas ) {
						
						
					$id = $datas ['Adv_ID'];
					
					unset ( $datas ['UserId'] );
					unset ( $datas ['Adv_ID'] );
					unset ( $datas ['Condition'] );
					unset ( $datas ['Body_Type'] );
					unset ( $datas ['Vin_Number'] );
					unset ( $datas ['Engine_Type'] );
					unset ( $datas ['Title'] );
					unset ( $datas ['Warranty'] );
					unset ( $datas ['Description'] );
					unset ( $datas ['Car_Location'] );
					unset ( $datas ['Location_Longitude'] );
					unset ( $datas ['Location_Latitude'] );
					unset ( $datas ['Ship_Type'] );
					unset ( $datas ['Payment_Method'] );
					unset ( $datas ['User_ID'] );
					unset ( $datas ['Uploaded_Date'] );
					
					$datas['Banner_Image'] = str_replace(array("/240x/","x200.","c225",",w_277/","/w_220/h_163/","width=220&height=163&","w=225&amp;h=165"),array("/640x/","x640.","t640",",w_640/","/w_640/h_480/","width=640&height=480&","w=640&amp;h=480"),$datas['Banner_Image']);
					
					$recentUpload [] = $datas;
					
				}
			}else{
				$datayear=date("Y")+1;
				$recentuploaddetails = $this->Showroom->getrecentuplocationloaddetails( $datayear,$lat, $lng, $area);
			
				foreach ( $recentuploaddetails as $datas ) {
						
						
					$id = $datas ['Adv_ID'];
					
					unset ( $datas ['UserId'] );
					unset ( $datas ['Adv_ID'] );
					unset ( $datas ['Condition'] );
					unset ( $datas ['Body_Type'] );
					unset ( $datas ['Vin_Number'] );
					unset ( $datas ['Engine_Type'] );
					unset ( $datas ['Title'] );
					unset ( $datas ['Warranty'] );
					unset ( $datas ['Description'] );
					unset ( $datas ['Car_Location'] );
					unset ( $datas ['Location_Longitude'] );
					unset ( $datas ['Location_Latitude'] );
					unset ( $datas ['Ship_Type'] );
					unset ( $datas ['Payment_Method'] );
					unset ( $datas ['User_ID'] );
					unset ( $datas ['Uploaded_Date'] );
					
					$datas['Banner_Image'] = str_replace(array("/240x/","x200.","c225",",w_277/","/w_220/h_163/","width=220&height=163&","w=225&amp;h=165"),array("/640x/","x640.","t640",",w_640/","/w_640/h_480/","width=640&height=480&","w=640&amp;h=480"),$datas['Banner_Image']);
					
					$recentUpload [] = $datas;
			}
				
			}	
			
			if($lat == "" && $lng == ""){
				 $neardetail = $this->Showroom->getNearmeData();
				//echo json_encode($neardetail);
					foreach ( $neardetail as $datas ) {
						unset ( $datas ['UserId'] );
					unset ( $datas ['Adv_ID'] );
					unset ( $datas ['Condition'] );
					unset ( $datas ['Body_Type'] );
					unset ( $datas ['Vin_Number'] );
					unset ( $datas ['Engine_Type'] );
					unset ( $datas ['Title'] );
					unset ( $datas ['Warranty'] );
					unset ( $datas ['Description'] );
					unset ( $datas ['Car_Location'] );
					unset ( $datas ['Location_Longitude'] );
					unset ( $datas ['Location_Latitude'] );
					unset ( $datas ['Ship_Type'] );
					unset ( $datas ['Payment_Method'] );
					unset ( $datas ['User_ID'] );
					unset ( $datas ['Uploaded_Date'] );
					
					$datas['Banner_Image'] = str_replace(array("/240x/","x200.","c225",",w_277/","/w_220/h_163/","width=220&height=163&","w=225&amp;h=165"),array("/640x/","x640.","t640",",w_640/","/w_640/h_480/","width=640&height=480&","w=640&amp;h=480"),$datas['Banner_Image']);
					
					$carmany[]  = $datas;
					
				}
					$column=2;
					$dataval=array_chunk($carmany , $column); 
			}else{
				$neardetail = $this->Showroom->getlocationNearmeData($lat, $lng, $area);
				//echo json_encode($neardetail);
					foreach ( $neardetail as $datas ) {
						unset ( $datas ['UserId'] );
					unset ( $datas ['Adv_ID'] );
					unset ( $datas ['Condition'] );
					unset ( $datas ['Body_Type'] );
					unset ( $datas ['Vin_Number'] );
					unset ( $datas ['Engine_Type'] );
					unset ( $datas ['Title'] );
					unset ( $datas ['Warranty'] );
					unset ( $datas ['Description'] );
					unset ( $datas ['Car_Location'] );
					unset ( $datas ['Location_Longitude'] );
					unset ( $datas ['Location_Latitude'] );
					unset ( $datas ['Ship_Type'] );
					unset ( $datas ['Payment_Method'] );
					unset ( $datas ['User_ID'] );
					unset ( $datas ['Uploaded_Date'] );
					
					$datas['Banner_Image'] = str_replace(array("/240x/","x200.","c225",",w_277/","/w_220/h_163/","width=220&height=163&","w=225&amp;h=165"),array("/640x/","x640.","t640",",w_640/","/w_640/h_480/","width=640&height=480&","w=640&amp;h=480"),$datas['Banner_Image']);
					
					$carmany[]  = $datas;
					
				}
					$column=2;
					$dataval=array_chunk($carmany , $column);
			}
			 if ($showroom) {
					echo $encode = json_encode ( array (
										"Best Selling Price" => $showroom,
										"Upcoming cars" => $recentUpload,
										"Car Comparision" => $dataval
										) ); 

					} else{
					$str=array();
					echo $encode =  json_encode( array("showroom data" =>"No data found"));
										
										
					}    
		 
				
			}
			
		public function carDetailsAction(){
			 if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('Error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			}    
		
			$vin = trim ( $this->getRequest ()->getParam ( 'VIN' ) );
			$dealerid = trim ( $this->getRequest ()->getParam ( 'Dealer_ID' ) );
			//$vin = "WBA8B9C33HK886111";
			//$dealerid = "00058"; 
			
			if($vin!="" && $dealerid!=""){
			$car = $this->Useraccount->getadpcardetails($vin, $dealerid);
			echo json_encode($car);
			}else{
				echo json_encode("No data found");
				}
			}  
			
		public function newCardetailAction(){
			if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('Error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			}  
		
			$newpage = trim ( $this->getRequest ()->getParam ( 'newpage' ) );
			//$dealerid = trim ( $this->getRequest ()->getParam ( 'Dealer_ID' ) );
			//$newpage = "http://www.sanantoniododge.com/vehicle-details/new-2018-ram-1500-lone-star-silver-1C6RR6LT0JS207894";
			//$dealerid = "00058"; 
			
			if($newpage!=""){
			$car = $this->Useraccount->newgetadpcardetails($newpage);
			echo json_encode($car);
			}else{
				echo json_encode("No data found");
				}
		}
		
		public function carDetailswebAction(){
			if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('Error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			} 
		
			$vin = trim ( $this->getRequest ()->getParam ( 'VIN' ) );
			$dealerid = trim ( $this->getRequest ()->getParam ( 'Dealer_ID' ) );
			//$vin = "WBA7F0C55JGM23084";
			//$dealerid = "00138";
			
			if($vin!="" && $dealerid!=""){
				$dataview = $this->Useraccount->getadpcardetailsweb($vin, $dealerid);		
					
			}
				$datalist = $this->Useraccount->carlistdata($dealerid);	
			
				if ($dataview) {
					echo $encode = json_encode ( array (
								"Car_details" => $dataview,
								"Dealer_cars" => $datalist));
					} 
			
		}	
		
		
		  public function dealerListAction(){
			 if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('Error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			}    
			
			
			$lat = trim ( $this->getRequest ()->getParam ( 'latitude' ) );
			$lng = trim ( $this->getRequest ()->getParam ( 'longitude' ) );
			$area = trim ( $this->getRequest ()->getParam ( 'radius' ) );
			$city = trim ( $this->getRequest ()->getParam ( 'city' ) );
			$make = trim ( $this->getRequest ()->getParam ( 'make' ) );
			/* $lat = "37.564143";
			$lng = "-122.004179";
			$area = 200; */
			//$city = "Columbia";
			//$make = "Sons";
			$detaview=array();
			if($city){
			$detaview=$this->Showroom->getCitydata($city,$make);
			$i = 0;
			foreach ( $detaview as $value ) {
				//echo json_encode($value);
					$resultLogo = $this->Showroom->dealergetdetails ( $value ['UserID'] );
					//echo json_encode($resultLogo);
					$detaview [$i] ['Banner_Image'] = "http://findyourcarapp.com/findyourcarapp_api/application/LogoImages/".$resultLogo [0] ['Banner_Image'];
					if(count($resultLogo)>0){
					}
					$i ++; 
				}
			}	
			 else
			{
			if($lat!="" && $lng!=""){
			$detaview = $this->Showroom->getDealerFromRadiuslist ( $lat, $lng, $area ,$make );
			//echo json_encode($detaview);
			$i = 0;
			foreach ( $detaview as $value ) {
				//echo json_encode($value);
					$resultLogo = $this->Showroom->dealergetdetails ( $value ['UserID'] );
					//echo json_encode($resultLogo);
					if(count($resultLogo)>0){
					$detaview [$i] ['Banner_Image'] = "http://findyourcarapp.com/findyourcarapp_api/application/LogoImages/".$resultLogo [0] ['Banner_Image'];
					}
					$i ++; 
				}
			} 
			
			  elseif($make){
				$detaview = $this->Showroom->getdealerlist($make);
				//echo json_encode($detaview);
				$i = 0;
				foreach ($detaview as $value) {
					//echo json_encode($value);
					$resultLogo = $this->Showroom->dealergetdetails ( $value ['UserID'] );
					//echo json_encode($resultLogo);
					
					if(count($resultLogo)>0){
						$detaview [$i] ['Banner_Image'] = "http://findyourcarapp.com/findyourcarapp_api/application/LogoImages/".$resultLogo[0]['Banner_Image'];
						
					}
					$i++; 
					
				}
			  }
			  else{
				$detaview = $this->Showroom->staticcars();
					//echo json_encode($detaview);
				$i = 0;
				foreach ($detaview as $value) {
					//echo json_encode($value);
					$resultLogo = $this->Showroom->dealergetdetails ( $value ['UserID'] );
					//echo json_encode($resultLogo);
					
					if(count($resultLogo)>0){
						$detaview [$i] ['Banner_Image'] = "http://findyourcarapp.com/findyourcarapp_api/application/LogoImages/".$resultLogo[0]['Banner_Image'];
						
					}
					$i++; 
					
				}
			} 
				 
		}   
			if ($detaview) {
					echo json_encode ( array (
							"Result" => $detaview 
					) );
			}else{
				echo $encode =  json_encode( array("showroom data" =>"No data found"));
					
			}   
		}
	 
	 
		public function dealerDetailsAction()
		{
			 if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('Error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			}  
			
			$Dealerid = trim ( $this->getRequest ()->getParam ( 'Dealer_ID' ) );
			$make = trim ( $this->getRequest ()->getParam ( 'Make' ) );
			$count = trim ( $this->getRequest ()->getParam ( 'count' ) );
			$datamakelist=array();
			$datamakelist1=array();
			$datamakelist2=array();
			$resultLogo=array();
			$detaview=array();
			//$Dealerid = "00009";
			//$count=60;
			//$make = "Acura";
			
				$datamake=$this->Useraccount->makelist($Dealerid);
				 foreach($datamake as $datalist){
							//echo $datalist['Make'];
							$datamakelist[]=$datalist['Make'];
						} 
					
				$dealername=$this->Useraccount->dealername($Dealerid);
					foreach($dealername as $datalist){
							//echo $datalist['Make'];
							$datamakelist1=$datalist['Dealer_Name'];
						} 
				$datacity=$this->Useraccount->cityvalue($Dealerid);
					  foreach($datacity as $datalist){
							$datamakelist2=$datalist['City'];
					} 	
					
				$detaview = $this->Useraccount->getuserid($Dealerid);
				//echo json_encode($detaview);
				foreach ($detaview as $value) {
				//echo json_encode($value ['userID']);
				$resultLogo = $this->Useraccount->dealergetdetails ( $value ['userID'] );
				//echo json_encode($resultLogo);
				 if(count($resultLogo)>0){
						$datalogo = "http://findyourcarapp.com/findyourcarapp_api/application/LogoImages/".$resultLogo[0]['Banner_Image'];
						
					}
					
				}	
				 
				
				$dataview=$this->Useraccount->dealercars($Dealerid,$make,$count);
				if ($dataview) {
					echo json_encode (array( 
							"Result" => $dataview,
							"Make list" => $datamakelist,
							"Dealer_Name" => $datamakelist1,
							"City" => $datamakelist2,
							"Banner_Image" => $datalogo
							)); 
		
							
				} 
		}
			
			
	public function carFilterAction()
		{
			if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('Error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			} 
			
			$lat = trim ( $this->getRequest ()->getParam ( 'latitude' ) );
			$lng = trim ( $this->getRequest ()->getParam ( 'longitude' ) );
			$area = trim ( $this->getRequest ()->getParam ( 'radius' ) ); 
			$make = trim ( $this->getRequest ()->getParam ( 'make' ) );
			$model = trim ( $this->getRequest ()->getParam ( 'model' ) );
			$year = trim ( $this->getRequest ()->getParam ( 'year' ) );
			$price = trim ( $this->getRequest ()->getParam ( 'price' ) );
			$Year_between = trim ( $this->getRequest ()->getParam ( 'YearBetween' ) );
			$mileage_range = trim ( $this->getRequest ()->getParam ( 'mileage_range' ) ); 
			$Distance_Sort =trim ( $this->getRequest ()->getParam('Sorting'));
			$count = trim ( $this->getRequest ()->getPost ( 'count' ) ); 
			$showroom=array();
			$pricerag=array();
			//echo $encode = json_encode ( array ("Filter_cars" => $count ) ); 
			//$lat = "47.805550";
			//$lng = "-122.326102";
			//$area = 50;
			//$make = "BMW"; 
			//$model = "3 Series";
			//$year = "2017";
			//$price="$30,000-$60,000";
			//$Year_between="2010-2018";
			//$mileage_range="15000-50000";
			//$Distance_Sort="Min_to_Max";
			//$Distance_Sort="Max_to_Min";
			//$Price_Sort="Lowest_to_Highest";
			//$Price_Sort="Highest_to_Lowest";
			//$Year_Sort="Oldest_to_Newest";
			//$Year_Sort="Newest_to_Oldest";
			//$Distance_Sort = "MaxtoMin";
			//$count=60;
			if($count=="")
			{
			$count=0;
			}
			if($price=="AboveHundredPrice")
			{
			$price="$100,000-$500,000";
			}
			
			if($price!="DESC" && $price!="ASC"){
				if($price==""){
					$start_price = "";
					$end_price = "";	
				}else{
			$price1 = str_replace(array("$",","),array("",""),$price);
				$getrange = explode("-", $price1);
				$start_price = $getrange[0];
				$end_price = $getrange[1];	
				}
			} 
			
			else{
				$pricerag = $price;
			}  
			if($Year_between=="NewModelYear")
			{
			$Year_between="2017-2018";
			}
			else if($Year_between=="OldModelYear")
			{
			$Year_between="1966-2018";
			$yearrange="DESC";
			}
			
			if($Year_between!="DESC" && $Year_between!="ASC"){
				if($Year_between==""){
					$Year_from = "";
					$Year_to = "";	
				}else{
			$yearsort = str_replace(array("$",","),array("",""),$Year_between);
				$getrange = explode("-", $yearsort);
				$Year_from = $getrange[0];
				$Year_to = $getrange[1];	
				}
			} 
			
			if($mileage_range!="DESC" && $mileage_range!="ASC"){
				if($mileage_range==""){
					$Mileage1 = "";
					$Mileage2 = "";	
				}else{
			$mileagesort = str_replace(array("$",","),array("",""),$mileage_range);
				$getrange = explode("-", $mileagesort);
				$Mileage1 = $getrange[0];
				$Mileage2 = $getrange[1];	
				}
			} 
			
			if($lat == "" && $lng == ""){
			
			$detaview = $this->Showroom->getcardata($make,$model,$year,$start_price,$end_price,$pricerag,$Year_between,$Year_from,$Year_to,$mileage_range,$Mileage1,$Mileage2,$Distance_Sort,$count);
			
					foreach ( $detaview as $data ) {
						
						unset ( $data ['UserId'] );
						unset ( $data ['Adv_ID'] );
						unset ( $data ['Condition'] );
						unset ( $data ['Body_Type'] );
						unset ( $data ['Vin_Number'] );
						unset ( $data ['Engine_Type'] );
						unset ( $data ['Title'] );
						unset ( $data ['Warranty'] );
						unset ( $data ['Description'] );
						unset ( $data ['Car_Location'] );
						unset ( $data ['Location_Longitude'] );
						unset ( $data ['Location_Latitude'] );
						unset ( $data ['Ship_Type'] );
						unset ( $data ['Payment_Method'] );
						unset ( $data ['User_ID'] );
						unset ( $data ['Uploaded_Date'] );
						
						$data['Banner_Image'] = str_replace(array("/240x/","x200.","c225",",w_277/","/w_220/h_163/","width=220&height=163&","w=225&amp;h=165"),array("/640x/","x640.","t640",",w_640/","/w_640/h_480/","width=640&height=480&","w=640&amp;h=480"),$data['Banner_Image']);
						
						$showroom [] = $data;
				}
			}
		
		else{
		$details = $this->Showroom->getDealerFromLocation ( $lat, $lng, $area,$make,$model,$start_price,$end_price,$pricerag,$Year_between,$Year_from,$Year_to,$mileage_range,$Mileage1,$Mileage2,$Distance_Sort,$count);
				
				
				// $i = 1;
				foreach ( $details as $datas ) {
					
					unset ( $datas ['UserId'] );
					unset ( $datas ['Adv_ID'] );
					unset ( $datas ['Condition'] );
					unset ( $datas ['Body_Type'] );
					unset ( $datas ['Vin_Number'] );
					unset ( $datas ['Engine_Type'] );
					unset ( $datas ['Title'] );
					unset ( $datas ['Warranty'] );
					unset ( $datas ['Description'] );
					unset ( $datas ['Car_Location'] );
					unset ( $datas ['Location_Longitude'] );
					unset ( $datas ['Location_Latitude'] );
					unset ( $datas ['Ship_Type'] );
					unset ( $datas ['Payment_Method'] );
					unset ( $datas ['User_ID'] );
					unset ( $datas ['Uploaded_Date'] );
					
					$datas['Banner_Image'] = str_replace(array("/240x/","x200.","c225",",w_277/","/w_220/h_163/","width=220&height=163&","w=225&amp;h=165"),array("/640x/","x640.","t640",",w_640/","/w_640/h_480/","width=640&height=480&","w=640&amp;h=480"),$datas['Banner_Image']);
					$showroom [] = $datas;
					}
				}

			
					if ($showroom) {
					echo $encode = json_encode ( array (
										"Filter_cars" => $showroom ) ); 
									}	
		}		
		/*-------------------- website filter -------------*/			
		/*public function carFilterwebAction()
		{
			if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('Error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			}    
			 
			$lat = trim ( $this->getRequest ()->getParam ( 'latitude' ) );
			$lng = trim ( $this->getRequest ()->getParam ( 'longitude' ) );  
			$Zipcode = trim ( $this->getRequest ()->getParam ( 'zipcode' ) );
			$area = trim ( $this->getRequest ()->getParam ( 'radius' ) ); 
			$make = trim ( $this->getRequest ()->getParam ( 'make' ) );
			$model = trim ( $this->getRequest ()->getParam ( 'model' ) );
			$type = trim ( $this->getRequest ()->getParam ( 'stock' ) );
			//$year = trim ( $this->getRequest ()->getParam ( 'year' ) );
			$price = trim ( $this->getRequest ()->getParam ( 'price' ) );
			//$transmission = trim ( $this->getRequest ()->getParam ( 'transmission' ) );
			$Year_between = trim ( $this->getRequest ()->getParam ( 'YearBetween' ) );
			$mileage_range = trim ( $this->getRequest ()->getParam ( 'mileage_range' ) ); 
			$page = trim ( $this->getRequest ()->getParam ( 'page' ) );
			$Distance_Sort =trim ( $this->getRequest ()->getParam('Sorting'));
			//echo("<script>console.log('Model: ".$page."');</script>");
			$showroom=array();
			$pricerag=array();
			//$lat = "34.2000834";
			//$lng = "-84.0907246";  
			//$area = 100;
			//$Zipcode ="94536";
			//$make = "Acura"; 
			//$model = "2 Series"; 
			//$area = 500; 
			//$type = "Used";
			//$year = "2018";
			//$price="$10,000-$20,000";
			//$Year_between="2015-2018";
			//$mileage_range="15000-50000";
			//$Distance_Sort="Min_to_Max";
			//$Distance_Sort="Max_to_Min";
			//$Price_Sort="Lowest_to_Highest";
			//$Price_Sort="Highest_to_Lowest";
			//$Year_Sort="Oldest_to_Newest";
			//$Year_Sort="Newest_to_Oldest";
			//$transmission = "Automatic";
			//$Zipcode ="94536";
			//$area = 100;
			//$Zipcode ="94536";
			//$area = 50;
			//$page = 50; 
			if($price=="Highest_to_Lowest")
			{
			$price="$100,000-$500,000";
			}
			if($area == ""){
				$area = 300;
			}
			if($page == ""){
				$page=0;
			}else{
				$page=$page*20-20;
				//$page *= 20;
				
			}
			
			if($price!="DESC" && $price!="ASC"){
				if($price==""){
					$start_price = "";
					$end_price = "";	
				}else{
			$price1 = str_replace(array("$",","),array("",""),$price);
				$getrange = explode("-", $price1);
				$start_price = $getrange[0];
				$end_price = $getrange[1];	
				}
			} 
			
			else{
				$pricerag = $price;
			}  
			if($Year_between=="Newest_to_Oldest")
			{
			$Year_between="2018-2019";
			}
			else if($Year_between=="Oldest_to_Newest")
			{
			$Year_between="1966-2018";
			$yearrange="DESC";
			}
			
			if($Year_between!="DESC" && $Year_between!="ASC"){
				if($Year_between==""){
					$Year_from = "";
					$Year_to = "";	
				}else{
			$yearsort = str_replace(array("$",","),array("",""),$Year_between);
				$getrange = explode("-", $yearsort);
				$Year_from = $getrange[0];
				$Year_to = $getrange[1];	
				}
			} 
			
			if($mileage_range!="DESC" && $mileage_range!="ASC"){
				if($mileage_range==""){
					$Mileage1 = "";
					$Mileage2 = "";	
				}else{
			$mileagesort = str_replace(array("$",","),array("",""),$mileage_range);
				$getrange = explode("-", $mileagesort);
				$Mileage1 = $getrange[0];
				$Mileage2 = $getrange[1];	
				}
			} 
			
			//if($lat == "" && $lng == ""){
				if($Zipcode ==""){
			//echo("<script>console.log('Model: ".$page."');</script>");
			$detaview = $this->Showroom->getcardataweb($make,$model,$type,$start_price,$end_price,$pricerag,$Year_between,$Year_from,$Year_to,$mileage_range,$Mileage1,$Mileage2,$page,$Distance_Sort);
			
					foreach ( $detaview as $data ) {
						
						unset ( $data ['UserId'] );
						unset ( $data ['Adv_ID'] );
						unset ( $data ['Condition'] );
						unset ( $data ['Body_Type'] );
						unset ( $data ['Vin_Number'] );
						unset ( $data ['Engine_Type'] );
						unset ( $data ['Title'] );
						unset ( $data ['Warranty'] );
						unset ( $data ['Description'] );
						unset ( $data ['Car_Location'] );
						unset ( $data ['Location_Longitude'] );
						unset ( $data ['Location_Latitude'] );
						unset ( $data ['Ship_Type'] );
						unset ( $data ['Payment_Method'] );
						unset ( $data ['User_ID'] );
						unset ( $data ['Uploaded_Date'] );
						
						$data['Banner_Image'] = str_replace(array("/240x/","x200.","c225",",w_277/","/w_220/h_163/","width=220&height=163&","w=225&amp;h=165"),array("/640x/","x640.","t640",",w_640/","/w_640/h_480/","width=640&height=480&","w=640&amp;h=480"),$data['Banner_Image']);
						
						$showroom [] = $data;
				}
				$countlist = $this->Showroom->countdatamake($make,$model,$type,$start_price,$end_price,$pricerag,$Year_between,$Year_from,$Year_to,$mileage_range,$Mileage1,$Mileage2);
			}
		
		else{
			
			function getLnt($zip){
			
				$datalist;
				$url = "http://maps.googleapis.com/maps/api/geocode/json?address=
				".urlencode($zip)."&sensor=false";
				$result_string = file_get_contents($url);
				$result = json_decode($result_string, true);
				$result1[]=$result['results'][0];
				$result2[]=$result1[0]['geometry'];
				$result3[]=$result2[0]['location'];
				return $result;
			}
			
			do {
				$datalist = getLnt($Zipcode);
				
			} while ($datalist['status'] !="OK");
			
				$result1[]=$datalist['results'][0];
				$result2[]=$result1[0]['geometry'];
				$result3[]=$result2[0]['location'];
				
				$valueslist = $result3[0];
				$lat  =  $valueslist['lat'];
				$lng = $valueslist['lng'];
		
		$details = $this->Showroom->getDealerFromLocationweb ( $lat, $lng, $area,$make,$model,$type,$start_price,$end_price,$pricerag,$Year_between,$Year_from,$Year_to,$mileage_range,$Mileage1,$Mileage2,$page,$Distance_Sort);
				
				
				// $i = 1;
				foreach ( $details as $datas ) {
					
					unset ( $datas ['UserId'] );
					unset ( $datas ['Adv_ID'] );
					unset ( $datas ['Condition'] );
					unset ( $datas ['Body_Type'] );
					unset ( $datas ['Vin_Number'] );
					unset ( $datas ['Engine_Type'] );
					unset ( $datas ['Title'] );
					unset ( $datas ['Warranty'] );
					unset ( $datas ['Description'] );
					unset ( $datas ['Car_Location'] );
					unset ( $datas ['Location_Longitude'] );
					unset ( $datas ['Location_Latitude'] );
					unset ( $datas ['Ship_Type'] );
					unset ( $datas ['Payment_Method'] );
					unset ( $datas ['User_ID'] );
					unset ( $datas ['Uploaded_Date'] );
					
					$datas['Banner_Image'] = str_replace(array("/240x/","x200.","c225",",w_277/","/w_220/h_163/","width=220&height=163&","w=225&amp;h=165"),array("/640x/","x640.","t640",",w_640/","/w_640/h_480/","width=640&height=480&","w=640&amp;h=480"),$datas['Banner_Image']);
					$showroom [] = $datas;
					}
					$countlist = $this->Showroom->countdataloc($lat, $lng, $area,$make,$model,$type,$start_price,$end_price,$pricerag,$Year_between,$Year_from,$Year_to,$mileage_range,$Mileage1,$Mileage2);
				}

			
					if ($showroom) {
					shuffle($showroom);	
					echo $encode = json_encode ( array (
										"Filter_cars" => $showroom,
										"Count" => $countlist) ); 
									}	
					else{
						echo json_encode("No data found");
					}
		}*/
		
		public function carFilterwebAction()
		{
			/* if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('Error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			}  */  
			 
			  /* $lat = trim ( $this->getRequest ()->getParam ( 'latitude' ) );
			$lng = trim ( $this->getRequest ()->getParam ( 'longitude' ) );   */
			$Zipcode = trim ( $this->getRequest ()->getParam ( 'zipcode' ) );
			$area = trim ( $this->getRequest ()->getParam ( 'radius' ) ); 
			$make = trim ( $this->getRequest ()->getParam ( 'make' ) );
			$model = trim ( $this->getRequest ()->getParam ( 'model' ) );
			$type = trim ( $this->getRequest ()->getParam ( 'stock' ) );
			//$year = trim ( $this->getRequest ()->getParam ( 'year' ) );
			$price = trim ( $this->getRequest ()->getParam ( 'price' ) );
			//$transmission = trim ( $this->getRequest ()->getParam ( 'transmission' ) );
			$Year_between = trim ( $this->getRequest ()->getParam ( 'YearBetween' ) );
			$mileage_range = trim ( $this->getRequest ()->getParam ( 'mileage_range' ) ); 
			$page = trim ( $this->getRequest ()->getParam ( 'page' ) );
			$Distance_Sort =trim ( $this->getRequest ()->getParam('Sorting'));
			//echo("<script>console.log('Model: ".$page."');</script>");
			$showroom=array();
			$pricerag=array();
			$Distance_Sort;
			/*  $lat = "34.2000834";
			$lng = "-84.0907246";  */
			/*  $area = 100;*/
			$Zipcode ="94536";
			$area = 50;
			$make = "Acura"; 
			//$model = "MDX"; 
			//$area = 500; 
			$type = "Used"; 
			//$year = "2018";
			//$price="$10,000-$20,000";
			//$Year_between="2015-2018";
			//$mileage_range="10000-50000"; 
			//$Distance_Sort="Min_to_Max";
			//$Distance_Sort="Max_to_Min";
			//$Distance_Sort="Highest_to_Lowest";
			//$Distance_Sort="Lowest_to_Highest";
			//$Distance_Sort="Oldest_to_Newest";
			$Distance_Sort="Newest_to_Oldest";
			//$transmission = "Automatic";
			//$Zipcode ="94536";
			//$area = 100;
			//$Zipcode ="94536";
			//$area = 50;
			//$page = 1; 
			//echo "before if condtion : ".$Distance_Sort;
			
			
			if($price!="DESC" && $price!="ASC"){
				if($price==""){
					$start_price = "";
					$end_price = "";	
				}else{
			$price1 = str_replace(array("$",","),array("",""),$price);
				$getrange = explode("-", $price1);
				$start_price = $getrange[0];
				$end_price = $getrange[1];	
				}
			} 
			
			if($Year_between!="DESC" && $Year_between!="ASC"){
				if($Year_between==""){
					$Year_from = "";
					$Year_to = "";	
				}else{
			$yearsort = str_replace(array("$",","),array("",""),$Year_between);
				$getrange = explode("-", $yearsort);
				$Year_from = $getrange[0];
				$Year_to = $getrange[1];	
				}
			}  
			
			if($mileage_range!="DESC" && $mileage_range!="ASC"){
				if($mileage_range==""){
					$Mileage1 = "";
					$Mileage2 = "";	
				}else{
			$mileagesort = str_replace(array("$",","),array("",""),$mileage_range);
				$getrange = explode("-", $mileagesort);
				$Mileage1 = $getrange[0];
				$Mileage2 = $getrange[1];	
				}
			} 
			
			if($page == ""){
				$page=0;
			}else{
				$page=$page*20-20;
				//$page *= 20;
				
			}
			
			if($area == ""){
				$area = 300;
			}
			
			
			//if($lat == "" && $lng == ""){
		if($Zipcode ==""){
			//echo("<script>console.log('Model: ".$page."');</script>");
			//echo $Distance_Sort."if called zip empty";
			//$detaview = $this->Showroom->getcardataweb($make,$model,$type,$start_price,$end_price,$pricerag,$Year_between,$Year_from,$Year_to,$mileage_range,$Mileage1,$Mileage2,$page,$Distance_Sort);
			$detaview = $this->Showroom->nonlocationsort($make,$model,$type,$start_price,$end_price,$pricerag,$Year_between,$Year_from,$Year_to,$mileage_range,$Mileage1,$Mileage2,$page,$Distance_Sort);
					//echo json_encode($detaview);
					foreach ( $detaview as $data ) {
						
						unset ( $data ['UserId'] );
						unset ( $data ['Adv_ID'] );
						unset ( $data ['Condition'] );
						unset ( $data ['Body_Type'] );
						unset ( $data ['Vin_Number'] );
						unset ( $data ['Engine_Type'] );
						unset ( $data ['Title'] );
						unset ( $data ['Warranty'] );
						unset ( $data ['Description'] );
						unset ( $data ['Car_Location'] );
						unset ( $data ['Location_Longitude'] );
						unset ( $data ['Location_Latitude'] );
						unset ( $data ['Ship_Type'] );
						unset ( $data ['Payment_Method'] );
						unset ( $data ['User_ID'] );
						unset ( $data ['Uploaded_Date'] );
						
						$data['Banner_Image'] = str_replace(array("/240x/","x200.","c225",",w_277/","/w_220/h_163/","width=220&height=163&","w=225&amp;h=165"),array("/640x/","x640.","t640",",w_640/","/w_640/h_480/","width=640&height=480&","w=640&amp;h=480"),$data['Banner_Image']);
						
						$showroom [] = $data;
				}  
				$countlist = $this->Showroom->nonlocationsortcount($make,$model,$type,$start_price,$end_price,$pricerag,$Year_between,$Year_from,$Year_to,$mileage_range,$Mileage1,$Mileage2,$Distance_Sort);
				//$countlist = $this->Showroom->countdatamake($make,$model,$type,$start_price,$end_price,$pricerag,$Year_between,$Year_from,$Year_to,$mileage_range,$Mileage1,$Mileage2,$Distance_Sort);
			} 
		
		else{
			//echo "location based :".$Distance_Sort;
			function getLnt($zip){
			
				$datalist;
				$url = "http://maps.googleapis.com/maps/api/geocode/json?address=
				".urlencode($zip)."&sensor=false";
				$result_string = file_get_contents($url);
				$result = json_decode($result_string, true);
				$result1[]=$result['results'][0];
				$result2[]=$result1[0]['geometry'];
				$result3[]=$result2[0]['location'];
				return $result;
			}
			
			do {
				$datalist = getLnt($Zipcode);
				
			} while ($datalist['status'] !="OK");
			
				$result1[]=$datalist['results'][0];
				$result2[]=$result1[0]['geometry'];
				$result3[]=$result2[0]['location'];
				 
				$valueslist = $result3[0];
				$lat  =  $valueslist['lat'];
				$lng = $valueslist['lng'];
		//echo "zipcode :".$Distance_Sort;
		//$details = $this->Showroom->getDealerFromLocationweb ( $lat, $lng, $area,$make,$model,$type,$start_price,$end_price,$pricerag,$Year_between,$Year_from,$Year_to,$mileage_range,$Mileage1,$Mileage2,$page,$Distance_Sort);
			$details = $this->Showroom->locationsorting($lat, $lng, $area,$make,$model,$type,$start_price,$end_price,$pricerag,$Year_between,$Year_from,$Year_to,$mileage_range,$Mileage1,$Mileage2,$Distance_Sort);
				//echo json_encode($details);
				// $i = 1;
				 
				foreach ( $details as $datas ) {
					
					unset ( $datas ['UserId'] );
					unset ( $datas ['Adv_ID'] );
					unset ( $datas ['Condition'] );
					unset ( $datas ['Body_Type'] );
					unset ( $datas ['Vin_Number'] );
					unset ( $datas ['Engine_Type'] );
					unset ( $datas ['Title'] );
					unset ( $datas ['Warranty'] );
					unset ( $datas ['Description'] );
					unset ( $datas ['Car_Location'] );
					unset ( $datas ['Location_Longitude'] );
					unset ( $datas ['Location_Latitude'] );
					unset ( $datas ['Ship_Type'] );
					unset ( $datas ['Payment_Method'] );
					unset ( $datas ['User_ID'] );
					unset ( $datas ['Uploaded_Date'] );
					
					$datas['Banner_Image'] = str_replace(array("/240x/","x200.","c225",",w_277/","/w_220/h_163/","width=220&height=163&","w=225&amp;h=165"),array("/640x/","x640.","t640",",w_640/","/w_640/h_480/","width=640&height=480&","w=640&amp;h=480"),$datas['Banner_Image']);
					$showroom [] = $datas;
					}
					$countlist = $this->Showroom->countdataloc($lat, $lng, $area,$make,$model,$type,$start_price,$end_price,$pricerag,$Year_between,$Year_from,$Year_to,$mileage_range,$Mileage1,$Mileage2,$Distance_Sort);
					
				}

			
					if ($showroom) {
					//shuffle($detaview);	
					echo $encode = json_encode ( array (
										"Filter_cars" => $showroom,
										"Count" => $countlist) ); 
									}	
					else{
						echo json_encode("No data found");
					}   
				
				
		}
		/*---------------------------------------------*/		
					
		public function cityListAction()
			{
			if (!$this->getRequest()->isGet())
			{
    		$encode = json_encode(array('Error'=>"This function accepts only GET."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			} 
			
			$datamake=$this->Showroom->cityvalue();
					  foreach($datamake as $datalist){
							if($datalist['City']!=""){
							$datamakelist[]=$datalist['City'];
							} 
					} 
					echo json_encode($datamakelist);
			}
			
			
		public function dealerMakeCarsAction()
			{
				
			if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('Error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			} 
			$datamakelist=array();
			
			
			$makelistdata = $this->Showroom->makelist();
				foreach($makelistdata as $datalist){
						if($datalist['Make']!=""&&$datalist['Make']!=" "){
							$datamakelist[]=$datalist;
							} 
						}
					if ($datamakelist) {
							echo json_encode (array( 
									"Make_list" => $datamakelist,
									));
					}
		 
			}
			
		public function showroomWebsiteAction()
			{
			if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('Error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			} 
			
			$datayear=(date("Y")+1);
			$recentuploaddetails = $this->Showroom->getrecentuploadcars($datayear);
			
				foreach ( $recentuploaddetails as $datas ) {
						
						
					$id = $datas ['Adv_ID'];
					
					unset ( $datas ['UserId'] );
					unset ( $datas ['Adv_ID'] );
					unset ( $datas ['Condition'] );
					unset ( $datas ['Body_Type'] );
					unset ( $datas ['Vin_Number'] );
					unset ( $datas ['Engine_Type'] );
					unset ( $datas ['Title'] );
					unset ( $datas ['Warranty'] );
					unset ( $datas ['Description'] );
					unset ( $datas ['Car_Location'] );
					unset ( $datas ['Location_Longitude'] );
					unset ( $datas ['Location_Latitude'] );
					unset ( $datas ['Ship_Type'] );
					unset ( $datas ['Payment_Method'] );
					unset ( $datas ['User_ID'] );
					unset ( $datas ['Uploaded_Date'] );
					
					$datas['Banner_Image'] = str_replace(array("/240x/","x200.","c225",",w_277/","/w_220/h_163/","width=220&height=163&","w=225&amp;h=165"),array("/640x/","x640.","t640",",w_640/","/w_640/h_480/","width=640&height=480&","w=640&amp;h=480"),$datas['Banner_Image']);
					
					$recentUpload [] = $datas;
					
					
				}
			
				$detaview = $this->Showroom->getdealerdatalist( );
			
					foreach ( $detaview as $data ) {
						
						$id = $data ['Adv_ID'];
						
						
						unset ( $data ['UserId'] );
						unset ( $data ['Adv_ID'] );
						unset ( $data ['Condition'] );
						unset ( $data ['Body_Type'] );
						unset ( $data ['Vin_Number'] );
						unset ( $data ['Engine_Type'] );
						unset ( $data ['Title'] );
						unset ( $data ['Warranty'] );
						unset ( $data ['Description'] );
						unset ( $data ['Car_Location'] );
						unset ( $data ['Location_Longitude'] );
						unset ( $data ['Location_Latitude'] );
						unset ( $data ['Ship_Type'] );
						unset ( $data ['Payment_Method'] );
						unset ( $data ['User_ID'] );
						unset ( $data ['Uploaded_Date'] );
						
						$data['Banner_Image'] = str_replace(array("/240x/","x200.","c225",",w_277/","/w_220/h_163/","width=220&height=163&","w=225&amp;h=165"),array("/640x/","x640.","t640",",w_640/","/w_640/h_480/","width=640&height=480&","w=640&amp;h=480"),$data['Banner_Image']);
						
						$showroom [] = $data;
					}
			
				
					if ($recentUpload) {
					echo $encode = json_encode ( array (
										"Upcoming_cars" => $recentUpload,
										"Best_selling_cars" => $showroom
										) ); 

					}else{
					$str=array();
					echo $encode = json_encode ( array (
										"Upcoming_cars" => $recentUpload,
										"Best_selling_cars" => $showroom
										) ); 
					} 
			
			}
			
			
		public function dealerCarlistAction()
			{
		 	if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('Error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			}  
			
			$Make = trim ( $this->getRequest ()->getParam ( 'Make' ) );
			$Dealer_Name = trim ( $this->getRequest ()->getParam ( 'Dealer_Name' ) );
			$Dealer_ID = trim ( $this->getRequest ()->getParam ( 'Dealer_ID' ) );
			
			//$Make = "Honda";
			//$Dealer_Name = "BMW";
			//$Dealer_ID = "00007";
			$dealercar = $this->Showroom->makesearchcars($Make,$Dealer_Name,$Dealer_ID);
			$detaview = $this->Useraccount->getuserid($Dealer_ID);
				//echo json_encode($detaview);
				foreach($detaview as $dataimg){
				$resultLogo = $this->Useraccount->dealergetdetailsdata ( $dataimg['userID'] );
				//echo json_encode($resultLogo);
				 if(count($resultLogo)>0){
						$datalogo = "http://findyourcarapp.com/findyourcarapp_api/application/LogoImages/".$resultLogo[0]['Logo_Image'];
						
					}
					
					
				}
				if ($dealercar) {
					echo json_encode(array("Dealer_cars" =>$dealercar,
											"Logo_Image" => $datalogo )); 
			
					}else{
						echo json_encode("No cars found");
					}
			}
			
		public function getcarMatchAction()
			{
			if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('Error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			}
			
			$Make = trim ( $this->getRequest ()->getParam ( 'make' ) );
			$Model = trim ( $this->getRequest ()->getParam ( 'model' ) );
			$Year = trim ( $this->getRequest ()->getParam ( 'year' ) );
			//$Make="Audi";
			//$Model="Q7";
			//$Year="2015";
			$getview = $this->Showroom->getcarlist($Make,$Model,$Year);
			echo json_encode($getview);
		}
		
		public function getdealerNameAction()
			{
			if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('Error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			} 
		
			
			$makelistdata = $this->Showroom->dealerlist();
		
				foreach($makelistdata as $datalist){
						//if($datalist['Dealer_Name']!=""){
							$datamakelist2[]=$datalist;
							}
					//} 
					if ($datamakelist2) {
					echo json_encode (array( 
						"Dealer_Name" =>$datamakelist2 ));
					}
		
			}
			
		public function carCompareAction(){
			if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('Error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			} 
			$Make = trim ( $this->getRequest ()->getParam ( 'make' ) );
			$Model = trim ( $this->getRequest ()->getParam ( 'model' ) );
			$Year = trim ( $this->getRequest ()->getParam ( 'year' ) );
			//$Make="Audi";
			//$Model="Q7";
			//$Year="2015";
			$getview = $this->Showroom->carmatch($Make,$Model,$Year);
			echo json_encode($getview);
		}
		
		public function carforVinAction(){
			if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('Error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			} 
			$Vin = trim ( $this->getRequest ()->getParam ( 'VIN' ) );
			//$Vin="WBA2M7C56JVA97268";
			$getview = $this->Showroom->selectvin($Vin);
			echo json_encode($getview);
		}
		public function comparedataAction(){
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
		 $curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://5mroeoez7j.execute-api.us-west-2.amazonaws.com/Prod/api/vehicle/makes",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Cache-Control: no-cache",
    "Postman-Token: 7653600a-69e2-474b-d3c3-0bf16e4bd905",
    "X-API-KEY: dk0KlY8Mpu3uxKOqb8Cu95BGg3NoASgM8K8ffoBf"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
} 	
}
public function getmakemodelyearAction(){
	
		   if (!$this->getRequest()->isGet())
			{
    		$encode = json_encode(array('Error'=>"This function accepts only GET."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			} 
		
			$make = trim ( $this->getRequest ()->getParam ( 'make' ) );
			$model = trim ( $this->getRequest ()->getParam ( 'model' ) );
			$year = trim ( $this->getRequest ()->getParam ( 'year' ) );	
			
		$detaview = $this->Showroom->getmakemodelyear();
		if ($detaview) {
					echo json_encode ( array (
							"makes" => $detaview 
					) );
			}    
			
}
/*public function makemodelyeardataAction(){
			 if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('Error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			}   
ini_set('max_execution_time', 300);
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://findyourcarapp.com/findyourcarapp_api/public/api/showroom/getmakemodelyear?token=24462a501a5aa6ca239d1ade0fc90c9c",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 300,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_HTTPHEADER => array(
    "Cache-Control: no-cache",
    "Postman-Token: 77877347-67b8-f431-de40-899b29441736"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}		
}*/

		public function showroomNewAction(){
			
		 	if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('Error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			}   
			$datayear= date("Y");
			$recentuploaddetails = $this->Showroom->showroomcar($datayear);
			
				foreach ( $recentuploaddetails as $datas ) {
						
						
					$id = $datas ['Adv_ID'];
					
					unset ( $datas ['UserId'] );
					unset ( $datas ['Adv_ID'] );
					unset ( $datas ['Condition'] );
					unset ( $datas ['Body_Type'] );
					unset ( $datas ['Vin_Number'] );
					unset ( $datas ['Engine_Type'] );
					unset ( $datas ['Title'] );
					unset ( $datas ['Warranty'] );
					unset ( $datas ['Description'] );
					unset ( $datas ['Car_Location'] );
					unset ( $datas ['Location_Longitude'] );
					unset ( $datas ['Location_Latitude'] );
					unset ( $datas ['Ship_Type'] );
					unset ( $datas ['Payment_Method'] );
					unset ( $datas ['User_ID'] );
					unset ( $datas ['Uploaded_Date'] );
					
					$datas['Banner_Image'] = str_replace(array("/240x/","x200.","c225",",w_277/","/w_220/h_163/","width=220&height=163&","w=225&amp;h=165"),array("/640x/","x640.","t640",",w_640/","/w_640/h_480/","width=640&height=480&","w=640&amp;h=480"),$datas['Banner_Image']);
					
					$recentUpload [] = $datas;
					
				}
				if ($recentUpload) {
					echo $encode = json_encode ( array (
										"Upcoming_cars" => $recentUpload
										
										) ); 

					}
			}
			
		public function getVindataAction(){
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
			
			$vin = trim ( $this->getRequest ()->getParam ( 'vin' ) );
			//$vin = "JTEZU5JR6D5057779";
			/* $json = file_get_contents("http://specifications.vinaudit.com/getspecifications.php?key=3ZE17RO3Z1KG3VK&vin="."$vin&format=json");
			$data = json_decode($json,true);
			$reultdata["Result"] = $data['attributes'];
			echo json_encode($reultdata); */
			$curl = curl_init();

			curl_setopt_array($curl, array(
			CURLOPT_URL => "https://p3kfmk7me3.execute-api.us-west-2.amazonaws.com/Prod/decode?vin="."$vin",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
			"Cache-Control: no-cache",
			"Postman-Token: d3a9f9bd-feca-e760-a7b2-18de2d6c06c7",
			"x-api-key: dk0KlY8Mpu3uxKOqb8Cu95BGg3NoASgM8K8ffoBf"
			),
		));

			$response = curl_exec($curl);

			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			  echo "cURL Error #:" . $err;
			} else {
			  //echo $response;
			}
			$data = json_decode($response,true);
			//$text = str_replace('\\n', '', $data);
			$result = $data['S'];
			$manage = json_decode($result,true);
			$reultdata["Result"] = $manage['attributes'];
			echo json_encode($reultdata); 
		}
		
		
	/*public function newFilterWebAction(){
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
			
			$Zipcode = trim ( $this->getRequest ()->getParam ( 'zipcode' ) );
			$radius = trim ( $this->getRequest ()->getParam ( 'radius' ) ); 
			$count = trim ( $this->getRequest ()->getParam ( 'count' ) );
			$Zipcode = 94536;
			$radius = 50;
			$count = "20";
			if($Zipcode!=""){
				function getLnt($zip){
			
				$datalist;
				$url = "http://maps.googleapis.com/maps/api/geocode/json?address=
				".urlencode($zip)."&sensor=false";
				$result_string = file_get_contents($url);
				$result = json_decode($result_string, true);
				$result1[]=$result['results'][0];
				$result2[]=$result1[0]['geometry'];
				$result3[]=$result2[0]['location'];
				return $result;
			}
			
			do {
				$datalist = getLnt($Zipcode);
				
			} while ($datalist['status'] !="OK");
			
				$result1[]=$datalist['results'][0];
				$result2[]=$result1[0]['geometry'];
				$result3[]=$result2[0]['location'];
				
				$valueslist = $result3[0];
				$lat  =  $valueslist['lat'];
				$lng = $valueslist['lng'];
				
				$locationdata = $this->Showroom->getDealerFromRadius($lat, $lng, $radius);
				
				//$length = count($locationdata);
				//echo json_encode($length);
				//for ($i = 0; $i < $length; $i++) {
				//$valuelist = $locationdata[$i];
				//$datacount = $valuelist['Dealer_ID'];
				$variable = $this->Showroom->locationbasedcars($locationdata);
				echo json_encode($variable);
				//}
				
			}else{
				echo "failed";
			}
			
			if($Zipcode!=""){
				function getLnt($zip){
			
				$datalist;
				$url = "http://maps.googleapis.com/maps/api/geocode/json?address=
				".urlencode($zip)."&sensor=false";
				$result_string = file_get_contents($url);
				$result = json_decode($result_string, true);
				$result1[]=$result['results'][0];
				$result2[]=$result1[0]['geometry'];
				$result3[]=$result2[0]['location'];
				return $result;
			}
			
			do {
				$datalist = getLnt($Zipcode);
				
			} while ($datalist['status'] !="OK");
			
				$result1[]=$datalist['results'][0];
				$result2[]=$result1[0]['geometry'];
				$result3[]=$result2[0]['location'];
				
				$valueslist = $result3[0];
				$lat  =  $valueslist['lat'];
				$lng = $valueslist['lng'];
				$locationdata = $this->Showroom->getDealerFromRadius($lat, $lng, $radius);
				$length = count($locationdata);
				for ($i = 0; $i < $length; $i++) {
				//$valuelist = $locationdata[$i];
				//$example = $valuelist['College_Id'];
				$dataview = $this->Showroom->locationbasedcarlist($locationdata[$i],$count);
				//$variable1 = $variable[0]; 
				///$varable2 = $variable1['NAME'];
				//$finallist[$i] = $varable2;
			}
				
				
				
				//$dataview = $this->Showroom->locationbasedcarlist($final);
				//echo json_encode($dataview);
			}else{
				echo "failed";
				}
				
		}*/	
		
		
}		
?>