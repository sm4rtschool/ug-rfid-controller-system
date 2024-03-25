<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Example Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        input[type="checkbox"] {
            transform: scale(1.5);
        }

        .blink-container {
            display: flex;
            justify-content: space-around;
            margin-top: 10px;
        }

        .blinking-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin: 0 5px; /* Reduced margin */
            animation: blinker 1s linear infinite;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }

        .yellow {
            background-color: #f1c40f; /* Yellow */
        }

        .green {
            background-color: #2ecc71; /* Green */
        }
    </style>
</head>
<body>

<table border="1">
    <thead>
        <tr>
            <th>No. Urut</th>
            <th>Parameter</th>
            <th>Indikator</th>
            <th>State</th>
            <th>Treshold</th>
            <th>Alarm</th>
            <th>Speech</th>
        </tr>
    </thead>
    <tbody>
        <!-- Example Data -->
        <tr>
            <td>1</td>
            <td>Parameter 1</td>
            <td>Indikator 1</td>
            <td>State 1</td>
            <td>Threshold 1</td>
            <td><input type="checkbox" checked></td>
            <td><input type="checkbox" checked></td>
        </tr>
        <tr>
            <td>2</td>
            <td>Parameter 2</td>
            <td>Indikator 2</td>
            <td>State 2</td>
            <td>Threshold 2</td>
            <td><input type="checkbox"></td>
            <td><input type="checkbox" checked></td>
        </tr>
        <!-- Add more rows as needed -->
    </tbody>
</table>

<div class="blink-container">
    <div class="blinking-circle yellow"></div>
    <div class="blinking-circle green"></div>
</div>

</body>
</html>
