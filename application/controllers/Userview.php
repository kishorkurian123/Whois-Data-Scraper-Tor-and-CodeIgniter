
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userview extends CI_Controller
{


    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Frontfunc');
    }

    public function index()
    {
        $data = $this->Frontfunc->homestats();
        $this->load->view('home',$data);

    }

    public function addlist()
    {
        //Process Postdata
        if( count($this->input->post()) > 0 ){
            $data['success'] = $this->Frontfunc->addlist();
        }
        else{
            $data="";
        }
        //Render the form
        $this->load->view('addlist',$data);

    }
    public function export()
    {
        $data=$this->Frontfunc->export();
        $this->load->view('export',$data);
    }

}

