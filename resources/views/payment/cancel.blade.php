<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment Cancelled</title>
  <style>
    body {
      background-color: #fff3f3;
      font-family: Arial, sans-serif;
      text-align: center;
      padding: 50px;
    }
    .box {
      background-color: white;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 4px 16px rgba(255, 0, 0, 0.1);
      max-width: 600px;
      margin: auto;
    }
    h1 {
      color: #dc2626;
    }
    p {
      color: #444;
      font-size: 18px;
    }
    a {
      display: inline-block;
      margin-top: 20px;
      padding: 12px 24px;
      background-color: #dc2626;
      color: white;
      border-radius: 8px;
      text-decoration: none;
      transition: 0.3s ease-in-out;
    }
    a:hover {
      background-color: #ef4444;
    }
  </style>
</head>
<body>
  <div class="box">
    <h1>❌ Payment Cancelled</h1>
    <p>Your payment was not completed. Please try again later.</p>
    <a href="http://localhost:4200/user-bookings">Back to Bookings</a>
  </div>
</body>
</html>
