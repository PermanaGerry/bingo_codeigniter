<?php 
    
    defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * class bingo
    */
    class Bingo extends CI_Controller
    {
      
      public function __construct()
      {
          parent::__construct();
          $this->load->helper(array(
            'form','url'
          ));
      }

      public function randomAngka()
      {
        /**
         * create range 1 - 25 of array
         */
        $range = range(1, 25);

        // call shuffle untuk menjadikan random array
        shuffle($range);

        /**
         * Bagi Bingo seiap 5 offset
         * untuk di tampilkan sebagai variable
         */
        $bingo['bingo'] = [];
        for ($i = 0; 5 > $i;$i++) {
          $bingo['bingo'][] = array_slice($range, $i*5, 5);
        }

        return $bingo;
      }

      public function index()
      { 
        $bingo = $this->randomAngka();
        $this->load->view('Bingo',$bingo);
      }

    }

 ?> 