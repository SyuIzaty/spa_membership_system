<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INVOICE</title>
    <style>
        @page {
            size: A4;
        }

        body {
            font-family: "Arial", sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.6;
        }

        .container {
            width: 100%;
            max-width: 190mm;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .header {
            text-align: left;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 58px;
            color: #5c4ac7;
            margin: 0;
        }

        .header p {
            margin: 0;
            font-size: 24px;
            color: #888;
        }

        .info {
            margin: 20px 0;
            font-size: 26px;
        }

        .info div p {
            margin: 0;
        }

        .info div p span {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 26px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #f4f4f4;
        }

        .totals {
            margin: 20px 0;
            text-align: right;
        }

        .totals p {
            margin: 5px 0;
            font-size: 26px;
        }

        .totals p span {
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 24px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header" style="margin-bottom: 30px">
            <h1>INVOICE</h1>
            <p>
                INV-{{ $customerPlan->membership_id }}{{ $customerPlan->plan_id }}{{ \Carbon\Carbon::parse($customerPlan->start_date)->format('dmY') }}
            </p>
        </div>
        <div class="info">
            <div style="margin-bottom:10px">
                <p><span>Issue Date:</span> {{ \Carbon\Carbon::today()->format('d/m/Y') }}</p>
            </div>
            <div style="margin-bottom:10px">
                <p><span>Currency:</span> RM</p>
            </div>
            <div style="margin-bottom:30px">
                <p><span> From: </span></p>
                <p><span> Raudhah Serenity </span></p>
                <p>Menara Harmony, Level 12, Jalan Ampang, 50450 Kuala Lumpur, Malaysia</p>
                <p>Email: info@raudhahserenity.com | Phone: (+60) 3-1234 5678</p>
            </div>
            <div style="margin-bottom:10px">
                <p><span> To: </span></p>
                <p><span>{{ $customerPlan->customer->customer_name }}</span></p>
                <p><span>{{ $customerPlan->membership_id }}</span></p>
                <p>{{ $customerPlan->customer->customer_address }}, {{ $customerPlan->customer->customer_postcode }}, {{ $customerPlan->customer->customer_state }}</p>
                <p>Email: {{ $customerPlan->customer->customer_email }} | Phone: {{ $customerPlan->customer->customer_phone }}</p>
            </div>
            <br>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Plan Name</th>
                    <th>Plan Description</th>
                    <th>Unit Cost (RM)</th>
                    <th>Quantity</th>
                    <th>Total (RM)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1.</td>
                    <td>{{ $customerPlan->membershipPlan->plan_name }}</td>
                    <td>
                        {{ $customerPlan->membershipPlan->plan_description }}<br>
                        <ul>
                            @foreach($customerPlan->membershipPlan->planServices as $services)
                                <li>{{ $services->service->service_name }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $customerPlan->membershipPlan->plan_price }}</td>
                    <td>1</td>
                    <td>{{ $customerPlan->membershipPlan->plan_price }}</td>
                </tr>
            </tbody>
        </table>
        <div class="totals">
            <p>Subtotal: <span>RM {{ $customerPlan->membershipPlan->plan_price }}</span></p>
            <p>Total: <span style="font-size: 28px; color: #5c4ac7;"> RM {{ $customerPlan->membershipPlan->plan_price }}</span></p>
        </div>

        <div class="footer">
            <p>This is a computer-generated receipt confirming your payment. <br>
            Thank you for your prompt payment and your continued membership.</p>
        </div>
    </div>
</body>
</html>
