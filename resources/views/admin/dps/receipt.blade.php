<!DOCTYPE html>
<html>

<head>
    <title>DPS Receipt</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            border: 1px solid #000;
            padding: 8px;
        }
    </style>
</head>

<body>

    <h2>DPS Receipt</h2>

    <table>
        <tr>
            <th>Member</th>
            <td>{{ $dps->member->name }}</td>
        </tr>
        <tr>
            <th>Mature Amount</th>
            <td>{{ $dps->mature_amount }}</td>
        </tr>
        <tr>
            <th>Mature Date</th>
            <td>{{ $dps->mature_date }}</td>
        </tr>
    </table>

    <br>
    <button onclick="window.print()" style="padding:8px 20px; background:black; color:white;">
        Print
    </button>

</body>

</html>
