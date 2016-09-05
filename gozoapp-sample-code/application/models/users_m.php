<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Users_m extends DIA_Model
{	
	protected $table = 'users';
	
	public function __construct()
	{
		parent::__construct();
	}

	public function get_user_devices($where=null, $limit=null, $offset=null)
	{
		$this->db->select('users.*')
				 ->select('user_devices.device_type, user_devices.device_id, user_devices.push_notification_id AS register_id')
				 ->join('user_devices', 'user_devices.user_id = users.id');
		if( $where )
			$this->db->where($where);
		
		return parent::get();
			
	}
	
	/* xml feeds */
	public function get_user_xml($user_id)
	{
		$rec = $this->db->get_where($this->table, array('users.id' => $user_id), 1)->first_row();
		$response = array(
			'items' => array(
				'item'=> array(
					'id' => $rec->id,
					'email' => $rec->email,
					'first_name' => $rec->first_name,
					'last_name' => $rec->last_name,
					'phone' => format_phone_number($rec->phone),
					'zip' => $rec->zip_code,
					'image_path' => $rec->profile_image ? base_url() . 'media/users/' . $rec->id . '/' . $rec->profile_image : NULL
				)	
			)
		);
		return $response;
		
	}
		
	public function get_user_custom_contacts_xml($user_id)
	{
		$contacts = $this->get_user_custom_contacts($user_id);
		
		$response = array();
		
		if( $contacts->num_rows() > 0 )
		{
			$response = array('items' => array('item' => array()));
			
			foreach($contacts->result() AS $contact)
			{
				$item_array = array(
						'name' => $contact->contact_name,
						'email' => $contact->email ? $contact->email : null,
						'phone' => $contact->phone ? format_phone_number($contact->phone) : null
				);
				array_push($response['items']['item'], $item_array);
			}
		}
		
		return $response;
	}
	
	public function check_nonusers($where)
	{		
		if( isset($where['email']) || !empty($where['email']) )
			return $this->db->get_where('nonusers', array('email' => $where['email']), 1)->first_row();
		
		if( isset($where['phone']) || !empty($where['phone']) )
			return $this->db->get_where('nonusers', array('phone' => $where['phone']), 1)->first_row();
		
		if( isset($where['facebook_id']) || !empty($where['facebook_id']) )
			return $this->db->get_where('nonusers', array('facebook_id' => $where['facebook_id']), 1)->first_row();
		
		/*if( isset($where['facebook_id']) && $where['facebook_id'] != NULL)
			return $this->db->get_where('nonusers', array('facebook_id' => $where['facebook_id']), 1)->first_row();
			
		exit( $this->db->last_query());	*/
		return false;
	}

	/* front end stuff */
	public function get_user_custom_contacts($user_id)
	{
		$this->db->where(array('owner_id' => $user_id, 'owner_type' => 'user'))
				 ->order_by('contact_name', 'asc');
		
		return $this->db->get('user_custom_contacts');
	}
}