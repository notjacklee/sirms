<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SIRMS Incident Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #1f2937;
        }

        h1 {
            margin-bottom: 5px;
            font-size: 22px;
        }

        p {
            margin-top: 0;
            margin-bottom: 15px;
            color: #6b7280;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #f3f4f6;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>SIRMS Incident Report</h1>
    <p>Generated on {{ now()->format('d M Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Severity</th>
                <th>Status</th>
                <th>Reporter</th>
                <th>Assigned Officer</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($incidents as $incident)
                <tr>
                    <td>{{ $incident->id }}</td>
                    <td>{{ $incident->title }}</td>
                    <td>{{ $incident->category }}</td>
                    <td>{{ $incident->severity }}</td>
                    <td>{{ $incident->status->name ?? '-' }}</td>
                    <td>{{ $incident->reporter->name ?? '-' }}</td>
                    <td>{{ $incident->assignedTo->name ?? 'Not Assigned' }}</td>
                    <td>{{ optional($incident->created_at)->format('d M Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>