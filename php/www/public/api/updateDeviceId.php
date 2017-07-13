<?php

$pdo = new PDO("mysql:host=localhost;dbname=api;charset=utf8", "root", "safe520");

$userId = $_REQUEST['userId'];
$deviceId = $_REQUEST['deviceId'];
$userId = $pdo->quote($userId);
$deviceId = $pdo->quote($deviceId);
//根据userId获取对应的deviceId
$sql = "REPLACE INTO c_device(userId, deviceId) VALUES($userId,$deviceId)";

$data = [];
if ($pdo->exec($sql)) {
    $data['code'] = 1;
} else {
    $data['code'] = 0;
}
echo json_encode($data);
