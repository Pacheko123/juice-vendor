<?php if (isset($_SESSION['message'])) : ?>
    <div class="alert alert-juicy">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <?php echo $_SESSION['message']; ?>
    </div>
    <?php unset($_SESSION['message']); ?>
<?php endif ?>