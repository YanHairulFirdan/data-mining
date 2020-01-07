<div class="container">
    <h1 class="text-center">Tabel kasus</h1>

    <table class="table table-bordered mt-5">
        <thead>
            <tr>
                <th class="text-center" scope="col">no</th>
                <th class="text-center" scope="col">OUTLOOK</th>
                <th class="text-center" scope="col">TEMPERATURE</th>
                <th class="text-center" scope="col">HUMADITY</th>
                <th class="text-center" scope="col">WINDY</th>
                <th class="text-center" scope="col">PLAY</th>
                <th class="text-center" scope="col">AKSI</th>
            </tr>
        </thead>
        <tbody>
            <td>
                <?php $i = 1;
                foreach ($dataTraining->result_array() as $dataSingle) : ?>
                    <tr>
                        <td class="text-center"><?= $i; ?></td>
                        <td class="text-center"><?= $dataSingle['outlook']; ?></td>
                        <td class="text-center"><?= $dataSingle['temperature']; ?></td>
                        <td class="text-center"><?= $dataSingle['humadity']; ?></td>
                        <td class="text-center"><?= $dataSingle['windy']; ?></td>
                        <td class="text-center"><?= $dataSingle['play']; ?></td>
                        <td class="text-center">
                            <a href="updateData/<?= $dataSingle['id'] ?>" class="btn btn-success">edit</a>
                            <a href="hapusData/<?= $dataSingle['id'] ?>" class="btn btn-danger">hapus</a>
                        </td>
                    </tr>
                <?php $i++;
                endforeach; ?>
            </td>
        </tbody>
    </table>
    <a href="predict" class="btn btn-primary mt-5 float-right">Halaman Prediksi</a>
</div>