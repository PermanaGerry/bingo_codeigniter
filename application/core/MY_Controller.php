<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');

    class MY_Controller extends CI_Controller
    {
        
        public function __construct()
        {
            parent::__construct();
            // load helper
            $this->load->helper('url');
            // load model
            $this->load->model('dbTable','person');
        }
    }
