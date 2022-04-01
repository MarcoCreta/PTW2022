    <form class="content" method="POST" id="login-form">
        <h2>Login</h2>

        <p class="" id="login-error"><?php echo $templateParams["loginError"];?></p>

        <div class="mb-3">
            <input type="text" class="form-control" id="l-username" name="l-username" placeholder="e-mail">
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" id="l-password" name="l-password" placeholder="password">
            <a href="signup.php">non hai un account? iscriviti</a>
        </div>
        <button type="submit" class="btn btn-primary container-fluid" name="submit" value="Invia">Submit</button>
    </form>