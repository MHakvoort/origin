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

//Haal ID op
$id = $_GET['id'];
$bands = new Bands();
$bandsmusic = new BandsMusic();
$bandsusers = new BandsUsers();

//Haal genres op
$genres = new Genres();
$genres = $genres->get_all();

//Haal band op
$band = $bands->get($id);
if (!$band) {
    header('HTTP/1.0 302 Found');
    header("Location: index.php?map=events&page=index");
    exit();
}

//Haal bandleden op
$bandmembers = $bandsusers->getBandMembers($id);
$remainingMembers = $bandsusers->getAllMembers($id);

//Haal video's op
$video = $bandsmusic->getVideo($id);

//Check of er POST waarde is
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Valideer post attr van info form
    if (!empty($_POST['info_submit'])) {
        if ($_POST && isset($_POST['naam'], $_POST['website'], $_POST['woonplaats'], $_POST['telefoon'], $_POST['genre'])) {
            $naam = test_input($_POST['naam']);
            $website = test_input($_POST['website']);
            $woonplaats = test_input($_POST['woonplaats']);
            $telefoon = test_input($_POST['telefoon']);
            $genre = test_input($_POST['genre']);

            $band_new = $bands->edit($id, $naam, $genre, $woonplaats, $website, $telefoon);
            if ($band_new) {
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

            $band = $bands->get($id);
        } else {
            ?>
            <script>
                $.notify("Niet alle waardes zijn ingevuld", "error");
            </script>
        <?php
        }
    }

    if (!empty($_POST['add_member_submit'])) {
        $member = $_POST['member'];

        $bandsusers->addBandMember($member, $id);
        ?>
        <script>
            $.notify("Nieuw lid succesvol toegevoegd", "success");
        </script>
        <?php

        $band = $bands->get($id);
        $bandmembers = $bandsusers->getBandMembers($id);
        $remainingMembers = $bandsusers->getAllMembers($id);
    }

    if (!empty($_POST['add_video_submit'])) {
        $video = $_POST['video'];

        $bandsmusic->addVideo($video, $id);
        ?>
        <script>
            $.notify("Video succesvol toegevoegd", "success");
        </script>
        <?php

        $band = $bands->get($id);
        $video = $bandsmusic->getVideo($id);
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
        <i class="fa fa-fw fa-music"></i> <?= $band['naam'] ?>
        <small><?= $band['website'] ?></small>
    </h3>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-fw fa-info"></i> Info
                </h3>

                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <form name="infoForm" method="post" action="">
                            <div class="form-group">
                                <label>Naam</label>
                                <input type="text" class="form-control" name="naam"
                                       value="<?= $band['naam'] ?>"  <?= ($band['admin_id'] == $usr['id']) ? '' : 'disabled' ?>>
                            </div>
                            <div class="form-group">
                                <label>Genre</label>
                                <select name="genre"
                                        class="form-control" <?= ($band['admin_id'] == $usr['id']) ? '' : 'disabled' ?>>
                                    <?php foreach ($genres as $genre) { ?>
                                        <option <?= ($band['genre_id'] == $genre['genre_id']) ? 'selected=selected' : '' ?>
                                            value="<?= $genre['genre_id'] ?>"> <?= $genre['naam'] ?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Website</label>
                                <input type="text" class="form-control" name="website"
                                       value="<?= $band['website'] ?>" <?= ($band['admin_id'] == $usr['id']) ? '' : 'disabled' ?>>
                            </div>
                            <div class="form-group">
                                <label>Woonplaats</label>
                                <input type="text" class="form-control" name="woonplaats"
                                       value="<?= $band['woonplaats'] ?>" <?= ($band['admin_id'] == $usr['id']) ? '' : 'disabled' ?>>
                            </div>
                            <div class="form-group">
                                <label>Telefoon</label>
                                <input type="text" class="form-control" name="telefoon"
                                       value="<?= $band['telefoon'] ?>" <?= ($band['admin_id'] == $usr['id']) ? '' : 'disabled' ?>>
                            </div>
                            <?php if ($band['admin_id'] == $usr['id']) { ?>
                                <div class="form-group">
                                    <input type="submit" name=info_submit" class="btn btn-primary"
                                           value="Pas informatie aan!">
                                </div>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-fw fa-users"></i> Band leden
                </h3>

                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-responsive">
                            <thead>
                            <tr>
                                <th>Gebruikersnaam</th>
                                <th>Naam</th>
                                <th>Emailadres</th>
                                <th>Woonplaats</th>
                                <th>Persoonlijke website</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (count($bandmembers) > 0) { ?>
                                <?php foreach ($bandmembers as $member) { ?>
                                    <tr>
                                        <td>
                                            <a href="index.php?map=leden&page=show&id=<?= $member['users_id'] ?>"><?= $member['gebruikersnaam'] ?></a>
                                        </td>
                                        <td><?= $member['voornaam'] ?>&nbsp;<?= $member['achternaam'] ?></td>
                                        <td><?= $member['email'] ?></td>
                                        <td><?= $member['woonplaats'] ?></td>
                                        <td><?= $member['gebruikerwebsite'] ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="5">Nog geen leden toegevoegd..</td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if ($band['admin_id'] == $usr['id']) { ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#addMember">
                                    <i class="fa fa-fw fa-plus"></i>
                                    Bandlid toevoegen
                                </button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-video-camera"></i> Video's
                </h3>

                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <?php if (count($video) > 0) { ?>
                    <?php foreach ($video as $v) { ?>
                        <div class="row">
                            <div class="col-md-12">
                                <?= $v['url'] ?>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                Nog geen video's toegevoegd..
                            </p>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($band['admin_id'] == $usr['id']) { ?>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addVideo">
                                <i class="fa fa-fw fa-plus"></i> Video toevoegen
                            </button>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-fw fa-camera-retro"></i> Foto's
                </h3>

                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--Modal member toevoegen-->
<div id="addMember" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Bandlid toevoegen</h4>
            </div>
            <div class="modal-body">
                <form name="addMemberForm" method="post" action="">
                    <p>Selecteer een lid om deze toe te voegen aan de band
                        <br>
                        <small><b>Let op: Een lid kan maar van 1 band lid zijn!</b></small>
                    </p>

                    <select class="form-control" name="member">
                        <?php foreach ($remainingMembers as $m) { ?>
                            <option value="<?= $m['id'] ?>"><?= $m['username'] ?> (<?= $m['first_name'] ?>
                                &nbsp;<?= $m['surname'] ?>)
                            </option>
                        <?php } ?>
                    </select>
                    <br>
                    <input type="submit" name="add_member_submit" class="btn btn-primary"
                           value="Lid toevoegen aan deze band!">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<!--Modal video toevoegen-->
<div id="addVideo" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Video toevoegen</h4>
            </div>
            <div class="modal-body">
                <form name="addMemberForm" method="post" action="">
                    <p>Voer de URL in naar het Youtube of Soundcloud bestand<br>
                        <b>Gebruik de url voor een "embedded" video</b>
                    </p>

                    <input type="text" class="form-control" name="video">
                    <br>
                    <input type="submit" name="add_video_submit" class="btn btn-primary"
                           value="Video toevoegen voor deze band!">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


<script>
    /*
     * Add collapse and remove events to boxes
     */
    $("[data-widget='collapse']").click(function () {
        //Find the box parent
        var box = $(this).parents(".box").first();
        //Find the body and the footer
        var bf = box.find(".box-body, .box-footer");
        if (!box.hasClass("collapsed-box")) {
            box.addClass("collapsed-box");
            bf.slideUp();
        } else {
            box.removeClass("collapsed-box");
            bf.slideDown();
        }
    });
</script>
