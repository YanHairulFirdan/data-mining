<div class="container p-4">
    <h1 class="text-center">Halaman Prediksi</h1>
    <div class="card container" style="width: 30rem">
        <div class="card-body">
            <form method="post" action="<?= site_url(); ?>/c_naiveBayes/hasilPrediksi">
                <div class="form-group">
                    <label for="exampleInputEmail1">Outlook</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="enter outlook" name="outlook">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Temperature</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="enter temperature" name="temprature">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Humadity</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="enter Humadity" name="humadity">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Windy</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="enter Windy" name="windy">
                </div>
                <button type="submit" class="btn btn-primary">Proses</button>
            </form>
        </div>
    </div>

</div>