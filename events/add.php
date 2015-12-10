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

//Define variables
$naam = $omschrijving = $datum = $type = $genre = $plaatsnaam = $land = "";

//Haal evenement types op
$evenementtype = new EventsType();
$types = $evenementtype->get_all();

//Haal genres op
$genres = new Genres();
$genres = $genres->get_all();

//Haal landen op
$landen = new Land();
$landen = $landen->get_all();

$events = new Events();

//Check of er POST waarde is
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Valideer post attr
    if ($_POST && isset($_POST['naam'], $_POST['omschrijving'], $_POST['datum'], $_POST['type'], $_POST['genre'], $_POST['plaatsnaam'], $_POST['land'])) {
        $naam = test_input($_POST['naam']);
        $omschrijving = test_input($_POST['omschrijving']);
        $datum = test_input($_POST['datum']);
        $type = test_input($_POST['type']);
        $genre = test_input($_POST['genre']);
        $plaatsnaam = test_input($_POST['plaatsnaam']);
        $land = test_input($_POST['land']);

        $event = $events->add($type, $genre, $land, $plaatsnaam, $naam, $omschrijving, $datum, $usr['id']);
        if ($event) {
            $event = $events->get($event);

            if ($event) {
                ?>
                <script>
                    $.notify("Evenement is succesvol aangemaakt!", "success");
                </script>
                <?php

                header('HTTP/1.0 302 Found');
                header("Location: index.php?map=events&page=edit&id=".$event['events_id']);
            } else {
                ?>
                <script>
                    $.notify("Evenement kon niet worden aangemaakt", "error");
                </script>
            <?php
            }
        }
    } else {
        ?>
        <script>
            $.notify("Niet alle waardes zijn ingevuld", "error");
        </script>
    <?php
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<script>
    $(document).ready(function () {
        $('#datepicker').datepicker();
    });
</script>

<div class="page-header">
    <?php if (!empty($usr['band']) && isset($usr['band']) || !empty($usr['podia']) && isset($usr['podia'])) { ?>
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" ariahaspopup="true"
                    aria-expanded="false">
                Acties <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="?map=events&page=index">Terug naar overzicht</a></li>
            </ul>
        </div>
    <?php } ?>
    <h3>
        <i class="fa fa-fw fa-calendar"></i> Evenementen
        <small>Nieuw</small>
    </h3>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label>Naam Evenement</label>
                        <input type="text" class="form-control" name="naam">
                    </div>
                    <div class="form-group">
                        <label>Omschrijving</label>
                        <textarea class="form-control" rows="5" name="omschrijving"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Datum</label>
                        <input type="text" class="form-control" id="datepicker" name="datum">
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" class="form-control">
                            <?php foreach ($types as $type) { ?>
                                <option value="<?= $type['events_type_id'] ?>"> <?= $type['naam'] ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Genre</label>
                        <select name="genre" class="form-control">
                            <?php foreach ($genres as $genre) { ?>
                                <option value="<?= $genre['genre_id'] ?>"> <?= $genre['naam'] ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Plaatsnaam</label>
                        <input type="text" class="form-control" name="plaatsnaam">
                    </div>
                    <div class="form-group">
                        <label>Land</label>
                        <select name="land" class="form-control">
                            <?php foreach ($landen as $land) { ?>
                                <option value="<?= $land['land_id'] ?>"> <?= $land['naam'] ?> </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Voeg evenement toe!">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
<!-- /.container -->
