<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Category_m extends DIA_Model
{	
	protected $table = 'business_categories';
	
	public function __construct()
	{
		parent::__construct();	
	}
	
	public function get($limit=null, $offset=null)
	{
		$this->db->select('business_categories.*, parent_category.title AS parent')
				 ->select("IF(business_categories.parent_id = '0', business_categories.id, business_categories.parent_id) AS sequence", false)
				 ->join('business_categories AS parent_category', 'parent_category.id = business_categories.parent_id', 'left')
				 ->order_by('sequence ASC, parent_id ASC, title ASC');
		
		return parent::get($limit, $offset);
	}
	
	public function get_user_categories($user_id, $limit=null, $offset=null)
	{
		$this->db->select('business_categories.*')
				 ->select("(SELECT preference FROM user_preferences WHERE user_id = '$user_id' AND preference_id = business_categories.id LIMIT 1) as user_preference", false)
				 ->join('user_preferences', 'preference_id = business_categories.id')
				 ->where('user_preferences.preference_type', 'category')
				 ->group_by('business_categories.id')
				 ->order_by('business_categories.title', 'asc');
		
		return $this->db->get($this->table);
	}
}
