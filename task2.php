<?php

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

function sendMessageJobs($user) {
    //
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $notSent = false;
    $stmt = $conn->prepare('SELECT * FROM users WHERE is_sent = :is_sent');
    $stmt->bindParam(':is_sent', $sent);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($users as $user) {
        sendMessageJobs($user);

        $sent = true;
        $userId = $user['id'];
        $stmt = $conn->prepare("UPDATE users SET is_sent = :is_sent WHERE id = :user_id");
        $stmt->bindParam(':is_sent', $sent);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
    }

    $conn = null;
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
