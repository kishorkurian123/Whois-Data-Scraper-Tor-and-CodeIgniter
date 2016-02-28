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
        }
        else{
            //already running
            $state = FALSE;
        }

        if($state==TRUE){
            //Fetch sites
            $query = "SELECT site FROM `sites` WHERE status=0 LIMIT 2500";
            $result = $this->db->query($query);

            //grab a row, detect the extension, and call the function
            while ($site= $result->unbuffered_row()){
                $site = $site->site;

                //write it to the lastsite
                $file = fopen("tmp/lastsite.txt","w+");
                fwrite($file,$site);
                fclose($file);
                //load model
                $this->load->model('Backend');
                //check the extension
                if(strpos($site,".my")!==FALSE){
                    $this->Backend->fetchmy($site);
                }
                elseif(strpos($site,".sg")!==FALSE){
                    $this->Backend->fetchsg($site);
                }
                elseif(strpos($site,".com")!==FALSE){
                    $this->Backend->fetchcommon($site);
                }
                else {
                    $this->Backend->markasdone($site);
                }
            }

        }
    }
    public function rotatetor($tor_ip = '127.0.0.1', $control_port = '9051', $auth_code = '"crackit"')
    {
        //write it to the status file
        $file = fopen("tmp/status.txt","w+");
        fwrite($file,"Rotating Tor IP");
        fclose($file);

        $fp = fsockopen($tor_ip, $control_port, $errno, $errstr, 30);
        if (!$fp) return false; //can't connect to the control port

        fputs($fp, "AUTHENTICATE $auth_code\r\n");
        $response = fread($fp, 1024);
        list($code, $text) = explode(' ', $response, 2);
        if ($code != '250') return false; //authentication failed

        //send the request to for new identity
        fputs($fp, "signal NEWNYM\r\n");
        $response = fread($fp, 1024);
        list($code, $text) = explode(' ', $response, 2);
        if ($code != '250') echo "FALSE";//return false; //signal failed
        fclose($fp);
        return true;

    }
}
