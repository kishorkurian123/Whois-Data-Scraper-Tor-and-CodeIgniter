<?php

class Backend extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
        global $html;
    }

    private function getdata($search)
    {
        global $html;
        $data = explode($search, $html);
        $data = explode("\n", $data[1]);
        $data = trim($data[0]);
        return ($data);

    }

    private function getrepeateddata($search)
    {
        global $html;
        $status = array();
        $data = explode($search, $html);
        unset($data[0]);
        array_values($data);
        for ($i = 1; $i < sizeof($data); $i++) {
            $status[] = $data[$i];
        }

        $data = explode("\n", $data[sizeof($data)]);
        $status[] = $data[0];
        $status = implode(" ", $status);
        return $status;

    }

    private function rotatetor($tor_ip = '127.0.0.1', $control_port = '9051', $auth_code = '"crackit"')
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
        if ($code != '250') return false; //signal failed
        fclose($fp);
        return true;

    }

    public function markasdone($site)
    {
        //write it to the status file
        $file = fopen("tmp/status.txt","w+");
        fwrite($file,"Marking $site as done");
        fclose($file);
        if(strpos($site,"http://")===FALSE) {
            $site = "http://" . $site;
        }
        $query = "UPDATE `sites` SET status=1 WHERE site='$site'";
        $this->db->query($query);

    }

    public function fetchcommon($site)
    {
        $file = fopen("tmp/status.txt","w+");
        fwrite($file,"Fetching Common Extension data - $site");
        fclose($file);
        global $html;
        $site = str_replace("http://", "", $site);
        $html = shell_exec("timeout 10 proxychains whois -H $site");

        //check if invalid extenion
        if (strpos($html,"No whois server is known for this kind of object.")!==FALSE){
            $this->markasdone($site);
            return false;
        }
        //check if domain available - check for no match in the result
        if (strpos($html, "No match") != FALSE) {
            //Domain is available. So mark domain as done.
            $this->markasdone($site);
            return false;
        }
        //explode to data start
        $html = explode("The Registry database contains ONLY .COM, .NET, .EDU domains and
Registrars.\n", $html);
        $html = $html[1];

        //do parsing and get back the sql query
        $sqlquery = $this->fetchcommonparser($site);
        //grab the final query with all details
        $query = $this->db->query("$sqlquery");
        if ($query) {
            $this->markasdone($site);
        }

    }

    private function fetchcommonparser($site)
    {
        //write it to the status file
        $file = fopen("tmp/status.txt","w+");
        fwrite($file,"Parsing Common Extension data - $site");
        fclose($file);
        $registarydomainid = $this->getdata('Registry Domain ID: ');
        if (strpos($site, ".net") !== FALSE) {
            $whoisserver = $this->getdata("Registrar WHOIS server: ");
        } else {
            $whoisserver = $this->getdata("Registrar WHOIS Server: ");
        }
        $registarurl = $this->getdata("Registrar URL: ");

        if (strlen($registarurl) < 2) {
            //retry
            $return = $this->rotatetor();
            $this->fetchcommon($site);
        }


        $updateddate = $this->getdata("Updated Date: ");
        $creationdata = $this->getdata("Creation Date: ");
        $expirationdata = $this->getdata("Registrar Registration Expiration Date: ");
        $registar_name = $this->getdata("Registrar: ");
        $registarIANAID = $this->getdata("Registrar IANA ID: ");
        $abuseemail = $this->getdata("Registrar Abuse Contact Email: ");
        $abusephone = $this->getdata("Registrar Abuse Contact Phone: ");
        $registrantid = $this->getdata("Registry Registrant ID: ");
        $registrantname = $this->getdata("Registrant Name: ");
        $registrantorg = $this->getdata("Registrant Organization: ");
        $registrantstreet = $this->getdata("Registrant Street: ");
        $registrantcity = $this->getdata("Registrant City: ");
        $registrantstate = $this->getdata("Registrant State/Province: ");
        $registrantpostal = $this->getdata("Registrant Postal Code: ");
        $registrantcountry = $this->getdata("Registrant Country: ");
        $registrantphone = $this->getdata("Registrant Phone: ");
        $registrantphoneext = $this->getdata("Registrant Phone Ext: ");
        $registrantfax = $this->getdata("Registrant Fax: ");
        $registrantfaxext = $this->getdata("Registrant Fax Ext: ");
        $registrantemail = $this->getdata("Registrant Email: ");
        $registryadminid = $this->getdata("Registry Admin ID: ");
        $adminname = $this->getdata("Admin Name: ");
        $adminorganization = $this->getdata("Admin Organization: ");
        $adminstreet = $this->getdata("Admin Street: ");
        $admincity = $this->getdata("Admin City: ");
        $adminstate = $this->getdata("Admin State/Province: ");
        $adminpostalcode = $this->getdata("Admin Postal Code: ");
        $admincountry = $this->getdata("Admin Country: ");
        $adminphone = $this->getdata("Admin Phone: ");
        $adminphoneext = $this->getdata("Admin Phone Ext: ");
        $adminfax = $this->getdata("Admin Fax: ");
        $adminfaxext = $this->getdata("Admin Fax Ext: ");
        $adminemail = $this->getdata("Admin Email: ");
        $registrarytechid = $this->getdata("Registry Tech ID: ");
        $techname = $this->getdata("Tech Name: ");
        $techorganization = $this->getdata("Tech Organization: ");
        $techstreet = $this->getdata("Tech Street: ");
        $techcity = $this->getdata("Tech City: ");
        $techstate = $this->getdata("Tech State/Province: ");
        $techpostal = $this->getdata("Tech Postal Code: ");
        $techcountry = $this->getdata("Tech Country: ");
        $techphone = $this->getdata("Tech Phone: ");
        $techphoneext = $this->getdata("Tech Phone Ext: ");
        $techfax = $this->getdata("Tech Fax: ");
        $techfaxext = $this->getdata("Tech Fax Ext: ");
        $techemail = $this->getdata("Tech Email: ");
        $dnssec = $this->getdata("DNSSEC: ");
        $domainstatus = $this->getrepeateddata('Domain Status: ');


        //get nameservers
        $nameservers = $this->getrepeateddata("Name Server: ");
        // prepare the query
        $query = "INSERT INTO `data` (site,registar_name,whoisserver,domainstatus,nameservers,registarydomainid,registarurl,updateddate,creationdata,expirationdata,registarIANAID,abuseemail,abusephone,registrantid,registrantname,registrantorg,registrantstreet,registrantcity,registrantstate,registrantpostal,registrantcountry,registrantphone,registrantphoneext,registrantfax,registrantfaxext,registrantemail,registryadminid,adminname,adminorganization,adminstreet,admincity,adminstate,adminpostalcode,admincountry,adminphone,adminphoneext,adminfax,adminfaxext,adminemail,registrarytechid,techname,techorganization,techstreet,techcity,techstate,techpostal,techcountry,techphone,techphoneext,techfax,techfaxext,techemail,dnssec) VALUES('$site','$registar_name','$whoisserver','$domainstatus','$nameservers','$registarydomainid','$registarurl','$updateddate','$creationdata','$expirationdata','$registarIANAID','$abuseemail','$abusephone','$registrantid','$registrantname','$registrantorg','$registrantstreet','$registrantcity','$registrantstate','$registrantpostal','$registrantcountry','$registrantphone','$registrantphoneext','$registrantfax','$registrantfaxext','$registrantemail','$registryadminid','$adminname','$adminorganization','$adminstreet','$admincity','$adminstate','$adminpostalcode','$admincountry','$adminphone','$adminphoneext','$adminfax','$adminfaxext','$adminemail','$registrarytechid','$techname','$techorganization','$techstreet','$techcity','$techstate','$techpostal','$techcountry','$techphone','$techphoneext','$techfax','$techfaxext','$techemail','$dnssec') ON DUPLICATE KEY UPDATE id=id";
        //return the sql query
        return $query;
    }

    public function fetchsg($site)
    {
        //Write to status file
        $file = fopen("tmp/status.txt","w+");
        fwrite($file,"Fetching SG Extension data - $site");
        fclose($file);
        global $html;
        $site = str_replace("http://", "", $site);
        $html = shell_exec("timeout 10 proxychains whois -H $site");

        //check if invalid extenion
        if (strpos($html,"No whois server is known for this kind of object.")!==FALSE){
            $this->markasdone($site);
            return false;
        }
        //check if domain available
        if (strpos($html, "Domain Not Found") !== FALSE) {
            $this->markasdone($site);
            return false;
        } elseif (strpos($html, "Service is not available.") !== FALSE) {
            //blocked. Rotate IP and retry
            $this->rotatetor();
            $this->fetchsg($site);
        } else {
            $sqlquery = $this->fetchsgparser($html, $site);
            //run query and update status
            $result = $this->db->query($sqlquery);
            if ($result) {
                $this->markasdone($site);
            }
        }

    }

    public function fetchsgparser($html, $site)
    {
        //Write to status file
        $file = fopen("tmp/status.txt","w+");
        fwrite($file,"Parsing SG Extension data - $site");
        fclose($file);
        // Splitoff the header
        global $html;
        $html = explode("The following data is provided for information purposes only.", $html);
        $html = $html[1];
        $registar = $this->getdata("Registrar:   ");
        $creationdate = $this->getdata("Creation Date:");
        $modifieddate = $this->getdata("Modified Date:");
        $expirydate = $this->getdata("Expiration Date:");
        $domainstatus = $this->getrepeateddata("Domain Status:");

        //change $html - cutoff headpart - Registrant
        $html = explode("Registrant:", $html);
        $html = $html[1];

        $registrantname = $this->getdata("Name:");

        //change $html - cutoff headpart - Administrative
        $html = explode("Administrative Contact:", $html);
        $html = $html[1];
        $adminname = $this->getdata("Name:");

        //Change $html - cutoff headpart - Technical
        $html = explode("Technical Contact:", "$html");
        $html = $html[1];

        $technicalname = $this->getdata("Name:");
        $technicalemail = $this->getdata("Email:");

        //Cutoff to get the nameservers
        $html = explode("Name Servers:", $html);
        $nameservers = trim($html[1]);

        //make sqlquery
        $site = "http://" . $site;
        $sqlquery = "INSERT INTO `sgdata` (site,creation,modification,expiration,domainstatus,registrantname,adminname,techname,techemail,nameservers) VALUES ('$site','$creationdate','$modifieddate','$expirydate','$domainstatus','$registrantname','$adminname','$technicalname','$technicalemail','$nameservers') ON DUPLICATE KEY UPDATE id=id";
        return $sqlquery;
    }

    public function fetchmy($site)
    {
        //Write to status file
        $file = fopen("tmp/status.txt","w+");
        fwrite($file,"Fetching MY Extension data - $site");
        fclose($file);
        $site1 = str_replace("http://", "", $site);
        $site1 = str_replace("www.", "", $site1);
        $siteparts = explode(".", $site1);
        $domain = $siteparts[0];
        unset($siteparts[0]);
        $ext = implode('.', $siteparts);
        $url = "http://whois.mynic.my/index.jsp?type=domain&searchtxt=$domain&ext=.$ext";

        //call dom parser
        $this->load->helper("Domparser");
        $html = file_get_html($url);

        //check if exists in whois site, else mark as done already
        if(strpos($html, "does not exist in database")!==FALSE){
            $this->markasdone($site);
            return false;
        }
        //Table
        $table = $html->find('table', 5);
        $rowData = array();

        foreach ($table->find('tr') as $row) {
            // initialize array to store the cell data from each row
            $flight = array();
            foreach ($row->find('td') as $cell) {
                // push the cell's text to the array
                $flight[] = $cell->plaintext;
            }

            $rowdata[] = $flight;
        }

        //set variables
        $regno = $rowdata[1][2];
        $created = $rowdata[2][2];
        $expired = $rowdata[3][2];
        $modified = $rowdata[4][2];

        //set arrays if existing
        foreach ($rowdata as $row) {
            //Registrant
            if (strpos($row[1],"Registrant Code")!==FALSE)
                $registrant = $row;
            //Administrative
            if (strpos($row[1],"Administrative Contact Code")!==FALSE)
                $admin = $row;
            //Billing
            if (strpos($row[1],"Billing Contact Code")!==FALSE)
                $billing = $row;
            //technical
            if (strpos($row[1],"Technical Contact Code")!==FALSE)
                $tech = $row;
        }
        // For sites with admin/reg code together, reset new value to registrant and admin
        foreach ($rowdata as $row){
            if(strpos($row[1],"Registrant/Administrative Code")){
                $flag = 1;
                $registrant = $row;
                $admin = $row;
            }
        }

        //Registrant
        $registrant = explode("\n", $registrant[1]);
        if ($flag==1){
            $registrantcode = str_replace("[&nbsp;Registrant/Administrative Code:&nbsp;","",$admin[0]);
        }
        else {
            $registrantcode = str_replace("[&nbsp;Administrative Contact Code:&nbsp;", "", $admin[0]);
        }
        $registrantcode = trim(str_replace("&nbsp;]", "", $registrantcode));

        $registrantcol1 = trim($registrant[1]);
        $registrantcol2 = trim($registrant[2]);

        $registrantdata = $this->fetchmyparser($registrant);
        $registrantdata = explode("~~", $registrantdata);
        $registranttel = $registrantdata[0];
        $registrantfax = $registrantdata[1];
        $registrantemail = $registrantdata[2];
        $registrantcol3 = $registrantdata[3];

        if(strpos($registrantcol2,"@")!==FALSE){
            $registrantemail=$registrantcol2;
            $registrantcol2 ="";
        }


        //Admin
        $admin = explode("\n",$admin[1]);
        if ($flag==1){
            $admincode = str_replace("[&nbsp;Registrant/Administrative Code:&nbsp;","",$admin[0]);
        }
        else {
            $admincode = str_replace("[&nbsp;Administrative Contact Code:&nbsp;", "", $admin[0]);
        }
        $admincode = trim(str_replace("&nbsp;]","",$admincode));
        $admincol1 = trim($admin[1]);
        $admincol2 = trim($admin[2]);
        $admindata = $this->fetchmyparser($admin);
        $admindata = explode("~~", $admindata);
        $admintel = $admindata[0];
        $adminfax = $admindata[1];
        $adminemail = $admindata[2];
        $admincol3 = $admindata[3];

        if(strpos($admincol2,"@")!==FALSE){
            $adminemail=$admincol2;
            $admincol2 ="";
        }


        //Billing
        $billing = explode("\n",$billing[1]);

        $billingcode = str_replace("[&nbsp;Billing Contact Code:&nbsp;","",$billing[0]);
        $billingcode = trim(str_replace("&nbsp;]","",$billingcode));

        $billingcol1 = trim($billing[1]);
        $billingcol2 = trim($billing[2]);
        $billingdata = $this->fetchmyparser($billing);
        $billingdata = explode("~~", $billingdata);
        $billingtel = $billingdata[0];
        $billingfax = $billingdata[1];
        $billingemail = $billingdata[2];
        $billingcol3 = $billingdata[3];

        if(strpos($billingcol2,"@")!==FALSE){
            $billingemail=$billingcol2;
            $billingcol2 ="";
        }

        //Tech
        $tech = explode("\n",$tech[1]);
        $techcode = str_replace("[&nbsp;Technical Contact Code:&nbsp;","",$tech[0]);
        $techcode = trim(str_replace("&nbsp;]","",$techcode));
        $techcol1 = trim($tech[1]);
        $techcol2 = trim($tech[2]);
        $techdata = $this->fetchmyparser($tech);
        $techdata = explode("~~", $techdata);
        $techtel = $techdata[0];
        $techfax = $techdata[1];
        $techemail = $techdata[2];
        $techcol3 = $techdata[3];

        if(strpos($techcol2,"@")!==FALSE){
            $techemail=$techcol2;
            $techcol2 ="";
        }

        //SQL QUERY
        $query = "INSERT INTO `mydata`(site,regno,created,expired,modified,admincode,admincol1,admincol2,admintel,adminfax,adminemail,admincol3,billingcode,billingcol1,billingcol2,billingtel,billingfax,billingemail,billingcol3,techcode,techcol1,techcol2,techtel,techfax,techemail,techcol3,registrantcode,registrantcol1,registrantcol2,registranttel,registrantfax,registrantemail,registrantcol3) VALUES('$site','$regno','$created','$expired','$modified','$admincode','$admincol1','$admincol2','$admintel','$adminfax','$adminemail','$admincol3','$billingcode','$billingcol1','$billingcol2','$billingtel','$billingfax','$billingemail','$billingcol3','$techcode','$techcol1','$techcol2','$techtel','$techfax','$techemail','$techcol3','$registrantcode','$registrantcol1','$registrantcol2','$registranttel','$registrantfax','$registrantemail','$registrantcol3')";
        $result = $this->db->query($query);

        if($result){
            $this->markasdone($site);
        }


    }

    private function fetchmyparser($data)
        {
            //Write to status file
            $file = fopen("tmp/status.txt","w+");
            fwrite($file,"Parsing MY Extension data");
            fclose($file);
            $col3 = "";
            $email = "";
            $tel = "";
            $fax = "";
            for ($i = 3; $i < sizeof($data) - 1; $i++) {

                if (strpos($data[$i], "(Tel)") !== FALSE) {
                    $tel = trim($data[$i]);
                    if (strpos($tel, "(Tel)  -") !== FALSE) {
                        $tel = "";
                    } else {
                        $tel = str_replace("(Tel)  ", "", $tel);
                    }
                } elseif (strpos($data[$i], "(Fax)") !== FALSE) {
                    $fax = trim($data[$i]);
                    if (strpos($fax, "(Fax)  -") !== FALSE) {
                        $fax = "";
                    } else {
                        $fax = str_replace("(Fax)  ", "", $fax);
                    }
                } elseif (strpos($data[$i], "@") !== FALSE) {
                    $email = trim($data[$i]);

                } else {
                    $col3 .= " " . trim($data[$i]);
                }
            }

            return $tel . "~~" . $fax . "~~" . $email . "~~" . $col3;
        }

}