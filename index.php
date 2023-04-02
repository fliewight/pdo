<?php
require_once '_connec.php';
$pdo = new PDO(DSN, USER, PASS);

// A exécuter afin d'afficher vos lignes déjà insérées dans la table friends
$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchAll();

echo '<ul>';
    foreach ($friends as $friend) {
        echo '<li>';
            echo $friend['id'].' : '.$friend['firstname'].' '.$friend['lastname'];
        echo '</li>';
    }
echo '</ul>';

// Formulaire envopyé
if (!empty($_POST))
{
    $firstname = trim(htmlentities($_POST['firstname']));
    $lastname = trim(htmlentities($_POST['name']));

    $errors = [];

    if (empty($firstname)) $errors[] = 'Le champ "Prénom" est vide';
    elseif (strlen($firstname) > 45) $errors[] = 'Le champ"Prénom" doit faire moins de 46 caractères';
    if (empty($lastname)) $errors[] = 'Le champ "Nom" est vide';
    elseif (strlen($lastname) > 45) $errors[] = 'Le champ"Nom" doit faire moins de 46 caractères';

    if (empty($errors))
    {
        $query = "INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':firstname', $firstname);
        $statement->bindValue(':lastname', $lastname);
        $statement->execute();

        header("Location: index.php");
    }
    else
    {
        echo '<ul>';
            foreach ($errors as $error)
            {
                echo '<li>';
                    echo $error;
                echo '</li>';
            }
        echo '</ul>';
    }
}
?>

<form method="post">
    <div>
        <label for="firstname">Prénom : </label>
        <input type="text" name="firstname" id="firstname" value="" required>
    </div>
    <div>
        <label for="name">Nom : </label>
        <input type="text" name="name" id="name" value="" required>
    </div>
    <button>Ajouter</button>
</form>
