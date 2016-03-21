<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
		$this->load->helper('directory')
		$candidates = directory_map(DATAPATH);
		sort($candidates);
		foreach($candidates as $file){
			if(substr_compare($file, XMLSUFFIX, strlen($file) - strlen(XMLSUFFIX), strlen(XMLSUFFIX)) === 0){
				$bookings[] = array('filename' => substr($file, 0, -4));
			}
		}

		$this->data['bookings'] = $bookings;

		$this->data['pagebody'] = 'homepage';
		$this->render();

	}
}
