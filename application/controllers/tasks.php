<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tasks extends CI_Controller {

	public function index()
	{
		$this->load->model("Task");
		$data['task_data'] = $this->Task->get_tasks();
		$this->load->view('index', $data);
	}

	public function new_task()
	{
		$post = $this->input->post();
		$this->load->model("Task");
		$task_data['id'] = $this->Task->add_task($post);
		$task_data['name'] = $post['name'];
		echo json_encode($task_data);
	}

	public function update_all()
	{
		$post = $this->input->post();
		$this->load->model("Task");
		$this->Task->edit_tasks($post);
		
		$task_data = $this->Task->get_tasks();
		echo json_encode($task_data);
	}
}