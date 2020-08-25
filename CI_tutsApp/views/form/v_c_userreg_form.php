<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title><?= $judulApp; ?></title>
</head>

<body>
    <div class="container">

        <?php
        // var_dump($aksi);
        // var_dump(base_url());
        echo heading($judulApp, 1);
        echo validation_errors();
        echo form_open($aksi);
        echo form_label("Nama User");
        echo form_input($username);
        echo "<br/>";
        echo form_label("Password");
        echo form_input($userpass);
        echo "<br/>";
        echo form_label("Password Konfirmasi");
        echo form_input($userpassv);
        echo "<br/>";
        echo form_label("Email");
        echo form_input($useremail);
        echo "<br/>";
        echo form_submit("btnReg", "Registrasi");
        echo form_close();
        ?>
        </form>
    </div>
</body>

</html>