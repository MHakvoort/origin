<?php

if (isset($_POST) && !empty($_POST)) {
    $usr = new Users();
    $usr->storeFormValues($_POST);

    if ($usr->register()) {
        echo '<div class="row">
            <div class="col-md-6 col-md-offset-3">
            <div class="alert alert-success" role="alert">
            <center>U bent succesvol geregistreerd! <br> Houd onze facebook pagina in de gaten voor nieuwe updates!</center>
            </div>
            </div></div>
            ';
    } else {
        echo '<div class="row">
            <div class="col-md-6 col-md-offset-3">
            <div class="alert alert-danger" role="alert">
            <center>Deze gebruikersnaam is al in gebruik!</center>
            </div>
            </div></div>
            ';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>MyGig - Coming Soon</title>
    <link rel="stylesheet" href="comingsoon/assets/bootstrap/css/bootstrap.css"/>
    <link id="theme" rel="stylesheet" href="comingsoon/assets/blue.css"/>
</head>
<body>

<div class="container">
    <div class="wrapper-bg">
        <div class="wrapper">
            <div class="shadow"></div>
            <div class="header"><img src="/style/images/logo-mygig.png"></div>
            <div class="opacity">
                <div class="topleft"></div>
                <div class="bottomleft"></div>
                <div class="bottomright"></div>
                <div class="content">
                    <h1><span>MyGig</span> bands fans en podia dichter bij elkaar
                    </h1>

                    <div class="row block">
                        <div class="row">
                            <div class="col-md-6 col-xs-12"><h3>Features</h3>
                                <ul class="list-unstyled">
                                    <li>Ontdek nieuwe bands</li>
                                    <li>Creeer nieuwe connecties</li>
                                    <li>Vind potentiele bands voor je evenement</li>
                                    <li>Vind nieuwe podia</li>
                                    <li>Blijf op de hoogte</li>
                                    <li>Vergroot je bekendheid</li>
                                    <li>Lidmaatschap is volledig GRATIS</li>
                                </ul>

                                <div class="social">
                                    <a href="https://www.facebook.com/pages/My-Gig/356617624539002"><img
                                            src="comingsoon/assets/img/facebook.png" height="24"
                                            alt="facebook"/></a>
                                    <a href="#"><img src="comingsoon/assets/img/twitter.png" height="24" alt="twitter"/></a>
                                    <a href="#"><img src="comingsoon/assets/img/linkedin.png" height="24"
                                                     alt="linkedin"/></a>
                                    <a href="#"><img src="comingsoon/assets/img/instagram.png" height="24"
                                                     alt="instagram"/></a>
                                </div>


                            </div>
                            <div class="col-md-6 col-xs-12">
                                <h2>MyGig is nog onder constructie</h2>

                                <div class="subscribe">
                                    <p>Toch al inschrijven? Meld je nu snel vast aan!</p>

                                    <form method="post" action="">
                                        <div class="field">
                                            <input class="form-control" name="first_name" type="text"
                                                   placeholder="Voornaam">
                                        </div>
                                        <div class="field">
                                            <input class="form-control" name="surname" type="text"
                                                   placeholder="Achternaam">
                                        </div>
                                        <div class="field">
                                            <input class="form-control" name="email" type="text"
                                                   placeholder="Emailadres">
                                        </div>
                                        <div class="field">
                                            <input class="form-control" name="user-input" type="text"
                                                   placeholder="Gebruikersnaam">
                                        </div>
                                        <div class="field">
                                            <input class="form-control" name="password-input" type="password"
                                                   placeholder="Wachtwoord">
                                        </div>
                                        <div class="field">
                                            <input type="radio" name="type" value="fan"> Fan <br>
                                            <input type="radio" name="type" value="band"> Band <br>
                                            <input type="radio" name="type" value="podia"> Podia
                                        </div>
                                        <button class="btn btn-default">Registreer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xs-12" style="text-align:center;">
                                <small>
                                    <br>Meer informatie, vragen of suggesties? <br>
                                    Mail ons snel op <span style="color:#18a8eb;">info@mygig.nl</span>
                                </small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="comingsoon/assets/bootstrap/js/bootstrap.js"></script>
</body>
</html>



