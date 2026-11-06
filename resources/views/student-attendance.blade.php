@extends('layouts.student-app')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">My Attendance Record</h2>

    @if($student)
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded mb-6">
            <strong>Welcome:</strong> {{ $student->first_name }} {{ $student->last_name }}
        </div>

        @if($records->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                            <th class="p-4 rounded-tl-lg">Date</th>
                            <th class="p-4 rounded-tr-lg">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($records as $record)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 text-gray-600">{{ \Carbon\Carbon::parse($record->date)->format('F d, Y') }}</td>
                                <td class="p-4">
                                    @if($record->status === 'Present')
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold">Present</span>
                                    @elseif($record->status === 'Absent')
                                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-bold">Absent</span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold">Late</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-10">No attendance records found yet.</p>
        @endif
    @else
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
            Student profile not found. Please contact the Admin.
        </div>
    @endif
</div>
@endsection