<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autoload</title>
</head>

<body>
    <?php
    spl_autoload_register(function ($nombreClase) {
        include_once $nombreClase . '.php';
    });
    ?>
</body>

</html>