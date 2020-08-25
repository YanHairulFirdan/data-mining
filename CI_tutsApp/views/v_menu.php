<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    Menu :
    <?php
    echo anchor('c_dbqcrud/showfilter', "Filter ");
    echo "|";
    echo anchor('c_dbqcrud/showform/add', " Tambah ");
    echo "|";
    echo anchor('c_dbqcrud/findrecto/update', " Update ");
    echo "|";
    echo anchor('c_dbqcrud/findrecto/delete4', " Delete ");
    echo "|";
    echo anchor('c_dbqcrud/showallrecord', " Tamplikan ");
    ?>
</body>

</html>