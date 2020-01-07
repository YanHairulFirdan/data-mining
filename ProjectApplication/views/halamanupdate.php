<div class="container p-4">
    <h1 class="text-center">Halaman Perbaharui Data</h1>
    <div class="card container" style="width: 30rem">
        <div class="card-body">

            <form method="post" action="">
                <div class="form-group">
                    <input type="hidden" class="form-control" id="exampleInputEmail1" name="id" value="<?= $updateData[0]['id'] ?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Nama Produk</label>
                    <select class="custom-select" name='productname'>
                        <!-- <option selected>Pilih Nama Produk</option> -->
                        <?php foreach ($dataForm['namaproduk'] as $produk) : ?>
                            <?php $active = ($updateData[0]['namaproduk'] == $produk) ? "selected" : " " ?>
                            <option value="<?= $produk ?>" <?= $active ?>><?= $produk ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Ukuran</label>
                    <select class="custom-select" name="sizes">
                        <!-- <option selected>Pilih Ukuran</option> -->
                        <?php foreach ($dataForm['ukuran'] as $ukran) : ?>
                            <?php $active = ($updateData[0]['ukuran'] == $ukran) ? "selected" : " " ?>
                            <option value="<?= $ukran ?>" <?= $active ?>><?= $ukran ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Harga</label>
                    <select class="custom-select" name="prices">
                        <!-- <option selected>Pilih Harga</option> -->
                        <?php foreach ($dataForm['daftarHarga'] as $harga) : ?>
                            <?php $active = ($updateData[0]['harga'] == $harga) ? "selected" : " " ?>
                            <option value="<?= $harga ?>" <?= $active ?>><?= $harga ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Warna</label>
                    <select class="custom-select" name="colors">
                        <!-- <option selected>Pilih Warna</option> -->
                        <?php foreach ($dataForm['daftarWarna'] as $warna) : ?>
                            <?php $active = ($updateData[0]['warna'] == $warna) ? "selected" : " " ?>
                            <option value="<?= $warna ?>" <?= $active ?>><?= $warna ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Jumlah Pembelian</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="masukkann jumlah pembelian" name="sale" value="<?= $updateData[0]['jml_pembelian'] ?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Status</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="masukkan status" name="keterangan" value="<?= $updateData[0]['status'] ?>">
                </div>
                <button type="submit" class="btn btn-lg btn-primary">Proses</button>
            </form>
        </div>
    </div>

</div>