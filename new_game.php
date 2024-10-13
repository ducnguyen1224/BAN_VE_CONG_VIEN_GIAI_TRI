<?php if(!isset($conn)){ include 'db_connect.php'; } ?>
<style>
  textarea{
    resize: none;
  }
</style>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-game">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="row">
          <div class="col-md-12">
            <div id="msg" class=""></div>

            <div class="row">
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">Tên trò chơi</label>
            <!--tao input de nhap ten chuyen di-->
                <textarea name="game" id="" cols="30" rows="2" class="form-control"><?php echo isset($game) ? $game : '' ?></textarea>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6 form-group ">
                 <!--tao input de nhap mo ta -->
                <label for="" class="control-label">Mô Tả</label>
                <textarea name="description" id="" cols="30" rows="3" class="form-control"><?php echo isset($description) ? $description : '' ?></textarea>
              </div>
            </div>
          </div>
        </div>
      </form>
  	</div>
  	<div class="card-footer border-top border-info">
  		<div class="d-flex w-100 justify-content-center align-items-center">
  			<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-game">Lưu</button>
  			<a class="btn btn-flat bg-gradient-secondary mx-2" href="./index.php?page=games_list">Hủy</a>
  		</div>
  	</div>
	</div>
</div>
<script>
	$('#manage-game').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_game',
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
              location.href = 'index.php?page=games_list' /*điều hướng về trang danh sách chuyến đi*/
					},2000)
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
