<div class="container">
    <h1 class="text-center">Tabel kasus</h1>
    <?php
    if ($this->session->flashdata('flash')) : ?>
        <div class="row mt-3">
            <div class="col-md-6">
            </div>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Data Baru <strong>Berhasil</strong> <?= $this->session->flashdata('flash'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    <?php endif; ?>
    <table class="table table-bordered mt-5">
        <thead>
            <tr>
                <th class="text-center" scope="col">No</th>
                <th class="text-center" scope="col">Nama Produk</th>
                <th class="text-center" scope="col">Ukuran/th>
                <th class="text-center" scope="col">Warna</th>
                <th class="text-center" scope="col">Harga</th>
                <th class="text-center" scope="col">Jumlah Pembelian</th>
                <th class="text-center" scope="col">Status</th>
                <th class="text-center" scope="col">AKSI</th>
            </tr>
        </thead>
        <tbody>
            <td>
                <?php
                $i = 1;
                foreach ($datasearching as $dataSingle) : ?>
                    <tr>
                        <td class="text-center"><?= $i; ?></td>
                        <td class="text-center"><?= $dataSingle['namaproduk']; ?></td>
                        <td class="text-center"><?= $dataSingle['ukuran']; ?></td>
                        <td class="text-center"><?= $dataSingle['warna']; ?></td>
                        <td class="text-center"><?= $dataSingle['harga']; ?></td>
                        <td class="text-center"><?= $dataSingle['jml_pembelian']; ?></td>
                        <td class="text-center"><?= $dataSingle['status']; ?></td>
                        <td class="text-center">
                            <a href="updateData/<?= $dataSingle['id'] ?>" class="btn btn-success">edit</a>
                            <a href="delete/<?= $dataSingle['id'] ?>" class="btn btn-danger" onclick="return confirm('hapus data')">hapus</a>
                        </td>
                    </tr>
                <?php $i++;
                endforeach; ?>
            </td>
        </tbody>
    </table>
    <a href="prediksi" class="btn btn-primary mt-5 float-right">Halaman Prediksi</a>
</div>