<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary " href="./index.php?page=new_promo"><i class="fa fa-plus"></i> Thêm Mới</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<!-- <colgroup>
					<col width="5%">
					<col width="15%">
					<col width="25%">
					<col width="25%">
					<col width="15%">
				</colgroup> -->
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Tên khuyến mãi </th>
						<th>Giảm giá</th>
						<th>Hành động</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM promo ORDER BY name_promo ASC");

					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<td class="text-center"><?php echo $i++ ?></td>
						<td class=""><b><?php echo $row['name_promo'] ?></b></td>
						<td><p><small><?php echo $row['discount'] ?></small></p></td>
						<td class="text-center">
		                    <div class="btn-group">
								<!---thực hiện được việc chuyển hướng đến trang view_promo.php và truyền id của chuyến đi-->
		                        <a href="index.php?page=edit_promo&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-flat ">
		                          <i class="fas fa-edit"></i>                                  
		                        </a>
		                        <button type="button" class="btn btn-danger btn-flat delete_promo" data-id="<?php echo $row['id'] ?>">
		                          <i class="fas fa-trash"></i>
		                        </button>
	                      </div>
						</td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<style>
	table td{
		vertical-align: middle !important;
	}
</style>
<script>
	// Khi tài liệu đã được tải xong
	$(document).ready(function(){
		// Khởi tạo bảng với DataTable cho danh sách có id là #list
		$('#list').dataTable()

		// Khi người dùng nhấn vào nút có class là 'view_promo'
		$('.view_promo').click(function(){
			// Mở một modal (cửa sổ) với nội dung là chi tiết chuyến đi tương ứng
			// Hàm 'uni_modal' nhận tham số tiêu đề, URL và kích thước của modal (ở đây là 'large')
			uni_modal("Chi tiết chuyến đi", "view_promo.php?id=" + $(this).attr('data-id'), "large")
		})

		// Khi người dùng nhấn vào nút có class là 'delete_promo'
		$('.delete_promo').click(function(){
			// Hiển thị hộp thoại xác nhận xóa. Hàm '_conf' sẽ hiển thị thông báo xác nhận
			// Nếu người dùng đồng ý, hàm 'delete_promo' sẽ được gọi với tham số là id của chuyến đi cần xóa
			_conf("Bạn có chắc chắn muốn xóa trò chơi này?", "delete_promo", [$(this).attr('data-id')])
		})
	})

	// Hàm thực hiện xóa chuyến đi có id đã cung cấp
	function delete_promo($id){
		// Bắt đầu tải (có thể là hiển thị một spinner hay thông báo tải)
		start_load()

		// Thực hiện một yêu cầu AJAX đến file 'ajax.php?action=delete_promo' để xóa dữ liệu
		$.ajax({
			url: 'ajax.php?action=delete_promo', // URL xử lý yêu cầu xóa
			method: 'POST', // Phương thức POST để gửi yêu cầu
			data: { id: $id }, // Dữ liệu là id của chuyến đi
			success: function(resp){
				// Nếu phản hồi từ server là 1 (thành công)
				if(resp == 1){
					// Hiển thị thông báo toast thành công
					alert_toast("Dữ liệu đã được xóa thành công", 'success')

					// Sau 1.5 giây, trang sẽ tự động tải lại để cập nhật danh sách
					setTimeout(function(){
						location.reload()
					}, 1500)
				}
			}
		})
	}
</script>

