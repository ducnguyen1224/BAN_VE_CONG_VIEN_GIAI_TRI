<?php
ob_start();
date_default_timezone_set("Asia/Manila");

$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'login2'){
	$login = $crud->login2();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'logout2'){
	$crud->logout();
	if($logout)
		echo $logout;
}

if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'update_user'){
	$save = $crud->update_user();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'save_game'){
	$save = $crud->save_game();
	if($save)
		echo $save;
}
if($action == 'delete_game'){
	$save = $crud->delete_game();
	if($save)
		echo $save;
}
if($action == 'save_pricing'){
	$save = $crud->save_pricing();
	if($save)
		echo $save;
}
if($action == 'delete_pricing'){
	$save = $crud->delete_pricing();
	if($save)
		echo $save;
}
if($action == 'save_ticket'){
	$save = $crud->save_ticket();
	if($save)
		echo $save;
}
if($action == 'delete_ticket'){
	$save = $crud->delete_ticket();
	if($save)
		echo $save;
}
if($action == 'print_ticket'){
	$save = $crud->print_ticket();
	if($save)
		echo $save;
}
if($action == 'get_report'){
	$get = $crud->get_report();
	if($get)
		echo $get;
}
if($action == 'save_promo'){
	$save = $crud->save_promo();
	if($save)
		echo $save;
}
if($action == 'delete_promo'){
	$save = $crud->delete_promo();
	if($save)
		echo $save;
}
ob_end_flush();
?>
<?php

?>
