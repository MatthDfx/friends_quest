<?php
require_once 'connec.php';

$pdo = new PDO(DSN, USER, PASSWORD);

$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchAll();

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
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = array_map('trim', $_POST);
        $errors = [];
        if (!isset($data['firstname']) || empty($data['firstname']))
            $errors[] = 'Le prénom est obligatoire';
        if (!isset($data['lastname']) || empty($data['lastname']))
            $errors[] = 'Le nom est obligatoire';
        if (count($errors) === 0) {
            $pdo = new \PDO(DSN, USER, PASSWORD);

            $query2 = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
            $statement = $pdo->prepare($query2);
            $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
            $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
            $statement->execute();
        }
    }  ?>
</body>

</html>