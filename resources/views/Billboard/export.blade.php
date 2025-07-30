<!DOCTYPE html>
<html>
<head>
    <title>Billboard Detail</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { font-size: 16px; font-weight: bold; margin-bottom: 20px; }
        .info-table td { padding: 5px 10px; }
        .image { margin-top: 20px; }
        .image img { max-width: 100%; height: auto; }
    </style>
</head>
<body>
    <div class="header">Billboard Details</div>

    <table class="info-table">
        <tr><td>Site Number:</td><td>{{ $billboard->site_number }}</td></tr>
        <tr><td>Type:</td><td>{{ $billboard->type }}</td></tr>
        <tr><td>Size:</td><td>{{ $billboard->size }}</td></tr>
        <tr><td>Lighting:</td><td>{{ $billboard->lighting }}</td></tr>
        <tr><td>Location:</td><td>{{ $billboard->location_name }}, {{ $billboard->district_name }}, {{ $billboard->state_name }}</td></tr>
    </table>

    <div class="image">
        <strong>Images:</strong><br>
        @foreach($billboard->images as $img)
            <img src="{{ public_path('storage/' . $img->image_path) }}" alt="Billboard Image" style="margin-bottom: 10px;">
        @endforeach
    </div>
</body>
</html>
