<div class="container">
    <?php foreach ($dataset as $key => $data) : ?>
        <div class="row">
            <div class="col-md-3">
                <?php echo "<pre>"; ?>
                <?php print_r($data); ?>
                <?php echo "</pre>"; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>