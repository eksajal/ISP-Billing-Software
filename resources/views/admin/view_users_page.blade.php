<!DOCTYPE html>
<html lang="en">

<head>
    @include('home.css')
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
                                        <h2>Customers</h2>
                                    </div>

                                    <!-- Success Message -->
                                    <div class="col-lg-12">
                                        <div id="success-message" style="display: none;" class="alert-custom">
                                            <span><strong>Success!</strong> Customer updated successfully.</span>
                                            <button
                                                onclick="document.getElementById('success-message').style.display='none'">&times;</button>
                                        </div>
                                    </div>

                                    <!-- Table for displaying customers -->
                                    <div class="col-lg-12 mt-4">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="customers-table">
                                                <thead>
                                                    <tr>
                                                        <th>User Name</th>
                                                        <th>Phone</th>
                                                        <th>Address</th>
                                                        <th>Starting Date</th>
                                                        <th>Package</th>
                                                        <th class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="customer-list">
                                                    <!-- Customer data will be appended here via AJAX -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Customer Modal -->
    <div id="edit-modal" class="modal" tabindex="-1" aria-labelledby="edit-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-modal-label">Edit Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-customer-form">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="edit_user_name">User Name</label>
                            <input type="text" name="user_name" id="edit_user_name" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_phone">Phone</label>
                            <input type="text" name="phone" id="edit_phone" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_address">Address</label>
                            <input type="text" name="address" id="edit_address" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_starting_date">Starting Date</label>
                            <input type="date" name="starting_date" id="edit_starting_date" class="form-control" required>
                        </div>
                        <input type="hidden" id="customer_id">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-edit"></i> Update Customer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="delete-confirm-modal" tabindex="-1" aria-labelledby="deleteConfirmLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this customer?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirm-delete-btn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    @include('home.footer')
    @include('home.script')

    <!-- AJAX Script -->
    <script>
        let customerToDelete = null;

        document.addEventListener('DOMContentLoaded', function() {
            fetchCustomers();

            function fetchCustomers() {
                fetch("{{ url('get_customers') }}")
                    .then(response => response.json())
                    .then(data => {
                        const customerList = document.getElementById('customer-list');
                        customerList.innerHTML = '';
                        data.customers.forEach(customer => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${customer.user_name}</td>
                                <td>${customer.phone}</td>
                                <td>${customer.address}</td>
                                <td>${customer.starting_date}</td>
                                <td>${customer.package_name}</td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <button class="btn btn-warning btn-sm" onclick="editCustomer(${customer.id})">Edit</button>
                                        <button class="btn btn-danger btn-sm" onclick="showDeleteModal(${customer.id})">Delete</button>
                                    </div>
                                </td>
                            `;
                            customerList.appendChild(row);
                        });
                    });
            }

            window.editCustomer = function(id) {
                fetch(`/get_customer/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        const customer = data.customer;
                        document.getElementById('edit_user_name').value = customer.user_name;
                        document.getElementById('edit_phone').value = customer.phone;
                        document.getElementById('edit_address').value = customer.address;
                        document.getElementById('edit_starting_date').value = customer.starting_date;
                        document.getElementById('customer_id').value = customer.id;
                        new bootstrap.Modal(document.getElementById('edit-modal')).show();
                    });
            };

            document.getElementById('edit-customer-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const id = document.getElementById('customer_id').value;
                const user_name = document.getElementById('edit_user_name').value;
                const phone = document.getElementById('edit_phone').value;
                const address = document.getElementById('edit_address').value;
                const starting_date = document.getElementById('edit_starting_date').value;
                const token = document.querySelector('input[name="_token"]').value;

                fetch(`/update_customer/${id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({
                            user_name: user_name,
                            phone: phone,
                            address: address,
                            starting_date: starting_date
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            fetchCustomers();
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
            });

            window.showDeleteModal = function(id) {
                customerToDelete = id;
                new bootstrap.Modal(document.getElementById('delete-confirm-modal')).show();
            };

            document.getElementById('confirm-delete-btn').addEventListener('click', function() {
                if (!customerToDelete) return;
                const token = document.querySelector('input[name="_token"]').value;

                fetch(`/delete_customer/${customerToDelete}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            fetchCustomers();
                            bootstrap.Modal.getInstance(document.getElementById('delete-confirm-modal'))
                                .hide();
                        }
                    });
            });
        });
    </script>
</body>

</html>
