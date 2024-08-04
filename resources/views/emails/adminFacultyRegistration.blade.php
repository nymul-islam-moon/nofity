<!DOCTYPE html>
<html>
<head>
    <title>Faculty Registration Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        h1 {
            color: #333;
        }
        p {
            color: #555;
        }
        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>{{ $mailData['title'] }}</h1>

        <p>Congratulations!</p>
        <p>Your faculty account has been successfully created.</p>

        <p>Here are your login credentials:</p>
        <p><strong>Email:</strong> {{ $mailData['email'] }}</p>
        <p><strong>Password:</strong> {{ $mailData['password'] }}</p>

        <p>Your position: <strong>{{ $mailData['type'] }}</strong></p>

        <p>You can access the admin portal using the following link:</p>
        <p><a href="{{ $mailData['admin_url'] }}" class="button">Admin Portal</a></p>

        <p>Thank you for joining us. If you have any questions or need assistance, please do not hesitate to contact our support team.</p>

        <p>Best regards,</p>
        <p>The Admin Team</p>
    </div>
</body>
</html>
