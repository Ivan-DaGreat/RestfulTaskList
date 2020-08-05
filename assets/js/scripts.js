;(function(root, doc, $) {
    /**
     * Task list checks & validation */
    $(function() {
        let taskForm = $('#taskForm'),
            taskModal = $('#taskModal'),
            status = $('.modal-footer .status');

        // Activate Date Picker
        $('#datepicker').datepicker();
        // Tooltips
        $('[data-toggle="tooltip"]').tooltip();

        /**
         * Add Task - Show Add Modal */
        $('button.addTask').click(function(e) {
            e.preventDefault();
            taskModal
                .addClass('addTask')
                .removeClass('editTask')
                .clearTaskForm()
                .modal('show');
        });

        /**
         * Edit Task - Show Edit Modal */
        $(document).on('click', '.editTask.task-action', function(e) {
            e.stopPropagation();
            e.preventDefault();
            console.log($(this));
            let theTask = $(this).parent(),
                taskId = theTask.data('tid'),
                taskDate = new Date(theTask.data('date')),
                taskTitle = theTask.attr('title');
            taskModal
                .addClass('editTask')
                .removeClass('addTask')
                .clearTaskForm()
                .modal('show');
            $('#taskName', taskModal).val(taskTitle);
            $('#datepicker', taskModal).datepicker("setDate", taskDate);
            taskForm.find('button.updateTask ').data('tid', taskId).removeAttr("disabled");
            $('#taskModal').modal('show');
        });

        /**
         * Add/Edit task Form */
        taskForm.validateTaskForm();
        $('button.addNewTask, button.updateTask').on('click', function (e) {
            e.preventDefault();
            $('button.addNewTask, button.updateTask').prop("disabled", true);
            status.html('Saving....');
            let method, apiUrl;
            // Adding
            if ($(this).hasClass('addNewTask')) {
                method = 'POST';
                apiUrl = '/api/task/add';
            } else {
                // Updating
                method = 'PUT';
                apiUrl = '/api/task/' + $(this).data('tid');
            }
            // Make the request
            apiRequest(method, taskForm.serialize(), apiUrl).then((response) => {
                if (response.status === 'success') {
                    status.html(response.message);
                    setTimeout(function(){
                        $('#taskModal').modal('hide');
                        // Update The Tasks
                        taskForm.updateCurrentTasks(response.tasks);
                    }, 3000);
                } else {
                    status.html('Error Creating Task.');
                    setTimeout(function(){ $('#taskModal').modal('hide'); }, 3000);
                }
                return false;
            });
        });

        /**
         * Delete Task */
        $(document).on('click', '.deleteTask', function() {
            let theTask = $(this).parent(),
                taskId = theTask.data('tid');
            apiRequest('DELETE', taskId, '/api/task/' + taskId).then((response) => {
                if (response.status === 'success') {
                    theTask.addClass('removed');
                    setTimeout(function(){
                        theTask.slideUp("normal", function() { theTask.remove(); } );
                    }, 2000);
                } else {
                    status.html('Error Removing Task.');
                    setTimeout(function(){ $('#taskModal').modal('hide'); }, 3000);
                }
                return false;
            });
        });

    });

    /**
     * Validate Add Task form
     */
    $.fn.validateTaskForm = function() {
        $('input', this).on('change input', function() {
            if ($('#taskName').isValid() && $('#datepicker').isValid()) {
                $('button.addNewTask').removeAttr("disabled");
            } else {
                $('button.addNewTask').prop("disabled", true);
            }
        });
    };

    /**
     * Load new tasks
     * @param tasks
     */
    $.fn.updateCurrentTasks = function(tasks) {
        let taskListContainer = $('.task-list-container .task-list'),
            taskDate,
            displayDate,
            dateTimeFormat = new Intl.DateTimeFormat('en', { year: 'numeric', month: 'short', day: '2-digit' });
        taskListContainer.empty();
        $.each(tasks, function( tid, task) {
            taskDate = new Date(task.duedate);
            const [{ value: month },,{ value: day }] = dateTimeFormat.formatToParts(taskDate);
            displayDate = `${month}. ${day}`;

            taskListContainer.append(
                "<li id='task_"+task.id+"' class='task list-group-item' title='"+task.task+"' data-tid='"+task.id+"' data-date='"+task.duedate+"'>" +
                    "<i class='deleteTask fa fa-window-close-o pr-2 task-action' data-toggle='tooltip' data-placement='top' title='Delete'></i>" +
                    "<i class='editTask fa fa-pencil-square-o pr-2 task-action' data-toggle='tooltip' data-placement='top' title='Edit'></i>" +
                    task.task +
                    "<span class='duedate float-right'>"+displayDate+"</span>" +
                "</li>"
            );
        });
    }

    /**
     * Clear Task form
     */
    $.fn.clearTaskForm = function() {
        $('input', this).each(function() {
            $(this).val('');
        });
        $('button.addNewTask, button.updateTask').prop("disabled", true);
        $('.status', this).html('');
        return this;
    };

    /**
     * Validate input fields
     * @return {boolean}
     */
    $.fn.isValid = function() {
        return this.val().length >= 4;
    };

    /**
     * Make Request to the Api
     * @param method {String}
     * @param data {Array}
     * @param apiUrl {String|Boolean}
     */
    async function apiRequest(method, data, apiUrl = '/api/task/add') {
        let response;
        try {
            response = await jQuery.ajax({
                url: apiUrl,
                data: data,
                type: method
            });
            return response;
        } catch(error) {
            console.log(error);
            return false;
        }
    }

    /**
     * Setup our global ajax params.
     */
    $.ajaxSetup({
        url : '/api/task/add',
        dataType : 'json',
        async : true,
        type : 'POST',
        timeout : 60000,
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest, textStatus, errorThrown);
        }
    });

})(	this, document, jQuery);