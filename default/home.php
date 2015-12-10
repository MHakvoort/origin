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

<div class="page-header">
    <h3>
        <i class="fa fa-fw fa-dashboard"></i> Dashboard
    </h3>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                Content
            </div>
        </div>
    </div>
</div>

</div>
<!-- /.container -->
