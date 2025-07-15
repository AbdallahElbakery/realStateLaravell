<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            background: linear-gradient(135deg, #667eea 0%, #1e40af 100%);
            color: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            margin: -30px -30px 30px -30px;
        }

        .success-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }

        .property-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #1e40af;
        }

        .property-title {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }

        .detail-label {
            font-weight: bold;
            color: #555;
        }

        .detail-value {
            color: #2c3e50;
        }

        .price-highlight {
            background-color: #d4edda;
            color: #1e40af;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 15px 0;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #1e40af;
            color: #ffffffff !important;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
        }

        .btn:hover {
            background-color: #003385ff;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="success-icon">🎉</div>
            <h1>Congratulations!</h1>
            <p>Your property booking has been confirmed</p>
        </div>

        <h2>Hello {{ $user->name }} 👋</h2>

        <p>Great news! Your booking for the following property has been <strong>confirmed</strong> by the seller.</p>

        <div class="property-details">
            <div class="property-title">{{ $property->title }}</div>

            <div class="detail-row">
                <span class="detail-label">Property:</span>
                <span class="detail-value">{{ $property->name ?? 'N/A' }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Location:</span>
                <span class="detail-value">{{ $property->address->city ?? 'N/A' }},
                    {{ $property->address->country ?? 'N/A' }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Bedrooms:</span>
                <span class="detail-value">{{ $property->bedrooms ?? 'N/A' }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Bathrooms:</span>
                <span class="detail-value">{{ $property->bathrooms ?? 'N/A' }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Area:</span>
                <span class="detail-value">{{ $property->area ?? 'N/A' }} m²</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Original Price:</span>
                <span class="detail-value">{{ number_format($property->price) }} EGP</span>
            </div>
        </div>

        <div class="price-highlight">
            💰 Your Accepted Offer: {{ number_format($booking->suggested_price) }} EGP
        </div>

        <div style="background-color: #e7f3ff; padding: 15px; border-radius: 8px; margin: 20px 0;">
            <h3 style="color: #0056b3; margin-top: 0;">📅 Booking Details</h3>
            <div class="detail-row">
                <span class="detail-label">Booking ID:</span>
                <span class="detail-value">#{{ $booking->id }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Booking Date:</span>
                <span class="detail-value">{{ $booking->created_at->format('F j, Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Confirmation Date:</span>
                <span class="detail-value">{{ $booking->updated_at->format('F j, Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Status:</span>
                <span class="detail-value" style="color: #3727b1ff; font-weight: bold;">✅ Confirmed</span>
            </div>
        </div>

        <div style="background-color: #fff3cd; padding: 15px; border-radius: 8px; margin: 20px 0;">
            <h3 style="color: #856404; margin-top: 0;">📋 Next Steps</h3>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Contact the seller to arrange property viewing</li>
                <li>Complete the payment process</li>
                <li>Sign the necessary documents</li>
                <li>Schedule the property handover</li>
            </ul>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <a href="http://localhost:4200/user-bookings" class="btn bg-primary text-light">View My Bookings</a>
        </div>

        <div class="footer">
            <p>Thank you for choosing our platform!</p>
            <p>If you have any questions, please don't hesitate to contact our support team.</p>
            <p style="font-size: 12px; color: #999;">
                This email was sent to {{ $user->email }}<br>
                Booking ID: #{{ $booking->id }} | Property ID: #{{ $property->id }}
            </p>
        </div>
    </div>
</body>

</html>