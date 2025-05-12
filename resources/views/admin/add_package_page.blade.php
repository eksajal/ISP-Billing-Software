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
    </style>

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
                                        <h2>Add Package</h2>
                                    </div>

                                    <div class="col-lg-12">
                                        <div id="success-message" style="display: none;" class="alert-custom">
                                            <span><strong>Success!</strong> Package added successfully.</span>
                                            <button onclick="document.getElementById('success-message').style.display='none'">&times;</button>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mt-4">
                                        <form id="add-package-form">
                                            @csrf
                                            <div class="form-group mb-3">
                                                <label for="package_name">Package Name</label>
                                                <input type="text" name="package_name" id="package_name" class="form-control" placeholder="Enter package name" required>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="monthly_bill">Monthly Bill (BDT)</label>
                                                <input type="number" name="monthly_bill" id="monthly_bill" class="form-control" placeholder="Enter monthly bill" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-plus-circle"></i> Add Package
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="right-image wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.5s">
                                <img src="assets/images/slider-dec.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('home.footer')
    @include('home.script')

    <!-- AJAX Script -->
    <script>
        document.getElementById('add-package-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const packageName = document.getElementById('package_name').value;
            const monthlyBill = document.getElementById('monthly_bill').value;
            const token = document.querySelector('input[name="_token"]').value;

            fetch("{{ url('add_package') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({
                    package_name: packageName,
                    monthly_bill: monthlyBill
                })
            })
            .then(response => {
                if (!response.ok) throw new Error("Error");
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('add-package-form').reset();
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
                alert("Failed to add package.");
                console.error(err);
            });
        });
    </script>
</body>

</html>
