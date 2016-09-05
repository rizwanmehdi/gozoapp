<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends DIA_Admin_Controller {
	
	protected $table = 'users';
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('user_devices_m');
		$this->load->model('users_m');
	}

	public function index()
	{
		$per_page = 25;
		$total_rows = $this->user_devices_m->count_all_results();

		$config = array(
			'base_url' => base_url() . 'admin/users/?' . $_SERVER['QUERY_STRING'],
			'total_rows' => $total_rows,
			'per_page' => $per_page,
			'enable_query_string' => true,
			'page_query_string' => true,
			'page_number' => true,
			'full_tag_open' => '<div class="yahoo2">',
			'full_tag_close' => '</div>',
			'next_link' => 'Next',
			'prev_link' => 'Prev',
			'num_links' => 5
		);
		$this->pagination->initialize($config);
		$this->template->set('pagination', $this->pagination->create_links());
		
		$this->db->where('user_devices.deleted_on', NULL);
		$this->template->set('items',$this->user_devices_m->get($per_page, $this->input->get('per_page')));
		$this->template->set('page', 'users/main');
		$this->template->view('base');
	}
	
	public function delete($user_id = null)
	{
		if( !is_numeric($user_id) || !$this->users_m->get_where(array('users.id' => $user_id), 1)->first_row() )
		{
			$this->message->set('error', 'Invalid User ID or user does not exists.', true);
			redirect('/admin/users/');
		}
		
		$this->users_m->soft_delete(array('users.id' => $user_id), 1);
		$this->user_devices_m->soft_delete(array('user_id' => $user_id), 1);

		$this->message->set('success', 'User was successfully deleted.', true);
		redirect('/admin/users/');
	}
}