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
echo("<thead><td>Full Name</td><td>Headline</td>");
if ( isset($_SESSION['name']) ) {
    echo("<td>Actions</td>");};
echo("</thead>");
$sql = "SELECT profile_id, user_id, first_name, last_name, headline FROM profile";
$stmt = $pdo->query($sql);
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    echo("<tr><td>");
    echo(htmlentities($row['first_name'])." ".htmlentities($row['last_name']));
    echo("</td><td>");
    echo(htmlentities($row['headline']));
    echo("</td>");
    // set condition for user_id to show actions
    if( isset($_SESSION['name']) ) {
        if( ( $_SESSION['user_id'] == $row['user_id'] ) ) {
            echo("<td>");
            echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> / ');
            echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
            echo('</td>');
        } else {
            echo("<td>No Access for this user</td>");
        };
    };
    echo("</tr>");
};
echo('</table>');
?>

<?php
if ( isset($_SESSION['name']) ) {
    echo('<a href="add.php">Add New</a><br/>');
    echo('<a href=logout.php>Logout</a>');
};
?>
</body>
</html>
