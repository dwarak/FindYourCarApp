<?php
class Classes_ScrapeLoadDB extends Classes_DBAdapter
{
	public function __construct(){
		parent::__construct();
	}
	public static function truncate(){
		$self=new self();
		$truncs="TRUNCATE TABLE scrapedata";
		$sql=$self->truncload($truncs);
		return $sql;
	}
	public static function qrylod($paths){
		$self=new self();
		$load="LOAD DATA INFILE '$paths' INTO TABLE scrapedata FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n'";
		$sql=$self->truncload($load);
		return $sql;

	}
	public static function scrapeCurrentUpdate($filename){
		$self = new self ();
		$truncs="TRUNCATE TABLE scrape_current_update";
		$sql=$self->truncload($truncs);
		$data = array ("Scrape_File_Name" => $filename);
		$result = $self->insertValues ( "scrape_current_update", $data );
		return $result;

	}
	public static function getscrapeCurrentUpdate() {
		$self = new self ();
		$sql = "select Scrape_File_Name from scrape_current_update";
		$data = $self->getData ( $sql );
		return $data;
	}
	
	
	
	
	
	
	
	
	
	

}
?>