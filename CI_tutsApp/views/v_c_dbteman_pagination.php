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
    echo heading($judulApp, 2);
    ?>
    <table>
        <?php
        $c = 1;

        foreach ($hslquery->result() as $row) {
            echo "<tr>";
            echo "<td>";
            echo "No. " . $row->noteman;
            echo br();
            echo "Nama :" . $row->namateman;
            echo br();
            echo "No Telp :" . $row->notlpn;
            echo br();
            echo "Email :" . $row->email;
            echo br();
            echo "<hr />";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
    <?= $pagination; ?>
</body>
</td>