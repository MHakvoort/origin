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
    header("Location: index.php?map=events&page=index");
    exit();
}


$id = $_GET['id'];
$events = new Events();
$event = $events->get($id);
if (!$event) {
    header('HTTP/1.0 302 Found');
    header("Location: index.php?map=events&page=index");
    exit();
}

$events->delete($event['events_id']);

?>
<script>
    $.notify("Evenement is succesvol verwijderd!", "success");
</script>
<?php

header('HTTP/1.0 302 Found');
header("Location: index.php?map=events&page=index");
exit();

?>
