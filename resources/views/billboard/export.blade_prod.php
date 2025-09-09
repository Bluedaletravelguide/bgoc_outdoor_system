<!DOCTYPE html>
<html>
<head>
    <title>Billboard Detail</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.2;
            margin: 0;
            padding: 20px;
        }

        .header {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .info-container {
            display: table;
            width: 100%;
        }

        .info-column {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .info-table td {
            padding: 3px 6px;
            vertical-align: top;
        }

        .info-table td:first-child {
            font-weight: bold;
            width: 130px;
        }

        .image-section {
            margin-top: 10px;
            clear: both;
        }

        .image-section-title {
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
            padding-bottom: 5px;
        }

        .image-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }



        .image-grid img {
            flex: 1 1 48%;       /* two images per row */
            max-width: 48%;      /* prevent overflow */
            height: 300px;       /* fixed display box height */
            object-fit: contain; /* keep aspect ratio */
            border: 1px solid #ccc; /* optional: keep uniform borders */
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    <div class="header">Billboard Details</div>

    <div class="info-container">
        <!-- LEFT COLUMN -->
        <div class="info-column">
            <table class="info-table">
                <tr><td>Site Number:</td><td>{{ $billboard->site_number }}</td></tr>
                <tr><td>Type:</td><td>{{ $billboard->type }}</td></tr>
                <tr><td>Size:</td><td>{{ $billboard->size }}</td></tr>
                <tr><td>Lighting:</td><td>{{ $billboard->lighting }}</td></tr>
                <tr><td>Traffic Volume:</td><td>{{ $billboard->traffic_volume }}</td></tr>
            </table>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="info-column">
            <table class="info-table">
                <tr><td>Location:</td><td>{{ $billboard->location->name ?? '-' }}</td></tr>
                <tr><td>District:</td><td>{{ $billboard->location->district->name ?? '-' }}</td></tr>
                <tr><td>State:</td><td>{{ $billboard->location->district->state->name ?? '-' }}</td></tr>
                <tr><td>Council:</td><td>{{ $billboard->location->council->abbreviation }} - {{ $billboard->location->council->name ?? '-' }}</td></tr>
                <tr><td>GPS Coordinates:</td><td>{{ $billboard->gps_latitude }}, {{ $billboard->gps_longitude }}</td></tr>     
            </table>
        </div>
    </div>

    <div class="image-section">
        <div class="image-section-title">Images:</div><br><br><br><br>
        <div class="image-grid">
            @foreach ($billboard->images as $img)
                @php
                    $fullPath = '/home/bluedale2/public_html/bgocoutdoor.bluedale.com.my/' . $img;
                    $dataUri = '';
                    if (file_exists($fullPath)) {
                        $dataUri = 'data:image/png;base64,' . base64_encode(file_get_contents($fullPath));
                    }
                @endphp
                @if ($dataUri)
                    <img src="{{ $dataUri }}" alt="Billboard Image">
                @endif
            @endforeach
        </div>

    </div>
</body>
</html>
