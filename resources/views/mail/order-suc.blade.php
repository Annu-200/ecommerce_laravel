<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2>Thank you for your order! 🎉</h2>

<p>Hi {{ $order->first_name }},</p>

<p>We’re pleased to inform you that your order has been successfully placed.</p>

<p><strong>Order Details:</strong></p>
<ul>
    <li><strong>Order ID:</strong> {{ $order->order_num }}</li>
    <li><strong>Total Amount:</strong> ₹{{ number_format($order->total) }}</li>
    <li><strong>Payment Method:</strong> {{ $order->payment_mode }}</li>
</ul>

<p>Your order is now being processed. We will notify you once it has been shipped.</p>

<p>If you have any questions, feel free to contact our support team.</p>

<br>

<p>Best regards,<br>

</body>
</html>