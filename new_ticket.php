

<?php if(!isset($conn)){ include 'db_connect.php'; } ?>
<style>
  textarea{
    resize: none;
  }
</style>



<div class="col-lg-12">
    <div class="card card-outline card-primary">
        <div class="card-body">
            <form action="" id="manage-ticket">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-sm-6 ">
                <div id="msg" class=""></div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">Khách Hàng</label>
                <input name="name" id="" class="form-control form-control-sm" value="<?php echo isset($name) ? $name : '' ?>" required>
              </div>
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">Vé Dành Cho</label>
                <select name="pricing_id" id="pricing_id" class="form-control form-control-sm select2" required >
                  <option value=""></option>
                  <?php 
                    $game['all'] = "Tất cả";
                    $game[0] = "Không";
                    $games = $conn->query("SELECT * FROM games order by game asc");
                    while($row=$games->fetch_assoc()){
                      $game[$row['id']] = ucwords($row['game']);
                    }
                    $pricing = $conn->query("SELECT * FROM pricing order by name asc");
                    while($row=$pricing->fetch_assoc()): 
                  ?>
                  <option value="<?php echo $row['id'] ?>" data-json='<?php echo json_encode($row) ?>' <?php echo isset($pricing_id) && $pricing_id == $row['id'] ?"selected": ""  ?>><?php echo ucwords($row['name'].'('.$game[$row['game_id']].')') ?></option>
                  <?php endwhile; ?>
                </select>
              </div>
            </div>
           <!-- <input type="hidden" name="adult_price" value="<?php echo isset($adult_price) ? $adult_price : '' ?>"> -->
            <!-- <input type="hidden" name="child_price" value="<?php echo isset($child_price) ? $child_price : '' ?>"> -->
            <input type="hidden" name="game_id" value="<?php echo isset($game_id) ? $game_id : '' ?>">
            <div class="row">
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">Số Lượng Người Lớn</label>
                <input name="no_adult" id="" class="form-control form-control-sm number text-right" value="<?php echo isset($no_adult) ? $no_adult : 0 ?>" onfocus="$(this).select()" onkeyup="update_tbl()" required>
              </div>
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">Số Lượng Trẻ Em</label>
                <input name="no_child" id="" class="form-control form-control-sm number text-right" value="<?php echo isset($no_child) ? $no_child : 0 ?>" onfocus="$(this).select()" onkeyup="update_tbl()" required>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-6">
                <table class="table table-condensed">
                  <thead>
                    <th>Loại</th>
                    <th class="text-right">Giá</th>
                    <th class="text-right">SL</th>
                  </thead>
                  <tbody>
                    <tr>
                      <th>Người Lớn</th>
                      <td class="text-right" id="aprice">0.000</td>
                      <td class="text-right" id="apax">0</td>
                    </tr>
                    <tr>
                      <th>Trẻ Em</th>
                      <td class="text-right" id="cprice">0.000</td>
                      <td class="text-right" id="cpax">0</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Số Tiền Phải Trả</label>
                  <input type="text" class="form-control form-control-sm text-right number" id="amount" name="amount" readonly="" required>
                </div>
                <div class="form-group">
                  <label for="">Số Tiền Đã Thanh Toán</label>
                  <input type="text" class="form-control form-control-sm text-right number" id="tendered" name="tendered" onkeyup="calc_change()" value="<?php echo isset($tendered) ? number_format($tendered) : '' ?>" required>
                </div>
                <div class="form-group">
                  <label for="">Tiền Thừa</label>
                  <input type="text" class="form-control form-control-sm text-right number" id="change" value="0" readonly="" required>
                </div>
                <div class="form-group">
                  <label for="payment_id">Phương Thức Thanh Toán</label>
                  <select name="payment_id" id="payment_id" class="form-control form-control-sm" required>
                    <option value="">-- Chọn --</option>
                    <option value="2">Tiền mặt</option>
                    <option value="1">Chuyển khoản</option>
                  </select>
                </div>
                <div class="row">
  <div class="col-sm-6 form-group ">
    <label for="" class="control-label">Chương Trình Khuyến Mãi</label>
    <select name="promo_id" id="promo_id" class="form-control form-control-sm">
      <option value="1">-- Không có khuyến mãi --</option>
      <?php 
       $promo = $conn->query("SELECT * FROM promo WHERE end_date >= CURDATE() OR end_date IS NULL order by name_promo asc");
        while($row=$promo->fetch_assoc()): 
      ?>
      <option value="<?php echo $row['id'] ?>" data-discount="<?php echo $row['discount'] ?>" data-end-date="<?php echo $row['end_date'] ?>">
    <?php echo ucwords($row['name_promo']) ?> (Giảm giá: <?php echo $row['discount'] ?>%)
</option>

      </option>
      <?php endwhile; ?>
    </select>
  </div>
</div>
<input type="hidden" name="user_id" value="<?php echo isset($_SESSION['login_id']) ? $_SESSION['login_id'] : '' ?>">

              </div>
            </div>
          </div>
        </div>
      </form>
      </div>
      <div class="card-footer border-top border-info">
          <div class="d-flex w-100 justify-content-center align-items-center">
              <button class="btn btn-flat bg-gradient-primary mx-2" form="manage-ticket">Lưu</button>
              <a class="btn btn-flat bg-gradient-secondary mx-2" href="./index.php?page=ticket_list">Hủy</a>
          </div>
      </div>
    </div>
</div>
<script>
  $('#pricing_id').change(function(){
    var id = $(this).val()
    var data = $(this).find('option[value="'+id+'"]').attr('data-json')
        data = JSON.parse(data)
        $('[name="adult_price"]').val(data.adult_price)
        $('[name="child_price"]').val(data.child_price)
        $('#aprice').text(parseFloat(data.adult_price).toLocaleString("en-US",{style:"decimal",minimumFractionDigits:2,maximumFractionDigits:2}))
       $('#cprice').text(parseFloat(data.child_price).toLocaleString("en-US",{style:"decimal",minimumFractionDigits:2,maximumFractionDigits:2}))
        $('[name="game_id"]').val(data.game_id)
        calc()
  })
  function update_tbl(){
    var na = $('[name="no_adult"]').val()
    var nc = $('[name="no_child"]').val()
    $('#apax').text(na)
    $('#cpax').text(nc)
    calc()
  }
  $('#promo_id').change(function(){
    var discount = $(this).find(':selected').data('discount') || 0;
    var endDate = $(this).find(':selected').data('end-date');
    var currentDate = new Date().toISOString().split('T')[0]; // Lấy ngày hiện tại

    // Kiểm tra nếu khuyến mãi đã hết hạn
    if (endDate && currentDate > endDate) {
        alert("Chương trình khuyến mãi này đã hết hạn.");
        $('#promo_id').val(''); // Xóa lựa chọn khuyến mãi
        return;
    }

    calc(discount); // Tính lại số tiền phải trả với giảm giá
});


function calc(discount = 0){
    var aprice = $('#aprice').text() > 0 ? $('#aprice').text() : 0;
    var cprice = $('#cprice').text() > 0 ? $('#cprice').text() : 0;
    var apax = $('#apax').text() > 0 ? $('#apax').text() : 0;
    var cpax = $('#cpax').text() > 0 ? $('#cpax').text() : 0;

    var amount = (parseFloat(aprice) * parseFloat(apax)) + (parseFloat(cprice) * parseFloat(cpax));
    
    // Tính giảm giá
    if(discount > 0) {
        amount = amount - (amount * (discount / 100));
    }

    $('#amount').val(parseFloat(amount).toLocaleString("en-US",{style:"decimal",minimumFractionDigits:2,maximumFractionDigits:2}));
    calc_change();
}


  function calc_change(){
      var amount = $('#amount').val();
      var tendered = $('#tendered').val();
          amount = amount.replace(/,/g,'')
          tendered = tendered.replace(/,/g,'')
          amount = amount > 0 ? amount : 0;
          tendered = tendered > 0 ? tendered : 0;
      var change = parseFloat(tendered) - parseFloat(amount) 
        $('#change').val(parseFloat(change).toLocaleString("en-US",{style:"decimal",minimumFractionDigits:2,maximumFractionDigits:2}))

  }
  $(document).ready(function(){
  if('<?php echo isset($id) ?>' == 1)
    $('#pricing_id').trigger('change')
    $('[name="no_child"],[name="no_adult"]').trigger('keyup')
  })
  $('#manage-ticket').submit(function(e){
    e.preventDefault();
    start_load();
    $('#msg').html('');

    // Debug form data
    var formData = new FormData($(this)[0]);
    console.log("Form data being submitted:");
    for (var pair of formData.entries()) {
        console.log(pair[0]+ ': ' + pair[1]); 
    }

    // Kiểm tra user_id
    if(!formData.get('user_id')) {
        $('#msg').html('<div class="alert alert-danger">Vui lòng đăng nhập để tiếp tục</div>');
        end_load();
        return false;
    }

    // Kiểm tra số tiền
    var amount = $('#amount').val();
    var tendered = $('#tendered').val();
    amount = amount.replace(/,/g,'');
    tendered = tendered.replace(/,/g,'');
    amount = amount > 0 ? amount : 0;
    tendered = tendered > 0 ? tendered : 0;

    if(parseFloat(amount) > parseFloat(tendered)){
        alert_toast("Số tiền đã thanh toán phải lớn hơn hoặc bằng số tiền phải trả.",'error');
        end_load();
        return false;
    }

    $.ajax({
        url: 'ajax.php?action=save_ticket',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        success: function(resp){
            try {
                if(resp) {
                    resp = JSON.parse(resp);
                    if(resp.status == 1){
                        alert_toast('Dữ liệu đã được lưu thành công',"success");
                        setTimeout(function(){
                            location.href = 'index.php?page=ticket_list'
                        }, 2000);
                    } else if(resp.status == 2){
                        $('#msg').html('<div class="alert alert-danger">Vé cho trò chơi được chọn và vé cho đã tồn tại.</div>');
                    } else if(resp.status == 0){
                        $('#msg').html('<div class="alert alert-danger">' + resp.msg + '</div>');
                    }
                }
            } catch(e) {
                console.error("Error parsing response:", e, resp);
                $('#msg').html('<div class="alert alert-danger">Có lỗi xảy ra khi xử lý phản hồi từ máy chủ</div>');
            }
            end_load();
        },
        error: function(xhr, status, error) {
            console.error("Ajax error:", error);
            $('#msg').html('<div class="alert alert-danger">Có lỗi khi gửi yêu cầu đến máy chủ</div>');
            end_load();
        }
    });
    // Thêm vào script sau khi login thành công
$.get('check_session.php', function(data) {
    console.log('Session after login:', data);
});
});
  function displayImgCover(input,_this) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $('#cover').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
      }
  }
</script> 