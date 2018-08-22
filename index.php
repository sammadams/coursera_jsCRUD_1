<?php
// FINISHED
require_once "pdo.php";
session_start();
?>

<html>
<head>
    <title>Samuel Adams</title>
</head>
<body>
<h1>Sam's Resume Registry</h1>
<?php
// display error flash
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
// display success flash
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}
// show login link if not logged in
if ( !isset($_SESSION['name']) ) {
    echo('<a href="login.php">Please log in</a>');
};
// display table
echo('<table border="1">'."\n");
$stmt = $pdo->query("SELECT name, email, password, user_id FROM users");
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    echo "<tr><td>";
    echo(htmlentities($row['name']));
    echo("</td><td>");
    echo(htmlentities($row['headline']));
    echo("</td>");

    // set condition for user_id to show actions
    echo("<td>");
    echo('<a href="edit.php?user_id='.$row['user_id'].'">Edit</a> / ');
    echo('<a href="delete.php?user_id='.$row['user_id'].'">Delete</a>');
    echo("</td></tr>\n");
    // end condition
    echo('</table>');
}
?>

<?php
if ( isset($_SESSION['name']) ) {
    echo('<a href="add.php">Add New</a>');
};
?>
</body>
</html>
