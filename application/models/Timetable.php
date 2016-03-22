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
        $this->xml = simplexml_load_file(DATAPATH . 'master.xml');

  		foreach ($this->xml->dayfacet->day->booking as $booking){
  			$record = new stdClass();
  			$record->clock = (string) $booking->clock;
  			$record->course = (string) $booking->course['course'];
  			$record->instructor = (string) $booking->instructor;
  			$record->room = (string) $booking->room;
  			$record->day = (string) $this->xml->dayfacet->day['day'];
  			$this->dayfacet[] = $record;
  		}
  		
  		foreach ($this->xml->timefacet->timeslot->booking as $booking){
  			$record = new stdClass();
  			$record->course = (string) $booking->course['course'];
  			$record->day = (string) $booking->day['day'];
  			$record->instructor = (string) $booking->instructor;
  			$record->room = (string) $booking->room;
  			$record->clock = (string) $this->xml->timefacet->timeslot->clock;
  			$this->timefacet[] = $record;
  			$counter ++;
  		}
  		
  		foreach ($this->xml->coursefacet->course->booking as $booking){
  			$record = new stdClass();
  			$record->clock = (string) $booking->clock;
  			$record->day = (string) $booking->day['day'];
  			$record->instructor = (string) $booking->instructor;
  			$record->room = (string) $booking->room;
  			$record->course = (string) $this->xml->coursefacet->course['course'];
  			$this->coursefacet[] = $record;
  			$counter ++;
  		}
    }


}
