<?PHP
function seguranca_admin()
{
	require_once __DIR__ . '/../backend/validate_user.php';

	$usuario = isset($_SESSION["user"]) ? $_SESSION["user"] : "";
	$senha = isset($_SESSION["senha"]) ? $_SESSION["senha"] : "";

	$result = validaAdmin($usuario, $senha);

	if ($result == '' || $result == 0) {
		header("Location: /acesso_negado");
	}
}

seguranca_admin();

?>