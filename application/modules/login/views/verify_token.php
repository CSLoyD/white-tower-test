<!-- Thank You Page -->
<div class="login-content">
    <div class="signup-container text-center">
        <?php if($status == 'success'): ?>
            <i class="fa fa-check text-success fs-64"></i>
            <h1 class="mb-3"><?= $msg; ?></h1>
        <?php else: ?>
            <i class="fa fa-times text-danger fs-64"></i>
            <h1 class="mb-3"><?= $msg; ?></h1>
        <?php endif; ?>

        <a href="<?= base_url('login') ?>" class="btn btn-primary btn-signup mt-5"> Go To Login</a>
    </div>
</div>