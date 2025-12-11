@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="d-flex flex-row ps-5 mt-3 justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">TRANSACTIONS</h1>

        <a href="{{ route('admin.transactions.download') }}"
        class=" ms-3 text-center px-2 py-0 rounded d-flex align-items-center">
            <i class="bx bx-download py-0 me-1"></i>
            Download Report
        </a>
    </div>

    <div class="bg-white shadow rounded p-4">
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100 mt-3">
                <thead class="bg-gray-100">
                    <tr>
                        <th>#</th>
                        <th>Reference No</th>
                        <th>Account No</th>
                        <th>Client Name</th>
                        <th>Amount</th>
                        <th>Fee</th>
                        <th>Net</th>
                        <th>Gateway</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $index => $t)
                        <tr>
                            <td>{{ $index + $transactions->firstItem() }}</td>
                            <td>{{ $t->reference_no }}</td>
                            <td>{{ $t->account->account_no ?? 'N/A' }}</td>
                            <td>{{ $t->account->user->name ?? 'N/A' }}</td>
                            <td>₱{{ number_format($t->amount, 2) }}</td>
                            <td>₱{{ number_format($t->fee, 2) }}</td>
                            <td>₱{{ number_format($t->net_amount, 2) }}</td>
                            <td>{{ strtoupper($t->payment_method) }}</td>
                            <td>{{ \Carbon\Carbon::parse($t->paid_at)->format('M d, Y h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12">
                                <div class="text-center text-uppercase fw-bold py-3">
                                    No Data Found
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $transactions->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>

@endsection
