<?php
require_once 'caminho/para/conexaoBD.php';

$conn = conectarBD();

// Array multidimensional para organizar melhor os erros
$erros = [
    'geral' => [],
    'cnpj' => [],
    'email' => [],
    'senha' => []
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cnpj = preg_replace('/[^0-9]/', '', $_POST['cnpj']); // Remove formatação
    $email = trim($_POST['email']);
    $senha = $_POST['password'];
    $confirmar_senha = $_POST['confirm-password'];

    // Validação do CNPJ
    if (empty($cnpj)) {
        $erros['cnpj'][] = "CNPJ é obrigatório";
    } elseif (!preg_match('/^\d{14}$/', $cnpj)) {
        $erros['cnpj'][] = "CNPJ deve conter 14 dígitos";
    } else {
        // Verifica se CNPJ já existe (só executa se o CNPJ for válido)
        $stmt = $conn->prepare("SELECT id FROM empresas WHERE cnpj = ?");
        $stmt->execute([$cnpj]);
        if ($stmt->rowCount() > 0) {
            $erros['cnpj'][] = "Este CNPJ já está cadastrado";
        }
    }

    // Validação do Email
    if (empty($email)) {
        $erros['email'][] = "E-mail é obrigatório";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros['email'][] = "E-mail inválido";
    } else {
        // Verifica se email já existe
        $stmt = $conn->prepare("SELECT id FROM empresas WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $erros['email'][] = "Este e-mail já está em uso";
        }
    }

    // Validação da Senha
    if (empty($senha)) {
        $erros['senha'][] = "Senha é obrigatória";
    } elseif (strlen($senha) < 8) {
        $erros['senha'][] = "Senha deve ter pelo menos 8 caracteres";
    } elseif ($senha !== $confirmar_senha) {
        $erros['senha'][] = "As senhas não coincidem";
    }

    // Se não houver erros em nenhum campo
    if (empty($erros['cnpj']) && empty($erros['email']) && empty($erros['senha'])) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        
        try {
            $stmt = $conn->prepare("INSERT INTO empresas (cnpj, email, senha) VALUES (?, ?, ?)");
            $stmt->execute([$cnpj, $email, $senha_hash]);
            
            header("Location: /login/loginfree.html?registro=sucesso");
            exit();
        } catch (PDOException $e) {
            $erros['geral'][] = "Erro no cadastro: " . $e->getMessage();
        }
    }
}
?>