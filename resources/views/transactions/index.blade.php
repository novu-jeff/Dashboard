@extends('layouts.app')

@section('content')

@php
    function sortLink($label, $column) {
        $currentSort = request('sort_by');
        $currentDir = request('sort_dir', 'asc');

        $newDir = ($currentSort === $column && $currentDir === 'asc') ? 'desc' : 'asc';

        $arrow = '';
        if ($currentSort === $column) {
            $arrow = $currentDir === 'asc' ? '↑' : '↓';
        }

        return '<a href="?'.http_build_query(array_merge(request()->query(), [
            'sort_by' => $column,
            'sort_dir' => $newDir
        ])).'" class="fw-bold">'. $label . ' ' . $arrow .'</a>';
    }
@endphp


<div class="p-6">
    <div class="d-flex flex-row ps-5 mt-3 justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">TRANSACTIONS</h1>

        <a href="{{ route('admin.transactions.download') }}"
        class=" ms-3 text-center px-2 py-0 rounded d-flex align-items-center">
            <i class="bx bx-download py-0 me-1"></i>
            Download Report
        </a>
    </div>

    <form method="GET" class="mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">

    <div class="flex-grow-1 position-relative" style="max-width: 350px;">
        <input
            type="text"
            id="searchInput"
            name="search"
            class="form-control ms-4"
            placeholder="🔎 reference no | account no | client name"
            value="{{ request('search') }}"
            style="padding-right: 2rem;"
        />

        <span
            id="clearSearch"
            style="
                position: absolute;
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
                cursor: pointer;
                font-size: 1.2rem;
                color: #888;
                display: none;
            "
        >
            &times;
        </span>
    </div>

        <!-- Per Page -->
        <div class="d-flex align-items-center me-4">
            <label class="me-2 fw-bold">Show:</label>
            <select name="per_page" onchange="this.form.submit()" class="form-select w-auto">
                @foreach ([10, 25, 50, 100] as $size)
                    <option value="{{ $size }}" {{ request('per_page', 20) == $size ? 'selected' : '' }}>
                        {{ $size }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    <div class="bg-white shadow rounded p-4" id="transactions-wrapper">
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100 mt-3">
                <thead class="bg-gray-100">
                    <tr>
                        <th>#</th>
                        <th>{!! sortLink('Reference No', 'reference_no') !!}</th>
                        <th>{!! sortLink('Account No', 'account_no') !!}</th>
                        <th>{!! sortLink('Client Name', 'client_name') !!}</th>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    const searchInput = $('#searchInput');
    const clearSearch = $('#clearSearch');
    let searchTimer;

    function fetchTransactions(query, page = 1) {
        let params = new URLSearchParams(window.location.search);

        if (query) {
            params.set('search', query);
        } else {
            params.delete('search');
        }

        params.set('page', page); // handle pagination
        $.get(window.location.pathname + '?' + params.toString(), function (data) {
            const newContent = $(data).find('#transactions-wrapper').html();
            $('#transactions-wrapper').html(newContent);
            bindPaginationLinks(query);
        });
    }

    function bindPaginationLinks(query) {
        $('.pagination a').on('click', function (e) {
            e.preventDefault();
            const url = new URL($(this).attr('href'));
            const page = url.searchParams.get('page');
            fetchTransactions(query, page);
        });
    }

    // Show × if input has value on load
    if (searchInput.val().trim() !== '') clearSearch.show();

    searchInput.on('keyup', function () {
        clearTimeout(searchTimer);
        const val = searchInput.val().trim();
        clearSearch.toggle(!!val);

        searchTimer = setTimeout(() => {
            fetchTransactions(val);
        }, 400);
    });

    clearSearch.on('click', function () {
        searchInput.val('');
        clearSearch.hide();
        fetchTransactions('');
    });

    // Initial bind for pagination links
    bindPaginationLinks(searchInput.val().trim());
});
</script>
