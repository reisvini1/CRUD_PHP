<?php
// Conexão
require 'php_action/db_connect.php';

// Header
require 'includes/header.php';
// Verificação
session_start();
if(!isset($_SESSION['logado'])):
    header('Location: index.php');
endif;
session_destroy();
// Message
require 'includes/message.php';
?>

<div class="row">
    <div class="col s12 m6 push-m3">
        <h3 class="light">Clientes</h3>
        <table class="striped">
            <thead>
                <tr>
                    <th>Nome:</th>
                    <th>Sobrenome:</th>
                    <th>Email:</th>
                    <th>Idade:</th>
                </tr>
            </thead>
            <tbody>

            <?php
            // SELECT BANCO
            $sql = "SELECT * FROM clientes";
            $resultado = mysqli_query($connect, $sql);

            if(mysqli_num_rows($resultado) > 0):

                while($dados = mysqli_fetch_array($resultado)):
                mysqli_close($connect);
            ?>
                    
                    <!-- Tabela -->
                    <tr>
                        <td><?php echo $dados ['nome']; ?></td>
                        <td><?php echo $dados ['sobrenome']; ?></td>
                        <td><?php echo $dados ['email']; ?></td>
                        <td><?php echo $dados ['idade']; ?></td>

                        <!-- Botão Editar -->
                        <td><a href="edit.php?id=<?php echo $dados ['id']; ?>" class="btn-floating blue"><i class="material-icons">edit</i></a></td>

                        <!-- Botão Excluir -->
                        <td><a href="#modal<?php echo $dados ['id']; ?>" class="btn-floating red modal-trigger"><i class="material-icons">delete</i></a></td>

                        <!-- Modal Structure -->
                        <div id="modal<?php echo $dados ['id']; ?>" class="modal">
                            <div class="modal-content">
                            <h4>Opa!</h4>
                            <p>Tem certeza que deseja excluir esse cliente?</p>
                            </div>
                            <div class="modal-footer">

                            <form action="php_action/delete.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $dados ['id']; ?>">

                                <button type="submit" name="btn-deletar" class="btn red">Sim, quero deletar.</button>

                                <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
                            </form>
                            </div>
                        </div>
                                
                        </tr>
                <?php 
                endwhile;
                else: ?> 
                    <tr>-</tr>
                    <tr>-</tr>
                    <tr>-</tr>
                    <tr>-</tr>

                <?php
                endif;
                ?>

            </tbody>
        </table>
        <br>

        <!-- Botão Add -->
        <a href="add.php" class="btn">Adicionar cliente</a>

        <!-- Logout -->
        <a href="logout.php" class="btn">Sair</a>
    </div>
</div>
<?php
// Footer
require 'includes/footer.php';
?>