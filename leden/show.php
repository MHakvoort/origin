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
    header("Location: index.php?map=leden&page=index");
    exit();
}

$id = $_GET['id'];
$users = new Users();
$lid = $users->get_lid($id);
if (!$lid) {
    header('HTTP/1.0 302 Found');
    header("Location: index.php?map=leden&page=index");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST && isset($_POST['firstname'], $_POST['surname'], $_POST['woonplaats'], $_POST['provincie'], $_POST['website'])) {
        $firstname = test_input($_POST['firstname']);
        $surname = test_input($_POST['surname']);
        $woonplaats = test_input($_POST['woonplaats']);
        $provincie = test_input($_POST['provincie']);
        $website = test_input($_POST['website']);
    }

    $updateUser = $users->edit($id, $firstname, $surname, $woonplaats, $provincie, $website);

    $lid = $users->get_lid($id);
    if (!$lid) {
        header('HTTP/1.0 302 Found');
        header("Location: index.php?map=leden&page=index");
        exit();
    }

    $target_dir = "/style/images/avatars/";
    $target_file = $target_dir . time() . '.jpg';
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    // Check if image file is a actual image or fake image
    if (isset($_FILES['ava']) && !empty($_FILES['ava']['name'])) {
        $check = getimagesize($_FILES["ava"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if (!$uploadOk == 0) {

            if (move_uploaded_file($_FILES["ava"]["tmp_name"], SITE_ROOT . "" . $target_file)) {
            }
        }

        $users->setAvatar($usr['id'], $target_file);
    }

    ?>
    <script>
        $.notify("Profiel succesvol aangepast", "success");
    </script>
<?php

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
        <i class="fa fa-fw fa-user"></i> <?= $lid['first_name'] ?>&nbsp;<?= $lid['surname'] ?>
    </h3>
</div>

<div class="row">
    <form method="post" action="" enctype="multipart/form-data">
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">
                        Info
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
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <center><img src="<?= $lid['avatar'] ?>"
                                                         style="height:100px !important; width:100px !important;">
                                            </center>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php if($usr['id'] == $id) { ?>
                                            <br><input id="input-1" type="file" class="file form-control" name="ava">
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <br>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Voornaam</label>
                                        <input type="text" class="form-control" name="firstname"
                                               value="<?= (isset($lid['first_name'])) ? $lid['first_name'] : '' ?>" <?= ($usr['id'] == $id) ? '' : 'disabled' ?>>
                                    </div>
                                    <div class="form-group">
                                        <label>Achternaam</label>
                                        <input type="text" class="form-control" name="surname"
                                               value="<?= (isset($lid['surname'])) ? $lid['surname'] : '' ?>" <?= ($usr['id'] == $id) ? '' : 'disabled' ?>>
                                    </div>
                                    <div class="form-group">
                                        <label>Woonplaats</label>
                                        <input type="text" class="form-control" name="woonplaats"
                                               value="<?= (isset($lid['woonplaats'])) ? $lid['woonplaats'] : '' ?>" <?= ($usr['id'] == $id) ? '' : 'disabled' ?>>
                                    </div>
                                    <div class="form-group">
                                        <label>Provincie</label>
                                        <input type="text" class="form-control" name="provincie"
                                               value="<?= (isset($lid['provincie'])) ? $lid['provincie'] : '' ?>" <?= ($usr['id'] == $id) ? '' : 'disabled' ?>>
                                    </div>
                                    <div class="form-group">
                                        <label>Website</label>
                                        <input type="text" class="form-control" name="website"
                                               value="<?= (isset($lid['website'])) ? $lid['website'] : '' ?>" <?= ($usr['id'] == $id) ? '' : 'disabled' ?>>
                                    </div>
                                    <?php if ($lid['id'] == $id) { ?>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="Wijzig informatie!">
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">
                        Bands
                    </h3>

                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body" style="display:block;">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th colspan="2">Deze bands vindt <?= $lid['first_name'] ?> leuk:</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="2"><i>Geen bands ... </i></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-9 pull-right">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">
                        Evenementen
                    </h3>

                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th colspan="2">Deze evenementen vindt <?= $lid['first_name'] ?> leuk:</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="2"><i>Geen evenementen ... </i></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>
<!--</div>-->


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
