<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body>
    <p>Dear {{ $student->first_name }} {{ $student->last_name }},</p>
    
    <p>Your account has been created successfully.</p>
    
    <p>Your password is: {{ $password }}</p>
    
    <p>Please click the following link to verify your email:</p>
    <p><a href="{{ $verificationUrl }}" style="display: inline-block; padding: 10px 20px; color: white; background-color: blue; text-decoration: none;">Confirm</a></p>
    
    <p>Thank you!</p>
</body>
</html>
