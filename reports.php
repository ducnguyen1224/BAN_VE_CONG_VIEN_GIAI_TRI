<?php include 'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<div class="d-flex w-100 px-1 py-2 justify-content-center align-items-center">
				<?php 
				$status_arr = array(
					"Hàng đã được chấp nhận bởi bưu tá", 
					"Đã thu gom", 
					"Đã giao hàng", 
					"Đang vận chuyển", 
					"Đã đến nơi", 
					"Đang giao hàng", 
					"Sẵn sàng để nhận", 
					"Đã giao", 
					"Đã nhận", 
					"Thử giao hàng không thành công"
				); 
				?>
				<label for="date_from" class="mx-1">Từ</label>
				<input type="date" id="date_from" class="form-control form-control-sm col-sm-3" value="<?php echo isset($_GET['date_from']) ? date("Y-m-d", strtotime($_GET['date_from'])) : '' ?>">
				<label for="date_to" class="mx-1">Đến</label>
				<input type="date" id="date_to" class="form-control form-control-sm col-sm-3" value="<?php echo isset($_GET['date_to']) ? date("Y-m-d", strtotime($_GET['date_to'])) : '' ?>">
				<button class="btn btn-sm btn-primary mx-1 bg-gradient-primary" type="button" id="view_report">Xem Báo Cáo</button>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
        					<button type="button" class="btn btn-success float-right" style="display: none" id="print"><i class="fa fa-print"></i> In</button>
						</div>
					</div>	
					
					<table class="table table-bordered" id="report-list">
						<thead>
							<tr>
								<th>#</th>
								<th>Ngày</th>
								<th>Khách hàng</th>
								<th>Vé cho</th>
								<th>Vé người lớn</th>
								<th>Giá vé người lớn</th>
								<th>Vé trẻ em</th>
								<th>Giá vé trẻ em</th>
								<th>Trạng thái thanh toán</th>
								<th>Khuyến mãi</th>	
								<th>Người bán</th>
								<th>Tổng số tiền</th>
							</tr>
						</thead>
						<tbody></tbody>
						<tfoot>
							<th colspan="10">Tổng doanh số</th>
							<th id="total" class="text-right"></th>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<noscript>
	<style>
		table.table {
			width: 100%;
			border-collapse: collapse;
		}
		table.table tr, table.table th, table.table td {
			border: 1px solid;
		}
		.text-center {
			text-align: center;
		}
		.text-right {
			text-align: right;
		}
	</style>
</noscript>
<div class="details d-none">
	<h3 class="text-center"><b>Báo cáo tính đến <span id="drange"></span></b></h3>
</div>
<script>
	function load_report() {
		start_load(); // Show loading spinner
		
		var date_from = $('#date_from').val();
		var date_to = $('#date_to').val();
		var status = $('#status').val();

		var dates = moment(date_from).format("MMM-D-YYYY") + ' - ' + moment(date_to).format("MMM-D-YYYY");
		$('#drange').text(dates);

		$.ajax({
			url: 'ajax.php?action=get_report',
			method: 'POST',
			data: { status: status, date_from: date_from, date_to: date_to },
			error: function(err) {
				console.log(err);
				alert_toast("Đã xảy ra lỗi", 'error');
				end_load();
			},
			success: function(resp) {
				if (typeof resp === 'object' || Array.isArray(resp) || typeof JSON.parse(resp) === 'object') {
					resp = JSON.parse(resp);

					if (Object.keys(resp).length > 0) {
						$('#report-list tbody').html('');
						var i = 1;
						var total = 0;

						Object.keys(resp).map(function(k) {
							var tr = $('<tr></tr>');
							tr.append('<td>' + (i++) + '</td>');
							tr.append('<td>' + (resp[k].date_created) + '</td>');
							tr.append('<td>' + (resp[k].name) + '</td>');
							tr.append('<td>' + (resp[k].ticket_for) + '</td>');
							tr.append('<td>' + (resp[k].no_adult) + '</td>');
							tr.append('<td>' + (resp[k].adult_price) + '</td>');
							tr.append('<td>' + (resp[k].no_child) + '</td>');
							tr.append('<td>' + (resp[k].child_price) + '</td>');
							tr.append('<td>' + (resp[k].payment_id) + '</td>');
							tr.append('<td>' + (resp[k].promo_id) + '</td>');
							tr.append('<td>' + (resp[k].user_id) + '</td>');
							tr.append('<td>' + (resp[k].amount) + '</td>');
						

							var amount = parseFloat(resp[k].amount.replace(/,/g, '')) || 0;
							total += amount;

							$('#report-list tbody').append(tr);
						});

						$('#total').text(total.toLocaleString('vi-VN', { style: 'decimal', minimumFractionDigits: 2, maximumFractionDigits: 2 }));
						$('#print').show();
					} else {
						$('#report-list tbody').html('');
						var tr = $('<tr></tr>');
						tr.append('<th class="text-center" colspan="11">Không có kết quả.</th>');
						$('#report-list tbody').append(tr);

						$('#total').text('0.00');
						$('#print').hide();
					}
				}
			},
			complete: function() {
				end_load();
			}
		});
	}

	$('#view_report').click(function() {
		if ($('#date_from').val() == '' || $('#date_to').val() == '') {
			alert_toast("Vui lòng chọn ngày trước.", "error");
			return false;
		}
		load_report();

		var date_from = $('#date_from').val();
		var date_to = $('#date_to').val();
		var target = './index.php?page=reports&filtered&date_from=' + date_from + '&date_to=' + date_to;
		window.history.pushState({}, null, target);
	});

	$(document).ready(function() {
		if ('<?php echo isset($_GET['filtered']) ?>' == 1) {
			load_report();
		}
	});

	$('#print').click(function() {
		start_load();

		var ns = $('noscript').clone();
		var details = $('.details').clone();
		var content = $('#report-list').clone();

		ns.append(details);
		ns.append(content);

		var nw = window.open('', '', 'height=700,width=900');
		nw.document.write(ns.html());
		nw.document.close();
		nw.print();

		setTimeout(function() {
			nw.close();
			end_load();
		}, 750);
	});
</script>
