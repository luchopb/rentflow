<?php
require_once 'config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = clean_input($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // encripto el pass
    // echo "hash: " . password_hash($_POST['password'], PASSWORD_DEFAULT)."\n";

    if ($username && $password) {
        // Consultar usuario
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            // Login correcto
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['username'];
            $_SESSION['user_role'] = $user['rol'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    } else {
        $error = "Por favor ingresa usuario y contraseña.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Inmobiliaria | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: #fff;
            color: #374151;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-container {
            max-width: 380px;
            margin: auto;
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 10px rgb(0 0 0 / 0.05);
            background: #fafafa;
        }
        h2 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .error-msg {
            color: #dc2626;
            margin-bottom: 1rem;
            font-weight: 600;
            text-align:center;
        }
    </style>
</head>
<body>
    <main class="login-container">
        <h2>Iniciar Sesión</h2>
        <?php if ($error): ?>
            <div role="alert" class="error-msg"><?=htmlspecialchars($error)?></div>
        <?php endif; ?>
        <form method="POST" novalidate>
            <div class="mb-3">
                <label for="username" class="form-label fw-semibold">Usuario</label>
                <input type="text" class="form-control" id="username" name="username" required autofocus/>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label fw-semibold">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required />
            </div>
            <button class="btn btn-black w-100 py-2 fw-bold" type="submit" style="background:black; color:white; font-size:1.1rem; border-radius:0.5rem;">
                Entrar
            </button>
        </form>
    </main>
</body>
</html>
