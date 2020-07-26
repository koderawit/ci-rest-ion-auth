<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class User extends RestController {
	public function __construct()
	{
		parent::__construct();
	}

	public function index_get()
	{
		$this->me_get();
	}

	public function me_get()
	{
		$this->response( $this->rest_auth->user(), 200 );
	}
}
