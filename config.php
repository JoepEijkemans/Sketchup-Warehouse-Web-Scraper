<?PHP

$db_server = "Localhost";
$db_user = "root";
$db_pass = "psw";
$db_name = "dbname";

$db = new PDO('mysql:host=' . $db_server . ';port=3307;dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>