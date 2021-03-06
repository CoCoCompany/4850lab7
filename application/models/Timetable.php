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
  protected $days = array(array('day'=>'Monday'), array('day'=>'Tuesday'), array('day'=>'Wednesday'), array('day'=>'Thursday'), array('day'=>'Friday'));
  protected $times = array(array('time'=>'8:30-9:30'),array('time'=>'9:30-10:30'),
  array('time'=>'10:30-11:30'),array('time'=>'11:30-12:30'),
  array('time'=>'1:30-2:30'),array('time'=>'2:30-3:30')
  ,array('time'=>'3:30-4:30'),array('time'=>'4:30-5:30'));

  public function __construct() {
    parent::__construct();
    $this->xml = simplexml_load_file(DATAPATH . 'master.xml');

    foreach ($this->xml->dayfacet->day as $stuff) {

      foreach ($stuff->booking as $bookingslot){
        $record = new Booking($bookingslot);
        $record->setCourse($bookingslot['course']);
        $record->setClock($bookingslot['clock']);
        $record->setDay($stuff['day']);
        $this->dayfacet[] = $record;
      }
    }
    foreach ($this->xml->timefacet->timeslot as $stuff) {

      foreach ($stuff->booking as $bookingslot){
        $record = new Booking($bookingslot);
        $record->setCourse($bookingslot['course']);
        $record->setClock($stuff['clock']);
        $record->setDay($bookingslot['day']);
        $this->timefacet[] = $record;
      }
    }

    foreach ($this->xml->coursefacet->course as $stuff) {

      //print_r($stuff);
      foreach ($stuff->booking as $bookingslot){
        $record = new Booking($bookingslot);
        $record->setCourse($stuff['course']);
        $record->setClock($bookingslot['clock']);
        $record->setDay($bookingslot['day']);
        $this->coursefacet[] = $record;
      }
    }
    //print_r($this->coursefacet);
  }

  public function searchByDays($day, $time){
    $result = array();
    foreach ($this->dayfacet as $obj){
      if($obj->getDay() == $day && $obj->getClock() == $time){
        $result[] = $obj;
      }
    }
    return $result;
  }
  public function searchbyTimes($day, $time){
    $result = array();
    foreach ($this->timefacet as $obj){
      if($obj->getDay() == $day && $obj->getClock() == $time){
        $result[] = $obj;
      }
    }
    return $result;
  }
  public function searchByCourses($day, $time){
    $result = array();
    foreach ($this->coursefacet as $obj){
      if($obj->getDay() == $day && $obj->getClock() == $time){
        $result[] = $obj;
      }
    }
    return $result;
  }






  //accessor
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
    $this->instructor = (string) $stuff['instructor'];
    $this->room = (string) $stuff['room'];

  }

  public function setCourse($in){
    $this->course = (string) $in;
  }
  public function setClock($in){
    $this->clock = (string) $in;
  }
  public function setDay($in){
    $this->day = (string) $in;
  }
  public function getCourse(){
    return $this->course;
  }
  public function getDay(){
    return $this->day;
  }
  public function getClock(){
    return $this->clock;
  }
  public function getInstructor(){
    return $this->instructor;
  }
  public function getRoom(){
    return $this->room;
  }
}
