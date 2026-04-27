<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #c1121f;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
            color: #c1121f;
            font-size: 28px;
        }

        .header p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 14px;
        }

        .booking-details {
            background-color: #f5f5f5;
            border-left: 4px solid #c1121f;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .booking-details h3 {
            margin: 0 0 15px 0;
            color: #333;
            font-size: 16px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: bold;
            color: #555;
        }

        .detail-value {
            color: #333;
            text-align: right;
        }

        .seats-section {
            background-color: #e8f4f8;
            border-left: 4px solid #0066cc;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .seats-section h3 {
            margin: 0 0 15px 0;
            color: #0066cc;
            font-size: 16px;
        }

        .seat-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 10px;
        }

        .seat-badge {
            background-color: #0066cc;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            text-align: center;
            font-weight: bold;
            font-size: 14px;
        }

        .fixture-info {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .fixture-info h3 {
            margin: 0 0 10px 0;
            color: #856404;
            font-size: 16px;
        }

        .fixture-info p {
            margin: 5px 0;
            color: #856404;
        }

        .amount-section {
            background-color: #f0f0f0;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            text-align: right;
        }

        .total-amount {
            font-size: 24px;
            font-weight: bold;
            color: #c1121f;
            margin: 10px 0 0 0;
        }

        .footer {
            border-top: 1px solid #e0e0e0;
            margin-top: 30px;
            padding-top: 20px;
            text-align: center;
            color: #666;
            font-size: 12px;
        }

        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #c1121f;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
            text-align: center;
        }

        .button:hover {
            background-color: #a00e1a;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>✓ Ticket Booking Confirmed</h1>
            <p>Your seats for the upcoming match are reserved!</p>
        </div>

        <!-- Greeting -->
        <p>Hi <strong>{{ $user->name }}</strong>,</p>
        <p>Thank you for booking tickets with Mwatate FC! Your booking has been confirmed and payment received.
            Below are your ticket details.</p>

        <!-- Fixture Information -->
        <div class="fixture-info">
            <h3>Match Details</h3>
            <p><strong>Opponent:</strong> {{ $fixture->opponent }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($fixture->match_date)->format('l, F j, Y \a\t g:i A') }}</p>
            <p><strong>Venue:</strong> {{ $fixture->venue }} | <strong>Stadium:</strong>
                {{ optional($fixture->stadium)->name ?? 'TBA' }}</p>
            <p><strong>Competition:</strong> {{ $fixture->competition }}</p>
        </div>

        <!-- Booking Details -->
        <div class="booking-details">
            <h3>Booking Summary</h3>
            <div class="detail-row">
                <span class="detail-label">Booking Reference:</span>
                <span class="detail-value">#{{ $order->id }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Ticket Category:</span>
                <span class="detail-value">{{ $order->ticket_type ?? $order->section_name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Number of Tickets:</span>
                <span class="detail-value">{{ $order->quantity }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Price Per Ticket:</span>
                <span class="detail-value">KES {{ number_format($order->price, 2) }}</span>
            </div>
            <div class="detail-row" style="border-bottom: 2px solid #ddd; padding: 12px 0;">
                <span class="detail-label">Total Amount Paid:</span>
                <span class="detail-value" style="font-size: 18px; color: #c1121f;">KES
                    {{ number_format($order->price * $order->quantity, 2) }}</span>
            </div>
        </div>

        <!-- Seat Numbers -->
        @if ($order->seat_numbers && count($order->seat_numbers) > 0)
            <div class="seats-section">
                <h3>Your Seat Assignments</h3>
                <div class="seat-list">
                    @foreach ($order->seat_numbers as $seat)
                        <div class="seat-badge">{{ $seat }}</div>
                    @endforeach
                </div>
                <p style="margin-top: 15px; color: #0066cc; font-weight: bold;">
                    📍 Located in: {{ $order->section_name }} Section
                </p>
            </div>
        @endif

        <!-- Important Information -->
        <div style="background-color: #f5f5f5; padding: 15px; border-radius: 4px; margin: 20px 0;">
            <h3 style="margin: 0 0 10px 0; color: #333;">Important Information</h3>
            <ul style="margin: 0; padding-left: 20px; color: #555;">
                <li>Please arrive at the stadium 30 minutes before kick-off</li>
                <li>Keep this email for admission to the stadium</li>
                <li>Your seat numbers are valid for the specific section mentioned above</li>
                <li>In case of any issues, reply to this email or contact our support team</li>
            </ul>
        </div>

        <!-- Call to Action -->
        {{-- <div style="text-align: center;">
            <a href="{{ config('app.url') }}" class="button">View Match Details</a>
        </div> --}}

        <!-- Footer -->
        <div class="footer">
            <p style="margin: 0;">Mwatate FC Supporter Portal</p>
            <p style="margin: 5px 0 0 0;">This is an automated message, please do not reply to this email.</p>
            <p style="margin: 10px 0 0 0;">© {{ date('Y') }} Mwatate FC. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
