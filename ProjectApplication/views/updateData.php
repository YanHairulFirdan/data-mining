<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Halaman Home</title>
</head>

<body>
    <div class="container p-4">
        <h1 class="text-center">Halaman Ubah Data</h1>
        <div class="card container" style="width: 30rem">
            <div class="card-body">
                <form method="post" action="perbaharuiData">
                    <input type="hidden" name="id" value="<?= $updateData[0]['id'] ?>">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Outlook</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="enter outlook" name="outlook" value="<?= $updateData[0]['outlook'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Temperature</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="enter temperature" name="temprature" value="<?= $updateData[0]['temperature'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Humadity</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="enter Humadity" name="humadity" value="<?= $updateData[0]['humadity'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Windy</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="enter Windy" name="windy" value="<?= $updateData[0]['windy'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Windy</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="enter Windy" name="windy" value="<?= $updateData[0]['play'] ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Proses</button>
                </form>
            </div>
        </div>

    </div>

</body>

</html>