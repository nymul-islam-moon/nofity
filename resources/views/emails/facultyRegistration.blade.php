<!DOCTYPE html>
<html>
<head>
    <title>E-Book</title>
</head>
<body>
    <h1>{{ $mailData['title'] }}</h1>

    <p>Congratulation your login Email is {{ $mailData['email'] }} and your login password id {{ $mailData['password'] }}</p>
    <p> Admin Url is {{ $mailData['admin_url'] }} </p>
    <p>Thank you</p>
</body>
</html>
