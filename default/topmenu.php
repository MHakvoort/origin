<?php
if (isset($_SESSION['user'])) {
    $usr = new Users();
    $usr = $usr->get($_SESSION['user']);
    if (!$usr) {
        header('HTTP/1.0 302 Found');
        header("Location: index.php?map=login&page=index");
        exit();
    }
}
?>

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <a class="logo" href="#">
        <!--        <span><img src="/style/images/logo-mygig.png" style="margin-left:10px;"></span>-->
    </a>

    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php?map=default&page=home"><span class="fa fa-fw fa-dashboard"></span> Dashboard</a>
                </li>
                <li><a href="index.php?map=events&page=index"><span class="fa fa-fw fa-calendar"></span> Evenementen</a>
                </li>
                <li><a href="index.php?map=bands&page=index"><span class="fa fa-fw fa-music"></span> Bands</a></li>
                <li><a href="index.php?map=leden&page=index"><span class="fa fa-fw fa-users"></span> Leden</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="index.php?map=leden&page=show&id=<?=$usr['id']?>">
                        <span class="fa fa-fw fa-user"></span><?= $_SESSION['user'] ?>
                    </a>
                </li>
                <li>
                    <a href="index.php?map=login&page=loguit"><span class="fa fa-fw fa-arrow-circle-o-right"></span>
                        Uitloggen</a>
                </li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>
<div class="container">

