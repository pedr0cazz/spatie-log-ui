<head>
    <title>Activity Log</title>
    <!-- Styles Bootstrap 5.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    <style>
        :root {
            --primary-color: #00a69f !important;
            --light-bg-color: #f4f6f9 !important;
            --light-text-color: #333 !important;
        }

        body {
            background-color: var(--light-bg-color) !important;
            font-family: 'Roboto', sans-serif !important;
            color: var(--light-text-color) !important;
        }

        .header {
            background-color: var(--primary-color) !important;
            color: #ffffff !important;
            padding: 20px 0 !important;
            text-align: center !important;
        }


        h1 {
            font-size: 2.5rem !important;
            margin-bottom: 20px !important;
            font-weight: 700 !important;
        }

        .card {
            border: none !important;
            border-radius: 10px !important;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1) !important;
            margin-bottom: 20px !important;
        }

        .card-header {
            background-color: var(--primary-color) !important;
            color: white !important;
            font-weight: bold !important;
            text-align: center !important;
            padding: 15px !important;
            border-radius: 10px 10px 0 0 !important;
            font-size: 1.25rem !important;
        }

        .log-table th {
            background-color: var(--primary-color) !important;
            color: #ffffff !important;
            text-align: center !important;
            vertical-align: middle !important;
            font-size: 1rem !important;
            padding: 15px !important;
        }

        .log-table td {
            text-align: center !important;
            vertical-align: middle !important;
            font-size: 0.95rem !important;
            padding: 12px !important;
        }

        .bg-created {
            background-color: #28a745 !important;
            color: white !important;
            padding: 5px 10px !important;
            border-radius: 5px !important;
        }

        .bg-updated {
            background-color: #ffc107 !important;
            color: white !important;
            padding: 5px 10px !important;
            border-radius: 5px !important;
        }

        .bg-deleted {
            background-color: #dc3545 !important;
            color: white !important;
            padding: 5px 10px !important;
            border-radius: 5px !important;
        }

        .btn-details {
            padding: 10px 20px !important;
            border-radius: 5px !important;
            background-color: var(--primary-color) !important;
            color: white !important;
            border: none !important;
            cursor: pointer !important;
            transition: background-color 0.3s ease, transform 0.2s ease !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 0.95rem !important;
        }

        .btn-details:hover {
            background-color: #008a84 !important;
            transform: scale(1.05) !important;
        }

        .btn-details i {
            margin-right: 5px !important;
        }

        .spinner-border {
            width: 3rem !important;
            height: 3rem !important;
            margin: 50px auto !important;
        }

        .modal-content {}

        .modal-header {
            background-color: var(--primary-color) !important;
            color: white !important;
            border-bottom: none !important;
            border-radius: 5px 5px 0 0 !important;
        }

        .modal-body {
            font-size: 0.9rem !important;
            color: var(--light-text-color) !important;
        }

        .page-link {
            color: var(--primary-color) !important;
        }

        .active .page-link {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: white !important;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Activity Log</h1>
    </div>

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>Logs Overview</h2>
            </div>
            <div class="card-body">
                <table id="log" class="table table-striped table-bordered log-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th data-bs-toggle="tooltip" title="Action performed in the log entry">Action</th>
                            <th data-bs-toggle="tooltip" title="ID of the subject involved">Subject ID</th>
                            <th data-bs-toggle="tooltip" title="Type of subject involved">Subject Type</th>
                            <th data-bs-toggle="tooltip" title="Email of the user who caused the action">Causer Email
                            </th>
                            <th data-bs-toggle="tooltip" title="Type of the causer">Causer Type</th>
                            <th data-bs-toggle="tooltip" title="Date and time when the action was performed">Date</th>
                            <th data-bs-toggle="tooltip" title="Unique identifier for the batch">Batch UUID</th>
                            <th data-bs-toggle="tooltip" title="Available actions for this log entry">Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th><input type="text" class="form-control" placeholder="ID" /></th>
                            <th><input type="text" class="form-control" placeholder="Action" /></th>
                            <th><input type="text" class="form-control" placeholder="Subject ID" /></th>
                            <th><input type="text" class="form-control" placeholder="Subject Type" /></th>
                            <th><input type="text" class="form-control" placeholder="Causer Email" /></th>
                            <th><input type="text" class="form-control" placeholder="Causer Type" /></th>
                            <th><input type="text" class="form-control" placeholder="Date" /></th>
                            <th><input type="text" class="form-control" placeholder="Batch UUID" /></th>
                            <th></th>
                        </tr>

                    </tfoot>
                </table>
            </div>
        </div>
    </div>


    <!-- Modal for Log Details -->
    <div class="modal fade" id="logDetailsModal" tabindex="-1" aria-labelledby="logDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logDetailsModalLabel">Log Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Dynamic content will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts Bootstrap 5.2 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>

    <script>
        $(document).ready(function() {
            const url = "{{ route('spatie_log_ui.get_ajax_log_data') }}";

            // Debounce function to delay the execution of the search
            function debounce(func, wait = 500) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), wait);
                };
            }

            const table = $('#log').DataTable({
                processing: true,
                serverSide: true,
                ajax: url,
                columns: [
                    { data: 'id', visible: true, searchable: true, orderable: true },
                    { data: 'description', render: renderDescription, searchable: true, orderable: true },
                    { data: 'subject_id', searchable: true, orderable: true },
                    { data: 'subject_type', searchable: true, orderable: true },
                    { data: 'causer_id', searchable: true, orderable: true },
                    { data: 'causer_type', searchable: true, orderable: true },
                    { data: 'created_at', searchable: true, orderable: true },
                    { data: 'batch_uuid', searchable: true, orderable: true },
                    { data: 'actions', orderable: false, searchable: false, render: renderActions }
                ],
                order: [
                    [6, "desc"] // Default ordering by 'created_at' column in descending order
                ],
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only"></span></div>',
                },
                drawCallback: function() {
                    $('[data-bs-toggle="popover"]').popover();
                },
                initComplete: function() {
                    // Apply debounce to search
                    this.api().columns().every(function() {
                        var column = this;
                        var input = $('input', this.footer());

                        // Ensure input is not re-initialized
                        if (input.length) {
                            input.on('keyup change clear', debounce(function() {
                                if (column.search() !== this.value) {
                                    column
                                        .search(this.value)
                                        .draw();
                                }
                            }, 500)); // 500ms debounce time
                        }
                    });
                }
            });

            $('#log tbody').on('click', 'td #show', function() {
                const id = $(this).data('id');
                $.ajax({
                    url: "{{ route('spatie_log_ui.get_ajax_log_details') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': @json(csrf_token())
                    },
                    data: {
                        id: id
                    },
                    success: function(data) {
                        const modalBody = $('#logDetailsModal .modal-body');
                        modalBody.html(format(data));
                        $('#logDetailsModal').modal('show');
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            });

            $('[data-bs-toggle="tooltip"]').tooltip();

            function renderDescription(data) {
                let cssClass = '';
                if (data === 'Criado') cssClass = 'bg-created';
                if (data === 'Actualizado') cssClass = 'bg-updated';
                if (data === 'Apagado') cssClass = 'bg-deleted';
                return `<span class="badge ${cssClass}">${data}</span>`;
            }

            function renderActions(data, type, row) {
                return `<button id='show' data-id='${row.id}' class='btn-details' title="Details"><i class="bi bi-info-circle"></i> Details</button>`;
            }
        });
    </script>


</body>
