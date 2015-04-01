MySQL Transaction:
mysql_query("START TRANSACTION"); //mysql_query("BEGIN");
  	$a1 = mysql_query("INSERT INTO customer(name) VALUES('KABIR')");
  	$a2 = mysql_query("INSERT INTO customer(name) VALUES('Hossain')");
if($a1 and $a2){
	mysql_query("COMMIT");
}else {        
    mysql_query("ROLLBACK");
}


CodeIgniterTransaction:
$this->db->trans_start();
$this->db->query("INSERT INTO customer(name) VALUES('KABIR')");
$this->db->query("INSERT INTO customer(name) VALUES('Hossain')");
$this->db->trans_complete();
if($this->db->trans_status=== TRUE)
	echo “Success”;
else
	echo “Failed”;
