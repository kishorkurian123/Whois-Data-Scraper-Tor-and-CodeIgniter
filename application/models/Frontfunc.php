<?php

class Frontfunc extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }
    public function homestats(){

        //Pending Count
        $query = "SELECT COUNT(id) as COUNT FROM sites WHERE status=0";
        $result = $this->db->query($query);
        $result= $result->first_row();
        $data['pending'] = $result->COUNT;

        //Total Sites in DB
        //Pending Count
        $query = "SELECT COUNT(id) as COUNT FROM sites";
        $result = $this->db->query($query);
        $result= $result->first_row();
        $data['total'] = $result->COUNT;

        //Last done 10 common sites
        $query = "SELECT * FROM data ORDER BY id DESC LIMIT 10";
        $result = $this->db->query($query);
        $data['common'] = $result->result_array();

        //Last done 10 sg sites
        $query = "SELECT * FROM sgdata ORDER BY id DESC LIMIT 10";
        $result = $this->db->query($query);
        $data['sg'] = $result->result_array();

        //Last done 10 my sites
        $query = "SELECT * FROM mydata ORDER BY id DESC LIMIT 10";
        $result = $this->db->query($query);
        $data['my'] = $result->result_array();


        //Check Script Status
        //Try to lock the file. If it gets locked, Script is idle,
        // if its already locked, script is running
        $file = fopen("tmp/lock.txt","w+");
        if (flock($file, LOCK_EX | LOCK_NB))
        {
            $data['status'] = "Idle";
        }
        else
        {
            $data['status'] = "Running";
        }

        // Return 4 datas - pending, total, resultarray and status.
        return $data;


    }
    private function is_valid($domain_name)
    {
        return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name) //valid chars check
            && preg_match("/^.{1,253}$/", $domain_name) //overall length check
            && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name)   ); //length of each label
    }
    public function addlist()
    {
        $lines = array_filter(array_map('trim',explode("\n",(strtolower($this->input->post('sites'))))));

        //Get the row count before and after, and return no. of sites added
        $start =$this->db->count_all('sites');

        foreach ($lines as $site) {
            //add http to all lines if not present.
            if (strpos($site, "http://") === FALSE AND strpos($site, "https://") === FALSE) {
                $site = "http://" . $site;
            }
            //Remove WWW or www
            $site = str_ireplace("WWW.", "", $site);

            //If site is valid, add to db.
            if (filter_var($site, FILTER_VALIDATE_URL)) {
                //site is valid. Add it to database
                $status = $this->db->query("INSERT INTO `sites` (site) VALUES ('$site') ON DUPLICATE KEY UPDATE id=id ");
            }
        }
            //get final count
            $final = $this->db->count_all('sites');
            $success = $final-$start;
            return $success;
    }

    private function exporthelper($table){

        //Do the exporting
        $file = fopen("tmp/export.csv", "w");
        $query = "SELECT * FROM  `$table` WHERE export=0";
        $result = $this->db->query($query);
        $row = $result->unbuffered_row('array');

        //prepare the titles
        $title = array();
        $firstrow = array();
        foreach ($row as $key => $value) {
            $title[] = $key;
            $firstrow[] = $value;
        }
        //Write heading titles to the csv
        fputcsv($file, $title);
        fputcsv($file, $firstrow);
        while ($row = $result->unbuffered_row('array')) {
            $buffer = array();
            foreach ($row as $items) {
                $buffer[] = $items;
            }
            fputcsv($file, $buffer);
        }
        fclose($file);

        //update everything's status to 1.

        $query = "UPDATE `$table` SET export = 1 WHERE export=0";
        $result = $this->db->query($query);
        header("Location: tmp/export.csv");

    }
    public function export(){
        //check if there is pending to export
        //check count
        $query = "SELECT COUNT(id) as COUNT FROM data WHERE export=0";
        $result = $this->db->query($query);
        $result= $result->first_row();
        $com = $result->COUNT;
        $data['com'] = $com;

        $query = "SELECT COUNT(id) as COUNT FROM mydata WHERE export=0";
        $result = $this->db->query($query);
        $result= $result->first_row();
        $my = $result->COUNT;
        $data['my'] = $my;

        $query = "SELECT COUNT(id) as COUNT FROM sgdata WHERE export=0";
        $result = $this->db->query($query);
        $result= $result->first_row();
        $sg = $result->COUNT;
        $data['sg'] = $sg;


        //check if post.
        if( count($this->input->post()) > 0 ){

          switch ($this->input->post('type')) {
              case "my":
                  $this->exporthelper("mydata");
                  break;
              case "sg":
                  $this->exporthelper("sgdata");
                  break;
              case "com":
                  $this->exporthelper("data");
                  break;
              default:
                  break;
          }


        }
        else{
            return $data;
        }

        }


}


