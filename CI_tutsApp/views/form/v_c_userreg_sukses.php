<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $judulApp; ?></title>
</head>

<body>
    <?php
    echo heading($judulApp, 1);
    echo heading("Selamat!", 2);
    echo form_label("Nama User");
    echo $username['value'];
    echo br();
    echo form_label("Email");
    echo $useremail['value'];
    echo br();
    ?>
</body>

</html>