<?php
include 'db/DB.php';
$db = new DB();
$update_user = $db->query()->table('users')
                  ->insert([
                    'id' => '3',
                    'name' => 'sample',
                    'status' => '1'
                ]);

echo json_encode($update_user);

?>