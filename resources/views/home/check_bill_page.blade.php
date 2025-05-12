<!DOCTYPE html>
<html lang="en">

<head>
    @include('home.css')
    <!-- Font Awesome for dropdown icon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* This ensures the navbar is fixed at the top with proper z-index to stay above content */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030; /* Ensure navbar is above content */
        }

        /* Add padding to the content below the navbar to avoid overlap */
        .form-section {
            padding-top: 80px; /* Adjust this value based on your navbar height */
        }

        .dropdown-wrapper {
            position: relative;
        }

        .dropdown-wrapper select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        .dropdown-wrapper .fa-chevron-down {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            pointer-events: none;
            color: #6c757d;
        }

        .alert {
            margin-top: 20px; /* Ensure space between navbar and notification */
            max-width: 500px;
            width: 100%;
            margin-left: auto;
            margin-right: auto;
            padding: 20px;
            font-weight: bold;
            font-size: 1.1rem;
            text-align: center;
            border-radius: 8px;
        }

        .alert-success {
            background-color: #4CAF50;
            color: white;
            box-shadow: 0 4px 8px rgba(0, 128, 0, 0.3);
        }

        .alert-danger {
            background-color: #f44336;
            color: white;
            box-shadow: 0 4px 8px rgba(255, 0, 0, 0.3);
        }

        /* Modal styling */
        .modal-content {
            border-radius: 12px;
        }

        .modal-header {
            background-color: #f44336;
            color: white;
        }

        .modal-body {
            font-size: 1.2rem;
            font-weight: bold;
            text-align: center;
            padding: 30px;
        }

        .btn-close {
            color: white;
        }

        /* Custom modal positioning */
        .modal-dialog {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Ensure modal is centered vertically */
        }
    </style>
</head>

<body>

    @include('home.header') {{-- Your navbar is included here --}}

    <!-- Form Section: This will have padding to separate it from the fixed navbar -->
    <section class="form-section">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="p-4 shadow-sm rounded bg-white">
                        <h3 class="mb-4 text-center">Pay Your ISP Bill</h3>

                        {{-- Notification Section: Show bill status --}}
                        @if(isset($isPaid))
                            <div class="alert {{ $isPaid ? 'alert-success' : 'alert-danger' }} text-center mb-4 rounded shadow-sm">
                                {{ $isPaid ? '✅ Your bill has been paid.' : '❌ Your bill is unpaid.' }}
                            </div>
                        @endif

                        {{-- First Form --}}
                        <form id="userForm">
                            <div class="mb-3">
                                <label class="form-label">User Name</label>
                                <input type="text" class="form-control" value="{{ $customer->user_name }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" class="form-control" value="{{ $customer->phone }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" value="{{ $customer->address }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Billing Month</label>
                                <div class="dropdown-wrapper">
                                    <select class="form-select" name="month" form="bkashForm">
                                        @foreach ($months as $m)
                                            <option value="{{ $m }}" {{ $m === $currentMonth ? 'selected' : '' }}>
                                                {{ $m }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Package Name</label>
                                <input type="text" class="form-control" value="{{ $customer->package->name ?? 'N/A' }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Bill Amount (৳)</label>
                                <input type="text" class="form-control" value="{{ $customer->package->monthly_bill ?? 'N/A' }}" readonly>
                            </div>

                            {{-- Display bKash Payment Button only if the bill is unpaid --}}
                            @if(!$isPaid)
                                <div class="d-grid">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#bkashModal">bKash Payment</button>
                                </div>
                            @endif
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Modal for bKash Payment --}}
    <div class="modal fade" id="bkashModal" tabindex="-1" aria-labelledby="bkashModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bkashModalLabel">bKash Payment Not Available</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>bKash Payment is not available right now. Please contact us for further assistance.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @include('home.footer')
    @include('home.script')

    <!-- Bootstrap JS (for modal functionality) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
