<aside class="main-sidebar sidebar-light-primary elevation-4">
    <div class="dropdown">
        <a href="./" class="brand-link">
            <?php if ($_SESSION['login_type'] == 1): ?>
                <h3 class="text-center p-0 m-0"><b>QUẢN TRỊ</b></h3>
            <?php else: ?>
                <h3 class="text-center p-0 m-0"><b>NHÂN VIÊN</b></h3>
            <?php endif; ?>
        </a>
    </div>
    <div class="sidebar pb-4 mb-4">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
                
                <!-- Biểu tượng Dashboard -->
                <li class="nav-item dropdown">
                    <a href="./" class="nav-link nav-home">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Trang chủ</p>
                    </a>
                </li>  

                <?php if ($_SESSION['login_type'] == 1): ?>
                
                <!-- Mục Trò chơi -->
                <li class="nav-item">
                    <a href="#" class="nav-link nav-edit_game">
                        <i class="nav-icon fas fa-gamepad"></i>
                        <p>
                            Trò chơi
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="./index.php?page=new_game" class="nav-link nav-new_game tree-item">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Thêm Mới</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./index.php?page=games_list" class="nav-link nav-games_list tree-item">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Danh Sách</p>
                            </a>
                        </li>
                    </ul>
                </li> 

                <!-- Mục Giá Cả -->
                <li class="nav-item">
                    <a href="#" class="nav-link nav-edit_pricing">
                        <i class="nav-icon fas fa-coins"></i>
                        <p>
                            Giá Cả
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="./index.php?page=new_pricing" class="nav-link nav-new_pricing tree-item">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Thêm Mới</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./index.php?page=pricing_list" class="nav-link nav-pricing_list tree-item">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Danh Sách</p>
                            </a>
                        </li>
                    </ul>
                </li> 
                
                <?php endif; ?>
                 <!-- Mục khuyens mai-->
                 <li class="nav-item">
                    <a href="#" class="nav-link nav-edit_promo">
                        <i class="nav-icon fas fa-gift"></i>
                        <p>
                         Khuyến mãi 
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="./index.php?page=new_promo" class="nav-link nav-new_promo tree-item">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Thêm Mới</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./index.php?page=promo_list" class="nav-link nav-promo_list tree-item">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Danh Sách</p>
                            </a>
                        </li>
                    </ul>
                </li> 
             <!-- Mục Vé -->
<li class="nav-item">
    <a href="#" class="nav-link nav-edit_ticket">
        <i class="nav-icon fas fa-ticket-alt"></i>
        <p>
            Vé
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="./index.php?page=new_ticket" class="nav-link nav-new_ticket tree-item">
                <i class="fas fa-angle-right nav-icon"></i>
                <p>Thêm Mới</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="./index.php?page=ticket_list" class="nav-link nav-ticket_list tree-item">
                <i class="fas fa-angle-right nav-icon"></i>
                <p>Danh Sách</p>
            </a>
        </li>
        <!-- New Menu for Printing Tickets -->
        <li class="nav-item">
            <a href="./index.php?page=print_ticket" class="nav-link nav-print_ticket tree-item">
                <i class="fas fa-angle-right nav-icon"></i>
                <p>In Vé</p>
            </a>
        </li>
    </ul>
</li>


                <?php if ($_SESSION['login_type'] == 1): ?>
                
                <!-- Mục Báo Cáo Bán Hàng -->
                <li class="nav-item dropdown">
                    <a href="./index.php?page=reports" class="nav-link nav-reports">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Báo Cáo Bán Hàng
                        </p>
                    </a>
                </li>   
                
                <!-- Mục Người Dùng -->
                <li class="nav-item">
                    <a href="#" class="nav-link nav-edit_user">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Người Dùng
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="./index.php?page=new_user" class="nav-link nav-new_user tree-item">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Thêm Mới</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./index.php?page=user_list" class="nav-link nav-user_list tree-item">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Danh Sách</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <?php endif; ?>
                
            </ul>
        </nav>
    </div>
</aside>

<script>
    $(document).ready(function(){
        var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
        var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
        if (s != '')
            page = page + '_' + s;
        if ($('.nav-link.nav-' + page).length > 0) {
            $('.nav-link.nav-' + page).addClass('active');
            if ($('.nav-link.nav-' + page).hasClass('tree-item') == true) {
                $('.nav-link.nav-' + page).closest('.nav-treeview').siblings('a').addClass('active');
                $('.nav-link.nav-' + page).closest('.nav-treeview').parent().addClass('menu-open');
            }
            if ($('.nav-link.nav-' + page).hasClass('nav-is-tree') == true) {
                $('.nav-link.nav-' + page).parent().addClass('menu-open');
            }
        }
    });
</script>
