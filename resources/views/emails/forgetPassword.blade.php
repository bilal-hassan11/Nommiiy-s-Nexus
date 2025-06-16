
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            text-align: center;
            margin: auto;
        }
        .container p {
            font-size: 16px;
            color: #333333;
            line-height: 1.5;
        }
        .otp {
            font-size: 24px;
            font-weight: bold;
            color: #ff5722;
            margin: 20px 0;
            letter-spacing: 4px;
            padding: 10px;
            border: 2px dashed #ff5722;
            display: inline-block;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #777777;
        }
    </style>
</head>
<body>
    <div class="container">
        <p>You are receiving this email because we received a password reset request for your account.</p>

    <a href="{{$resetLink}}" style="display: inline-block; padding: 10px 20px; color: white; background-color: #3498db; text-decoration: none; border-radius: 5px;">Reset Password</a>

    <p>If you did not request a password reset, no further action is required.</p>
    </div>
</body>
</html>
