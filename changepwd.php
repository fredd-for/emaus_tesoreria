<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "usuarioinfo.php" ?>
<?php include "userfn6.php" ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php

// Define page object
$changepwd = new cchangepwd();
$Page =& $changepwd;

// Page init processing
$changepwd->Page_Init();

// Page main processing
$changepwd->Page_Main();
?>
<?php include "header.php" ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<script type="text/javascript">
<!--
var changepwd = new ew_Page("changepwd");

// extend page with ValidateForm function
changepwd.ValidateForm = function(fobj)
{
	if (!this.ValidateRequired)
		return true; // ignore validation
	if  (!ew_HasValue(fobj.opwd))
		return ew_OnError(this, fobj.opwd, "Ingrese antigua contraseña");
	if  (!ew_HasValue(fobj.npwd))
		return ew_OnError(this, fobj.npwd, "Por favor ingrese nueva contraseña");
	if  (fobj.npwd.value != fobj.cpwd.value)
		return ew_OnError(this, fobj.cpwd, "Contraseñas no coinciden");

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj)) return false;
	return true;
}

// extend page with Form_CustomValidate function
changepwd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// requires js validation
<?php if (EW_CLIENT_VALIDATE) { ?>
changepwd.ValidateRequired = true;
<?php } else { ?>
changepwd.ValidateRequired = false;
<?php } ?>

//-->
</script>
<p><span class="phpmaker">Página para cambiar contraseña</span></p>
<?php $changepwd->ShowMessage() ?>
<form action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return changepwd.ValidateForm(this);">
<table border="0" cellspacing="0" cellpadding="4">
	<tr>
		<td><span class="phpmaker">Contraseña anterior</span></td>
		<td><span class="phpmaker"><input type="password" name="opwd" id="opwd" size="20"></span></td>
	</tr>
	<tr>
		<td><span class="phpmaker">Nueva Contraseña</span></td>
		<td><span class="phpmaker"><input type="password" name="npwd" id="npwd" size="20"></span></td>
	</tr>
	<tr>
		<td><span class="phpmaker">Confirmar Contraseña</span></td>
		<td><span class="phpmaker"><input type="password" name="cpwd" id="cpwd" size="20"></span></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><span class="phpmaker"><input type="submit" name="submit" id="submit" value="Cambiar Contraseña"></span></td>
	</tr>
</table>
</form>
<br>
<script language="JavaScript" type="text/javascript">
<!--

// Write your startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php

//
// Page Class
//
class cchangepwd {

	// Page ID
	var $PageID = 'changepwd';

	// Page Object Name
	var $PageObjName = 'changepwd';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		if (@$_SESSION[EW_SESSION_MESSAGE] <> "") { // Append
			$_SESSION[EW_SESSION_MESSAGE] .= "<br>" . $v;
		} else {
			$_SESSION[EW_SESSION_MESSAGE] = $v;
		}
	}

	// Show Message
	function ShowMessage() {
		if ($this->getMessage() <> "") { // Message in Session, display
			echo "<p><span class=\"ewMessage\">" . $this->getMessage() . "</span></p>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}
	}

	// Validate Page request
	function IsPageRequest() {
		return TRUE;
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cchangepwd() {
		global $conn;

		// Initialize table object
		$GLOBALS["usuario"] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'changepwd', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $usuario;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn() || $Security->IsSysAdmin())
			$this->Page_Terminate("login.php");
		$Security->LoadCurrentUserLevel("usuario");

		// Global page loading event (in userfn6.php)
		Page_Loading();

		// Page load event, used in current page
		$this->Page_Load();
	}

	//
	//  Page_Terminate
	//  - called when exit page
	//  - if URL specified, redirect to the URL
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page unload event, used in current page
		$this->Page_Unload();

		// Global page unloaded event (in userfn*.php)
		Page_Unloaded();

		 // Close Connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			ob_end_clean();
			header("Location: $url");
		}
		exit();
	}

	// 
	// Page main processing
	//
	function Page_Main() {
		global $conn, $Security, $gsFormError, $usuario;
		if (!ew_IsHttpPost())
			return;
		$bPwdUpdated = FALSE;

		// Setup variables
		$sUsername = $Security->CurrentUserName();
		$sOPwd = ew_StripSlashes(@$_POST["opwd"]);
		$sNPwd = ew_StripSlashes(@$_POST["npwd"]);
		$sCPwd = ew_StripSlashes(@$_POST["cpwd"]);
		if ($this->ValidateForm($sOPwd, $sNPwd, $sCPwd)) {
			$sFilter = "(login = '" . ew_AdjustSql($sUsername) . "')";

			// Set up filter (Sql Where Clause) and get Return SQL
			// SQL constructor in usuario class, usuarioinfo.php

			$usuario->CurrentFilter = $sFilter;
			$sSql = $usuario->SQL();
			if ($rs = $conn->Execute($sSql)) {
				if (!$rs->EOF) {
					if ((EW_MD5_PASSWORD && md5($sOPwd) == $rs->fields('password')) ||
						(!EW_MD5_PASSWORD && $sOPwd == $rs->fields('password'))) {
						$rsnew = array('password' => $sNPwd); // Change Password
						$rs->Close();
						$conn->raiseErrorFn = 'ew_ErrorFn';
						$bValidPwd = $conn->Execute($usuario->UpdateSQL($rsnew));
						$conn->raiseErrorFn = '';
						if ($bValidPwd)
							$bPwdUpdated = TRUE;
					}	else {
						$this->setMessage("Contraseña incorrecta");
					}
				} else {
					$rs->Close();
				}
			}
		}
		if ($bPwdUpdated) {
			$this->setMessage("Contraseña cambiada"); // set up message
			$this->Page_Terminate("index.php"); // exit page and clean up
		} else {
			$this->setMessage($gsFormError);
		}
	}

	// 
	// Validate form
	//
	function ValidateForm($opwd, $npwd, $cpwd) {

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;
		global $gsFormError;
		$gsFormError = "";
		if ($opwd == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Ingrese antigua contraseña";
		}
		if ($npwd == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese nueva contraseña";
		}
		if ($npwd <> $cpwd) {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Contraseñas no coinciden";
		}

		// Return validate result
		$valid = ($gsFormError == "");

		// Call Form Custom Validate event
		$sFormCustomError = "";
		$valid = $valid && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $sFormCustomError;
		}
		return $valid;
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
