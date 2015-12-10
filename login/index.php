<?php
if (isset($_GET['map'])) {
    if (!isset($_POST['user-input']) && !isset($_POST['password-input']) && $_GET['map'] !== 'login') {
        header('HTTP/1.0 302 Found');
        header("Location: index.php?map=login&page=index");
        die;
    }
}
if (isset($_POST['user-input']) && isset($_POST['password-input'])) {
    $usr = new Users();
    $usr->storeFormValues($_POST);

    if ($_POST['user-input'] != '' && $_POST['password-input'] != '') {

        if ($usr->login()) {

            $_SESSION['user'] = $_POST['user-input'];

            header('HTTP/1.0 302 Found');
            header("Location: index.php?map=default&page=home");
            die;
        } else {
            echo "<div class='errormessage'>Verkeerde gebruikersnaam of wachtwoord</div><br>";
        }
    } else if ($_POST['user-input'] == '') {
        echo "<div class='errormessage'>Gebruikersnaam niet ingevuld</div>";
    } else if ($_POST['password-input'] == '') {
        echo "<div class='errormessage'>Wachtwoord niet ingevuld</div>";
    }

    if (isset($_SESSION['user'])) {
        header('HTTP/1.0 302 Found');
        header("Location: index.php?map=default&page=home");
        exit();
    }
}

if (isset($_SESSION['user'])) {
    header('HTTP/1.0 302 Found');
    header("Location: index.php?map=default&page=home");
    die;
}
?>

<link rel="stylesheet" href="/comingsoon/assets/bootstrap/css/bootstrap.css"/>
<link id="theme" rel="stylesheet" href="/comingsoon/assets/blue.css"/>

<div class="container" style="margin-top:-100px;">
    <div class="wrapper-bg">
        <div class="wrapper">
            <div class="shadow"></div>
            <!--            <div class="header"><img src="./style/images/logo.png" alt="MyGig" /></div>-->
            <div class="header">&nbsp;</div>
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
                                            src="/comingsoon/assets/img/facebook.png" style="width:25px; height:24px;"
                                            alt="facebook"/></a>
                                    <a href="#"><img src="/comingsoon/assets/img/twitter.png" style="width:25px; height:24px;"
                                                     alt="twitter"/></a>
                                    <a href="#"><img src="/comingsoon/assets/img/linkedin.png" style="width:25px; height:24px;"
                                                     alt="linkedin"/></a>
                                    <a href="#"><img src="/comingsoon/assets/img/instagram.png" style="width:25px; height:24px;"
                                                     alt="instagram"/></a>
                                </div>


                            </div>
                            <div class="col-md-6 col-xs-12">
                                <h2>Login</h2>

                                <div class="subscribe">
                                    <form method="post" action="">
                                        <div class="field">
                                            <input type="text" class="form-control" name="user-input"
                                                   placeholder="Gebruikersnaam">
                                        </div>
                                        <div class="field">
                                            <input type="password" class="form-control" name="password-input"
                                                   placeholder="Wachtwoord">
                                        </div>

                                        <button class="btn btn-default">Login</button>
                                    </form>
                                </div>

                                <p>
                                    <br>
                                    <a href="#">Wachtwoord vergeten?</a> <br>
                                    <a href="index.php?map=register&page=index">Nog geen account? Registreer hier!</a>
                                </p>
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






