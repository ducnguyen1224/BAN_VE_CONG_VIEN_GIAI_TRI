<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * FROM ticket_list where id = ".$_GET['id'])->fetch_array();//select from ticket_list where id is equal to the id passed on the url
foreach($qry as $k => $v){
	$$k = $v;
}
include 'new_ticket.php';
?>