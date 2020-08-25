<div class="container">
    <h1 class="text-center">Tabel kasus</h1>
    <a href="hapusDataTable" class="btn btn-danger float-right mb-2" onclick="return confirm('hapus semua data training')">Hapus Data</a>
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
    <?php
    // echo "<pre>";
    // print_r($dataTraining->result_array());
    // echo "</pre>";
    ?>
    <table class="table table-bordered mt-5">
        <thead>
            <tr>
                <th class="text-center" scope="col">No</th>
                <th class="text-center" scope="col">Nama Produk</th>
                <th class="text-center" scope="col">Ukuran</th>
                <th class="text-center" scope="col">Warna</th>
                <th class="text-center" scope="col">Harga</th>
                <th class="text-center" scope="col">Jumlah Pembelian</th>
                <th class="text-center" scope="col">Status</th>
                <th class="text-center" scope="col">AKSI</th>
            </tr>
        </thead>
        <tbody ng-repeat="data in dataPenjualan">


            <tr ng-repeat="datas in data | filter:keyword">

                <td class="text-center" ng-init="i=range()">{{i+1 }}
                </td>
                <td class="text-center">{{datas.namaproduk}}</td>
                <td class="text-center">{{datas.ukuran}}</td>
                <td class="text-center">{{datas.warna}}</td>
                <td class="text-center">{{datas.harga}}</td>
                <td class="text-center">{{datas.jml_pembelian}}</td>
                <td class="text-center">{{datas.status}}</td>
                <td class="text-center">
                    <a href="updateData/{{data[i].id}}" class=" btn btn-success">edit</a>
                    <a href="delete/{{data[i].id}}" class="btn btn-danger" onclick="return confirm('hapus data')">hapus</a>
                </td>
            </tr>

        </tbody>
    </table>
    <a href="<?= site_url() ?>/ReadExcel" class="btn btn-primary mt-5 float-right">Upload File</a>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js">
</script>
<script>
    var myApp = angular.module("myApp", []);
    myApp.controller("myCtrl", function($scope) {
        $scope.dataPenjualan = [
            <?= json_encode($dataTraining->result_array()) ?>
        ];
        $scope.start = 0;
        $scope.range = function() {
            console.log("index " + $scope.start);
            return $scope.start++;

        }
    })
</script>