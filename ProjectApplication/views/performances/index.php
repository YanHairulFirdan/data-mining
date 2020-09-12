<div class="container">
    <h3 class="text-center text-bold m-4">Hasil Pengukuran Performa klasifikasi pada <?= $this->session->userdata('mode'); ?></h3>
    <div class="row">
        <?php foreach ($dataset as $key => $data) : ?>
            <?php if ($key != 'avgAccuracy') : ?>
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
                                    <td>TP :
                                        <?= $data['tp']; ?>
                                    </td>
                                    <td>FN :
                                        <?= $data['fn']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-bold">Negative</td>
                                    <td>TN :
                                        <?= $data['tn']; ?>
                                    </td>
                                    <td>FP :
                                        <?= $data['fp']; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table">
                            <tr>
                                <td>accuracy</td>
                                <th><?= number_format($data['accuracy'] * 100) ?></th>
                            </tr>
                            <tr>
                                <td>precision</td>
                                <th><?= number_format($data['precision'] * 100); ?></th>
                            </tr>
                            <tr>
                                <td>recall</td>
                                <th><?= number_format($data['recall'] * 100) ?></th>
                            </tr>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <?php
    echo $dataset['avgAccuracy'] * 100;
    ?>
</div>