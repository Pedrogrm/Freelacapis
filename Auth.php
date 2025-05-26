<?php 

class Auth {
    public static function iniciarSessao($usuario) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            session_regenerate_id(true);

            $_SESSION['auth'] = [
                'logado' => true,
                'id' => $usuario['id'],
                'nome' => $usuario['nome'],
                'usuario' => $usuario['usuario'],
                'perfil' => $usuario['perfil']
            ];
    }

    public static function encerrarSessao() {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION = [];

            if (isset($_COOKIE[session_name()])) {
                setcookie(session_name());
            }

            session_destroy();
    }

    public static function estaLogado() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return isset($_SESSION['auth']) && $_SESSION['auth']['logado'] === true;
    }

    // verifica se o usuario esta autenticado
    public static function obterUsuario() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return $_SESSION['auth'] ?? null;
    }

    // verifica se o usuario tem o perfil especificado
    public static function temperfil($perfil) {
        $usuario = self::obterUsuario();
        return $usuario && $usuario['perfil'] === $perfil;
    }

    public static function temPermissao($acao) {
        $usuario = self::obterUsuario();

        if (!$usuario) {
            return false;
        }

        $permissoes = [
            'admin' => [
                'visualizar' => true,
                'adicionar' => true,
                'editar' => true,
                'excluir' => true
            ],
            'empresa' => [
                'visualizar' => true,
                'adicionar' => true,
                'editar' => false,
                'excluir' => false
            ],
            'usuario' => [
                'visualizar' => true,
                'adicionar' => false,
                'editar' => false,
                'excluir' => false
            ],
        ];

        if (!isset($permissoes[$usuario['perfil']]) || !isset($permissoes[$usuario['perfil']][$acao])) {
            return false;
        }

        return $permissoes[$usuario['perfil']][$acao];
        
    }





}


?>