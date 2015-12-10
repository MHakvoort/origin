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

$bands = new Bands();

//Define variables
$naam = $genre_id = $website = $woonplaats = $telefoon = "";

//Haal genres op
$genres = new Genres();
$genres = $genres->get_all();

//Check of er POST waarde is
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Valideer post attr
    if ($_POST && isset($_POST['naam'], $_POST['genre'], $_POST['website'], $_POST['woonplaats'], $_POST['telefoon'])) {
        $naam = test_input($_POST['naam']);
        $genre_id = test_input($_POST['genre']);
        $website = test_input($_POST['website']);
        $woonplaats = test_input($_POST['woonplaats']);
        $telefoon = test_input($_POST['telefoon']);

        $band = $bands->add($naam, $genre_id, $website, $woonplaats, $telefoon, $usr['id']);
        if ($band) {
            $band = $bands->get($band);

            if ($band) {
                ?>
                <script>
                    $.notify("Band is succesvol aangemaakt!", "success");
                </script>
                <?php

            } else {
                ?>
                <script>
                    $.notify("Band kon niet worden aangemaakt", "error");
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

<div class="page-header">
    <h3>
        <i class="fa fa-fw fa-calendar"></i> Bands
        <small>Nieuw</small>
    </h3>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label>Naam Band</label>
                        <input type="text" class="form-control" name="naam">
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
                        <label>Website</label>
                        <input type="text" class="form-control" name="website">
                    </div>
                    <div class="form-group">
                        <label>Woonplaats</label>
                        <input type="text" class="form-control" name="woonplaats">
                    </div>
                    <div class="form-group">
                        <label>Telefoonnummer</label>
                        <input type="text" class="form-control" name="telefoon">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Voeg band toe!">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
