<!DOCTYPE html>
<html lang="en">
<head>
    @include('home.css')
    <style>
        @media (max-width: 768px) {
            .form-group select,
            #package {
                max-width: 100%;
                width: auto;
                padding: 10px;
                font-size: 16px;
                box-sizing: border-box;
                display: inline-block;
            }
        }
        #package {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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
        
    </style>
</head>
<body>
    @include('home.admin_page_header')

    <div class="main-banner wow fadeIn" id="top" data-wow-duration="1s" data-wow-delay="0.5s">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6 align-self-center">
                            <div class="left-content show-up header-text wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1s">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h2>Add Customer</h2>
                                    </div>
                                    <div class="col-lg-12">
                                        <div id="success-message" style="display: none;" class="alert-custom">
                                            <span><strong>Success!</strong> Customer added successfully.</span>
                                            <button onclick="document.getElementById('success-message').style.display='none'">&times;</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mt-4">
                                        <form id="add-customer-form">
                                            @csrf
                                            <div class="form-group mb-3">
                                                <label for="user_name">User Name</label>
                                                <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Enter user name" required>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="user_id">User ID</label>
                                                <input type="text" name="user_id" id="user_id" class="form-control" placeholder="Enter user ID" required>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="phone">Phone</label>
                                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter phone number" required>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="address">Address</label>
                                                <input type="text" name="address" id="address" class="form-control" placeholder="Enter address" required>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="package">Package</label>                                           
                                                <select name="package" id="package" class="form-control" required>
                                                    <option value="">Select Package</option>
                                                </select>                                       
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="starting_date">Starting Date</label>
                                                <input type="date" name="starting_date" id="starting_date" class="form-control" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-plus-circle"></i> Add Customer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="right-image wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.5s">
                                <img src="{{ asset('assets/images/slider-dec.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('home.footer')
    @include('home.script')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch("{{ url('get_packages') }}")
                .then(response => response.json())
                .then(data => {
                    const select = document.getElementById('package');
                    data.packages.forEach(pkg => {
                        const option = document.createElement('option');
                        option.value = pkg.id;
                        option.textContent = `${pkg.name} ${pkg.monthly_bill}tk`;
                        select.appendChild(option);
                    });
                });

            document.getElementById('add-customer-form').addEventListener('submit', function (e) {
                e.preventDefault();

                const payload = {
                    user_name: document.getElementById('user_name').value,
                    user_id: document.getElementById('user_id').value,
                    phone: document.getElementById('phone').value,
                    address: document.getElementById('address').value,
                    package_id: document.getElementById('package').value,
                    starting_date: document.getElementById('starting_date').value
                };

                fetch("{{ url('add_user') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify(payload)
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById('add-customer-form').reset();
                        const alertBox = document.getElementById('success-message');
                        alertBox.style.display = 'flex';
                        setTimeout(() => {
                            alertBox.style.transition = "opacity 0.5s ease-out";
                            alertBox.style.opacity = 0;
                            setTimeout(() => {
                                alertBox.style.display = 'none';
                                alertBox.style.opacity = 1;
                            }, 500);
                        }, 5000);
                    }
                })
                .catch(err => {
                    alert("Failed to add customer.");
                    console.error(err);
                });
            });
        });
    </script>
</body>
</html>
