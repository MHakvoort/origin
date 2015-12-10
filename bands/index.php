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
$all_bands = $bands->get_all();
?>

<div class="page-header">
    <?php if(!empty($usr['band']) && isset($usr['band'])) { ?>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" ariahaspopup="true"
                aria-expanded="false">
            Acties <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="index.php?map=bands&page=add">Eigen band aanmaken</a></li>
        </ul>
    </div>
    <?php } ?>
    <h3>
        <i class="fa fa-fw fa-music"></i> Bands
    </h3>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Website</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($all_bands as $band) { ?>
                        <tr>
                            <td><?= $band['naam']?></td>
                            <td><?=$band['website']?></td>
                            <td><a href="index.php?map=bands&page=show&id=<?=$band['bands_id']?>"><i class="fa fa-fw fa-search"></i></a></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>
<!-- /.container -->
