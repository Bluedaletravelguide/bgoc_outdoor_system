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
            margin-bottom: 20px;
            text-align: center;
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

        table.image-grid {
            width: 100%;
            border-collapse: collapse;
        }

        table.image-grid td {
            padding: 5px;
            text-align: center;
            vertical-align: top;
        }

        table.image-grid img {
            max-width: 100%;
            height: 200px;
            object-fit: contain;
            border: 1px solid #ccc;
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
                        <tr><td>Council:</td><td>{{ $billboard->location->council->abbreviation ?? '-' }} - {{ $billboard->location->council->name ?? '-' }}</td></tr>
                        <tr><td>GPS Coordinates:</td><td>{{ $billboard->gps_latitude }}, {{ $billboard->gps_longitude }}</td></tr>
                    </table>
                </div>
            </div>

            <!-- IMAGE SECTION -->
            <div class="image-section">
                <div class="image-section-title">Images:</div>
                <table class="image-grid">
                    @foreach (collect($billboard->images)->chunk(2) as $row)
                        <tr>
                            @foreach ($row as $img)
                                @php
                                    $fullPath = '/home/bluedale2/public_html/bgocoutdoor.bluedale.com.my/' . $img;
                                    $dataUri = '';
                                    if (file_exists($fullPath)) {
                                        $data = file_get_contents($fullPath);
                                        $dataUri = 'data:image/png;base64,' . base64_encode($data);
                                    }
                                @endphp
                                <td width="50%">
                                    @if($dataUri)
                                        <img src="{{ $dataUri }}" alt="Billboard Image" style="max-width: 100%; height: auto; object-fit: contain; border: 1px solid #ccc;">
                                    @endif
                                </td>
                            @endforeach

                            @if(count($row) == 1)
                                <td width="50%"></td> {{-- fill empty cell if only one image --}}
                            @endif
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    @endforeach

</body>
</html>
