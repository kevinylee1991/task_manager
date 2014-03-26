<html>
<head>
	<title>Task Manager</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<link href="/css/bootstrap.css" rel="stylesheet">
	<link rel='stylesheet' type='text/css' href='/assets/css/task.css'>
	<script src="/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.add').submit(function(){
				$.post(
					$(this).attr('action'),
					$(this).serialize(),
					function(data){
						$('#list').prepend("<div class='task'><a class='edit' id='"+data.id+"' href='/tasks/edit'>Edit</a><input class = 'check' type='checkbox' name='completed[]' value='"+data.id+"'><span class='task_name'>"+data.name+"</span></div>")
					},
					'json'
				);
				return false;
			});

			$(document).on('click', '.edit', function(){
				var task_id = $(this).attr('id');
				var task_name = $(this).siblings('span.task_name').text();
				$(this).siblings('span.task_name').replaceWith("<textarea class='textarea_task' name='"+task_id+"'>"+task_name+"</textarea>");

				return false;
			});

			$(document).on('change', '.check', function(){
				$(this).parent().submit();
				alert('form submited?')
			})

			$(document).on('blur', 'textarea', function(){
				var text = $(this).val();
				console.log(text);
				$(this).parent().parent().submit();
				$(this).replaceWith("<span class='task_name'>"+text+"</span>")
			})

			$(document).on('submit', '#list', function(){
				alert('im ron burgundy?')
				$.post(
					$(this).attr('action'),
					$(this).serialize(),
					function(data){
						alert('you know i dont speak spanish')
						$('#list').empty();
						for(var i=0; i < data.length; i++)
						{
							if(data[i].completed == 1)
							{
								$('#list').append("<div class='task'><a class='edit' id='" + data[i].id + "'href='/tasks/edit'>Edit</a><input class= 'check' type='checkbox' name='completed[]' value='" + data[i].id + "' checked><span class='task_name gray'>"+data[i].name+"</span></div>");
							}
							else
							{
								$('#list').append("<div class='task'><a class='edit' id='" + data[i].id + "'href='/tasks/edit'>Edit</a><input class = 'check' type='checkbox' name='completed[]' value='" + data[i].id + "'><span class='task_name'>"+data[i].name+"</span></div>");
							}
						}
						// $('#list').append("<input id='update_button' type='submit' value='Update All'>")
					},
					'json'
				);
				return false;
			});
		});
	</script>

</head>
<body>
	<div class='container-fluid'>
		<div class='row'>
			<div class='col-md-1'></div>
			<div class='col-md-11'>
				<h1>List of Tasks:</h1>
			</div>
		</div>
		<div class='row'>
			<div class='col-md-1'></div>
			<div id='tasks' class='col-md-5'>
				<form id='list' action='<?php echo base_url('tasks/update_all')?>' method='post'>
<?php
	foreach($task_data as $task)
	{
		if ($task['completed'] == 1)
		{
			echo "<div class='task'>
					<a class='edit' id='" . $task['id'] . "' href='/tasks/edit'>Edit</a>
					<input class= 'check' type='checkbox' name='completed[]' value='" . $task['id'] . "' checked>
					<span class='task_name gray'>" . $task['name'] . "</span>
				</div>";
		}
		else
		{
			echo "<div class='task'>
					<a class='edit' id='" . $task['id'] . "' href='/tasks/edit'>Edit</a>
					<input class = 'check' type='checkbox' name='completed[]' value='" . $task['id'] . "'>
					<span class='task_name'>" . $task['name'] . "</span>
				</div>";
		}
	}

	// foreach($task_data as $task)
	// {
	// 		echo "<div class='task'>
	// 				<a class='edit' id='" . $task['id'] . "' href='/tasks/edit'>Edit</a>
	// 				<input type='checkbox' name='completed[]' value='" . $task['id'] . "'>
	// 				<span class='task_name'>" . $task['name'] . "</span>
	// 			</div>";
		
	// }
?>
					<!-- <input type='hidden' name = 'filler' value = 'filler'> -->
					<!-- <input id='update_button' type='submit' value='Update All'> -->
				</form>
			</div>
			<div id='add_tasks' class='col-md-6'>
			<form class='add' action='<?php echo base_url('tasks/new_task')?>' method='post'>
					<p>Create a New Task:</p>
					<input type='text' name='name'>
					<input type='submit' value='Add Task'>
				</form>
			</div>
		</div>
	</div>
</body>
</html>