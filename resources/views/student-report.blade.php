<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Card - {{ $student->first_name }} {{ $student->last_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Times New Roman', serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white; padding: 0; margin: 0; }
            .report-container { box-shadow: none; border: none; padding: 0; margin: 0; width: 100%; max-width: 100%; }
        }
    </style>
</head>
<body class="bg-gray-200 p-8">

    <!-- Action Buttons (Hidden when printing) -->
    <div class="no-print max-w-4xl mx-auto mb-6 flex justify-between items-center">
        <a href="/students/{{ $student->id }}" class="text-blue-600 hover:underline"><i class="fas fa-arrow-left mr-2"></i> Back to Profile</a>
        <div class="flex gap-4">
            <button onclick="window.print()" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 font-bold shadow-lg">
                <i class="fas fa-print mr-2"></i> Print
            </button>
            <!-- NEW RED DOWNLOAD BUTTON -->
            <a href="/students/{{ $student->id }}/report/download" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 font-bold shadow-lg">
                <i class="fas fa-file-pdf mr-2"></i> Download PDF
            </a>
        </div>
    </div>

    <!-- The Actual Report Card -->
    <div class="report-container max-w-4xl mx-auto bg-white p-10 shadow-lg border border-gray-300">
        
        <div class="text-center border-b-2 border-black pb-4 mb-6">
            <h1 class="text-3xl font-bold uppercase tracking-wider">EduManage International School</h1>
            <p class="text-sm text-gray-600 mt-1">P.O. Box 123, Accra, Ghana | Tel: +233 20 000 0000</p>
            <h2 class="text-xl font-bold mt-4 underline">END OF TERM REPORT CARD</h2>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-8 text-sm border border-gray-400 p-4 rounded">
            <div><strong>Name:</strong> {{ strtoupper($student->first_name . ' ' . $student->last_name) }}</div>
            <div><strong>Admission No:</strong> {{ $student->admission_number }}</div>
            <div><strong>Class:</strong> {{ $student->classLevel->name ?? 'N/A' }}</div>
            <div><strong>Section:</strong> {{ $student->section->name ?? 'N/A' }}</div>
            <div><strong>Term/Session:</strong> 2024-2025 (1st Trimester)</div>
            <div><strong>Date of Birth:</strong> {{ $student->date_of_birth }}</div>
        </div>

        <h3 class="font-bold text-lg mb-2 text-center uppercase">Academic Performance</h3>
        <table class="w-full border-collapse border border-black text-sm mb-8">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-black p-2 text-left">Subject</th>
                    <th class="border border-black p-2 text-center">Class Score (30)</th>
                    <th class="border border-black p-2 text-center">Exam Score (70)</th>
                    <th class="border border-black p-2 text-center">Total (100)</th>
                    <th class="border border-black p-2 text-center">Grade</th>
                    <th class="border border-black p-2 text-center">Remark</th>
                </tr>
            </thead>
            <tbody>
                @php
                    function getGrade($marks) {
                        if ($marks >= 80) return ['A', 'Excellent'];
                        if ($marks >= 70) return ['B', 'Very Good'];
                        if ($marks >= 60) return ['C', 'Good'];
                        if ($marks >= 50) return ['D', 'Credit'];
                        if ($marks >= 40) return ['E', 'Pass'];
                        return ['F', 'Fail'];
                    }
                @endphp
                @forelse($exams as $exam)
                    @php $total = $exam->marks; [$grade, $remark] = getGrade($total); @endphp
                    <tr>
                        <td class="border border-black p-2 font-bold">{{ $exam->subject->name }}</td>
                        <td class="border border-black p-2 text-center">-</td>
                        <td class="border border-black p-2 text-center">{{ $total }}</td>
                        <td class="border border-black p-2 text-center font-bold">{{ $total }}</td>
                        <td class="border border-black p-2 text-center font-bold">{{ $grade }}</td>
                        <td class="border border-black p-2 text-center">{{ $remark }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="border border-black p-4 text-center text-gray-500">No grades posted for this term yet.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="grid grid-cols-2 gap-8 mb-8">
            <div class="border border-black p-4">
                <h4 class="font-bold mb-2 border-b border-black pb-1">Attendance Record</h4>
                <div class="flex justify-between text-sm mb-1"><span>Days School Opened:</span> <span>90</span></div>
                <div class="flex justify-between text-sm mb-1"><span>Days Present:</span> <span class="font-bold text-green-700">{{ $attendance['Present'] ?? 0 }}</span></div>
                <div class="flex justify-between text-sm mb-1"><span>Days Absent:</span> <span class="font-bold text-red-700">{{ $attendance['Absent'] ?? 0 }}</span></div>
            </div>
            <div class="border border-black p-4">
                <h4 class="font-bold mb-2 border-b border-black pb-1">Teacher's Remark</h4>
                <p class="text-sm italic h-16">{{ $student->teacher_remark ?? 'No remark provided.' }}</p>
                <h4 class="font-bold mt-4 mb-2 border-b border-black pb-1">Principal's Remark</h4>
                <p class="text-sm italic h-16">{{ $student->principal_remark ?? 'No remark provided.' }}</p>
            </div>
        </div>

        <div class="flex justify-between mt-12 text-sm">
            <div class="text-center">
                <div class="border-b border-black w-48 mb-1"></div>
                <p>Class Teacher's Signature</p>
            </div>
            <div class="text-center">
                <div class="border-b border-black w-48 mb-1"></div>
                <p>Principal's Signature & Stamp</p>
            </div>
            <div class="text-center">
                <div class="border-b border-black w-48 mb-1"></div>
                <p>Parent's Signature</p>
            </div>
        </div>
    </div>
</body>
</html>