<?php
/**
 * Not using Laravel nor an autoloader so going to be a bit of writing. Sigh...
 */

use App\Controllers\TaskDisplayController;

require_once (__DIR__ . '/app/Bootstrap.php')
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Task List</title>
	<!-- CSS -->
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="/assets/css/styles.css">
	<!-- JS -->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	<script src="/assets/js/scripts.js"></script>
</head>
<body>
<section class="jumbotron">
	<div class="container">
		<div class="container has-text-centered">
			<h1 class="display-3">Task List</h1>
			<h2 class="subtitle">....get to work</h2>
		</div>
	</div>
</section>
<section class="section mb-5">
	<div class="container">
		<div class="row">
			<div class="col-md-10">
				<h3>Tasks<button type="button" class="addTask small btn btn-primary pull-right" data-toggle="modal" data-target="#taskModal" >+Add Task</button></h3>
				<div class="task-list-container content">
					<?php doTasksList(); ?>
				</div>
			</div>
			<div class="col-md-2 mt-5">
				<h5 class="text-muted">Total Tasks: <span class="badge badge-secondary badge-pill">#</span></h5>
                <hr>
                <h5 class="text-muted">Maybe Alerts:</h5>
                <ul class="content">
                    <li class="small text-muted">...</li>
                </ul>
			</div>
		</div>
	</div>
</section>

<!-- Add Task Modal -->
<div class="modal fade" id="taskModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Task</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="taskForm" novalidate>
				<div class="modal-body">
					<div class="input-group date p-2 row">
						<label for="taskName" class="col-3">Title:</label>
						<input id="taskName" class="form-control form-control-sm col-9" name="task" type="text" placeholder="Name Of Task (at least 4 characters)" autocomplete="off" required>
						<div class="invalid-feedback">
							Need a Task name
						</div>
					</div>
					<div class="input-group date p-2 row" data-provide="datepicker">
						<label for="taskName" class="col-3">Complete By:</label>
						<input type="text" class="form-control form-control-sm col-9" name='date' id="datepicker" placeholder="When should it be completed by..." autocomplete="off" required>
					</div>
				</div>
				<div class="modal-footer">
					<div class="status text-left"></div>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="button" class="addNewTask btn btn-primary" disabled>Create Task</button>
					<button type="button" class="updateTask btn btn-primary" disabled>Update Task</button>
				</div>
			</form>
		</div>
	</div>
</div>
<footer class="navbar navbar-expand-md navbar-light fixed-bottom bg-dark">
	<div class="container">
		<span class="text-muted">@IvanDavila</span>
	</div>
</footer>
</body>
</html>
<?php

function doTasksList() {
	$tasks = new TaskDisplayController();
	print $tasks::doTasksList();
}
?>