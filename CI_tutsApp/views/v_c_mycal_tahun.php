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
    var_dump($varkal);
    echo "<table>";
    echo "<caption>" . heading($judulApp, 2) . "</caption>";
    $i = 1;
    foreach ($varkal as $bulan => $kals) {
        if ($i == 1) {
            echo "<tr>";
        }
        echo "<td style='cellpadding = 5px; border:solid 1px;'>" . $kals . "</td>";
        $i++;

        if ($i == 5) {
            echo "</tr>";
            $i = 1;
        }
    }

    echo "</table>";

    ?>
</body>

</html>