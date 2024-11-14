<?PHP

require_once __DIR__ . '/../backend/validate_user.php';

$usuario = isset($_SESSION["user"]) ? $_SESSION["user"] : "";
$senha = isset($_SESSION["senha"]) ? $_SESSION["senha"] : "";

if (!validaUsuario($usuario, $senha)) {
	header("Location: /acesso_negado");
}

?>