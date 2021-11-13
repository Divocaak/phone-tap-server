<?php
include_once "../config.php";

$return = [];
$sql = 'SELECT id, login, token, password FROM users WHERE login="' . $_GET["phone"] . '";';
if ($result = mysqli_query($link, $sql)) {
    while ($row = mysqli_fetch_row($result)) {
        if(password_verify($_GET["password"], $row[3])){
            $return = ["id" => $row[0], "phone" => $row[1],
            "token" => $row[2]];
            echo json_encode($return, JSON_PRETTY_PRINT, JSON_FORCE_OBJECT);
        }
        else{echo "php error";}
    }
    mysqli_free_result($result);
}
mysqli_close($link);
?>