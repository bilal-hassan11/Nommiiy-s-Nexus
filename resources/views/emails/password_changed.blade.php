<!DOCTYPE html>
<html>
<head>
    <title>Password Changed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            padding: 20px;
            border: 1px solid #dddddd;
            border-radius: 5px;
        }
        h1 {
            color: #333333;
        }
        p {
            color: #555555;
            margin: 0 0 10px;
        }
       
    </style>
</head>
<body>
    <div class="container">
        <p>Hi {{ $name }},</p>
        <p>Your epos account password has been changed on {{ $datetime }}. If you did not request this change, please contact support immediately.</p>
        <p>Thanks,</p>
        
    </div>
</body>
</html>
