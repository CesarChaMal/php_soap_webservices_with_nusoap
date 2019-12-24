<?php
/**
 * Codigo para consumir un servicio web (Web Service) por medio de NuSoap
 * La distribucion del codigo es totalmente gratuita y no tiene ningun tipo de restriccion. 
 * Se agradece que mantengan la fuente del mismo.
 */

error_reporting(1); 

// Inclusion de la libreria nusoap (la que contendra toda la conexión con el servidor //
require_once('nusoap/lib/nusoap.php');

$oSoapClient = new soapclient('http://www.sencide.com/blog/login.php', true);

if ($sError = $oSoapClient->getError()) {
	echo "No se pudo realizar la operación [" . $sError . "]";
	die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $aParametros = array("username" => $_POST["username"], "password" => $_POST["password"]);
	$aRespuesta = $oSoapClient->call("AuthenticateUser", $aParametros);
}
// Existe alguna falla en el servicio?
if ($oSoapClient->fault) { // Si
	echo 'No se pudo completar la operaci&oacute;n';
	die();
} else { // No
	$sError = $oSoapClient->getError();
	// Hay algun error ?
	if ($sError) { // Si
		echo 'Error:' . $sError;
	} 
}
?>

<html>
<body>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <table width="367" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2"><div align="center">Login</div></td>
      </tr>
      <tr>
        <td width="147">&nbsp;</td>
	    <td width="220">&nbsp;</td>
      </tr>

      <tr>
        <td>username:</td>
        <td><input type="text" id="username" name="username" required minlength="4" maxlength="10" size="10"></td>
      </tr>
      <tr>
        <td>password:</td>
        <td><input type="password" id="password" name="password" required minlength="4" maxlength="10" size="10"></td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit"></td>
        <td></td>
      </tr>
    </table>
</form>
<?php 
$username = $_POST["username"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($aRespuesta ["AuthenticateUserResult"] == 'true') {
        echo "<p>Welcome $username.</p>";
    } else {
        echo "<p>Invalid user.</p>";
    }
}?> 
</body>
</html>
