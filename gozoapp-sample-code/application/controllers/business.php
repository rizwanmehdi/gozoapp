<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Business extends DIA_Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('business_m');
		$this->load->model('locations_m');
		$this->load->model('business_category_m', 'category_m');
		$this->_validation = array();
	}
	
	public function index()
	{
		$per_page = 20;
		$total_rows = $this->business_m->count_all_results();

		$this->db->order_by('company', 'ASC');
		$items = $this->business_m->get($per_page, $this->input->get('per_page'));

		$config = array(
			'base_url' => base_url() . 'admin/business/?' . $_SERVER['QUERY_STRING'],
			'total_rows' => $total_rows,
			'per_page' => $per_page,
			'enable_query_string' => true,
			'page_query_string' => true,
			'page_numbers' => true,
			'full_tag_open' => '<div class="yahoo2">',
			'full_tag_close' => '</div>',
			'next_link' => 'Next',
			'prev_link' => 'Prev',
			'num_links' => 5
		);
		$this->pagination->initialize($config);

		$this->template->set('items', $items);
		$this->template->set('pagination', $this->pagination->create_links());
		$this->template->set('page', 'business/main');
		$this->template->view('base');
	}
	
	public function add()
	{
		if( $this->input->post('process') )
			$this->process();
		
		$this->template->set('categories', $this->category_m->get_parent_category());
		$this->template->set('item', null_object(array('id', 'email', 'password', 'salt', 'company', 'phone', 'group_id', 'category_id', 'subcategory_id')));
		$this->template->set('page', 'business/form');
		$this->template->view('base');	
	}
	
	public function edit($id)
	{
		if( !is_numeric($id) || !$item = $this->business_m->get_where(array('id'=>$id), 1)->first_row() )
		{
			$this->message->set('error', 'Invalid Business', true);
			redirect('/admin/business/');
		}
		
		if( $this->input->post('process') )
			$this->process('edit', $id);
		
		$this->template->set('categories', $this->category_m->get_parent_category());
		$this->template->set('item', $item);
		$this->template->set('page', 'business/form');
		$this->template->view('base');
	}
	
	public function delete($id)
	{
		if( !is_numeric($id) || !$item = $this->business_m->get_where(array('id' => $id), 1)->first_row() )
		{
			$this->message->set('error', 'Invalid Business', true);
			redirect('/admin/business/');
		}
		
		$this->db->where(array('owner_type'=>'business', 'owner_id' => $id));
		$this->db->delete('locations');
		
		$this->db->where(array('id'=>$id));
		$this->db->delete('businesses');
		
		$this->message->set('success', 'Business and all Locations were successfully deleted.', true);
		
		redirect('/admin/business/');
	}
	
	private function process($action='add', $id=null)
	{
		if( $id )
			$user = $this->business_m->get_where(array('id' => $id), 1)->first_row();
		
		if( $action == 'add' )
		{
			$this->_validation = array(
				array(
					'field' => 'category_id',
					'label' => 'Category',
					'rules' => 'trim|required|xss_clean'
				),
				array(
					'field' => 'subcategory_id',
					'label' => 'Sub-Category',
					'rules' => 'trim|xss_clean'
				),
				array(
					'field' => 'company',
					'label' => 'Business Name',
					'rules' => 'trim|max_length[128]|required|xss_clean'
				),
				array(
					'field' => 'phone',
					'label' => 'Phone',
					'rules' => 'trim|make_numeric|exact_length[10]|xss_clean'
				),
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'trim|max_length[64]|valid_email|required|is_unique[businesses.email]|xss_clean'
				),
				array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'trim|min_length[5]|max_length[12]|alpha_numeric|required|xss_clean'
				)
			);
		}
		elseif( $action == 'edit' )
		{
			array_push(
				$this->_validation,
				array(
					'field' => 'category_id',
					'label' => 'Category',
					'rules' => 'trim|required|xss_clean'
				),
				array(
					'field' => 'subcategory_id',
					'label' => 'Sub-Category',
					'rules' => 'trim|xss_clean'
				),
				array(
					'field' => 'company',
					'label' => 'Business Name',
					'rules' => 'trim|max_length[128]|required|xss_clean'
				),
				array(
					'field' => 'phone',
					'label' => 'Phone',
					'rules' => 'trim|make_numeric|exact_length[10]|xss_clean'
				)
			);
			
			if( $this->input->post('email') != $user->email )
			{
				array_push(
					$this->_validation,
					array(
						'field' => 'email',
						'label' => 'Email',
						'rules' => 'trim|max_length[64]|valid_email|required|is_unique[businesses.email]|xss_clean'
					)
				);
			}
			
			if( $this->input->post('password') )
			{
				array_push(
					$this->_validation,
					array(
						'field' => 'password',
						'label' => 'Password',
						'rules' => 'trim|min_length[5]|max_length[12]|alpha_numeric|required|xss_clean'
					)
				);
			}
		}
		
		$this->form_validation->set_rules($this->_validation);
		
		if( $this->form_validation->run() )
		{
			$set = array(
				'company' => $this->input->post('company'),
				'phone' => $this->input->post('phone') ? $this->input->post('phone') : null,
				'email' => $this->input->post('email'),
				'category_id' => $this->input->post('category_id'),
				'subcategory_id' => $this->input->post('subcategory_id') ? $this->input->post('subcategory_id') : null
			);
			
			$set['salt'] = isset($id) ? $user->salt : $this->auth->salt();
			
			if( $this->input->post('password') )
				$set['password'] = $this->auth->encrypt_password($this->input->post('password'), $set['salt']);
			
			if( $action == 'add' )
			{
				$set['slug'] = unique_slug($this->input->post('company'), 'businesses');
				$this->business_m->insert($set);
				$id = $this->db->insert_id();
				$this->message->set('success', 'Business was successfully created. You may start adding locations.', true);
				redirect('/admin/business/locations/add/?business_id=' . $id);
			}
			elseif( $action == 'edit' )
			{
				$this->business_m->update($set, array('id'=>$id), 1);
				$this->message->set('success', 'Business was successfully updated.', true);
				redirect('/admin/business/');
			}
		}
		else
			$this->message->set('error', validation_errors());
	}
	
	public function locations($action=null, $id=null)
	{
		switch($action)
		{
			case 'add': $this->location_add(); break;
			case 'edit': $this->location_edit($id);break;
			case 'delete': $this->location_delete($id);break;
			default:
				$business_id = $this->input->get('business_id');
				if( !is_numeric($business_id) || !$item = $this->business_m->get_where(array('id' => $business_id), 1)->first_row() )
				{
					$this->message->set('error', 'Invalid Business', true);
					redirect('/admin/business/');
				}
				$this->template->set('business', $item);
				$this->template->set('items', $this->locations_m->get_where(array('owner_id' => $business_id, 'owner_type' => 'business')));
				$this->template->set('page', 'business/locations');
				$this->template->view('base');
				break;
		}
	}
	
	private function location_add()
	{
		$business_id = $this->input->get('business_id');
		if( !is_numeric($business_id) || !$business = $this->business_m->get_where(array('id'=>$business_id), 1)->first_row() )
		{
			$this->message->set('error', 'Invalid Business', true);
			redirect('/admin/business/');
		}
		
		if( $this->input->post('process') )
			$this->process_location();
		
		$this->template->set('business', $business);
		$this->template->set('states', $this->eav_m->get_where(array('entity'=>'state')));
		$this->template->set('item', null_object(array('title', 'address', 'city', 'state', 'country')));
		$this->template->set('page', 'business/locations-form');
		$this->template->view('base');
	}
	
	private function location_edit($location_id=null)
	{
		if( !is_numeric($location_id) || !$item = $this->locations_m->get_where(array('locations.id' => $location_id), 1)->first_row() )
		{
			$this->message->set('error', 'Invalid Location', true);
			redirect('/admin/business/');	
		}
		
		if( $this->input->post('process') )
			$this->process_location('edit', $id);
		
		$address = explode(',', $item->formatted_address);
		$result = array(
			'title' => $item->title,
			'address' => trim($address[0]),
			'city' => trim($address[1]),
			'state' => trim($address[2]),
			'country' => trim($address[3])
		);
		
		$this->template->set('business', $this->business_m->get_where(array('id' => $item->owner_id))->first_row());
		$this->template->set('states', $this->eav_m->get_where(array('entity'=>'state')));
		$this->template->set('item', array_to_object($result));
		$this->template->set('page', 'business/locations-form');
		$this->template->view('base');
	}
	
	private function location_delete($location_id=null)
	{
		if( !is_numeric($location_id) || !$item = $this->locations_m->get_where(array('locations.id' => $location_id), 1)->first_row() )
		{
			$this->message->set('error', 'Invalid Location', true);
			redirect('/admin/business/');
		}
		
		$this->db->where(array(
			'owner_id' => $this->input->get('business_id'),
			'owner_type' => 'business',
			'locations.id' => $location_id,
			'deleted_on' => null
		))->delete('locations');
		
		$this->message->set('success', 'Location was successfully deleted.', true);
		redirect('/admin/business/locations/views/?' . $_SERVER['QUERY_STRING']);
		
	}
	
	private function process_location($action='add', $id=null)
	{
		$this->_validation = array(
			array(
				'field' => 'title',
				'label' => 'Location Name',
				'rules' => 'trim|max_length[100]|required|xss_clean'
			),
			array(
				'field' => 'address',
				'label' => 'Street Address',
				'rules' => 'trim|max_length[200]|required|xss_clean'
			),
			array(
				'field' => 'city',
				'label' => 'City',
				'rules' => 'trim|max_length[200]|required|xss_clean'
			),
			array(
				'field' => 'state',
				'label' => 'State',
				'rules' => 'trim|required|xss_clean'
			)
		);
		
		$this->form_validation->set_rules($this->_validation);
		if( $this->form_validation->run() )
		{
			$address = $this->input->post('address');
			$address .= ', ' . $this->input->post('city');
			$address .= ', ' . $this->input->post('state');
			$address .= ', ' . $this->input->post('country');
			$coords = coords_by_address_geocode($address);
			
			$set = array(
				'owner_id' => $this->input->post('business_id'),
				'owner_type' => 'business',
				'title' => $this->input->post('title'),
				'formatted_address' => $address,
				'latitude' => $coords['latitude'] ? $coords['latitude'] : null,
				'longitude' => $coords['longitude'] ? $coords['longitude'] : null,
				'modified_on' => mysql_now()
			);
			
			if( $action == 'add' )
			{
				$set['slug'] = unique_slug($this->input->post('title'), 'locations');
				$this->locations_m->insert($set);
				$this->message->set('success', 'Business Location was successfully added.', true);
			}
			elseif( $action == 'edit' )
			{
				$this->locations_m->update($set, array('id'=>$id), 1);
				$this->message->set('success', 'Business Location was successfully updated.', true);
			}
			redirect('/admin/business/locations/view/?business_id=' . $this->input->post('business_id'));
		}
		else
			$this->message->set('error', validation_errors());
	}


}
	
	