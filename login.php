<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ('./Widgets/head.php')?>
</head>
<body>
    <form action="./Api/authenticateUser.php" method="POST">
        <h2>Login</h2>

        <label for="usernameOrEmail">Username or Email:</label><br>
        <input type="text" id="usernameOrEmail" name="usernameOrEmail" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>