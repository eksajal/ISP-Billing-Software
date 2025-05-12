
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="p-4 shadow-sm rounded bg-white">
                <h3 class="mb-4 text-center">Pay Your ISP Bill</h3>

                <form action="{{ route('bkash.payment') }}" method="POST" id="bkashForm" class="mt-4">
                    @csrf
                    <h5 class="text-center mb-3">Enter bKash Number</h5>

                    <div class="mb-3">
                        <label class="form-label">bKash Number</label>
                        <input type="text" name="bkash_number" class="form-control" placeholder="01XXXXXXXXX" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Confirm Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

