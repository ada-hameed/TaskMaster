$(document).ready(function () {
	// Flatpickr
	flatpickr(".datepicker", {
		dateFormat: "Y-m-d",
		altInput: true,
		altFormat: "d-m-Y",
	});

	if (typeof editTaskData !== "undefined" && editTaskData) {
		var myModal = new bootstrap.Modal(document.getElementById("editTaskModal"));
		myModal.show();
	}

	// DataTable init
	var table = $("#tasksTable").DataTable({
		responsive: true,
		lengthChange: true,
		autoWidth: false,
		paging: true,
		searching: true,
		info: true,
		order: [],
		rowReorder: {
			selector: "td.reorder-handle",
			update: false,
		},
		columnDefs: [
			{
				orderable: false,
				targets: [0, 5],
			},
		],
		dom: '<"d-flex justify-content-between mb-2"Bf>rt<"d-flex justify-content-between mt-2"ip>',
		buttons: [
			{
				extend: "copy",
				text: '<i class="fas fa-copy me-1"></i> Copy',
				className: "btn btn-sm btn-outline-secondary",
			},
			{
				extend: "csv",
				text: '<i class="fas fa-file-csv me-1"></i> CSV',
				className: "btn btn-sm btn-outline-secondary",
			},
			{
				extend: "excel",
				text: '<i class="fas fa-file-excel me-1"></i> Excel',
				className: "btn btn-sm btn-outline-success",
			},
			{
				extend: "pdf",
				text: '<i class="fas fa-file-pdf me-1"></i> PDF',
				className: "btn btn-sm btn-outline-danger",
			},
			{
				extend: "print",
				text: '<i class="fas fa-print me-1"></i> Print',
				className: "btn btn-sm btn-outline-primary",
			},
		],
		language: {
			search: "Search:",
			lengthMenu: "Show _MENU_ entries",
			zeroRecords: "No matching tasks found",
			info: "Showing _START_ to _END_ of _TOTAL_ tasks",
			infoEmpty: "No tasks available",
			infoFiltered: "(filtered from _MAX_ total tasks)",
		},
	});

	// Row reorder save
	table.on("row-reorder", function (e, diff) {
		if (diff.length === 0) return;

		const orderData = diff.map((item) => $(item.node).data("task-id"));

		$.ajax({
			url: baseUrl + "dashboard/update_task_order",
			type: "POST",
			data: {
				order: orderData,
				[csrfName]: csrfHash,
			},
			dataType: "json",
			success: function (res) {
				if (res.status !== "success") {
					toastr.error("Update failed: " + (res.message || "Unknown error"));
				}
			},
			error: function (xhr, status, error) {
				toastr.error("Server error while updating order");
			},
		});
	});

	// Edit button click
	$(".editTaskBtn").click(function () {
		$("#edit_task_id").val($(this).data("id"));
		$("#edit_title").val($(this).data("title"));
		$("#edit_description").val($(this).data("description"));
		$("#edit_start").val($(this).data("start"));
		$("#edit_end").val($(this).data("end"));
		$("#edit_status").val($(this).data("status") || "Not Started");

		flatpickr("#edit_start", {
			dateFormat: "Y-m-d",
			altInput: true,
			altFormat: "d-m-Y",
		});
		flatpickr("#edit_end", {
			dateFormat: "Y-m-d",
			altInput: true,
			altFormat: "d-m-Y",
		});

		new bootstrap.Modal(document.getElementById("editTaskModal")).show();
	});

	// Delete button click
	$(document).on("click", ".deleteTaskBtn", function () {
		const taskId = $(this).data("id");

		Swal.fire({
			title: "Delete task?",
			text: "This action cannot be undone!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Yes, delete it!",
		}).then((result) => {
			if (result.isConfirmed) {
				window.location.href = baseUrl + "dashboard/delete_task/" + taskId;
			}
		});
	});

	// Common form validation
	function validateForm(formId) {
		let isValid = true;
		$(`#${formId} input, #${formId} textarea`).each(function () {
			let value = $(this).val().trim();
			if (value === "") {
				$(this).addClass("is-invalid");
				isValid = false;
			} else {
				$(this).removeClass("is-invalid");
			}
		});
		return isValid;
	}

	$("#addTaskForm").on("submit", function (e) {
		if (!validateForm("addTaskForm")) e.preventDefault();
	});

	$("#editTaskForm").on("submit", function (e) {
		if (!validateForm("editTaskForm")) e.preventDefault();
	});
	$("#addTaskModal, #editTaskModal").on("hidden.bs.modal", function () {
		$(this).find("input, textarea").removeClass("is-invalid");
		$(this).find("form")[0].reset();
	});
});
