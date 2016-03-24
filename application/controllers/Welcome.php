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
		//$data['results'] = $this->load->view('booking',NULL,TRUE);
		//$data = array('content'=>$this->load->view('search_result','',TRUE),'searchResult'=>$this->load->view(''))
		$this->data['pagebody'] = 'search_result';
		$timetable = new Timetable();
		$day = $this->input->post('daySelect');
		$timeslot = $this->input->post('timeSelect');
		$daysSearchResult = $timetable->searchByDays($day,$timeslot);
		$timesSearchResult = $timetable->searchByTimes($day,$timeslot);
		$coursesSearchResult = $timetable->searchByCourses($day,$timeslot);
		if(count($daysSearchResult) == 1 && count($timesSearchResult) == 1 && count($coursesSearchResult) == 1){
			//$this->data['searchResult'] = 'booking';

			//$this->load->view('search_result',$this->data);
			$this->data['message'] = "Bingo!";

			$bookingResult = array(
				'timeslot' => $daysSearchResult[0]->getClock(),
				'course' => $daysSearchResult[0]->getCourse(),
				'day' => $daysSearchResult[0]->getDay(),
				'instructor' => $daysSearchResult[0]->getInstructor(),
				'room' => $daysSearchResult[0]->getRoom());
			//print_r($bookingResult);

			$data['searchResult'] = $this->load->view('booking',$bookingResult,TRUE);
			//$this->data['searchResult'] = $data['searchResult'];

			//$this->data = array_merge($this->data, $bookingResult);
			$string = $this->parser->parse('booking',$bookingResult,TRUE);
			$this->data['searchResult'] = $string;
		}
		else{
			//$this->data['searchResult'] = 'timetable';
			//$this->load->view('search_result',$this->data);
			$this->data['message'] = "Not bingo...";

			//$this->data['bookingContent'] = 'booking';
			if(count($daysSearchResult) == 0 && count($timesSearchResult) == 0 && count($coursesSearchResult) == 0){
				$string = "No bookings found.";
			}
			else{
				print_r($daysSearchResult);
				print_r($timesSearchResult);
				print_r($coursesSearchResult);
				print_r($timetable->getCourses());
				$searchResult = array(
					array('facet'=>'day', 'bookings'=>$daysSearchResult),
					array('facet'=>'time', 'bookings'=>$timesSearchResult),
					array('facet'=>'course', 'bookings'=>$coursesSearchResult)
				);
				$data['searchResult'] = $this->load->view('timetable',$searchResult,TRUE);
				$string = $this->parser->parse('timetable',$searchResult,TRUE);
			}
			$this->data['searchResult'] = $string;
		}

		//$this->data['searchResult'] = $searchResult;
		//$this->parser->parse('search_result',$data);
		$this->render();
	}

	public function showTimetable($facet){
		$this->data['pagebody'] = 'timetable';
		//$this->data['bookingContent'] = 'booking';
		$timetable = new Timetable();
		$facetArray = array();
		//$bookings = array();
		switch($facet){
			case 'day':
				foreach($timetable->getDays() as $record){
					$bookings[] = array(
						'timeslot' => $record->getClock(),
						'course' => $record->getCourse(),
						'day' => $record->getDay(),
						'instructor' => $record->getInstructor(),
						'room' => $record->getRoom()
					);
				}
				break;
			case 'timeslot':
				foreach($timetable->getTimes() as $record){
					$bookings[] = array(
						'timeslot' => $record->getClock(),
						'course' => $record->getCourse(),
						'day' => $record->getDay(),
						'instructor' => $record->getInstructor(),
						'room' => $record->getRoom()
					);
				}
				break;
			case 'course':
				foreach($timetable->getCourses() as $record){
					$bookings[] = array(
						'timeslot' => $record->getClock(),
						'course' => $record->getCourse(),
						'day' => $record->getDay(),
						'instructor' => $record->getInstructor(),
						'room' => $record->getRoom()
					);
				}
				break;
			default:
		}

		$this->facetArray[] = array('facet'=>$facet, 'bookings'=>$bookings);
		//print_r($this->facetArray);
		//print '<script type="text/javascript">console.log('.$facetArray.');</script>';
		//echo $facetArray;
		$this->data['facets'] = $this->facetArray;
		$this->render();
	}
}
