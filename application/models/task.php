<?php
date_default_timezone_set('America/Los_Angeles');

class Task extends CI_Model {

	function get_tasks()
	{
		return $this->db->query("SELECT * FROM tasks ORDER BY tasks.created_at DESC")->result_array();
	}

	function add_task($task)
	{
		$query = "INSERT INTO tasks (name, created_at, updated_at, completed) VALUES (?,?,?,?)";
		$values = array($task['name'], date("Y-m-d, H:i:s"), date("Y-m-d, H:i:s"), FALSE);
		$this->db->query($query, $values);
		return $this->db->insert_id();
	}

	function edit_tasks($data)
	{
		$query = "UPDATE tasks SET tasks.completed = FALSE WHERE id > 0";
		$this->db->query($query);

		if (isset($data['completed']))
		{
			$complete_tasks = $data['completed'];

			foreach($complete_tasks as $task_id) //set tasks as completed or not
			{
				$query = "UPDATE tasks SET tasks.completed = TRUE WHERE id={$task_id}";
				$this->db->query($query);
			}
		}

		unset($data['completed']);
		// var_dump($data);
		foreach($data as $key => $value) //set edited task names in database
		{
			// var_dump($key);
			// var_dump($value);
			// if ($key != $data['completed']);
			// {
				$query = "UPDATE tasks SET tasks.name = '{$value}' WHERE id={$key}";
				$this->db->query($query);
			// }
		}
	}
}
?>