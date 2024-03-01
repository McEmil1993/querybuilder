<?php
include 'db/DB.php';
$db = new DB();

$update_user = $db->query()->table('users')
                  ->where('id', '=', '3') // Define the WHERE clause
                  ->update([
                    'name' => 'new_name',
                    'status' => '1'
                ]);

echo json_encode($update_user);
?>