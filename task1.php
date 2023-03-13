<?php

// подключаемся к базе данных
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // устанавливаем режим ошибок PDO на исключения
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // открываем файл для чтения
    $file = fopen("users.csv", "r");

    // считываем содержимое файла построчно
    while (($line = fgetcsv($file)) !== false) {
        // получаем номер и имя пользователя из строки
        $number = $line[0];
        $name = $line[1];

        // добавляем пользователя в базу данных
        $stmt = $conn->prepare("INSERT INTO users (number, name) VALUES (:number, :name)");
        $stmt->bindParam(':number', $number);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
    }

    // закрываем файл и соединение с базой данных
    fclose($file);

    $conn = null;
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
