<?php
header("Content-Type: text/html; charset=utf-8");

include_once "../config.php";

$return = [];
$insertedNumberId = 0;
$e = "";

$sql = 'INSERT INTO numbers (number, check_date) VALUES (' . $_GET["contactNum"] . ', CURDATE() + INTERVAL ' . $numberCheckDays . ' DAY);';
if (!mysqli_query($link, $sql)) {
    $e = "Error: " . $sql . " - " . mysqli_error($link);
}

if ($e == "") {
    $sql = 'SELECT LAST_INSERT_ID();';
    if ($result = mysqli_query($link, $sql)) {
        while ($row = mysqli_fetch_row($result)) {
            $insertedNumberId = $row[0];
        }
        mysqli_free_result($result);
    }
    
    $sql = 'INSERT INTO contacts (name, number_id, category_id, user_id) VALUES
    ("' . $_GET["name"] . '", ' . $insertedNumberId . ', ' . $_GET["categoryId"] . ', ' . $_GET["userId"] . ');';
    if (!mysqli_query($link, $sql)) {
        $e = "Error: " . $sql . " - " . mysqli_error($link);
    }else{
        echo "Číslo uloženo";
    }
}else{
echo $e;
}
?>