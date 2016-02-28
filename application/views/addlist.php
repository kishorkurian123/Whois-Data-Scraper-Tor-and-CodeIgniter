<?php
$this->load->view('header');
?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Add List</h1>
    <?php
    //output submission no. if successful
    if(isset($success)) {
        echo "<h4>".$success." sites added to the database.</h4>";
    }
    ?>

    <?php
    echo form_open();
    echo form_textarea(array('rows'=>15,'cols'=>100,'name'=>'sites','value'=> 'Paste your site list here.. One site per line..'));
    ?>
        <br><br>

    <?php echo form_submit('submit', 'Submit'); ?>
    <?php echo form_close('</div>'); ?>

