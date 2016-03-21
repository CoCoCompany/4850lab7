<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Timetable extends CI_Model {
    
    protected $xml = null;
    protected $timefacet = array();
    protected $dayfacet = array();
    protected $coursefacet = array();
    
    public function __construct() {
        parent::__construct();
        $this->xml = simplexml_load_file(DATAPATH, 'master.xml');
        
        
    }
    
    function getTimefacet(){
        
    }
    function getDayfacet(){
        
    }
    function getCoursefacet(){
        
    }
    
}