<?php
include 'db/DB.php';
$db = new DB();
$users = $db->query()->table('users')->getAll();

echo json_encode($users);

?>