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
    protected $days = array('Monday', 'Tuesday', 'Wednesday');
    protected $times = array('8:30-9:30', '9:30-10:30');
    
    public function __construct() {
        parent::__construct();
        $this->xml = simplexml_load_file(DATAPATH . 'master.xml');

        foreach ($this->xml->dayfacet->day as $stuff) {
            $record = new Booking($stuff);
            $record->setDay($stuff['day']);
            $this->dayfacet[] = $record;
        }
        foreach ($this->xml->timefacet->timeslot as $stuff) {
            $record = new Booking($stuff);
            $record->setClock($stuff['clock']);
            $this->timefacet[] = $record;
        }
        foreach ($this->xml->coursefacet->course as $stuff) {
            $record = new Booking($stuff);
            $record->setCourse($stuff['course']);
            $this->coursefacet[] = $record;
        }
    }
    public function getChoiceDay(){
        return $this->days;
    }
    public function getChoiceTime(){
        return $this->times;
    }
    public function getDays() {
        return $this->dayfacet;
    }
    public function getTimes() {
        return $this->timefacet;
    }
    public function getCourses() {
        return $this->coursefacet;
    }
    

}

class Booking extends CI_Model {

    protected $day;
    protected $clock;
    protected $course;
    protected $instructor;
    protected $room;

    public function __construct($stuff) {
        parent::__construct();
        $this->clock = '';
        $this->course = '';
        $this->day = '';
        $this->instructor = (string) $stuff->booking['instructor'];
        $this->room = (string) $stuff->booking['room'];
     
    }
    
    public function setCourse($in){
        $this->course = $in;
    }
    public function setClock($in){
        $this->clock = $in;
    }
    public function setDay($in){
        $this->day = $in;
    }
}
