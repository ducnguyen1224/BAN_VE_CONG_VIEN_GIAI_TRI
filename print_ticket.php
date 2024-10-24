<?php include 'db_connect.php'; ?>

<?php
// Khởi tạo mảng để lưu trữ tên trò chơi
$game[0] = "None";
$games = $conn->query("SELECT * FROM games ORDER BY game ASC");
while ($row = $games->fetch_assoc()) {
    $game[$row['id']] = ucwords($row['game']);
}

// Kiểm tra xem 'id' có trong mảng $_GET hay không
if (!isset($_GET['id'])) {
    die('Error: Ticket ID is not specified.');
}

// Sử dụng prepared statements để bảo vệ khỏi SQL Injection
$id = intval($_GET['id']);
$ticket_query = $conn->prepare("SELECT t.*, p.name as ticket_for FROM ticket_list t INNER JOIN pricing p ON p.id = t.pricing_id WHERE t.id = ?");
$ticket_query->bind_param("i", $id);
$ticket_query->execute();
$result = $ticket_query->get_result();

if ($result === false || $result->num_rows === 0) {
    die('Error: Ticket not found.');
}

$ticket = $result->fetch_array(MYSQLI_ASSOC);
foreach ($ticket as $k => $v) {
    $$k = $v; // Tạo biến động
}

// Mảng để định danh loại vé
$tarr = array('', 'Adult', 'Child');

// Lấy danh sách vé liên quan
$ticket_items = $conn->prepare("SELECT * FROM ticket_items WHERE ticket_id = ?");
$ticket_items->bind_param("i", $id);
$ticket_items->execute();
$items_result = $ticket_items->get_result();

?>

<style>
    .text-center {
        text-align: center;
    }
    .text-right {
        text-align: right;
    }
    .ticket-container {
        border: 1px solid #000;
        padding: 20px;
        width: 80%;
        margin: auto;
    }
</style>

<div class="ticket-container">
    <h2 class="text-center">Thông tin vé</h2>
    <p><strong>ID vé:</strong> <?php echo htmlspecialchars($id); ?></p>
    <p><strong>Khách hàng:</strong> <?php echo htmlspecialchars(ucwords($name)); ?></p>
    <p><strong>Vé cho:</strong> <?php echo htmlspecialchars($ticket_for); ?></p>
    <p><strong>Ngày tạo:</strong> <?php echo date("M d, Y", strtotime($date_created)); ?></p>
    
    <h3 class="text-center">Danh sách vé</h3>
    <table width="100%" border="1">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">Loại vé</th>
                <th class="text-center">Giá</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $i = 1;
            while ($row = $items_result->fetch_assoc()): 
            ?>
            <tr>
                <td class="text-center"><?php echo $i++; ?></td>
                <td class="text-center"><?php echo htmlspecialchars($tarr[$row['type']]); ?></td>
                <td class="text-right"><?php echo number_format($row['price'], 2); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<button onclick="window.print()">In vé</button>
