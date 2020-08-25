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


    $valfilters = [
        'name' => 'valfilters',
        'id' => 'valfilters',
        'value' => 'valfilters',
        'maxlength' => '50',
        'maxsize' => '20',
    ];
    $option = [
        'noteman' => 'Nomor teman',
        'namateman' => "Nama Teman"
    ];

    echo heading($judulApp);
    echo form_open();
    echo form_label('Filter/cari :');
    echo form_dropdown('namafields', $option, $namafield);
    echo form_input($valfilters);
    echo form_submit('btnFilters', "Filter");
    echo form_close();
    ?>

    <div>
        <?php if (!empty($hslquery)) : ?>
            <table>
                <tr>
                    <th style="border-bottom: solid 1px black;">No</th>
                    <th style="border-bottom: solid 1px black;">Nama</th>
                    <th style="border-bottom: solid 1px black;">No Telpon</th>
                    <th style="border-bottom: solid 1px black;">Email</th>
                </tr>
                <?php foreach ($hslquery->result_array() as $row) : ?>
                    <tr>
                        <td><?= $row['noteman'] ?></td>
                        <td><?= $row['namateman'] ?></td>
                        <td><?= $row['notlpn'] ?></td>
                        <td><?= $row['email'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif ?>
    </div>
</body>

</html>