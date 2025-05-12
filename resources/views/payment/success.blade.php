<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }

        .alert-success h3 {
            font-size: 2.5rem;
        }

        .alert-success p {
            font-size: 1.1rem;
        }

        .btn-primary {
            font-size: 1.1rem;
            padding: 10px 20px;
        }

        @media (max-width: 576px) {
            .alert-success h3 {
                font-size: 2rem;
            }

            .alert-success p {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="alert alert-success">
        <h3>Payment Successful!</h3>
        <p>Your payment was successfully processed.</p>
        <p>Transaction ID: {{ Session::get('transaction_id') }}</p>
        <a href="{{ url('/') }}" class="btn btn-primary mt-3">Go Back to Homepage</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
