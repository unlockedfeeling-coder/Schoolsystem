<!DOCTYPE html>
<html>
<head>
    <title>Report Card - {{ $student->first_name }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; margin: 20px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 22px; text-transform: uppercase; }
        .header p { margin: 5px 0; font-size: 10px; }
        .info-box { border: 1px solid #000; padding: 10px; margin-bottom: 20px; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 5px; }
        .info-cell { width: 48%; }
        table.grades { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.grades th, table.grades td { border: 1px solid #000; padding: 6px; text-align: center; }
        table.grades th { background-color: #f2f2f2; font-weight: bold; }
        .position-box { background-color: #ffeb3b; padding: 10px; text-align: center; margin: 20px 0; border: 2px solid #000; }
        .position-box h3 { margin: 0; font-size: 18px; }
        .footer { margin-top: 50px; display: flex; justify-content: space-between; }
        .signature { border-top: 1px solid #000; display: inline-block; padding-top: 5px; width: 150px; text-align: center; font-size: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>EduManage International School</h1>
        <p>P.O. Box 123, Accra, Ghana | Tel: +233 20 000 0000</p>
        <h2 style="margin-top: 15px; text-decoration: underline;">END OF TERM REPORT CARD</h2>
    </div>

    <div class="info-box">
        <div class="info-row">
            <div class="info-cell"><strong>Name:</strong> {{ strtoupper($student->first_name . ' ' . $student->last_name) }}</div>
            <div class="info-cell"><strong>Admission No:</strong> {{ $student->admission_number }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell"><strong>Class:</strong> {{ $student->classLevel->name ?? 'N/A' }}</div>
            <div class="info-cell"><strong>Section:</strong> {{ $student->section->name ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-cell"><strong>Term:</strong> 2024-2025 (1st Trimester)</div>
            <div class="info-cell"><strong>DOB:</strong> {{ $student->date_of_birth }}</div>
        </div>
    </div>

    @php
        $firstExam = $exams->first();
        $position = $firstExam ? $firstExam->position : '-';
    @endphp

    @if($position != '-')
    <div class="position-box">
        <h3>OVERALL POSITION: {{ $position }}<sup>{{ 
            $position == 1 ? 'st' : ($position == 2 ? 'nd' : ($position == 3 ? 'rd' : 'th')) 
        }}</sup> IN CLASS</h3>
    </div>
    @endif

    <h3 style="text-align: center; margin-bottom: 10px;">Academic Performance</h3>
    <table class="grades">
        <thead>
            <tr>
                <th style="text-align: left;">Subject</th>
                <th>Class Score (30)</th>
                <th>Exam Score (70)</th>
                <th>Total (100)</th>
                <th>Grade</th>
                <th>Remark</th>
            </tr>
        </thead>
        <tbody>
            @php
                function getGradePdf($marks) {
                    if ($marks >= 80) return ['A', 'Excellent'];
                    if ($marks >= 70) return ['B', 'Very Good'];
                    if ($marks >= 60) return ['C', 'Good'];
                    if ($marks >= 50) return ['D', 'Credit'];
                    if ($marks >= 40) return ['E', 'Pass'];
                    return ['F', 'Fail'];
                }
                
                $totalMarks = 0;
                $subjectCount = 0;
            @endphp

            @forelse($exams as $exam)
                @php 
                    $total = $exam->total_score ?: $exam->marks;
                    $totalMarks += $total;
                    $subjectCount++;
                    [$grade, $remark] = getGradePdf($total); 
                @endphp
                <tr>
                    <td style="text-align: left; font-weight: bold;">{{ $exam->subject->name }}</td>
                    <td>{{ $exam->class_score ?? '-' }}</td>
                    <td>{{ $exam->exam_score ?? $total }}</td>
                    <td style="font-weight: bold;">{{ $total }}</td>
                    <td style="font-weight: bold;">{{ $grade }}</td>
                    <td>{{ $remark }}</td>
                </tr>
            @empty
                <tr><td colspan="6" style="padding: 10px;">No grades posted for this term yet.</td></tr>
            @endforelse
            
            @if($subjectCount > 0)
                <tr style="background-color: #f2f2f2; font-weight: bold;">
                    <td style="text-align: left;">AVERAGE</td>
                    <td colspan="2"></td>
                    <td>{{ number_format($totalMarks / $subjectCount, 1) }}</td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- PERFORMANCE ANALYSIS & ATTENDANCE -->
    <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
        <div class="info-box" style="width: 48%;">
            <h4 style="margin: 0 0 10px 0; border-bottom: 1px solid #000; padding-bottom: 5px;">Attendance Record</h4>
            <p>Days Present: <strong>{{ $attendance['Present'] ?? 0 }}</strong></p>
            <p>Days Absent: <strong>{{ $attendance['Absent'] ?? 0 }}</strong></p>
        </div>
        <div class="info-box" style="width: 48%;">
            <h4 style="margin: 0 0 10px 0; border-bottom: 1px solid #000; padding-bottom: 5px;">Performance Analysis</h4>
            @php
                $subjectScores = [];
                foreach($exams as $exam) {
                    $subjectScores[$exam->subject->name] = $exam->total_score ?: $exam->marks;
                }
                if(count($subjectScores) > 0) {
                    arsort($subjectScores);
                    $strongest = array_key_first($subjectScores);
                    $weakest = array_key_last($subjectScores);
                } else {
                    $strongest = 'N/A';
                    $weakest = 'N/A';
                }
            @endphp
            <p><strong>Strongest Subject:</strong> {{ $strongest }}</p>
            <p><strong>Needs Improvement:</strong> {{ $weakest }}</p>
        </div>
    </div>

    <!-- REMARKS -->
    <div class="info-box" style="margin-bottom: 20px;">
        <h4 style="margin: 0 0 10px 0; border-bottom: 1px solid #000; padding-bottom: 5px;">Remarks</h4>
        <p><strong>Teacher:</strong> {{ $student->teacher_remark ?? 'N/A' }}</p>
        <p><strong>Principal:</strong> {{ $student->principal_remark ?? 'N/A' }}</p>
    </div>

    <!-- SIGNATURES -->
    <div class="footer">
        <div class="signature">Class Teacher</div>
        <div class="signature">Principal</div>
        <div class="signature">Parent</div>
    </div>

</body>
</html>