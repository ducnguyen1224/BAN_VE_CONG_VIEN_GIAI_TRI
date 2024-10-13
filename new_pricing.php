<?php if(!isset($conn)){ include 'db_connect.php'; } ?>
<style>
  textarea{
    resize: none;
  }
</style>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-pricing">
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
                <label for="" class="control-label">Vé Cho</label>
                <input name="name" id="" class="form-control form-control-sm" value="<?php echo isset($name) ? $name : '' ?>" required>
              </div>
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">Chuyến Đi</label>
                <select name="game_id" id="game_id" class="form-control form-control-sm select2" required >
                  <option value=""></option>
                  <option value="0" <?php echo isset($game_id) && $game_id == 0 ? "selected" : '' ?>>Không</option>
                  <option value="all" <?php echo isset($game_id) && $game_id == 'all' ? "selected" : '' ?>>Tất cả</option>
                  <?php 
                    $games = $conn->query("SELECT * FROM games order by game asc");
                    while($row=$games->fetch_assoc()): 
                  ?>
                  <option value="<?php echo $row['id'] ?>"><?php echo ucwords($row['game']) ?></option>
                  <?php endwhile; ?>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">Giá Người Lớn</label>
                <input name="adult_price" id="" class="form-control form-control-sm number text-right" value="<?php echo isset($adult_price) ? $adult_price : 0 ?>" onfocus="if($(this).val() == 0 ){$(this).select()}" required>
              </div>
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">Giá Trẻ Em</label>
                <input name="child_price" id="" class="form-control form-control-sm number text-right" value="<?php echo isset($child_price) ? $child_price : 0 ?>" onfocus="if($(this).val() == 0 ){$(this).select()}" required>
              </div>
            </div>
          </div>
        </div>
      </form>
  	</div>
  	<div class="card-footer border-top border-info">
  		<div class="d-flex w-100 justify-content-center align-items-center">
  			<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-pricing">Lưu</button>
  			<a class="btn btn-flat bg-gradient-secondary mx-2" href="./index.php?page=pricing_list">Hủy</a>
  		</div>
  	</div>
	</div>
</div>
<script>
	$('#manage-pricing').submit(function(e){
		e.preventDefault()
		start_load()
    $('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_pricing',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Dữ liệu đã được lưu thành công',"success");
					setTimeout(function(){
              location.href = 'index.php?page=pricing_list'
					},2000)
				}else if(resp ==2){
          $('#msg').html('<div class="alert alert-danger">Giá vé cho chuyến đi đã chọn đã tồn tại.</div>')
          end_load()
        }
			}
		})
	})
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
