<?php

class User_digests extends CI_Model {
	public function __construct()
	{
		parent::__construct();

		$this->load->model('ion_auth_model');
	}

	public function create($username, $password, $realm)
	{
		$hash = $this->create_hash($username, $password, $realm); 

		$user_id = $this->ion_auth_model->get_user_id_from_identity($username);

		// TODO more atomic please
		if ( $digest = $this->get_by_user_id($user_id) )
		{
			return $this->db->where('user_id', $user_id)
				->set('digest_string', $hash)
				->update('users_digests');
		}
		else
		{
			return $this->db->insert('users_digests', [
					'user_id' => $user_id,
					'digest_string' => $hash,
				]);
		}

		return FALSE;
	}

	public function create_hash($username, $password, $realm)
	{
		return md5($username.':'.$realm.':'.$password);
	}

	public function get_by_user_id($user_id)
	{
		return $this->db->from('users_digests')
			->where('user_id', $user_id)
			->limit(1)
			->get()->first_row();
	}
}
