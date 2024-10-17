

<?php



session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		extract($_POST);
			$qry = $this->db->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where email = '".$email."' and password = '".md5($password)."'  ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 2;
		}
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function login2(){
		extract($_POST);
			$qry = $this->db->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM students where student_code = '".$student_code."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['rs_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function save_user(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cpass','password')) && !is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if(!empty($password)){
					$data .= ", password=md5('$password') ";

		}
		$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set $data");
		}else{
			$save = $this->db->query("UPDATE users set $data where id = $id");
		}

		if($save){
			return 1;
		}
	}
	function signup(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cpass')) && !is_numeric($k)){
				if($k =='password'){
					if(empty($v))
						continue;
					$v = md5($v);

				}
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}

		$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
		}
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'],'../assets/uploads/'. $fname);
			$data .= ", avatar = '$fname' ";

		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set $data");

		}else{
			$save = $this->db->query("UPDATE users set $data where id = $id");
		}

		if($save){
			if(empty($id))
				$id = $this->db->insert_id;
			foreach ($_POST as $key => $value) {
				if(!in_array($key, array('id','cpass','password')) && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
					$_SESSION['login_id'] = $id;
			return 1;
		}
	}

	function update_user(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cpass','table','password')) && !is_numeric($k)){
				
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
		}
		if(!empty($password))
			$data .= " ,password=md5('$password') ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set $data");
		}else{
			$save = $this->db->query("UPDATE users set $data where id = $id");
		}

		if($save){
			foreach ($_POST as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
			return 1;
		}
	}
	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = ".$id);
		if($delete)
			return 1;
	}
	function save_system_settings(){
		extract($_POST);
		$data = '';
		foreach($_POST as $k => $v){
			if(!is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if($_FILES['cover']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['cover']['name'];
			$move = move_uploaded_file($_FILES['cover']['tmp_name'],'../assets/uploads/'. $fname);
			$data .= ", cover_img = '$fname' ";

		}
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set $data where id =".$chk->fetch_array()['id']);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set $data");
		}
		if($save){
			foreach($_POST as $k => $v){
				if(!is_numeric($k)){
					$_SESSION['system'][$k] = $v;
				}
			}
			if($_FILES['cover']['tmp_name'] != ''){
				$_SESSION['system']['cover_img'] = $fname;
			}
			return 1;
		}
	}
	function save_image(){
		extract($_FILES['file']);
		if(!empty($tmp_name)){
			$fname = strtotime(date("Y-m-d H:i"))."_".(str_replace(" ","-",$name));
			$move = move_uploaded_file($tmp_name,'../assets/uploads/'. $fname);
			$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
			$hostName = $_SERVER['HTTP_HOST'];
			$path =explode('/',$_SERVER['PHP_SELF']);
			$currentPath = '/'.$path[1]; 
			if($move){
				return $protocol.'://'.$hostName.$currentPath.'/assets/uploads/'.$fname;
			}
		}
	}
	function save_game(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id')) && !is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO games set $data");
		}else{
			$save = $this->db->query("UPDATE games set $data where id = $id");
		}
		if($save){
			return 1;
		}
	}
	function delete_game(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM games where id = $id");
		if($delete){
			return 1;
		}
	}
	function save_promo(){
		extract($_POST);
		$data = "";
		
		// Xử lý dữ liệu đầu vào và xây dựng chuỗi truy vấn
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id')) && !is_numeric($k)){
				$v = $this->db->real_escape_string($v); // Tránh SQL injection
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		
		// Kiểm tra xem có ID không, nếu không thì chèn mới, nếu có thì cập nhật
		if(empty($id)){
			$save = $this->db->query("INSERT INTO promo SET $data");
		}else{
			$id = $this->db->real_escape_string($id); // Thêm bảo mật cho id
			$save = $this->db->query("UPDATE promo SET $data WHERE id = $id");
		}
		
		// Kiểm tra kết quả lưu
		if($save){
			return 1;
		} else {
			// Trả về thông báo lỗi nếu lưu thất bại
			return json_encode(array('status' => 0, 'error' => $this->db->error));
		}
	}
	function delete_promo(){
		extract($_POST);
		
		// Kiểm tra xem ID có tồn tại và hợp lệ không
		if(!empty($id)){
			$id = $this->db->real_escape_string($id); // Tránh SQL injection
			$delete = $this->db->query("DELETE FROM promo WHERE id = $id");
			
			// Kiểm tra kết quả của việc xóa
			if($delete){
				return 1;
			} else {
				// Trả về thông báo lỗi nếu xóa thất bại
				return json_encode(array('status' => 0, 'error' => $this->db->error));
			}
		} else {
			return json_encode(array('status' => 0, 'error' => 'ID không hợp lệ.'));
		}
	}
	
	function save_pricing(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id')) && !is_numeric($k)){
				if(in_array($k, array('adult_price','child_price')))
					$v = str_replace(',', '', $v);
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		$chk = $this->db->query("SELECT * FROM pricing where name='$name' and game_id = '$game_id' and id !='$id' ")->num_rows;
		if($chk > 0){
			return 2;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO pricing set $data");
		}else{
			$save = $this->db->query("UPDATE pricing set $data where id = $id");
		}
		if($save){
			return 1;
		}
	}
	function delete_pricing(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM pricing where id = $id");
		if($delete){
			return 1;
		}
	}
	// function save_ticket(){
	// 	extract($_POST);
	// 	$data = "";
	// 	foreach($_POST as $k => $v){
	// 		if(!in_array($k, array('id','game_id')) && !is_numeric($k)){
	// 			if(in_array($k, array('no_adult','no_child','amount','tendered')))
	// 				$v = str_replace(',', '', $v);
	// 			if(empty($data)){
	// 				$data .= " $k='$v' ";
	// 			}else{
	// 				$data .= ", $k='$v' ";
	// 			}
	// 		}
	// 	}
	// 	if(empty($id)){
	// 		$save = $this->db->query("INSERT INTO ticket_list set $data");
	// 		if($save)
	// 			$id = $this->db->insert_id;
	// 	}else{
	// 		$save = $this->db->query("UPDATE ticket_list set $data where id = $id");
	// 	}
	// 	if($save){
	// 		$this->db->query("DELETE FROM ticket_items where ticket_id = $id");
	// 		for($i = 0 ; $i < $no_adult;$i++){
	// 			$data= " ticket_id = $id ";
	// 			$data.= ", game_id = '$game_id' ";
	// 			$data.= ", type = 1 ";
	// 			$c = 0;
	// 			while($c==0){
	// 				$code = sprintf("%'012d",mt_rand(0, 999999999999));
	// 				$chk = $this->db->query("SELECT * FROM ticket_items where ticket_no = '$code'")->num_rows;
	// 				if($chk <= 0)
	// 					$c =1;
	// 			}
	// 			$data.= ",  ticket_no= '$code' ";
	// 			$this->db->query("INSERT INTO ticket_items set $data");
	// 		}
	// 		for($i = 0 ; $i < $no_child;$i++){
	// 			$data= " ticket_id = $id ";
	// 			$data.= ", game_id = '$game_id' ";
	// 			$data.= ", type = 2 ";
	// 			$c = 0;
	// 			while($c==0){
	// 				$code = sprintf("%'012d",mt_rand(0, 999999999999));
	// 				$chk = $this->db->query("SELECT * FROM ticket_items where ticket_no = '$code'")->num_rows;
	// 				if($chk <= 0)
	// 					$c =1;
	// 			}
	// 			$data.= ",  ticket_no= '$code' ";
	// 			$this->db->query("INSERT INTO ticket_items set $data");
	// 		}
	// 		return json_encode(array('status'=>1,'id'=>$id));
	// 	}
	// }

	function save_ticket() {
		extract($_POST);
		$data = "";
	
		// Kiểm tra nếu có chương trình khuyến mãi được chọn
		$promo_id = isset($promo_id) ? $promo_id : null;
		
		// Xây dựng chuỗi dữ liệu cho các trường khác trong POST (ngoại trừ 'id', 'game_id' và các trường số)
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'game_id')) && !is_numeric($k)) {
				// Loại bỏ dấu phẩy khỏi các trường số
				if (in_array($k, array('no_adult', 'no_child', 'amount', 'tendered'))) {
					$v = str_replace(',', '', $v);
				}
				if (empty($data)) {
					$data .= "$k='$v'";
				} else {
					$data .= ", $k='$v'";
				}
			}
		}
	
		// Thêm chương trình khuyến mãi vào chuỗi dữ liệu
		// if ($promo_id) {
		// 	$data .= ", promo_id='$promo_id'";
		// }
	
		// Thêm trạng thái thanh toán vào chuỗi dữ liệu
		$payment_status = isset($payment_status) ? $payment_status : 'pending'; // Nếu không có payment_status, mặc định là 'pending'
	
		// Kiểm tra xem có ID hay không để quyết định chèn mới hay cập nhật
		if (empty($id)) {
			// Chèn dữ liệu mới vào bảng ticket_list
			$save = $this->db->query("INSERT INTO ticket_list SET $data");
	
			if ($save) {
				$id = $this->db->insert_id; // Lấy ID vừa chèn
			}
		} else {
			// Cập nhật dữ liệu với ID hiện có
			$save = $this->db->query("UPDATE ticket_list SET $data WHERE id = $id");
		}
	
		// Xử lý chèn hoặc cập nhật vé người lớn và trẻ em
		if ($save) {
			// Xóa các mục vé hiện tại trước khi chèn mới
			$this->db->query("DELETE FROM ticket_items WHERE ticket_id = $id");
	
			// Chèn vé người lớn
			for ($i = 0; $i < $no_adult; $i++) {
				$data = "ticket_id = $id";
				$data .= ", game_id = '$game_id'";
				$data .= ", type = 1"; // Người lớn
				$c = 0;
				while ($c == 0) {
					$code = sprintf("%'012d", mt_rand(0, 999999999999));
					$chk = $this->db->query("SELECT * FROM ticket_items WHERE ticket_no = '$code'")->num_rows;
					if ($chk <= 0) {
						$c = 1;
					}
				}
				$data .= ", ticket_no = '$code'";
				$this->db->query("INSERT INTO ticket_items SET $data");
			}
	
			// Chèn vé trẻ em
			for ($i = 0; $i < $no_child; $i++) {
				$data = "ticket_id = $id";
				$data .= ", game_id = '$game_id'";
				$data .= ", type = 2"; // Trẻ em
				$c = 0;
				while ($c == 0) {
					$code = sprintf("%'012d", mt_rand(0, 999999999999));
					$chk = $this->db->query("SELECT * FROM ticket_items WHERE ticket_no = '$code'")->num_rows;
					if ($chk <= 0) {
						$c = 1;
					}
				}
				$data .= ", ticket_no = '$code'";
				$this->db->query("INSERT INTO ticket_items SET $data");
			}
	
			
	
			// Cập nhật lại số tiền phải trả
			$this->db->query("UPDATE ticket_list SET amount = '$amount' WHERE id = $id");
	
			// Trả về JSON với trạng thái thành công và ID vé
			return json_encode(array('status' => 1, 'id' => $id));
		}
	}
	
	
	
	function delete_ticket(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM ticket_list where id = $id");
		if($delete){
			return 1;
		}
	}

	function get_report(){
		extract($_POST);
		$data = array();
	
	
	
	
		// Second query
	// Cập nhật truy vấn SQL để lấy thêm adult_price và child_price từ bảng pricing
$get = $this->db->query("SELECT t.*, p.name as ticket_for, p.adult_price, p.child_price, pay.type as payment_id,dis.name_promo as promo_id
FROM ticket_list t
INNER JOIN pricing p ON p.id = t.pricing_id
LEFT JOIN payment pay ON t.payment_id = pay.id
LEFT JOIN promo dis ON t.promo_id = dis.id
WHERE date(t.date_created) BETWEEN '$date_from' AND '$date_to'
ORDER BY unix_timestamp(t.date_created) DESC");

if ($get === false) {
// Xử lý lỗi truy vấn
return json_encode(array('error' => 'Failed to execute query 2'));
}

while($row = $get->fetch_assoc()){
$row['date_created'] = date("M d, Y", strtotime($row['date_created']));
$row['name'] = ucwords($row['name']);
$row['adult_price'] = isset($row['adult_price']) ? $row['adult_price'] : '0.00'; // Lấy giá vé người lớn
$row['child_price'] = isset($row['child_price']) ? $row['child_price'] : '0.00'; // Lấy giá vé trẻ em
$row['payment_id'] = ucwords($row['payment_id']);
$row['promo_id'] = ucwords($row['promo_id']);
$row['amount'] = number_format($row['amount'], 2);
$data[] = $row;
}

return json_encode($data);

	}
}