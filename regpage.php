<?php include_once "includes/header.php"; ?>
<main role="main" class="container">
    <div class="row">
        <div class="col-lg-12" id="products-container">
            <?php include_once "includes/nav.php"; ?>
            </div>
        </div>
    </div>
<form method="post" action="index.php">
<fieldset style="border: 1px solid rgba(0,0,0,.2); border-radius: 5px;">
  <div class="container">
    <h1>Registreren</h1>
    <p>Vul aub dit formulier in om een account aan te maken.</p>
    <hr>
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
            <label>Geboortedatum</label>
    <input type="date" class="form-control" placeholder="DD-MM-YY" name="date">
      </div>
      <div class="form-group">
            <label>Adresgegevens</label>
    <?php include_once "includes/maps.php"; ?>
      </div>

      <div class="form-group">
            <label>E-mailadres</label>
    <input type="email" class="form-control" placeholder="Vul hier uw e-mailadres in" name="email" required>
      </div>
      <div class="form-group">
            <label>Wachtwoord</label>
    <input type="password" class="form-control" placeholder="Vul hier uw wachtwoord in" name="psw" required>
      </div>
      <div class="form-group">
            <label>Wachtwoord herhalen</label>
    <input type="password" class="form-control" placeholder="Vul hier nogmaals uw wachtwoord in" name="psw-repeat" required>
      </div>
      <p>Door dit formulier te versturen gaat u akkoord met onze <a href="#">voorwaarden</a>.</p>
        <input type="hidden" name="register" value="1">
    <button class="btn btn-primary my-2 my-sm-0 col-lg-2" type="submit" class="registerbtn">Registreren</button>
  </div>

  <div class="container signin">
    <p>Heeft u al een account? <a href="inloggen.php">Log dan direct in!</a></p>
  </div>
    </fieldset>
</form>
<br>
</body>
</main>
<?php include_once "includes/footer.php"; ?>