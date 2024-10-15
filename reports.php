<?php include 'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<div class="d-flex w-100 px-1 py-2 justify-content-center align-items-center">
			<?php 
			$status_arr = array("Hàng đã được chấp nhận bởi bưu tá","Đã thu gom","Đã giao hàng","Đang vận chuyển","Đã đến nơi","Đang giao hàng","Sẵn sàng để nhận","Đã giao","Đã nhận","Thử giao hàng không thành công"); ?>
				<label for="date_from" class="mx-1">Từ</label>
                <input type="date" id="date_from" class="form-control form-control-sm col-sm-3" value="<?php echo isset($_GET['date_from']) ? date("Y-m-d",strtotime($_GET['date_from'])) : '' ?>">
                <label for="date_to" class="mx-1">Đến</label>
                <input type="date" id="date_to" class="form-control form-control-sm col-sm-3" value="<?php echo isset($_GET['date_to']) ? date("Y-m-d",strtotime($_GET['date_to'])) : '' ?>">
                <button class="btn btn-sm btn-primary mx-1 bg-gradient-primary" type="button" id='view_report'>Xem Báo Cáo</button>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 ">
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
								<th>Tổng số tiền</th>
								<th>Trạng thái thanh toán </th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
						<tfoot>
							<th colspan="8">Tổng doanh số</th>
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
		table.table{
			width:100%;
			border-collapse: collapse;
		}
		table.table tr,table.table th, table.table td{
			border:1px solid;
		}
		.text-center{
			text-align: center;
		}
		.text-right{
			text-align: right;
		}
	</style>
</noscript>
<div class="details d-none">
	<h3 class="text-center"><b>Báo cáo tính đến <span id="drange"></span></b></h3>
</div>
<script>
	// Hàm load_report dùng để tải báo cáo dựa trên các thông tin lọc ngày tháng và trạng thái
	function load_report(){
		start_load() // Bắt đầu tải (hiển thị loading spinner)
		
		// Lấy giá trị từ các trường 'date_from', 'date_to' và 'status' từ HTML
		var date_from = $('#date_from').val()
		var date_to = $('#date_to').val()
		var status = $('#status').val()

		// Định dạng lại ngày tháng theo định dạng "MMM-D-YYYY" và hiển thị trong phần tử '#drange'
		var dates = moment(date_from).format("MMM-D-YYYY") + ' - ' + moment(date_to).format("MMM-D-YYYY")
		$('#drange').text(dates)

		// Thực hiện yêu cầu AJAX để lấy dữ liệu báo cáo từ server
		$.ajax({
			url: 'ajax.php?action=get_report', // URL sẽ gọi đến server để lấy báo cáo
			method: 'POST', // Sử dụng phương thức POST
			data: { status: status, date_from: date_from, date_to: date_to }, // Gửi dữ liệu gồm trạng thái, ngày bắt đầu và kết thúc
			error: err => { // Nếu xảy ra lỗi
				console.log(err) // In ra lỗi
				alert_toast("Đã xảy ra lỗi", 'error') // Hiển thị thông báo lỗi
				end_load() // Kết thúc tải (ẩn spinner)
			},
			success: function(resp){ // Khi thành công nhận được phản hồi từ server
				// Kiểm tra nếu phản hồi là một object hoặc có thể chuyển đổi sang object
				if (typeof resp === 'object' || Array.isArray(resp) || typeof JSON.parse(resp) === 'object') {
					resp = JSON.parse(resp) // Chuyển đổi phản hồi JSON sang object

					// Kiểm tra nếu phản hồi có dữ liệu
					if (Object.keys(resp).length > 0) {
						$('#report-list tbody').html('') // Xóa nội dung trước đó trong bảng
						var i = 1; // Biến đếm cho số thứ tự
						var total = 0; // Tổng số tiền

						// Duyệt qua từng phần tử trong phản hồi (resp) để hiển thị trong bảng
						Object.keys(resp).map(function(k){
							var tr = $('<tr></tr>') // Tạo một dòng mới trong bảng

							// Thêm các cột dữ liệu vào dòng
							tr.append('<td>' + (i++) + '</td>') // Số thứ tự
							tr.append('<td>' + (resp[k].date_created) + '</td>') // Ngày tạo
							tr.append('<td>' + (resp[k].name) + '</td>') // Tên khách hàng
							tr.append('<td>' + (resp[k].ticket_for) + '</td>') // Loại vé
							tr.append('<td>' + (resp[k].no_adult) + '</td>') // Số vé người lớn
							tr.append('<td>' + (resp[k].adult_price) + '</td>') // Giá vé người lớn
							tr.append('<td>' + (resp[k].no_child) + '</td>') // Số vé trẻ em
							tr.append('<td>' + (resp[k].child_price) + '</td>') // Giá vé trẻ em
							tr.append('<td class="text-right">' + (resp[k].amount) + '</td>') // Tổng số tiền
							tr.append('<td>' + (resp[k].payment_id) + '</td>') // Giá vé trẻ em
							// Xóa dấu phẩy trong số tiền và chuyển thành số
							var amount = resp[k].amount.replace(/,/g, '')
							amount = amount > 0 ? amount : 0;

							// Cộng tổng số tiền
							total = parseFloat(total) + parseFloat(amount)

							// Thêm dòng vào bảng
							$('#report-list tbody').append(tr)
						})

						// Hiển thị tổng doanh số đã tính toán
						$('#total').text(parseFloat(total).toLocaleString('vi-VN', { style: 'decimal', minimumFractionDigits: 2, maximumFractionDigits: 2 }))
						$('#print').show() // Hiển thị nút "In"
					} else {
						// Nếu không có dữ liệu thì hiển thị thông báo "Không có kết quả"
						$('#report-list tbody').html('')
						var tr = $('<tr></tr>')
						tr.append('<th class="text-center" colspan="9">Không có kết quả.</th>')
						$('#report-list tbody').append(tr)

						// Đặt tổng là 0
						$('#total').text('0.00')
						$('#print').hide() // Ẩn nút "In"
					}
				}
			},
			complete: function(){ // Sau khi hoàn thành yêu cầu
				end_load() // Kết thúc tải (ẩn spinner)
			}
		})
	}

	// Sự kiện khi nhấn nút "Xem Báo Cáo"
	$('#view_report').click(function(){
		// Kiểm tra nếu chưa chọn ngày thì hiển thị thông báo lỗi
		if($('#date_from').val() == '' || $('#date_to').val() == ''){
			alert_toast("Vui lòng chọn ngày trước.", "error")
			return false; // Dừng nếu không có ngày
		}

		// Gọi hàm load_report để tải báo cáo
		load_report()

		// Cập nhật URL với các tham số ngày đã chọn
		var date_from = $('#date_from').val()
		var date_to = $('#date_to').val()
		var target = './index.php?page=reports&filtered&date_from=' + date_from + '&date_to=' + date_to
		window.history.pushState({}, null, target) // Thay đổi URL mà không tải lại trang
	})

	// Khi tài liệu đã sẵn sàng, nếu đã lọc thì tự động tải báo cáo
	$(document).ready(function(){
		if('<?php echo isset($_GET['filtered']) ?>' == 1) {
			load_report() // Gọi load_report nếu đã lọc dữ liệu
		}
	})

	// Sự kiện khi nhấn nút "In"
	$('#print').click(function(){
		start_load() // Bắt đầu tải (hiển thị spinner)

		// Sao chép nội dung cần in
		var ns = $('noscript').clone() // Sao chép thẻ <noscript>
		var details = $('.details').clone() // Sao chép phần "details"
		var content = $('#report-list').clone() // Sao chép bảng báo cáo

		// Ghép các phần tử lại với nhau
		ns.append(details)
		ns.append(content)

		// Mở một cửa sổ in mới và in nội dung đã sao chép
		var nw = window.open('', '', 'height=700,width=900')
		nw.document.write(ns.html()) // Ghi nội dung vào cửa sổ mới
		nw.document.close() // Đóng tài liệu
		nw.print() // In tài liệu

		// Đóng cửa sổ in sau 750ms
		setTimeout(function(){
			nw.close()
			end_load() // Kết thúc tải (ẩn spinner)
		}, 750)
	})
</script>
