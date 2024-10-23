<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
ob_start();

// Cập nhật thông tin hệ thống từ cơ sở dữ liệu vào session
$system = $conn->query("SELECT * FROM system_settings")->fetch_array();
foreach ($system as $k => $v) {
  $_SESSION['system'][$k] = $v;
}
ob_end_flush();

// Chuyển hướng nếu người dùng đã đăng nhập
if (isset($_SESSION['login_id'])) {
    header("location:index.php?page=home");
    exit();
}
?>
<?php include 'header.php'; ?>
<style>
    body {
        background-image: url('assets/img/Asia-Park.jpg'); 
        background-size: cover;
        background-repeat: no-repeat; 
        background-attachment: fixed; 
    }
    .login-box {
        background: rgba(255, 255, 255); 
        padding: 20px;
        border-radius: 10px;
    }
    .card {
        box-shadow: none;
    }
</style>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#" class="text-black"><b><?php echo htmlspecialchars($_SESSION['system']['name']); ?> </b></a>
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <form action="" id="login-form" method="POST">
        <!-- Email Input -->
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" required placeholder="Email" autocomplete="off">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <!-- Password Input -->
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" required placeholder="Password" autocomplete="off">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <!-- Remember Me -->
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $(document).ready(function(){
    $('#login-form').submit(function(e){
    e.preventDefault();
    start_load();
    if($(this).find('.alert-danger').length > 0) {
        $(this).find('.alert-danger').remove();
    }

    $.ajax({
        url: 'ajax.php?action=login',
        method: 'POST',
        data: $(this).serialize(),
        error: function(xhr, status, error) {
            console.error("Login error:", error);
            $('#login-form').prepend('<div class="alert alert-danger">Có lỗi xảy ra khi đăng nhập. Vui lòng thử lại.</div>');
            end_load();
        },
        success: function(resp){
            try {
                if(resp == 1) {
                    location.href = 'index.php?page=home';
                } else {
                    let error = JSON.parse(resp);
                    $('#login-form').prepend('<div class="alert alert-danger">' + error.msg + '</div>');
                }
            } catch(e) {
                console.error("Error parsing response:", e);
                $('#login-form').prepend('<div class="alert alert-danger">Có lỗi xảy ra. Vui lòng thử lại.</div>');
            }
            end_load();
        }
    });
});
  });
</script>
<?php include 'footer.php'; ?>
</body>
</html>
