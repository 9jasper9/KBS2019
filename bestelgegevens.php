<?php include_once "includes/header.php"; ?>
<!--
Een snelle opzet van de pagina voor het invullen van bestelgegevens.
Optioneel inloggen en/of account aanmaken

~bas

-->
<main role="main" class="container" >
    <div class="row">
        <div class="col-lg-12" id="products-container">
            <?php include_once "includes/nav.php"; ?>
            <form method="post">
<fieldset style="border: 1px solid rgba(0,0,0,.2); border-radius: 5px;">
  <div class="container">
      <h1>Gegevens invullen</h1><br>
                    
                    Als u al een account hebt, kunt u <a href="login.php">hier inloggen</a>.<br>
                    Indien u nog geen account hebt, kunt u zich <a href="regpage.php">hier registreren</a>.<br>
                    
                    <hr>
                    Als u wilt bestellen zonder een account aan te maken, vul dan uw gegevens in in het onderstaande formulier.
                    <br><br>



      <div class="form-group">
          <label>Voornaam</label>
          <input type="text" class="form-control" placeholder="Vul hier uw voornaam in" name="firstname" required>
      </div>
      <div class="form-group">
          <label>Achternaam</label>
          <input type="text" class="form-control" placeholder="Vul hier uw achternaam in" name="lastname" required>
      </div>
      <div class="form-group">
          <label>Telefoonnummer</label>
          <input type="tel" class="form-control" placeholder="Vul hier uw telefoonnummer in" name="phone">
      </div>
      <div class="form-group">
          <label>E-mailadres</label>
          <input type="email" class="form-control" placeholder="Vul hier uw e-mailadres in" name="email" required>
      </div>
      <div class="form-group">
          <label>Geboortedatum</label>
          <input type="date" class="form-control" placeholder="DD-MM-YY" name="birthdate">
      </div>
      <div class="form-group">
          <label>Adresgegevens</label>
          <?php include_once "includes/maps.php"; ?>
      </div>
    <hr>
    <p>Door dit formulier te versturen gaat u akkoord met onze <a href="#">voorwaarden</a>.</p>

    <button class="btn btn-primary my-2 my-sm-0 col-lg-2" type="submit" class="registerbtn">Doorgaan met betalen</button>
    <br>
  </div>
    <br>
  </fieldset>
</form>
        </div>
    </div>
</main>
<br><br>
<?php include_once "includes/footer.php"; ?>