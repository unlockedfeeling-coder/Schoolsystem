@extends('layouts.parent-app')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Fees & Financials</h2>

    @if($child)
        <div class="bg-purple-50 border-l-4 border-purple-500 text-purple-700 p-4 rounded mb-6">
            <strong>Student:</strong> {{ $child->first_name }} {{ $child->last_name }} ({{ $child->admission_number }})
        </div>

        <!-- Financial Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
                <h3 class="text-blue-800 font-bold mb-2 text-sm uppercase">Total Required</h3>
                <p class="text-3xl font-bold text-blue-900">GHS {{ number_format($totalRequired, 2) }}</p>
            </div>
            <div class="bg-green-50 p-6 rounded-xl border border-green-100">
                <h3 class="text-green-800 font-bold mb-2 text-sm uppercase">Total Paid</h3>
                <p class="text-3xl font-bold text-green-900">GHS {{ number_format($totalPaid, 2) }}</p>
            </div>
            <div class="bg-red-50 p-6 rounded-xl border border-red-100">
                <h3 class="text-red-800 font-bold mb-2 text-sm uppercase">Outstanding Balance</h3>
                <p class="text-3xl font-bold text-red-900">GHS {{ number_format($balance, 2) }}</p>
            </div>
        </div>

        <!-- Payment History Table -->
        <h3 class="text-xl font-bold text-gray-800 mb-4">Payment History</h3>
        @if($payments->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                            <th class="p-4 rounded-tl-lg">Date</th>
                            <th class="p-4">Fee Type</th>
                            <th class="p-4">Method</th>
                            <th class="p-4">Amount Paid</th>
                            <th class="p-4 rounded-tr-lg">Receipt</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($payments as $payment)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 text-gray-600">{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</td>
                                <td class="p-4 font-bold text-gray-800">{{ $payment->feeType->name }}</td>
                                <td class="p-4 text-gray-600">{{ $payment->payment_method }}</td>
                                <td class="p-4 font-bold text-green-600">GHS {{ number_format($payment->amount_paid, 2) }}</td>
                                <td class="p-4">
                                    <a href="/parent/fees/{{ $payment->id }}/receipt" target="_blank" class="bg-red-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-red-700 transition">
                                        <i class="fas fa-file-pdf mr-1"></i> Download
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-yellow-50 border border-yellow-200 p-6 rounded-lg text-center text-yellow-700">
                No payments have been recorded for this term yet.
            </div>
        @endif
    @else
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
            No child is currently linked to your account.
        </div>
    @endif
</div>
@endsection