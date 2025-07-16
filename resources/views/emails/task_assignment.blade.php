<!DOCTYPE html>
<html>
<head>
    <title>{{ $details['title'] }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: auto;
        }
        .header {
            background: #007BFF;
            color: white;
            text-align: center;
            padding: 15px;
            border-radius: 8px 8px 0 0;
            font-size: 20px;
            font-weight: bold;
        }
        .content {
            padding: 20px;
            text-align: left;
            color: #333;
        }
        .button {
            display: inline-block;
            background: #007BFF;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
        {{ $details['title'] }}
        </div>
        <div class="content">
            <p><strong>{{ $details['greeting'] }}</strong></p>
            <p>{{ $details['body'] }}</p>

            <!-- Work Order Details -->
            <p>
                <strong>
                    {{ isset($details['work_order_no']) ? 'Work Order No:' : 'Service Request No:' }}
                </strong> 
                {{ $details['work_order_no'] ?? $details['service_request_no'] ?? 'Unknown' }}
            </p>
            <p><strong>Service Request Type:</strong> {{ $details['type'] ?? 'Unknown'  }}</p>
            <p><strong>Description:</strong> {{ $details['description'] ?? 'Unknown'  }}</p>
            <p><strong>Client Remark:</strong> {{ $details['client_remark'] ?? 'Unknown'  }}</p>
            <p><strong>Priority:</strong> {{ $details['priority'] ?? 'Unknown'  }}</p>
            <p><strong>Due Date:</strong> {{ $details['due_date'] ?? 'Unknown'  }}</p>

            <p>Click the button below to view the task details:</p>
            <p style="text-align: center;">
                <a href="{{ $details['actionurl'] }}" class="button">{{ $details['actiontext'] }}</a>
            </p>
            <p>{{ $details['lastline'] }}</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} MDT Innovations. All rights reserved.
        </div>
    </div>
</body>
</html>