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

$users = new Users();
$leden = $users->get_all();
?>

<div class="page-header">
    <h3>
        <i class="fa fa-fw fa-users"></i> Leden <small>Overzicht</small>
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
                        <th>Band</th>
                        <th>Fan</th>
                        <th>Podia</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($leden as $lid) { ?>
                        <tr>
                            <td><?= $lid['first_name'] ?>&nbsp;<?= $lid['surname'] ?></td>
                            <td><?= ($lid['band']) ? '<i class="fa fa-fw fa-check">' : '<i class="fa fa-fw fa-close">' ?></td>
                            <td><?= ($lid['fan']) ? '<i class="fa fa-fw fa-check">' : '<i class="fa fa-fw fa-close">' ?></td>
                            <td><?= ($lid['podia']) ? '<i class="fa fa-fw fa-check">' : '<i class="fa fa-fw fa-close">' ?></td>
                            <td><a href="index.php?map=leden&page=show&id=<?= $lid['id'] ?>"><i
                                        class="fa fa-fw fa-search"></i></a></td>
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
