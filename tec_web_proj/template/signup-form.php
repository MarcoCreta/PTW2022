<form class="content" method="POST" id="signup-form">
    <h2>Crea nuovo account</h2>
    <p class="" id="singup-error"><?php echo $templateParams["loginError"]; ?></p>
    <div class="mb-3">
        <label for="r-username">username</label>
        <div class="position-relative" id="r_u">
            <input type="text" class="form-control" id="r-username" name="r-username" placeholder="create your username">
            <div id="r-u-w">
            </div>
        </div>

        <label for="r-email">e-mail</label>
        <div class="position-relative" id="r_e">
            <input type="email" class="form-control" id="r-email" name="r-email" placeholder="insert your email">
            <div></div>
        </div>

        <label for="r1-password">password</label>
        <div class="position-relative" id="r_p_1">
            <input type="password" class="form-control" id="r1-password" name="r1-password" placeholder="insert your password">
            <div></div>
        </div>

        <label for="r2-password" id="r_p_2">password</label>
        <div class="position-relative">
            <input type="password" class="form-control" id="r2-password" name="r2-password" placeholder="confirm password">
            <div></div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary container-fluid" id="r-submit" name="r-submit" value="Invia">Subscribe</button>
</form>