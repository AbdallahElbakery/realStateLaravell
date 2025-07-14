<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Cancelled</title>
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
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            margin: -30px -30px 30px -30px;
        }
        .info-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .property-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #dc3545;
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
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="info-icon">ℹ️</div>
            <h1>Booking Cancelled</h1>
            <p>Your property booking has been cancelled by the seller</p>
        </div>

        <h2>Hello {{ $user->name }} 👋</h2>
        
        <p>We regret to inform you that your booking for the following property has been <strong>cancelled</strong> by the seller.</p>

        <div class="property-details">
            <div class="property-title">{{ $property->title }}</div>
            
            <div class="detail-row">
                <span class="detail-label">Property Type:</span>
                <span class="detail-value">{{ $property->category->name ?? 'N/A' }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Location:</span>
                <span class="detail-value">{{ $property->address->city ?? 'N/A' }}, {{ $property->address->country ?? 'N/A' }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Your Offer:</span>
                <span class="detail-value">{{ number_format($booking->suggested_price) }} EGP</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Booking Date:</span>
                <span class="detail-value">{{ $booking->created_at->format('F j, Y') }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Cancellation Date:</span>
                <span class="detail-value">{{ $booking->updated_at->format('F j, Y') }}</span>
            </div>
        </div>

        <div style="background-color: #fff3cd; padding: 15px; border-radius: 8px; margin: 20px 0;">
            <h3 style="color: #856404; margin-top: 0;">💡 What's Next?</h3>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Browse other available properties on our platform</li>
                <li>Make new offers on properties that interest you</li>
                <li>Contact our support team if you need assistance</li>
            </ul>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <a href="http://localhost:4200/properties" class="btn">Browse Properties</a>
            <a href="http://localhost:4200/user-bookings" class="btn">View My Bookings</a>
        </div>

        <div class="footer">
            <p>Thank you for using our platform!</p>
            <p>We hope you find your perfect property soon.</p>
            <p style="font-size: 12px; color: #999;">
                This email was sent to {{ $user->email }}<br>
                Booking ID: #{{ $booking->id }} | Property ID: #{{ $property->id }}
            </p>
        </div>
    </div>
</body>
</html> 