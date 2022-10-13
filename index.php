<?php
require_once 'connec.php';

$pdo = new PDO(DSN, USER, PASSWORD);

$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <table>
        <thead>
            <th>FirstName</th>
            <th>LastName</th>
        </thead>
        <tbody>
            <?php
            foreach ($friends as $friend) {



                echo '<tr><td>' . $friend['firstname'] . '</td>';
                echo '<td>' . $friend['lastname'] . '</td>';
            }
            ?>
        </tbody>
    </table>

    <form action="/index.php" method="POST"></form>
    <br>
    <label for="firstname">First Name</label>
    <input type="text" name="firstname" id="firstname">
    </br>
    <br>
    <label for="lastname">Last Name</label>
    <input type="text" name="lastname" id="lastname">
    </br>
    <input type="submit" value="Envoyer">

    <?php

    $errors = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $friend = array_map('trim', $_POST);

        if (!isset($friend['firstname']) || empty($friend['firstname']))
            $errors[] = 'Le prénom est obligatoire';
        if (!isset($friend['lastname']) || empty($friend['lastname']))
            $errors[] = 'Le nom est obligatoire';
        if (count($errors) === 0) {

            $query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
            $statement = $pdo->prepare($query);
            $statement->bindValue(':firstname', $friend['firstname'], \PDO::PARAM_STR);
            $statement->bindValue(':lastname', $friend['lastname'], \PDO::PARAM_STR);
            $statement->execute();
            header('Location: /');
            die();
        }
    }
    ?>
</body>

</html>