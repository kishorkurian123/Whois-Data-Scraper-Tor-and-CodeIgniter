<?php

class Worker extends CI_Controller{

    public function index(){
        // this function should start the scrapper,manage the list and
        // call the respective functions based on the domain extension.
        //Run uninterupted.
        ignore_user_abort(true);
        set_time_limit(0);

        //check if already running
        $file = fopen("tmp/lock.txt","w+");
        // exclusive lock
        if (flock($file, LOCK_EX | LOCK_NB)) {
            // Grab lock. Continue work.
            $state = TRUE;
            echo "Started Running";
            //do the work
            //Fetch sites
            $query = "SELECT site FROM `sites` WHERE status=0 LIMIT 2500";
            $result = $this->db->query($query);

            //grab a row, detect the extension, and call the function
            while ($site = $result->unbuffered_row()) {
                $site = $site->site;

                //write it to the lastsite
                $file = fopen("tmp/lastsite.txt", "w+");
                fwrite($file, $site);
                fclose($file);
                //load model
                $this->load->model('Backend');
                //check the extension
                if (strpos($site, ".my") !== FALSE) {
                    $this->Backend->fetchmy($site);
                } elseif (strpos($site, ".sg") !== FALSE) {
                    $this->Backend->fetchsg($site);
                } elseif (strpos($site, ".com") !== FALSE) {
                    $this->Backend->fetchcommon($site);
                } else {
                    $this->Backend->markasdone($site);
                }
            }
        }

        else{
            //already running
            $state = FALSE;
            echo "Already Running";
            exit;
        }

    }
}
