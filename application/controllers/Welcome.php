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

	public function search(){
		$this->data['pagebody'] = 'search_result';
		$timetable = new Timetable();
		$day = $this->input->post('daySelect');
		$timeslot = $this->input->post('timeSelect');
		$daysSearchResult = $timetable->searchByDays($day,$timeslot);
		$timesSearchResult = $timetable->searchByTimes($day,$timeslot);
		$coursesSearchResult = $timetable->searchByCourses($day,$timeslot);
		if(count($daysSearchResult) == 1 && count($timesSearchResult) == 1 && count($coursesSearchResult) == 1) &&
			$daysSearchResult[0] === $timesSearchResult[0] && $timesSearchResult[0] == $coursesSearchResult[0]){
			$this->data['message'] = "Bingo!";
			$this->data['searchResult'] = 'booking';
			$this->data = array_merge($this->data, $daysSearchResult[0]);
		}
		else{
			$this->data['message'] = "Not bingo...";
			$this->data['searchResult'] = 'timetable';
			$this->data['bookingContent'] = 'booking';
			$searchResult = array(
				array('facet'=>'day', 'bookings'=>$daysSearchResult),
				array('facet'=>'time', 'bookings'=>$timesSearchResult),
				array('facet'=>'course', 'bookings'=>$coursesSearchResult)
			);
			$this->data['bookings'] = $searchResult;
		}

		//$this->data['searchResult'] = $searchResult;
		$this->render();
	}

	public function showTimetable($facet){
		$this->data['pagebody'] = 'timetable';
		$this->data['bookingContent'] = 'booking';
		$timetable = new Timetable();
		$facet = array();
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
		$this->facet[] = array('facet'=>$facet, 'bookings'=>$bookings);
		$this->data['facets'] = $facet;
		$this->render();
	}
}
