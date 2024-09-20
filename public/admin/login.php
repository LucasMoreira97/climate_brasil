<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <div class="login">
        <div class="login-container">
            <div class="login-box">
                <h2>Login</h2>
                <?php if (isset($error)): ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="input-box">
                        <input type="text" name="username" required>
                        <label>Usuário</label>
                    </div>
                    <div class="input-box">
                        <input type="password" name="password" required>
                        <label>Senha</label>
                    </div>
                    <input type="submit" value="Login" class="login-btn">
                </form>
            </div>
        </div>
    </div>
</body>

</html>