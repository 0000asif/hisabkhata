@extends('admin.masterAdmin')
@section('content')

<div class="report-card">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>📌 Loan Summary Report</h3>

        <a href="{{ route('loans.print') }}" target="_blank" class="btn btn-primary">
            Print
        </a>


    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
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
                        <b>{{ $loan->member->name }}</b> <br>
                        <small>{{ $loan->member->phone }}</small>
                    </td>
                    <td>{{ number_format($loan->loan_amount,2) }}</td>
                    <td>{{ number_format($loan->total_amount,2) }}</td>
                    <td class="text-success">{{ number_format($loan->paid_total,2) }}</td>
                    <td class="{{ $loan->remaining_total <= 0 ? 'text-success' : 'text-danger' }}">
                        <b>{{ number_format($loan->remaining_total,2) }}</b>
                    </td>
                    <td>
                        @if($loan->remaining_total <= 0)
                            <span class="badge bg-success">Paid</span>
                        @elseif($loan->paid_total > 0)
                            <span class="badge bg-warning">Partial</span>
                        @else
                            <span class="badge bg-danger">Not Paid</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>

<script>
function printLoanReport() {

    // The content you want to print
    let content = document.querySelector('.report-card').innerHTML;

    // Create hidden iframe
    let printFrame = document.createElement('iframe');
    printFrame.name = "print_frame";
    printFrame.style.position = "absolute";
    printFrame.style.top = "-100000px";
    document.body.appendChild(printFrame);

    let frameDoc = printFrame.contentWindow
        ? printFrame.contentWindow
        : printFrame.contentDocument.document
        ? printFrame.contentDocument.document
        : printFrame.contentDocument;

    frameDoc.document.open();
    frameDoc.document.write(`
        <html>
            <head>
                <title>Loan Report</title>

                <style>
                    table { width: 100%; border-collapse: collapse; }
                    table, th, td { border: 1px solid #000; padding: 6px; }
                    body { font-family: sans-serif; padding: 20px; }
                </style>

            </head>
            <body>
                ${content}
            </body>
        </html>
    `);
    frameDoc.document.close();

    setTimeout(() => {
        frameDoc.focus();
        frameDoc.print();
        document.body.removeChild(printFrame);
    }, 300);
}
</script>


@endsection

@section('style')
<style>
@media print {
    body * { visibility: hidden !important; }
    .report-card, .report-card * { visibility: visible !important; }

    .report-card {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }

    .btn, .btn * {
        display: none !important;
    }
}
</style>
@endsection

@section('script')
<script>
function printLoanReport() {
    window.print();
}
</script>
@endsection
