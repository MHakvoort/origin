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

$events = new Events();
$all_events = $events->get_all();

?>

<link rel="stylesheet" href="/style/css/event.css" type="text/css">

<div class="page-header">
    <?php if (!empty($usr['band']) && isset($usr['band']) || !empty($usr['podia']) && isset($usr['podia'])) { ?>
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" ariahaspopup="true"
                    aria-expanded="false">
                Acties <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="index.php?map=events&page=add">Evenement toevoegen</a></li>
            </ul>
        </div>
    <?php } ?>
    <h3>
        <i class="fa fa-fw fa-calendar"></i> Evenementen
        <small>Overzicht</small>
    </h3>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="container">
                    <div class="row">
                        <div class="[ col-xs-12 col-sm-11 ]">
                            <ul class="event-list">
                                <?php foreach($all_events as $event) {
                                    $date = new DateTime($event['datum']);
                                    ?>
                                    <li>
                                        <time datetime="<?=$date->format('Y-m-d')?>">
                                            <span class="day"><?=$date->format('d')?></span>
                                            <span class="month"><?=date('M', strtotime($date->format('Y-m-d')))?></span>
                                            <span class="year"><?=$date->format('Y')?></span>
                                            <span class="time">ALL DAY</span>
                                        </time>
                                        <div class="info">
                                            <h2 class="title"><?=$event['naam']?></h2>
                                            <p class="desc"><?=$event['plaatsnaam']?>,&nbsp;<?=$event['land']?></p>
                                            <p class="desc"><?=$event['omschrijving']?></p>
                                            <ul>
                                                <li style="width:33%;"><a href="#"><span class="fa fa-globe"></span> Website</a></li>
                                                <li style="width:33%;"><span class="fa fa-money"></span> &euro; 39.99</li>
                                                <li style="width:33%;">
                                                    <a href="index.php?map=events&page=show&id=<?=$event['events_id']?>">
                                                        <span class="fa fa-fw fa-arrow-right"></span> Meer informatie
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="social">
                                            <ul>
                                                <li class="facebook" style="width:33%;"><a href="#"><span class="fa fa-facebook"></span></a></li>
                                                <li class="twitter" style="width:34%;"><a href="#"><span class="fa fa-twitter"></span></a></li>
                                                <li class="google-plus" style="width:33%;"><a href="#"><span class="fa fa-google-plus"></span></a></li>
                                            </ul>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/style/js/responsive-calendar.js"></script>

</div>
<!-- /.container -->
