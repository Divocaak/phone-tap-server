<?php
header("Content-Type: text/html; charset=utf-8");

include_once "../config.php";

$return = [];
$sql = 'SELECT con.name, num.number, cat.name FROM contacts con INNER JOIN numbers num ON con.number_id = num.id
INNER JOIN categories cat ON con.category_id = cat.id WHERE num.number = ' . $_GET["number"] . ';';
if ($result = mysqli_query($link, $sql)) {
    while ($row = mysqli_fetch_row($result)) {
            $return = ["name" => $row[0],
            "number" => $row[1], "category" => $row[2]];
            echo json_encode($return, JSON_PRETTY_PRINT, JSON_FORCE_OBJECT);
    }
    mysqli_free_result($result);
}
mysqli_close($link);
?>