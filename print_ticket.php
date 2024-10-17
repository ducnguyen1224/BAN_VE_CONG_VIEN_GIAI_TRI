<?php include 'db_connect.php' ?>
<?php
$game[0] = "None";
$games = $conn->query("SELECT * FROM games ORDER BY game ASC");
while($row = $games->fetch_assoc()){
  $game[$row['id']] = ucwords($row['game']);
}

// Check if 'id' key exists in $_GET array
if (!isset($_GET['id'])) {
    die('Error: Ticket ID is not specified.');
}

$id = $_GET['id'];

// Execute the query and check if it was successful
$ticket_query = $conn->query("SELECT t.*, p.name as ticket_for FROM ticket_list t INNER JOIN pricing p ON p.id = t.pricing_id WHERE t.id = $id");

if ($ticket_query === false) {
    // Log the error message
    $error = $conn->error;
    die('Error: Failed to execute query. ' . $error);
}

$ticket = $ticket_query->fetch_array();

if ($ticket === null) {
    die('Error: Ticket not found.');
}

foreach($ticket as $k => $v){
    $$k = $v;
}

$tarr = array('', 'Adult', 'Child');
$ticket_items = $conn->query("SELECT * FROM ticket_items WHERE ticket_id = $id");

if ($ticket_items === false) {
    // Log the error message
    $error = $conn->error;
    die('Error: Failed to execute query for ticket items. ' . $error);
}
?>

<style>
    .text-center {
        text-align: center;
    }
    .text-right {
        text-align: right;
    }
</style>

<?php while($row = $ticket_items->fetch_assoc()): ?>
    <table width="100%">
        <tr>
            <th class="text-center" colspan="2">Công viên giải trí</th>
        </tr>
        <tr>
<?php endwhile; ?>