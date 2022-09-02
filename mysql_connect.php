<?php 
    $pdo = new PDO('mysql:host=localhost; dbname=boke', 'root', 'root');
    // var_dump($pdo);
    $stmt = $pdo->prepare('select * from article');
    $stmt->execute();
    $arr = $stmt->fetchall();
    print_r($arr)
?>