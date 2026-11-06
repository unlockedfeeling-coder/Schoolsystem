<div>
    <!-- Back Button -->
    <a href="/students" class="inline-flex items-center text-gray-600 hover:text-blue-600 mb-6 transition">
        <i class="fas fa-arrow-left mr-2"></i> Back to Students List
    </a>

    <!-- Profile Header Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6 flex flex-col md:flex-row items-start md:items-center gap-6">
        <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-blue-500 to-purple-500 flex items-center justify-center text-white text-3xl font-bold shadow-md">
            {{ strtoupper(substr($student->first_name, 0, 1)) }}{{ strtoupper(substr($student->last_name, 0, 1)) }}
        </div>
        <div class="flex-1">
            <h1 class="text-2xl font-bold text-gray-800">{{ $student->first_name }} {{ $student->last_name }}</h1>
            <p class="text-gray-500">Admission #: <span class="font-semibold text-gray-700">{{ $student->admission_number }}</span></p>
            <div class="flex gap-3 mt-2">
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-bold">{{ $student->classLevel->name ?? 'No Class' }}</span>
                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-bold">{{ $student->section->name ?? 'No Section' }}</span>
            </div>
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-500">Parent Contact</p>
            <p class="font-semibold text-gray-800"><i class="fas fa-phone mr-2 text-blue-500"></i>{{ $student->parent_phone ?? 'N/A' }}</p>
            <p class="font-semibold text-gray-800"><i class="fas fa-envelope mr-2 text-blue-500"></i>{{ $student->parent_email ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Attendance Card -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center"><i class="fas fa-clipboard-check text-green-500 mr-2"></i> Attendance</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Present</span>
                    <span class="font-bold text-green-600">{{ $attendanceStats['Present'] ?? 0 }} Days</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Absent</span>
                    <span class="font-bold text-red-600">{{ $attendanceStats['Absent'] ?? 0 }} Days</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Late</span>
                    <span class="font-bold text-yellow-600">{{ $attendanceStats['Late'] ?? 0 }} Days</span>
                </div>
            </div>
        </div>

        <!-- Academic Card -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center"><i class="fas fa-graduation-cap text-blue-500 mr-2"></i> Recent Exams</h3>
            @if($exams->count() > 0)
                <div class="space-y-3">
                    @foreach($exams as $exam)
                        <div class="flex justify-between items-center border-b border-gray-100 pb-2 last:border-0">
                            <span class="text-gray-600 text-sm">{{ $exam->subject->name ?? 'Unknown' }} ({{ $exam->exam_type }})</span>
                            <span class="font-bold text-blue-600">{{ $exam->marks }}/100</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 text-sm">No exam records yet.</p>
            @endif
        </div>

        <!-- Finance Card -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center"><i class="fas fa-money-bill-wave text-purple-500 mr-2"></i> Fee Status</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total Billed</span>
                    <span class="font-bold text-gray-800">${{ number_format($totalFees, 2) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total Paid</span>
                    <span class="font-bold text-green-600">${{ number_format($paidFees, 2) }}</span>
                </div>
                <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                    <span class="text-gray-800 font-semibold">Balance Due</span>
                    <span class="font-bold text-red-600 text-lg">${{ number_format($totalFees - $paidFees, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Fees Table -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Fee History</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider">
                        <th class="p-3 rounded-l-lg">Due Date</th>
                        <th class="p-3">Amount</th>
                        <th class="p-3">Status</th>
                        <th class="p-3 rounded-r-lg">Paid Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($fees as $fee)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3">{{ $fee->due_date }}</td>
                            <td class="p-3 font-semibold">${{ number_format($fee->amount, 2) }}</td>
                            <td class="p-3">
                                @if($fee->status === 'Paid')
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-bold">PAID</span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-bold">PENDING</span>
                                @endif
                            </td>
                            <td class="p-3 text-gray-500">{{ $fee->paid_date ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="p-4 text-center text-gray-400">No fee records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>