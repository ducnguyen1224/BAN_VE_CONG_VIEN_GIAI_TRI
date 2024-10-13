<?php include('db_connect.php') ?>
<?php
$twhere ="";
if($_SESSION['login_type'] != 1)
  $twhere = "  ";
?>
<!-- Các hộp thông tin -->
<?php if($_SESSION['login_type'] == 1): ?>
  <!-- khi đăng nhập thành công thì sẽ đưa người dùng vào giao diện trang chủ -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php echo $conn->query("SELECT * FROM games")->num_rows; ?></h3>
               <!-- Số lượng trò chơi -->
                <p>Các trò chơi </p>
              </div>
              <div class="icon">
                <i class="fa fa-building"></i>
              </div>
            </div>
          </div>
           <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php $sales = $conn->query("SELECT sum(amount) as sales FROM ticket_list where date(date_created) ='".date('Y-m-d')."' "); echo $sales->num_rows > 0 ? number_format($sales->fetch_array()['sales']) : '0.00' ?></h3>
 <!-- thực hiện việc truy vấn : tình tổng doanh thu(amount) từ bảng ticket_list ở thời gian là ngày hôm nay == với thời gian hàm cập nhật  -->
                <p>Tổng Doanh Thu Hôm Nay</p>
              </div>
              <div class="icon">
                <i class="fa fa-chart-line"></i>
              </div>
            </div>
          </div>
      </div>

<?php else: ?>
     <div class="col-12">
          <div class="card">
          	<div class="card-body">
          		Chào mừng <?php echo $_SESSION['login_name'] ?>!
          	</div>
          </div>
      </div>
          
<?php endif; ?>
