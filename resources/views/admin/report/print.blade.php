<!DOCTYPE html>
<html>
<head>
    <title>Loan Summary Print</title>

    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        h2 { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>

    <h2>Loan Summary Report</h2>

    <table>
        <thead>
            <tr>
                <th>Member</th>
                <th>Loan Amount</th>
                <th>Total Payable</th>
                <th>Paid</th>
                <th>Remaining</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach($loans as $loan)
            <tr>
                <td>
                    <b>{{ $loan->member->name }}</b><br>
                    <small>{{ $loan->member->phone }}</small>
                </td>
                <td>{{ number_format($loan->loan_amount,2) }}</td>
                <td>{{ number_format($loan->total_amount,2) }}</td>
                <td>{{ number_format($loan->paid_total,2) }}</td>
                <td>{{ number_format($loan->remaining_total,2) }}</td>
                <td>
                    @if($loan->remaining_total <= 0)
                        Paid
                    @elseif($loan->paid_total > 0)
                        Partial
                    @else
                        Not Paid
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

<script>
// Auto print when page loads
window.onload = function () {
    window.print();

    // After print OR cancel → close print tab → return to previous page
    window.onafterprint = function () {
        window.close();
    };
};
</script>

</html>
