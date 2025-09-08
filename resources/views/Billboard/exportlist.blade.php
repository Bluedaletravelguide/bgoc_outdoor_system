<!DOCTYPE html>
<html>
<head>
    <title>Billboard List</title>
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

        .section {
            page-break-inside: avoid;
            page-break-after: always;
            margin-bottom: 30px;
        }

        .section:last-child {
            page-break-after: auto;
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
            width: 48%;
            height: auto;
        }

        hr {
            border: none;
            border-top: 1px solid #ccc;
            margin: 30px 0;
        }
    </style>
</head>
<body>

    <div class="header">Billboard List</div>

    @foreach($billboards as $billboard)
        <div class="section">
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
                    @foreach($billboard->images as $img)
                        @php $path = public_path($img); @endphp
                        @if(file_exists($path))
                            <img src="{{ $path }}" alt="Billboard Image">
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</body>
</html>
