<!DOCTYPE html>
<html lang="en">

<head>
    @include('home.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        @media (max-width: 768px) {
            .nav {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
            }

            .nav li,
            .nav .gradient-button {
                width: 100%;
                margin-bottom: 10px;
            }

            .nav .gradient-button a {
                display: block;
                width: 100%;
                text-align: center;
                padding: 10px;
            }

            table td,
            table th {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            table {
                width: 100%;
                font-size: 12px;
            }
        }

        .gradient-button {
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .alert-custom {
            background-color: #d1e7dd;
            color: #0f5132;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .alert-custom button {
            background: none;
            border: none;
            font-weight: bold;
            font-size: 18px;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        table td,
        table th {
            text-align: center;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    @include('home.admin_page_header')

    <div class="main-banner wow fadeIn" id="top" data-wow-duration="1s" data-wow-delay="0.5s">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12 align-self-center">
                            <div class="left-content show-up header-text wow fadeInLeft" data-wow-duration="1s"
                                data-wow-delay="1s">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h2>Bill History</h2>
                                    </div>

                                    <div class="col-lg-12">
                                        <div id="success-message" style="display: none;" class="alert-custom">
                                            <span><strong>Success!</strong> Action completed successfully.</span>
                                            <button
                                                onclick="document.getElementById('success-message').style.display='none'">&times;</button>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mt-4">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="bills-table">
                                                <thead>
                                                    <tr>
                                                        <th>Customer</th>
                                                        <th>Phone</th>
                                                        <th>Month</th>
                                                        <th>Amount</th>
                                                        <th>Paid?</th>
                                                        <th class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="bill-history-list">
                                                    <!-- Bill data loaded via AJAX -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('home.footer')
    @include('home.script')

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="mb-0">Are you sure you want to delete this bill?</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger px-4" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- SMS Alert Modal -->
    <div class="modal fade" id="smsModal" tabindex="-1" aria-labelledby="smsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="smsModalLabel">SMS Feature Notice</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="mb-0">The SMS feature is under development. Stay tuned for updates!</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-info text-white px-4" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Section -->
    <script>
        let billToDelete = null;

        document.addEventListener('DOMContentLoaded', function () {
            fetchBillHistory();

            function fetchBillHistory() {
                fetch("{{ url('get_bills') }}")
                    .then(response => response.json())
                    .then(data => {
                        const billHistoryList = document.getElementById('bill-history-list');
                        billHistoryList.innerHTML = '';
                        data.bills.forEach(bill => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${bill.customer_name}</td>
                                <td>${bill.customer_phone}</td>
                                <td>${bill.month}</td>
                                <td>৳${bill.amount}</td>
                                <td>${bill.is_paid ? '<span class="badge bg-success">Paid</span>' : '<span class="badge bg-danger">Unpaid</span>'}</td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <button class="btn btn-warning btn-sm" onclick="sendSms(${bill.id})">Send SMS</button>
                                        <button class="btn btn-info btn-sm" onclick="changeStatus(${bill.id})">Change Status</button>
                                        <button class="btn btn-danger btn-sm" onclick="prepareDeleteBill(${bill.id})">Delete</button>
                                    </div>
                                </td>
                            `;
                            billHistoryList.appendChild(row);
                        });
                    });
            }

            window.sendSms = function (id) {
                $('#smsModal').modal('show');
            };

            window.changeStatus = function (id) {
                fetch(`/change_status/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        fetchBillHistory();
                        showSuccess();
                    }
                });
            };

            window.prepareDeleteBill = function (id) {
                billToDelete = id;
                $('#deleteModal').modal('show');
            };

            document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
                if (billToDelete !== null) {
                    fetch(`/delete_bill/${billToDelete}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            fetchBillHistory();
                            showSuccess();
                            $('#deleteModal').modal('hide');
                        }
                    });
                }
            });

            function showSuccess() {
                const msg = document.getElementById('success-message');
                msg.style.display = 'flex';
                setTimeout(() => {
                    msg.style.opacity = 0;
                    setTimeout(() => {
                        msg.style.display = 'none';
                        msg.style.opacity = 1;
                    }, 500);
                }, 5000);
            }
        });
    </script>
</body>

</html>
