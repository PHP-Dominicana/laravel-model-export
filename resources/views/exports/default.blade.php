<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Export</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 5px; border: 1px solid #ccc; text-align: left; }
    </style>
</head>
<body>
<h2>Export</h2>
<table>
    <thead>
    @if($row = $rows->first())
        <tr>
            @foreach(array_keys($row) as $column)
                <th>{{ $column }}</th>
            @endforeach
        </tr>
    @endif
    </thead>
    <tbody>
    @foreach($rows as $row)
        <tr>
            @foreach($row as $cell)
                <td>{{ $cell }}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
