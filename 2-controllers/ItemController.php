<?php

// controlar os itens
class ItemController {

    // lista todos os itens
    public function listar() {
        require_once 'models/Item.php';
        $itens = Item::buscarTodos();

        require_once 'views/lista.php';
        renderizarLista($itens);
    }


    // exibe detalhe de um item
    public function visualizar($id) {
        if (!Auth::temPermissao('visualizar')) {
            $_SESSION['mensagem'] = "Você não tem permissão para visualizar itens.";
            exit;
        }

        // se tiver permissão, retorna true
        return true;
        // require_once 'models/item.php';
        // $item = Item::buscarPorId($id);
        // require_once ''
        
    }

    public function adicionar($id) {
        if (!Auth::temPermissao('visualizar')) {
            $_SESSION['mensagem'] = "Você não tem permissão para visualizar itens.";
            exit;
        }

        // se tiver permissão, retorna true
        return true;
        // require_once 'models/item.php';
        // $item = Item::buscarPorId($id);
        // require_once ''
        
    }
}



?>