<!DOCTYPE html>
<html>
<head>
    <title>User Account Created</title>
</head>
<body>
    <h1>Welcome {{ $user['name'] }}!</h1>
    <p>Your account has been successfully created. You can now log in using your email {{ $user['email'] }}.</p>
    <p>Your assigned role is: {{ $roleName }}</p>
    <p>Your password is: {{ $plainPassword }}</p> <!-- Display plain password -->

</body>
</html>
