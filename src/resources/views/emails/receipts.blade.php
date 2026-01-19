<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt</title>
    <style>
        /* Reset and Base Styles */
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; color: #444; margin: 0; padding: 0; background-color: #f5f5f5; -webkit-font-smoothing: antialiased; }
        table { border-collapse: collapse; width: 100%; }

        /* Layout Wrappers */
        .wrapper { width: 100%; background-color: #f5f5f5; padding: 40px 0; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #e0e0e0; border-radius: 2px; }

        /* Header Section */
        .header { padding: 25px 30px; border-bottom: 1px solid #f0f0f0; }

        /* Custom Logo Styles */
        .logo-container { display: inline-block; vertical-align: middle; }
        .logo-symbol {
            display: inline-block;
            width: 36px;
            height: 36px;
            background-color: #0f9d58; /* Green BG */
            border-radius: 50%;
            text-align: center;
            margin-right: 10px;
            vertical-align: middle;
            line-height: 36px; /* Vertically center the image */
        }
        /* Style for the internal image icon */
        .logo-symbol img {
            vertical-align: middle;
            width: 20px;
            height: 20px;
            margin-top: -2px; /* Slight adjustment for visual centering */
        }

        .brand-name {
            display: inline-block;
            font-size: 18px;
            font-weight: 700;
            color: #333;
            vertical-align: middle;
            letter-spacing: -0.5px;
        }
        .receipt-title { font-size: 13px; color: #999; text-align: right; text-transform: uppercase; letter-spacing: 1px; font-weight: bold; }

        /* Product Card */
        .product-card { margin: 25px 30px; box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24); border-radius: 3px; overflow: hidden; background: #fff; }
        .product-details { padding: 20px; }
        .product-icon {
            width: 50px;
            height: 50px;
            background-color: #f1f3f4;
            border-radius: 4px;
            display: inline-block;
            vertical-align: middle;
            margin-right: 15px;
            text-align: center;
            line-height: 50px;
        }
        /* Style for the product placeholder image */
        .product-icon img {
            width: 24px;
            height: 24px;
            vertical-align: middle;
            opacity: 0.5;
        }

        .product-info { display: inline-block; vertical-align: middle; }
        .product-info h3 { margin: 0 0 4px 0; font-size: 16px; color: #333; font-weight: 600; }
        .product-info p { margin: 0; font-size: 14px; color: #0f9d58; font-weight: bold; }
        .date-info { font-size: 12px; color: #888; margin-top: 4px; }

        /* Green Status Bar */
        .status-bar-container { background-color: #fafafa; border-top: 1px solid #eee; }
        .status-table { width: 100%; border-collapse: collapse; }
        .status-label-cell {
            width: 1%;
            white-space: nowrap;
            background-color: #0f9d58;
            color: white;
            font-weight: bold;
            font-size: 12px;
            padding: 12px 25px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .status-line-cell { padding: 0 20px; vertical-align: middle; }
        .status-line { height: 4px; background-color: #0f9d58; width: 100%; border-radius: 2px; opacity: 0.8; }

        /* Summary */
        .summary-section { padding: 0 30px 30px 30px; }
        .greeting { font-size: 15px; margin-bottom: 25px; color: #333; }
        .summary-table td { padding: 10px 0; font-size: 14px; border-bottom: 1px solid #eee; }
        .summary-table .label { color: #666; width: 60%; }
        .summary-table .value { color: #333; text-align: right; font-weight: 500; }
        .total-row td { border-bottom: none; border-top: 2px solid #eee; padding-top: 15px; font-weight: bold; font-size: 18px; color: #000; }

        /* Footer */
        .footer { background-color: #fafafa; padding: 25px; text-align: center; font-size: 12px; color: #999; border-top: 1px solid #e0e0e0; }
        .footer a { color: #0f9d58; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <!-- Header -->
            <div class="header">
                <table width="100%">
                    <tr>
                        <td align="left">
                            <div class="logo-container">
                                <!-- Logo: Green Circle with White Ball Icon -->
                                <div class="logo-symbol">
                                    <img src="https://img.icons8.com/ios-filled/50/ffffff/football2.png" alt="Ball">
                                </div>
                                <span class="brand-name">Mwatate FC</span>
                            </div>
                        </td>
                        <td align="right">
                            <span class="receipt-title">Payment Receipt</span>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Product Card -->
            <div class="product-card">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="product-details">
                            <!-- Product Icon: Gray Box with Bag Icon -->
                            <div class="product-icon">
                                <img src="https://img.icons8.com/ios-filled/50/000000/shopping-bag.png" alt="Item">
                            </div>
                            <div class="product-info">
                                <h3>{{ $order->product }}</h3>
                                <p>KES {{ number_format($order->price * $order->quantity, 2) }}</p>
                                <div class="date-info">Ordered on {{ $order->created_at->format('D, M d') }}</div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 0;">
                            <div class="status-bar-container">
                                <table class="status-table">
                                    <tr>
                                        <td class="status-label-cell">PAID</td>
                                        <td class="status-line-cell">
                                            <div class="status-line"></div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Receipt Details -->
            <div class="summary-section">
                <p class="greeting">Hi {{ explode(' ', $user->name)[0] }},</p>
                <p style="font-size: 14px; margin-bottom: 20px; color: #666; line-height: 1.5;">
                    Thanks for your order. We've received your payment and your order is now confirmed.
                </p>

                <table class="summary-table">
                    <tr>
                        <td class="label">Order Reference</td>
                        <td class="value" style="font-family: monospace;">#{{ $order->id }}</td>
                    </tr>
                    <tr>
                        <td class="label">Item Price</td>
                        <td class="value">KES {{ number_format($order->price, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="label">Quantity</td>
                        <td class="value">{{ $order->quantity }}</td>
                    </tr>
                    <tr class="total-row">
                        <td class="label">Total</td>
                        <td class="value">KES {{ number_format($order->price * $order->quantity, 2) }}</td>
                    </tr>
                </table>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p>&copy; {{ date('Y') }} Mwatate FC</p>
                <p>Need help? Email us at <a href="mailto:mwatatefootball@gmail.com">mwatatefootball@gmail.com</a></p>
            </div>
        </div>
    </div>
</body>
</html>
