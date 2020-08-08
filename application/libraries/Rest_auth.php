<?php

class Rest_auth {
	private $user;

	public function __construct()
	{
		$this->app =& get_instance();

		$this->app->load->database();
		$this->app->load->model('ion_auth_model');
		$this->app->load->model('user_digests');
	}

	public function authenticate($identity = "", $password = NULL)
	{
		$user_id = $this->app->ion_auth_model->get_user_id_from_identity($identity);

		if (! $user_id)
		{
			return FALSE;
		}

		$user = $this->app->ion_auth_model->user($user_id);	

		$this->set_user($user);

		$user_digest = $this->app->user_digests->get_by_user_id($user_id);

		if ( $user_digests !== FALSE )
		{
			$this->patch_to_app();
		}

		return $user_digest ? $user_digest->digest_string : FALSE;
	}

	public function set_user($user)
	{
		$this->user  = $user;
	}

	public function user()
	{
		return $this->user;
	}

	protected function patch_to_app()
	{
		$this->app->rest_auth = $this;
	}
}
