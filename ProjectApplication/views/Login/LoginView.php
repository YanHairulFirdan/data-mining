<!-- } echo $this->session->flashdata('alert'); ?> -->
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>asset/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>asset/css/loginStyle.css">

    <title>Hello, world!</title>
</head>

<body>

    <div class=" container form-login">

        <?php
        if ($this->session->flashdata('alert')) : ?>
            <div class="row mt-3 p-3">
                <div class="alert ml-3 alert-danger alert-dismissible fade show" role="alert">
                    <p> <?= $this->session->flashdata('alert'); ?></p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        <?php endif; ?>

        <h2 class="text-center text-light">Selamat Datang di website Data Mining</h2>
        <form action="<?= site_url() ?>/user/validation" method="POST">
            <div class="form-group">
                <label class="text-light" for="exampleInputEmail1">Username</label>
                <input name="namauser" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

            </div>
            <div class="form-group">
                <label class="text-light" for="exampleInputPassword1">Password</label>
                <input name="userpass" type="password" class="form-control" id="exampleInputPassword1">
            </div>

            <button type="submit" class="btn btn-primary">Masuk</button>
        </form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>