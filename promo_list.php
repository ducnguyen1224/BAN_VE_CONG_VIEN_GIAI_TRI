<?php include 'db_connect.php'; ?>
<div class="col-lg-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="card-tools">
                <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_promo">
                    <i class="fa fa-plus"></i> Thêm Mới
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered" id="list">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Tên khuyến mãi</th>
                        <th>Giảm giá</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $qry = $conn->query("SELECT * FROM promo ORDER BY name_promo ASC");
                    $current_date = new DateTime();

                    while ($row = $qry->fetch_assoc()):
                        $end_date = new DateTime($row['end_date']);
                        $is_expired = $current_date > $end_date; // Check if the promotion is expired
                    ?>
                        <tr class="<?php echo $is_expired ? 'table-danger' : '' ?>">
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td><b><?php echo $row['name_promo']; ?></b></td>
                            <td><p><small><?php echo $row['discount']; ?>%</small></p></td>
                            <td><p><small><?php echo date("M d, Y", strtotime($row['create_date'])); ?></small></p></td>
                            <td><p><small><?php echo date("M d, Y", strtotime($row['end_date'])); ?></small></p></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="index.php?page=edit_promo&id=<?php echo $row['id']; ?>" class="btn btn-primary btn-flat">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-flat delete_promo" data-id="<?php echo $row['id']; ?>">
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
    table td {
        vertical-align: middle !important;
    }
    .table-danger {
        background-color: #f8d7da !important;
    }
</style>
<script>
    $(document).ready(function(){
        $('#list').dataTable();

        // Confirmation dialog for deleting promotions
        $('.delete_promo').click(function(){
            _conf("Bạn có chắc chắn muốn xóa khuyến mãi này?", "delete_promo", [$(this).attr('data-id')]);
        });
    });

    // Function to delete a promotion
    function delete_promo(id){
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_promo',
            method: 'POST',
            data: { id: id },
            success: function(resp){
                if(resp == 1){
                    alert_toast("Dữ liệu đã được xóa thành công", 'success');
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                } else {
                    alert_toast("Có lỗi xảy ra, vui lòng thử lại", 'error');
                }
            }
        });
    }
</script>
