<!-- Login Form -->
<div class="login-content">
    <div class="signup-container">
        <h2>Log-In</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $_SESSION['error']; ?></div>
        <?php endif; ?>
        <form id="login-form" method="POST">
            <div class="mb-3">
                <label for="">Email</label>
                <input type="email" name="username" class="form-control" placeholder="Email" required>
                <p class="err"></p>
            </div>
            <div class="mb-3">
                <label for="">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <p class="err"></p>
            </div>
            <button type="submit" class="btn btn-primary btn-login">Login</button>
        </form>
    </div>
</div>