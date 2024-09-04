<!-- Sign-Up Form -->
<div class="login-content">
    <div class="signup-container">
        <h2>Sign-Up</h2>
        <form id="registration-form" method="POST">
            <div class="mb-3">
                <div class="row">
                    <div class="col">
                        <label for="">First Name</label>
                        <input type="text" name="firstname" class="form-control" placeholder="First Name" required>
                    </div>
                    <div class="col">
                        <label for="">Last Name</label>
                        <input type="text" name="lastname" class="form-control" placeholder="Last Name" required>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <label for="">New Password</label>
                <input type="password" name="password" class="form-control" placeholder="New Password" required>
            </div>
            <div class="mb-3">
                <label for="">Confirm Password</label>
                <input type="password" name="c_password" class="form-control" placeholder="Confirm Password" required>
                <p class="err"></p>
            </div>
            <button type="submit" class="btn btn-primary btn-signup">Sign Up</button>
        </form>
    </div>
</div>