<!DOCTYPE html>
<html lang="en">

<head>
    @include('home.css')
</head>

<body>
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
                                        <h2>Packages</h2>
                                    </div>

                                    <!-- Success Message -->
                                    <div class="col-lg-12">
                                        <div id="success-message" style="display: none;" class="alert-custom">
                                            <span><strong>Success!</strong> Package updated successfully.</span>
                                            <button
                                                onclick="document.getElementById('success-message').style.display='none'">&times;</button>
                                        </div>
                                    </div>

                                    <!-- Table for displaying packages -->
                                    <div class="col-lg-12 mt-4">
                                        <table class="table table-bordered" id="packages-table">
                                            <thead>
                                                <tr>
                                                    <th>Package Name</th>
                                                    <th>Monthly Bill (BDT)</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="package-list">
                                                <!-- Package data will be appended here via AJAX -->
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

    <!-- Edit Package Modal -->
    <div id="edit-modal" class="modal" tabindex="-1" aria-labelledby="edit-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-modal-label">Edit Package</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-package-form">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="edit_package_name">Package Name</label>
                            <input type="text" name="package_name" id="edit_package_name" class="form-control"
                                required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_monthly_bill">Monthly Bill (BDT)</label>
                            <input type="number" name="monthly_bill" id="edit_monthly_bill" class="form-control"
                                required>
                        </div>
                        <input type="hidden" id="package_id">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-edit"></i> Update Package
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
                    Are you sure you want to delete this package?
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
        let packageToDelete = null;

        document.addEventListener('DOMContentLoaded', function() {
            fetchPackages();

            function fetchPackages() {
                fetch("{{ url('get_packages') }}")
                    .then(response => response.json())
                    .then(data => {
                        const packageList = document.getElementById('package-list');
                        packageList.innerHTML = '';
                        data.packages.forEach(pkg => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${pkg.name}</td>
                                <td>${pkg.monthly_bill}</td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <button class="btn btn-warning btn-sm" onclick="editPackage(${pkg.id})">Edit</button>
                                        <button class="btn btn-danger btn-sm" onclick="showDeleteModal(${pkg.id})">Delete</button>
                                    </div>
                                </td>
                            `;
                            packageList.appendChild(row);
                        });
                    });
            }

            window.editPackage = function(id) {
                fetch(`/get_package/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        const pkg = data.package;
                        document.getElementById('edit_package_name').value = pkg.name;
                        document.getElementById('edit_monthly_bill').value = pkg.monthly_bill;
                        document.getElementById('package_id').value = pkg.id;
                        new bootstrap.Modal(document.getElementById('edit-modal')).show();
                    });
            };

            document.getElementById('edit-package-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const id = document.getElementById('package_id').value;
                const name = document.getElementById('edit_package_name').value;
                const bill = document.getElementById('edit_monthly_bill').value;
                const token = document.querySelector('input[name="_token"]').value;

                fetch(`/update_package/${id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({
                            package_name: name,
                            monthly_bill: bill
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            fetchPackages();
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
                packageToDelete = id;
                new bootstrap.Modal(document.getElementById('delete-confirm-modal')).show();
            };

            document.getElementById('confirm-delete-btn').addEventListener('click', function() {
                if (!packageToDelete) return;
                const token = document.querySelector('input[name="_token"]').value;

                fetch(`/delete_package/${packageToDelete}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            fetchPackages();
                            bootstrap.Modal.getInstance(document.getElementById('delete-confirm-modal'))
                                .hide();
                        }
                    });
            });
        });
    </script>
</body>

</html>
