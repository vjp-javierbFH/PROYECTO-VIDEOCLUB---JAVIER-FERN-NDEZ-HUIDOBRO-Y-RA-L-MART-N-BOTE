<?php
session_start();
ob_start();

// Borrar error de sesión
$error = null;
if (isset($_SESSION['error_login'])) {
    $error = $_SESSION['error_login'];
    unset($_SESSION['error_login']);
}

// Redireccionar si ya está logueado
if (isset($_SESSION['user_name'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: mainAdmin.php');
    } elseif (isset($_SESSION['cliente_data'])) {
        header('Location: mainCliente.php');
    } else {
        header('Location: main.php');
    }
    ob_end_flush();
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videoclub - Iniciar Sesión</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: #333;
        }

        .login-container {
            background: white;
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 420px;
            text-align: center;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 25px;
            font-size: 1.8em;
            font-weight: 600;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.95em;
            border: 1px solid #f5c6cb;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        form div {
            margin-bottom: 18px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #495057;
            font-size: 0.95em;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1em;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        input:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        button {
            width: 100%;
            padding: 14px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 10px;
        }

        button:hover {
            background: #5a6fd8;
        }

        button:active {
            transform: translateY(1px);
        }

        .info {
            margin-top: 30px;
            padding: 18px;
            background: #f1f3f5;
            border-radius: 10px;
            font-size: 0.9em;
            color: #495057;
            text-align: left;
        }

        .info p {
            margin-bottom: 8px;
        }

        .info strong {
            color: #2c3e50;
            font-family: 'Courier New', monospace;
        }

        .info .admin {
            color: #e74c3c;
        }

        .info .cliente {
            color: #27ae60;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
                margin: 10px;
            }

            h1 {
                font-size: 1.6em;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h1>Acceso al Videoclub</h1>

        <?php if ($error): ?>
            <div class="error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div>
                <label for="user">Usuario:</label>
                <input type="text" id="user" name="user" required placeholder="Ej: bruce">
            </div>
            <div>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
            </div>
            <button type="submit">Iniciar Sesión</button>
        </form>

        <div class="info">
            <p><strong>Usuarios de prueba:</strong></p>
            <p class="admin">Admin: <strong>admin / admin</strong></p>
            <p class="cliente">Cliente: <strong>usuario / usuario</strong></p>
            <p class="cliente">Cliente: <strong>bruce / batman</strong></p>
        </div>
    </div>
</body>

</html>
<?php ob_end_flush(); ?>