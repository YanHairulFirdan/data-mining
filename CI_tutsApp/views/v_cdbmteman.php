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
    echo "Jumlah Record : " . $hslquery->num_rows();
    ?>
    <table style="margin : auto; width:80%;">

        <?php
        $c = 1;
        foreach ($hslquery->result() as $row) {
            if ($c > 2) {
                echo "</tr>";
                $c =  1;
            }

            if ($c == 1) echo "<tr>";
            echo "<td>";
            echo "No : " . $row->noteman;
            echo br();
            echo "No.Tlp : " . $row->notlpn;
            echo br();
            echo "Nama : " . $row->namateman;
            echo br();
            echo "Email : " . $row->email;
            echo br();
            echo "<hr />";
            echo "</td>";
            $c++;
        }
        ?>
    </table>
</body>

</html>