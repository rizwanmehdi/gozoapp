<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends DIA_Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('category_m');
	}
	
	public function index()
	{
		$per_page = 50;
		$items = $this->category_m->get($per_page, $this->input->get('per_page'));
		$total_rows = $this->category_m->count_all();
		
		$config = array(
			'base_url' => base_url() . 'admin/category/?',
			'total_rows' => $total_rows,
			'per_page' => $per_page,
			'enable_query_strings' => true,
			'page_query_string' => true,
			'page_numbers' => true,
			'full_tag_open' => '<div class="yahoo2">',
			'full_tag_close' => '</div>',
			'next_link' => 'Next',
			'prev_link' => 'Prev',
			'num_links' => 5
		);
		$this->pagination->initialize($config);
		
		$this->template->set('pagination', $this->pagination->create_links());
		$this->template->set('items', $items);
		$this->template->set('page', 'category/main');
		$this->template->view('base');
	}
	
	public function add()
	{
		if($this->input->post('process') == '1')
			$this->process();

		if(validation_errors())
			$this->message->set('error', validation_errors());
		
		$this->template->set('parents', $this->category_m->get_where(array('parent_id'=>'0')));
		$this->template->set('item', null_object(array('id', 'title', 'parent_id')));
		$this->template->set('page', 'category/form');
		$this->template->view('base');
	}
	
	public function edit($id)
	{
		if(!is_numeric($id) || !$item = $this->category_m->get_where(array('id'=>$id))->first_row())
			show_404();
		
		if($this->input->post('process') == '1')
			$this->process('edit', $id);
		
		$this->template->set('parents', $this->category_m->get_where(array('parent_id'=>'0')));
		$this->template->set('item', $item);
		$this->template->set('page', 'category/form');
		$this->template->view('base');
	}
	
	public function delete($id)
	{
		
	}
	
	private function process($action='add', $id=null)
	{
		$validation = array(
			array('field'=>'title', 'label'=>'Title', 'rules' => 'trim|required|max_length[50]|xss_clean'),
			array('field'=>'parent_id', 'label'=>'Parent', 'rules' => 'trim')
		);
		
		$this->form_validation->set_rules($validation);
		
		if( $this->form_validation->run() )
		{
			$set = array(
				'title' => $this->input->post('title'),
				'parent_id' => $this->input->post('parent_id') ? $this->input->post('parent_id') : 0
			);
			
			if( $action == 'add' )
			{
				$set['slug'] = unique_slug($this->input->post('title'), 'business_categories');
				$this->category_m->insert($set);
				$this->message->set('success', 'Category was successfully created.', true);
				redirect('/admin/category/');
			}
			elseif( $action == 'edit' )
			{
				$this->category_m->update($set, array('id'=>$id), 1);
				$this->message->set('success', 'Category was successfully updated.', true);
				redirect('/admin/category/');
			}
		}
	}
}

	