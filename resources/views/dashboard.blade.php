@extends('layouts.app')

@section('content')
<main class="main">
    <div class="responsive-wrapper">

        <div class="main-header">
            <h1>Dashboard</h1>
        </div>

        <div class="row mt-5">

            <!-- TOTAL TRANSACTIONS -->
            <div class="col-12 col-md-4 mb-3">
                <div class="card shadow p-3">
                    <div class="card-body">
                        <h4 class="mb-3 text-uppercase fw-lighter">Total Transactions</h4>
                        <h1>{{ $data['total_count'] ?? 0 }}</h1>
                    </div>
                </div>
            </div>

            <!-- TOTAL PAID -->
            <div class="col-12 col-md-4 mb-3">
                <div class="card shadow p-3">
                    <div class="card-body">
                        <h4 class="mb-3 text-uppercase fw-lighter">Paid Amount</h4>
                        <h1>₱{{ number_format($data['total_paid'] ?? 0, 2) }}</h1>
                    </div>
                </div>
            </div>

            <!-- TOTAL AMOUNT -->
            <div class="col-12 col-md-4 mb-3">
                <div class="card shadow p-3">
                    <div class="card-body">
                        <h4 class="mb-3 text-uppercase fw-lighter">Total Amount</h4>
                        <h1>₱{{ number_format($data['total_amount'] ?? 0, 2) }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <hr class="mt-3 mb-3">
            <p class="text-uppercase text-muted fw-bold">
                Updated:
                <span class="text-decoration-underline fst-italic">
                    {{ \Carbon\Carbon::now()->format('F d, Y \a\t h:i A') }}
                </span>
            </p>
        </div>

        <!-- PAYMENT METHOD SUMMARY -->
        <div class="row">

            @foreach($data['payment_method_count'] as $method => $count)
                <div class="col-12 col-md-4 mb-3">
                    <div class="card shadow p-3">
                        <div class="card-body">
                            <h4 class="mb-3 text-uppercase fw-lighter">{{ ucfirst($method) }} Payments</h4>
                            <h1>{{ $count }}</h1>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

    </div>
</main>
@endsection
