<?php
$this->load->view('header');


if ($com<1) {
    $com = <<<DOM
<h3>No COM sites left to export</h3>
DOM;
} else {
    $com = <<<DOM
<h3 class="sub-header">Export .com sites</h3>
<form action="" method="post" accept-charset="utf-8">
<input type="hidden" name="type" value="com">
<button type="submit" value="submit">Export COM sites</button>
</form>
DOM;
}
if ($sg<1) {
    $sg = <<<DOM
<h3>No SG sites left to export</h3>
DOM;
}
else {
    $sg = <<<DOM
<h3 class="sub-header">Export .SG sites</h3>
<form action="" method="post" accept-charset="utf-8">
<input type="hidden" name="type" value="sg">
<button type="submit" value="submit">Export SG sites</button>
</form>
DOM;
}

if ($my<1) {
    $my = <<<DOM
<h3>No MY sites to export</h3>
DOM;
} else {
    $my = <<<DOM
<h3 class="sub-header">Export .MY sites</h3>
<form action="" method="post" accept-charset="utf-8">
<input type="hidden" name="type" value="my">
<button type="submit" value="submit">Export MY sites</button>
</form>
DOM;

}
?>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Export</h1>

<?php echo $com; ?>
<?php echo $sg; ?>
<?php echo $my; ?>