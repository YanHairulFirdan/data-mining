    <div class="container">
        <h3 class="text-center">Data Hasil Perhitungan</h3>
        <hr style="border : 3px solid grey;">
        <table class="table table-bordered table-stri   ped mt-3">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Atribut</th>
                    <th scope="col">Nilai Atribut</th>
                    <th scope="col">Jumlah Kasus</th>
                    <th scope="col">Jumlah Kasus(yes)</th>
                    <th scope="col">Jumlah Kasus(no)</th>
                    <th scope="col">Probabilitas(Yes)</th>
                    <th scope="col">Probabilitas(No)</th>
                </tr>
            </thead>
            <?php
            //membuat tabel hasil perhitungan
            $index = 1;
            foreach ($prediksi['dataTabelPrediksi'] as $singleArray) :
            ?>
                <tr>
                    <th class="text-center"><?= $index ?></th>
                    <th class="text-center"><?= $singleArray['namaAtribut'] ?></th>
                    <th class="text-center"><?= $singleArray['nilaiAtribut'] ?></th>
                    <th class="text-center"><?= $singleArray['jumlahKasus'] ?></th>
                    <th class="text-center"><?= $singleArray['jumlahYes'] ?></th>
                    <th class="text-center"><?= $singleArray['jumlahNo'] ?></th>
                    <th class="text-center"><?= $singleArray['probabilitasYes'] ?></th>
                    <th class="text-center"><?= $singleArray['probabilitasNo'] ?></th>
                </tr>
            <?php $index++;
                                        endforeach; ?>
            <tbody>
            </tbody>
        </table>
        <!-- print perhitungan -->
        <div class="container ">
            <div class="row">
                <div class="col-md-6 bg-light">
                    <?php foreach ($prediksi['dataTabelPrediksi'] as $hasil) :
                                            $kasusperAtribut = $hasil['jumlahKasus'] ?>
                        <p class="font-weight-bold">Probabilitas <?= $hasil['namaAtribut'] . "=" . $hasil['nilaiAtribut'] ?></p>
                        <span class="bg-success">P(<?= $hasil['namaAtribut'] . "=" . $hasil['nilaiAtribut'] . " | play = yes " ?>) <span><?= $hasil['jumlahYes'] . "/" . $kasusperAtribut; ?> = <?= $hasil['jumlahYes'] / $kasusperAtribut; ?></span></span>
                        <br>
                        <span class="bg-danger">P(<?= $hasil['namaAtribut'] . "=" . $hasil['nilaiAtribut'] . " | play = no " ?>) <span><?= $hasil['jumlahNo'] . "/" . $kasusperAtribut; ?> = <?= $hasil['jumlahNo'] / $kasusperAtribut; ?></span></span>
                    <?php endforeach; ?>
                    <!-- print hasil prediksi -->
                    <br>


                    <?php foreach ($prediksi['hslPrediksi'] as $hasil) : ?>
                        <p class="font-weight-bold">P(X|play=yes)*P(play=yes)=<?= $hasil['resultYes'] . " * " . "(" . $hasil['totalYes'] . "/" . $hasil['jumlahTotalKasus'] . ")" . " = " . $hasil['prediksiYes'] ?></p>
                        <p class="font-weight-bold">P(X|play=no)*P(play=no)=<?= $hasil['resultNo'] . " * " . "(" . $hasil['totalNo'] . "/" . $hasil['jumlahTotalKasus'] . ")" . " = " . $hasil['prediksiNo'] ?></p>
                        <p class="font-weight-bold"><?php echo "Hasil prediksi Play = " . $hasil['keterangan'] ?></p>
                    <?php endforeach; ?>
                    <!-- echo "Result Yes " . $hasil['resultYes'] . "<br />";
        echo "Result No " . $hasil['resultNo'] . "<br />";
        echo "Probabilitas Yes " . $hasil['prediksiYes'] . "<br />";
        echo "Probabilitras No " . $hasil['prediksiNo'] . "<br />";
       
        } -->
                </div>
            </div>
        </div>

    </div>