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
    echo "Jumlah record : " . $hslquery->num_rows();
    echo "<hr>";
    ?>
    <table style="margin : auto; width : 80%;">
        <?php
        $count = 1;
        foreach ($hslquery->result_array() as $row) {
            if ($count > 2) {
                echo "</tr>";
                $count = 1;
            }
            if ($count == 1) {
                echo "<tr>";
            }
            echo "<td>";

            echo "Nama      : " . $row['namateman'];
            echo br();
            echo "Email     : " . $row['email'];
            echo br();
            echo "<hr>";
            echo "</td>";
            $count++;
        }
        ?>
    </table>
    <?php
    $this->load->view('v_menu'); ?>
</body>

</html>