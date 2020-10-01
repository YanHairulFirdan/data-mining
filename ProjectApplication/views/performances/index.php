<div class="container">
    <h3 class="text-center text-bold m-4">Hasil Pengukuran Performa klasifikasi pada <?= $this->session->userdata('mode'); ?></h3>
    <div class="row">
        <?php foreach ($dataset as $key => $data) : ?>



            <?php if (gettype($key) == 'integer') : ?>
                <div class="col-sm-4 mb-1 mt-1">
                    <div class="card">
                        <h4 class="text-center">Performa iterasi ke-<?= $key + 1; ?></h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <td></td>
                                    <td class="text-bold">Positive</td>
                                    <td class="text-bold">Negative</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-bold">Positive</td>
                                    <td>True Fail :
                                        <?= $data['tp']; ?>
                                    </td>
                                    <td>False Success :
                                        <?= $data['fn']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-bold">Negative</td>
                                    <td>True Success :
                                        <?= $data['tn']; ?>
                                    </td>
                                    <td>False Fail :
                                        <?= $data['fp']; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table">
                            <tr>
                                <td>accuracy</td>
                                <th><?= number_format($data['accuracy'] * 100) ?> %</th>
                            </tr>
                            <tr>
                                <td>precision untuk kelas 'Fail'</td>
                                <th><?= number_format($data['precision'] * 100); ?> %</th>
                            </tr>
                            <tr>
                                <td>recall untuk kelas 'Fail'</td>
                                <th><?= number_format($data['recall'] * 100) ?> %</th>
                            </tr>
                            <tr>
                                <td>precision untuk kelas 'Success'</td>
                                <th><?= number_format($data['precisionsuccess'] * 100); ?> %</th>
                            </tr>
                            <tr>
                                <td>recall untuk kelas 'Success'</td>
                                <th><?= number_format($data['recallsuccess'] * 100) ?> %</th>
                            </tr>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <div class="row mt-5">
        <div class="col-8 container p-1">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-center">Predicted Fail</th>
                        <th class="text-center">Predicted Success</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Fail</th>
                        <td class="text-center"><?= $dataset['totalTP'] ?></td>
                        <td class="text-center"><?= $dataset['totalFN'] ?></td>
                    </tr>
                    <tr>
                        <th>Success</th>
                        <td class="text-center"><?= $dataset['totalFP'] ?></td>
                        <td class="text-center">
                            <?= $dataset['totalTN'] ?></td>
                    </tr>
                    <tr>
                        <th>Rata-rata akurasi</th>
                        <td colspan="2" class="text-center text-bold"><?= $dataset['avgAccuracy'] * 100 ?>%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>