<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Fee Receipt</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; color: #333; margin: 30px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 15px; margin-bottom: 30px; }
        .header h1 { margin: 0; font-size: 24px; text-transform: uppercase; }
        .header p { margin: 5px 0; font-size: 10px; }
        .receipt-box { border: 1px solid #000; padding: 20px; margin-bottom: 20px; }
        .row { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .cell { width: 48%; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total-row { font-weight: bold; background-color: #e0e0e0; }
        .footer { margin-top: 50px; text-align: right; }
        .signature { border-top: 1px solid #000; display: inline-block; padding-top: 5px; width: 150px; text-align: center; font-size: 12px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>EduManage International School</h1>
        <p>P.O. Box 123, Accra, Ghana | Tel: +233 20 000 0000</p>
        <h2 style="margin-top: 15px; text-decoration: underline;">OFFICIAL FEE RECEIPT</h2>
    </div>

    <div class="receipt-box">
        <div class="row">
            <div class="cell"><strong>Receipt No:</strong> #{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</div>
            <div class="cell"><strong>Date:</strong> {{ \Carbon\Carbon::parse($payment->payment_date)->format('F d, Y') }}</div>
        </div>
        <div class="row">
            <div class="cell"><strong>Student Name:</strong> {{ strtoupper($student->first_name . ' ' . $student->last_name) }}</div>
            <div class="cell"><strong>Admission No:</strong> {{ $student->admission_number }}</div>
        </div>
        <div class="row">
            <div class="cell"><strong>Class:</strong> {{ $student->classLevel->name ?? 'N/A' }}</div>
            <div class="cell"><strong>Session:</strong> {{ $session->name ?? 'N/A' }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Amount (GHS)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Fee Type:</strong> {{ $payment->feeType->name ?? 'Unknown' }}</td>
                <td></td>
            </tr>
            <tr>
                <td>Total Required for this Term</td>
                <td>{{ number_format($totalRequired, 2) }}</td>
            </tr>
            <tr>
                <td>Total Paid Previously</td>
                <td>{{ number_format($totalPaid - $payment->amount_paid, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td>Amount Paid Now ({{ $payment->payment_method }})</td>
                <td>{{ number_format($payment->amount_paid, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td>Outstanding Balance</td>
                <td>{{ number_format($totalRequired - $totalPaid, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <div class="signature">Bursar's Signature &amp; Stamp</div>
    </div>

</body>
</html>