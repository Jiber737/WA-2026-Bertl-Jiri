# WA-2026-Bertl-Jiri
Předmět WA . Verze 2026


<?php
$name = "";
$message = "";
$age ="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["myName"];
    if ($name == "Jiřík")
    {
        $message = "ahoj Jiří";
    }
    else{
        $message = "neznám tě, achjoo";
    }
}




?>



<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test PHP</title>
</head>

<body>
    <h1>Test formuláře</h1>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident, perspiciatis? Facilis ipsa doloremque aut nihil, hic, suscipit quaerat reiciendis alias recusandae consequuntur distinctio autem libero assumenda, at eum nobis error?</p>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut molestiae commodi ab quibusdam iure laborum, temporibus consectetur eos velit. Odit distinctio debitis autem quidem fugit modi quos, labore repellat voluptatum?</p>
    <form method="post">
        <input type="text" name="myName" placeholder="NeZadejte jmeno">
        <input type="number" name="myAge" placeholder="Zadej věk svůj">
        <button type="submit">sem klikni</button>
    </form>
    <p>
        <?php echo $message;?>
    </p>
    <p>
        <?php
            echo "tvůj věk je" ;
            echo $age;
        ?>
    </p>
</body>
</html>