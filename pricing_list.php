<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_pricing"><i class="fa fa-plus"></i> Thêm Mới</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table table-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Vé cho</th>
						<th>Trò chơi</th>
						<th>Giá vé người lớn</th>
						<th>Giá vé trẻ em</th>
						<th>Hành động</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$game['all'] = "Tất cả";
					$game[0] = "Không có";
					$games = $conn->query("SELECT * FROM games order by game asc");
					while($row=$games->fetch_assoc()){
						$game[$row['id']] = ucwords($row['game']);
					}
					$qry = $conn->query("SELECT * FROM pricing order by name asc ");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<td class="text-center"><?php echo $i++ ?></td>
						<td class=""><b><?php echo ucwords($row['name']) ?></b></td>
						<td><p><small><?php echo $game[$row['game_id']] ?></small></p></td>
						<td><p class="text-right"><?php echo number_format($row['adult_price']) ?></p></td>
						<td><p class="text-right"><?php echo number_format($row['child_price']) ?></p></td>
						<td class="text-center">
		                    <div class="btn-group">
		                        <a href="index.php?page=edit_pricing&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-flat ">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <button type="button" class="btn btn-danger btn-flat delete_pricing" data-id="<?php echo $row['id'] ?>">
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
	$(document).ready(function(){
		$('#list').dataTable()
		$('.view_pricings').click(function(){
			uni_modal("Chi tiết giá vé","view_pricings.php?id="+$(this).attr('data-id'),"large")
		})
	$('.delete_pricing').click(function(){
	_conf("Bạn có chắc chắn muốn xóa giá vé này không?","delete_pricing",[$(this).attr('data-id')])
	})
	})
	function delete_pricing($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_pricing',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Dữ liệu đã được xóa thành công",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>
