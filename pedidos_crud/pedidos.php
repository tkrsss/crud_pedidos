<?php
$pedidos = [
    ['id' => 1, 'nome_cliente' => 'Vini', 'nome_produto' => 'Tesla Model Y', 'quantidade' => 1, 'data_pedido' => '2020-01-20'],
    ['id' => 2, 'nome_cliente' => 'Max', 'nome_produto' => 'Tesla Cybertruck', 'quantidade' => 1, 'data_pedido' => '2020-12-19']
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $pedidos[] = [
            'id' => count($pedidos) + 1,
            'nome_cliente' => $_POST['nome_cliente'],
            'nome_produto' => $_POST['nome_produto'],
            'quantidade' => $_POST['quantidade'],
            'data_pedido' => $_POST['data_pedido']
        ];
    } elseif (isset($_POST['update'])) {
        foreach ($pedidos as &$pedido) {
            if ($pedido['id'] == $_POST['id']) {
                $pedido = [
                    'id' => $_POST['id'],
                    'nome_cliente' => $_POST['nome_cliente'],
                    'nome_produto' => $_POST['nome_produto'],
                    'quantidade' => $_POST['quantidade'],
                    'data_pedido' => $_POST['data_pedido']
                ];
                break;
            }
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $pedidos = array_filter($pedidos, fn($pedido) => $pedido['id'] != $id);
}

$editarPedido = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    foreach ($pedidos as $pedido) {
        if ($pedido['id'] == $id) {
            $editarPedido = $pedido;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Pedidos</title>
    <link rel="stylesheet" href="pedidos.css">
</head>
<body>
    <h1>Sistema de Pedidos</h1>
    
    <h2><?php echo $editarPedido ? 'Editar Pedido' : 'Criar Pedido'; ?></h2>
    <form method="post">
        <?php if ($editarPedido): ?>
            <input type="hidden" name="id" value="<?php echo $editarPedido['id']; ?>">
        <?php endif; ?>
        <label>Nome do Cliente:</label>
        <input type="text" name="nome_cliente" value="<?php echo $editarPedido['nome_cliente'] ?? ''; ?>" required><br>
        
        <label>Nome do Produto:</label>
        <input type="text" name="nome_produto" value="<?php echo $editarPedido['nome_produto'] ?? ''; ?>" required><br>
        
        <label>Quantidade:</label>
        <input type="number" name="quantidade" value="<?php echo $editarPedido['quantidade'] ?? ''; ?>" required><br>
        
        <label>Data do Pedido:</label>
        <input type="date" name="data_pedido" value="<?php echo $editarPedido['data_pedido'] ?? ''; ?>" required><br>
        
        <input type="submit" name="<?php echo $editarPedido ? 'update' : 'create'; ?>" value="<?php echo $editarPedido ? 'Atualizar Pedido' : 'Criar Pedido'; ?>">
    </form>

    <h2>Pedidos</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome do Cliente</th>
            <th>Nome do Produto</th>
            <th>Quantidade</th>
            <th>Data do Pedido</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($pedidos as $pedido): ?>
        <tr>
            <td><?php echo $pedido['id']; ?></td>
            <td><?php echo $pedido['nome_cliente']; ?></td>
            <td><?php echo $pedido['nome_produto']; ?></td>
            <td><?php echo $pedido['quantidade']; ?></td>
            <td><?php echo $pedido['data_pedido']; ?></td>
            <td>
                <a href="?edit=<?php echo $pedido['id']; ?>">Editar</a>
                <a href="?delete=<?php echo $pedido['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este pedido?')">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
