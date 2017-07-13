
<?php

$pdo = new PDO("mysql:host=localhost;dbname=api;charset=utf8", "root", "safe520");
$userId = $_REQUEST['userId'];
$userId = $pdo->quote($userId);
//根据userId获取对应的deviceId
$sql = "SELECT deviceId From c_device WHERE userId=$userId";
$data = [];
$lsit = $pdo->query($sql)->fetch();
if (!empty($lsit['deviceId'])) {
    $data['code'] = 1;
    $data['deviceId'] = $lsit['deviceId'];
} else {
    $data['code'] = 0;
}
echo json_encode($data);
