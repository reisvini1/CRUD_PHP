<?php
// Conexão 
require 'php_action/db_connect.php';

// Header
require 'includes/header_login.php';

// Message
require 'includes/message.php';

// Botão entrar
if(isset($_POST['btn-login'])):
    $login = mysqli_escape_string($connect, $_POST['login']);
    $senha = mysqli_escape_string($connect, $_POST['senha']);
    
    // Lembrar senha
	if(isset($_POST['lembrar-senha'])):

		setcookie('login', $login, time()+3600);
		setcookie('senha', md5($senha), time()+3600);
	endif;

    // Verif. usuário ou senha vazios
    if(empty($login) || empty($senha)):
        $_SESSION['mensagem'] = "O campo login ou senha não pode ficar vazio";
        header('Location: index.php');
    else:
        $sql = "SELECT login FROM usuarios WHERE login = '$login'";
        $resultado = mysqli_query($connect, $sql);
        
        // Conexão DB e encriptografia senha
        if(mysqli_num_rows($resultado) > 0):
            $senha = md5($senha);
            $sql = "SELECT * FROM usuarios WHERE login = '$login' AND senha = '$senha'";

            $resultado = mysqli_query($connect, $sql);

            if(mysqli_num_rows($resultado) == 1):
                $dados = mysqli_fetch_array($resultado);
                mysqli_close($connect);

                $_SESSION['logado'] = true;
                $_SESSION['id_usuario'] = $dados['id'];
                header('Location: registro.php');
            else:
                $_SESSION['mensagem'] = "Usuário e senha não conferem";
            endif;
        
        else:
            $_SESSION['mensagem'] = "Usuário inexistente";
        endif;

    endif;

endif;
?>

<!-- Inputs login, senha e botão entrar -->
<h1>Login</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    Login: <input type="text" name="login" value="<?php echo isset($_COOKIE['login']) ? $_COOKIE['login'] : '' ?>">
    <br>
    Senha: <input type="password" name="senha" value="<?php echo isset($_COOKIE['senha']) ? $_COOKIE['senha'] : '' ?>">
    <br>
    <label>
    <input type="checkbox" name="lembrar-senha" class="filled-in">
    <span>Lembrar senha</span>
    </label>
    <br>
    <button type="submit" name="btn-login" class="btn green"> Entrar </button>
</form>
<?php
// Footer
require 'includes/footer.php';
?>