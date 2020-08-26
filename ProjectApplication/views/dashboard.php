<div class="container mb-5">
    <div class="row">

        <div class="col-md-12">
            <h2>Selamat Datang di Aplikasi Data Mining Berbasis Website</h2>
            <p>Aplikasi ini merupakan aplikasi untuk prediksi yang menggunakan Algoritma Naive Bayes yang diintegrasikan dengan algoritma SMOTE</p>
            <a class="btn btn-primary" href="<?= site_url() ?>/smote/">tampilkan data awal</a>
        </div>
        <!-- <div class="col-md-4">
        <div class="container mt-2">
            <div class="card bg-light mb-3" style="max-width: 26rem;">
                <div class="card-header">
                    <h2><?= $data->name ?> Weather Status</h2>
                </div>
                <div class="card-body">
                    <div class="time pl-4">
                        <p class="text-bold text-gray"><?= date("l g:i a", $currentTime) ?></p>
                        <p class="text-bold text-gray"><?= date("jS F, Y", $currentTime) ?></p>
                        <p class="text-bold text-gray"><?= ucwords($data->weather[0]->description) ?></p>
                    </div>
                    <div class="weatherforcast pl-4">
                        <img src="http://openweathermap.org/img/w/<?php echo $data->weather[0]->icon ?>.png" class="wather-icon mr-1" alt=""><span><?= $data->main->temp_max - 275.15 ?>°C</span>
                        <span class="temp-min mr-1"><?= $data->main->temp_min - 275.15 ?>°C</span>
                    </div>
                    <div class="time pl-4">
                        <p>Humidity : <?= $data->main->humidity ?> %</p>
                        <p>speed : <?= $data->wind->speed ?> km/h</p>
                    </div>
                </div>
            </div>
        </div>-->
    </div>
</div>