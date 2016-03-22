<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Application {

	function _construct(){
		parent::_construct();
		//$this->load->model()
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->helper('directory');
		$this->data['pagebody'] = 'homepage';
		/*
		$candidates = directory_map(DATAPATH);
		sort($candidates);
		foreach($candidates as $file){
			if(substr_compare($file, XMLSUFFIX, strlen($file) - strlen(XMLSUFFIX), strlen(XMLSUFFIX)) === 0){
				$bookings[] = array('filename' => substr($file, 0, -4));
			}
		}
		*/

		$facets = array(
			array('facet' => 'day'),
			array('facet' => 'timeslot'),
			array('facet' => 'course')
		);
		/*
		$facets[] = array('day','timeslot','course');
		foreach($facets as $facet){
			$facetChoices[] = array('facet'=>$facet);
		}
		*/
		$timetable = new Timetable();
		$days = $timetable->getChoiceDay();
		$times = $timetable->getChoiceTime();

		$this->data['days'] = $days;
		$this->data['times'] = $times;
		$this->data['facets'] = $facets;
		$this->render();
	}

	public function showTimetable($facet){
		$this->data['pagebody'] = 'timetable';
		$timetable = new Timetable();
		switch($facet){
			case 'day':
				foreach($timetable->getDays() as $record){
					$bookings[] = array(
						'timeslot' => $record->clock,
						'course' => $record->course,
						'day' => $record->day,
						'instructor' => $record->instructor,
						'room' => $record->room
					);
				}
				break;
			case 'timeslot':
				foreach($timetable->getTimes() as $record){
					$bookings[] = array(
						'timeslot' => $record->clock,
						'course' => $record->course,
						'day' => $record->day,
						'instructor' => $record->instructor,
						'room' => $record->room
					);
				}
				break;
			case 'course':
				foreach($timetable->getCourses() as $record){
					$bookings[] = array(
						'timeslot' => $record->clock,
						'course' => $record->course,
						'day' => $record->day,
						'instructor' => $record->instructor,
						'room' => $record->room
					);
				}
				break;
			default:

		}
		$this->data['bookings'] = $bookings;
		$this->render();
	}
}
