<?

$dbuser = "DB_WEB_USER";
$dbpass = "DB_WEB_PASS";
$dbhost = "DB_WEB_HOST";
$dbbase = "DB_WEB_DATABASE";

try {
    $DBH = new PDO("mysql:host=$dbhost;dbname=$dbbase", $dbuser, $dbpass);
    $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $ex) {
    echo $ex->getMessage();
}