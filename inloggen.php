<?php include_once "includes/header.php";
?>
    <main role="main" class="container">
        <div class="row">
            <div class="col-lg-12" id="products-container">
                <h1> Inloggen </h1>
                <div class="row">
                    <?php
                    if (isset($message)){
                        echo "<div class='offset-4 col-4'><div class=\"alert alert-danger\" role=\"alert\">$message </div></div>";
                    }
                    ?>
                    <form method="post" class="offset-4 col-4">
                        <div class="form-group">
                            <label for="gebruikersnaam">E-mailadres:</label>
                            <input id="gebruikersnaam" class="form-control" type="email" name="gebruikersnaam" required>
                        </div>
                        <div class="form-group">
                            <label for="wachtwoord">Wachtwoord:</label>
                            <input id="wachtwoord" class="form-control" type="password" name="wachtwoord" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block"> Inloggen</button>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </main>
<?php include_once "includes/footer.php"; ?>