<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login</title>
</head>

<body class="d-flex align-items-center justify-content-center bg-dark" style="height: 100vh;">

    <?php
    // Verifica se o formulário foi enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Conecta ao banco de dados
        $host = "localhost";
        $user = "root";
        $pass = "";
        $dbname = "cadastrar_produto";
        $port = 3306;

        try {
            $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Obtém os dados do formulário
            $username = $_POST["username"];
            $password = $_POST["password"];

            // Proteção contra SQL injection usando prepared statements
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->execute();

            // Verifica se o usuário existe
            if ($stmt->rowCount() > 0) {
                echo "<h2>Login bem-sucedido!</h2>";

                // Redireciona para a página cadastro.php após o login
                header('Location: index.php');
                exit;
            } else {
                echo "<h2>Nome de usuário ou senha incorretos.</h2>";
            }
        } catch (PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }

        // Fecha a conexão
        $conn = null;
    }
    ?>

    <div class="card text-center bg-light" style="width: 35%; height: 65%;">
        <div class="card-header bg-warning">
            <h2>Login</h2>
        </div>
        <div class="card-body d-flex justify-content-center">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="text-start">
                <div class="mb-3 text-center">
                    <label for="username" class="form-label align-items-center">Nome de Usuário:</label>
                    <input type="text" name="username" class="form-control" id="username">
                </div>
                <div class="mb-3 text-center">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" name="password" class="form-control" id="password">
                </div>
                <div class="mt-4 text-center">
                    <button type="submit" class="btn btn-primary ">Entrar</button></div>
                    <div class="mt-5 text-center"><p> <a href="criar.php">Criar Login</a></p></div>
                
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
