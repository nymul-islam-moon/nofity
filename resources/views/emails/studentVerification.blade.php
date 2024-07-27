<!DOCTYPE html>
<html>
<head>
    <title>Confirm Your Registration</title>
</head>
<body>
    <h1>Hi {{ $student->first_name }} {{ $student->last_name }},</h1>
    <p>Thank you for registering. Please confirm your email by clicking the button below:</p>
    <a href="{{ $verificationUrl }}" style="display: inline-block; padding: 10px 20px; color: white; background-color: blue; text-decoration: none;">Confirm Registration</a>
    <p>If you did not register, please ignore this email.</p>
</body>
</html>
