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

if (!isset($_GET['id'])) {
    header('HTTP/1.0 302 Found');
    header("Location: index.php?map=default&page=home");
    exit();
}

$id = $_GET['id'];
$events = new Events();
$message = '';

//Haal evenement types op
$evenementtype = new EventsType();
$types = $evenementtype->get_all();

//Haal genres op
$genres = new Genres();
$genres = $genres->get_all();

//Haal landen op
$landen = new Land();
$landen = $landen->get_all();

$event = $events->get($id);
if (!$event) {
    header('HTTP/1.0 302 Found');
    header("Location: index.php?map=events&page=index");
    exit();
}

//Check of er POST waarde is
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = '';
    //Valideer post attr
    if ($_POST && isset($_POST['naam'], $_POST['omschrijving'], $_POST['datum'], $_POST['type'], $_POST['genre'], $_POST['plaatsnaam'], $_POST['land'])) {
        $naam = test_input($_POST['naam']);
        $omschrijving = test_input($_POST['omschrijving']);
        $datum = test_input($_POST['datum']);
        $type = test_input($_POST['type']);
        $genre = test_input($_POST['genre']);
        $plaatsnaam = test_input($_POST['plaatsnaam']);
        $land = test_input($_POST['land']);

        $event_new = $events->edit($event['events_id'], $type, $genre, $land, $plaatsnaam, $naam, $omschrijving, $datum, $usr['id']);
        if ($event_new) {
            ?>
            <script>
                $.notify("Evenement is aangepast", "success");
            </script>
        <?php

        } else {
            ?>
            <script>
                $.notify("Evenement kon niet worden aangepast", "error");
            </script>
        <?php
        }

        $event = $events->get($id);
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
    $(document).ready(function(){
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
                <li><a href="index.php?map=events&page=add">Evenement toevoegen</a></li>
                <?php if ($event['user_id'] == $usr['id']) { ?>
                    <li>
                        <a onclick="return confirm('Weet u zeker dat u dit evenement wilt verwijderen?')" href="index.php?map=events&page=delete&id=<?=$event['events_id']?>">Evenement verwijderen</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
    <h3>
        <i class="fa fa-fw fa-calendar"></i> <?= $event['naam'] ?>
        <small><?= $event['datum'] ?></small>
    </h3>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label>Naam Evenement</label>
                        <input type="text" class="form-control" name="naam"
                               value="<?= $event['naam'] ?>" <?= ($event['user_id'] == $usr['id']) ? '' : 'disabled' ?>>
                    </div>
                    <div class="form-group">
                        <label>Omschrijving</label>
                        <textarea class="form-control" rows="5"
                                  name="omschrijving" <?= ($event['user_id'] == $usr['id']) ? '' : 'disabled' ?>><?= $event['omschrijving'] ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Datum</label>
                        <input type="text" class="form-control" id="datepicker" name="datum"
                               value="<?= $event['datum'] ?>" <?= ($event['user_id'] == $usr['id']) ? '' : 'disabled' ?>>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type"
                                class="form-control" <?= ($event['user_id'] == $usr['id']) ? '' : 'disabled' ?>>
                            <?php foreach ($types as $type) { ?>
                                <option <?= ($event['events_type_id'] == $type['events_type_id']) ? 'selected=selected' : '' ?>
                                    value="<?= $type['events_type_id'] ?>"> <?= $type['naam'] ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Genre</label>
                        <select name="genre"
                                class="form-control" <?= ($event['user_id'] == $usr['id']) ? '' : 'disabled' ?>>
                            <?php foreach ($genres as $genre) { ?>
                                <option <?= ($event['genre_id'] == $genre['genre_id']) ? 'selected=selected' : '' ?>
                                    value="<?= $genre['genre_id'] ?>"> <?= $genre['naam'] ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Plaatsnaam</label>
                        <input type="text" class="form-control" name="plaatsnaam"
                               value="<?= $event['plaatsnaam'] ?>" <?= ($event['user_id'] == $usr['id']) ? '' : 'disabled' ?>>
                    </div>
                    <div class="form-group">
                        <label>Land</label>
                        <select name="land"
                                class="form-control" <?= ($event['user_id'] == $usr['id']) ? '' : 'disabled' ?>>
                            <?php foreach ($landen as $land) { ?>
                                <option <?= ($land['land_id'] == $event['land_id']) ? 'selected=selected' : '' ?>
                                    value="<?= $land['land_id'] ?>"> <?= $land['naam'] ?> </option>
                            <?php } ?>
                        </select>
                    </div>

                    <?php if ($event['user_id'] == $usr['id']) { ?>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Pas evenement aan!">
                        </div>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
<!-- /.container -->
