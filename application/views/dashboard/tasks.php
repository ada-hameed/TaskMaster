<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Tasks</h3>
                        <button class="btn btn-primary custom-task-btn btn-sm" data-bs-toggle="modal" data-bs-target="#addTaskModal">Add Task</button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tasksTable" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Start Date</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($tasks)): ?>
                                <?php foreach ($tasks as $task): ?>
                                    <tr data-task-id="<?= $task->id ?>">
                                        <td class="reorder-handle"><?= htmlspecialchars($task->title) ?></td>
                                        <td class="reorder-handle"><?= htmlspecialchars($task->description) ?></td>
                                        <td class="reorder-handle"><?= htmlspecialchars($task->start_date) ?></td>
                                        <td class="reorder-handle"><?= htmlspecialchars($task->end_date) ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm  status-btn 
                                                        <?php
                                                                switch ($task->status) {
                                                                    case 'Not Started':
                                                                        echo 'btn-secondary';
                                                                        break;
                                                                    case 'In Progress':
                                                                        echo 'btn-primary';
                                                                        break;
                                                                    case 'Complete':
                                                                        echo 'btn-success';
                                                                        break;
                                                                    default:
                                                                        echo 'btn-secondary';
                                                                        break;
                                                                }
                                                        ?>
                                                     dropdown-toggle"
                                                    type="button"
                                                    id="statusDropdown<?= $task->id ?>"
                                                    data-bs-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <?= $task->status ?>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="statusDropdown<?= $task->id ?>">
                                                    <a class="dropdown-item update-status" data-id="<?= $task->id ?>" data-status="Not Started">Mark as Not Started</a>
                                                    <a class="dropdown-item update-status" data-id="<?= $task->id ?>" data-status="In Progress">Mark as In Progress</a>
                                                    <a class="dropdown-item update-status" data-id="<?= $task->id ?>" data-status="Complete">Mark as Complete</a>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <!-- Actions -->
                                            <i class="fas fa-edit text-primary editTaskBtn"
                                                data-toggle="modal" data-target="#editTaskModal"
                                                data-id="<?= $task->id ?>"
                                                data-title="<?= htmlspecialchars($task->title) ?>"
                                                data-description="<?= htmlspecialchars($task->description) ?>"
                                                data-start="<?= $task->start_date ?>"
                                                data-end="<?= $task->end_date ?>"
                                                style="cursor: pointer; margin-right: 0.5rem;">
                                            </i>
                                            <i class="fas fa-trash-alt text-danger deleteTaskBtn"
                                                data-id="<?= $task->id ?>"
                                                style="cursor: pointer;"></i>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add Task Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTaskModalLabel">Add Task</h5>
                <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addTaskForm" action="<?= base_url('dashboard/save_task') ?>" method="post">
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control">
                        <div class="invalid-feedback">Please enter a title.</div>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control"></textarea>
                        <div class="invalid-feedback">Please enter a description.</div>
                    </div>
                    <div class="mb-3">
                        <label>Start Date</label>
                        <input type="text" name="start_date" class="form-control datepicker">
                        <div class="invalid-feedback">Please select a start date.</div>
                    </div>
                    <div class="mb-3">
                        <label>Due Date</label>
                        <input type="text" name="end_date" class="form-control datepicker">
                        <div class="invalid-feedback">Please select a due date.</div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary  btn-sm">Save Task</button>
                        <!-- <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button> -->
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Edit Task Modal -->
<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editTaskForm" action="<?= base_url('dashboard/update_task') ?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="task_id" id="edit_task_id" value="<?= $edit_task ? $edit_task->id : '' ?>" />

                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" id="edit_title" class="form-control" value="<?= $edit_task ? htmlspecialchars($edit_task->title) : '' ?>" />
                        <div class="invalid-feedback">Please enter a title.</div>
                    </div>

                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" id="edit_description" class="form-control"><?= $edit_task ? htmlspecialchars($edit_task->description) : '' ?></textarea>
                        <div class="invalid-feedback">Please enter a description.</div>
                    </div>

                    <div class="mb-3">
                        <label>Start Date</label>
                        <input type="text" name="start_date" id="edit_start" class="form-control datepicker" value="<?= $edit_task ? $edit_task->start_date : '' ?>" />
                        <div class="invalid-feedback">Please select a start date.</div>
                    </div>

                    <div class="mb-3">
                        <label>Due Date</label>
                        <input type="text" name="end_date" id="edit_end" class="form-control datepicker" value="<?= $edit_task ? $edit_task->end_date : '' ?>" />
                        <div class="invalid-feedback">Please select a due date.</div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Update Task</button>
                    <!-- <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button> -->
                </div>
            </div>
        </form>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="<?= base_url('assets/js/tasks.js') ?>"></script>
<script>
    var baseUrl = "<?= base_url() ?>";

    var csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash() ?>";
    var editTaskData = <?= !empty($edit_task) ? 'true' : 'false' ?>;
    window.statusUpdateUrl = "<?= base_url('dashboard/update_status') ?>";

    $(document).on('click', '.update-status', function() {
        const taskId = $(this).data('id');
        const status = $(this).data('status');

        $.ajax({
            url: window.statusUpdateUrl,
            type: "POST",
            data: {
                task_id: taskId,
                status: status,
                [csrfName]: csrfHash 
            },
            success: function(response) {
                if (response.trim() === 'success') {
                    toastr.success("Task status updated successfully!");
                    setTimeout(() => location.reload(), 1000);
                } else {
                    toastr.error("Something went wrong!");
                }
            },
            error: function() {
                toastr.error("Failed to update status.");
            }
        });
    });
</script>