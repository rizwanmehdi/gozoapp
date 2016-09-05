<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Business_m extends DIA_Model
{	
	protected $table = 'businesses';
	
	public function __construct()
	{
		parent::__construct();
		$this->miles = 100;
	}

	public function get_user_business_pref_xml($limit=null, $offset=null)
	{
		$user = $this->users_m->get_where(array('id' => $this->oauthserver->resource_id), 1)->first_row();

		$businesses = $this->get();

		$response = array();
		
		if( $businesses->num_rows() > 0 )
		{
			$response = array('items' => array('item' => array()));

			foreach($businesses->result() AS $row)
			{
				$item_array = array(
					'id' => $row->id,
					'title' => $row->company,
					'allow_invites' => 1
				);
				array_push($response['items']['item'], $item_array);
			}
		}
		return $response;
	}
	
	public function get_user_merchants($user_id)
	{
		$this->db->select('businesses.*')
				 ->select("(SELECT preference FROM user_preferences WHERE user_id = '$user_id' AND preference_type = 'business' AND preference_id = businesses.id LIMIT 1) as user_preference", false)
				 ->order_by('businesses.company');
		
		return parent::get();
	}
	public function getall(){
		//$this->db->select("businesses.*");
		$result=$this->db->get($this->table);
		return $result;
		//echo $this->db->last_query();die;
	}

}