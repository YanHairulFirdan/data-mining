<div class="container">
    <div class="form-group">
        <form action="<?= site_url() ?>/ReadExcel/upload" enctype="multipart/form-data" method="POST">
            <div class="form-group">
                <label for="exampleInputEmail1">Input File Excel Anda</label>
                <input type="file" name="file">
                <br>
                <input type="submit" value="upload file">
            </div>
        </form>

    </div>
</div>