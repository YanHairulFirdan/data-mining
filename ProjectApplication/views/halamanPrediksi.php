<div class="container p-4">
    <h1 class="text-center">Halaman Prediksi</h1>
    <div class="card container" style="width: 30rem">
        <div class="card-body">
            <form method="post" action="<?= site_url(); ?>/c_naiveBayes/hasilprediksidata">

                <div class="form-group">
                    <label for="exampleInputEmail1">Nama Produk</label>
                    <select class="custom-select" name='namaproduk'>
                        <option selected>Pilih Nama Produk</option>
                        <?php foreach ($dataForm['namaproduk'] as $produk) : ?>
                            <option value="<?= $produk ?>"><?= $produk ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Ukuran</label>
                    <select class="custom-select" name="harga">
                        <option selected>Pilih Ukuran</option>
                        <?php foreach ($dataForm['ukuran'] as $ukran) : ?>
                            <option value="<?= $ukran ?>"><?= $ukran ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Harga</label>
                    <select class="custom-select" name="ukuran">
                        <option selected>Pilih Harga</option>
                        <?php foreach ($dataForm['daftarHarga'] as $harga) : ?>
                            <option value="<?= $harga ?>"><?= $harga ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Warna</label>
                    <select class="custom-select" name="warna">
                        <option selected>Pilih Warna</option>
                        <?php foreach ($dataForm['daftarWarna'] as $warna) : ?>
                            <option value="<?= $warna ?>"><?= $warna ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Jumlah Pembelian</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="enter status" name="jml_pembelian">
                </div>
                <button type="submit" class="btn btn-lg btn-primary">Proses</button>
            </form>
        </div>
    </div>

</div>