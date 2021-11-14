<?php
header("Content-Type: text/html; charset=utf-8");

include_once "../config.php";

echo $_GET["number"] . "<br>";
echo $_GET["userId"] . "<br>";
echo $_GET["dateStart"] . "<br>";

$e = "";
$contactId = 0;

$sql = 'SELECT con.id FROM contacts con
INNER JOIN numbers num ON con.number_id = num.id
WHERE num.number = ' . $_GET["number"] . ' AND con.user_id=' . $_GET["userId"] . ';';
if ($result = mysqli_query($link, $sql)) {
    $contactId = mysqli_fetch_row($result)[0];
    mysqli_free_result($result);
}else{
    $e = "Error: " . $sql . " - " . mysqli_error($link);
}

if ($e == "") {
    $sql = 'SELECT log.date_start, log.date_end, con.name, num.number, cat.name FROM logs log
    INNER JOIN contacts con ON log.contacts_id=con.id
    INNER JOIN numbers num ON con.number_id=num.id
    INNER JOIN categories cat ON con.category_id=cat.id
    WHERE con.id = ' . $contactId . ' AND num.number = ' . $_GET["number"] . ' AND log.date_start = "' . $_GET["dateStart"] . '";';
    if ($result = mysqli_query($link, $sql)) {
        while ($row = mysqli_fetch_row($result)) {
            $return = [
                "dateStart" => $row[0],
                "dateEnd" => $row[1],
                "contact" => [
                    "name" => $row[2],
                    "number" => $row[3],
                    "category" => $row[4],
                ]];
            echo json_encode($return, JSON_PRETTY_PRINT, JSON_FORCE_OBJECT);
    }
        mysqli_free_result($result);
    }else{
        $e = "Error: " . $sql . " - " . mysqli_error($link);
    }
}else{
echo $e;
}
mysqli_close($link);
?>