@extends('layouts.parent-app')
@section('content')
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-2xl font-bold mb-4">Attendance Record</h2>
    @if($records->count() > 0)
        <table class="w-full text-left">
            <thead class="bg-gray-100"><tr><th class="p-3">Date</th><th class="p-3">Status</th></tr></thead>
            <tbody>
                @foreach($records as $record)
                    <tr class="border-b">
                        <td class="p-3">{{ $record->date }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded text-xs font-bold {{ $record->status === 'Present' ? 'bg-green-100 text-green-800' : ($record->status === 'Absent' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ $record->status }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-gray-500">No attendance records yet.</p>
    @endif
</div>
@endsection