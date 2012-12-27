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
$register = new cregister();
$Page =& $register;

// Page init processing
$register->Page_Init();

// Page main processing
$register->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var register = new ew_Page("register");

// page properties
register.PageID = "register"; // page ID
var EW_PAGE_ID = register.PageID; // for backward compatibility

// extend page with ValidateForm function
register.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_nombre"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Nombre(s)");
		elm = fobj.elements["x" + infix + "_paterno"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Apellido Paterno");
		elm = fobj.elements["x" + infix + "_ci"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - C.I");
		elm = fobj.elements["x" + infix + "_ci"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Entero Incorrecto - C.I");
		elm = fobj.elements["x" + infix + "_cargo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Cargo en la Iglesia");
		elm = fobj.elements["x" + infix + "_zlogin"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Login");
		elm = fobj.elements["x" + infix + "_password"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Password");
		if (fobj.x_password && !ew_HasValue(fobj.x_password)) {
			return ew_OnError(this, fobj.x_password, "Ingrese contraseña");
		}
		if (fobj.c_password.value != fobj.x_password.value) {
			return ew_OnError(this, fobj.c_password, "Contraseñas no coinciden");
		}

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
register.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
register.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
register.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<p><span class="phpmaker">Página de Registro<br><br>
<a href="login.php">Volver a la página de acceso</a></span></p>
<?php $register->ShowMessage() ?>
<form name="fusuarioregister" id="fusuarioregister" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return register.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="usuario">
<input type="hidden" name="a_register" id="a_register" value="A">
<?php if ($usuario->CurrentAction == "F") { // Confirm page ?>
<input type="hidden" name="a_confirm" id="a_confirm" value="F">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table class="ewTable">
	<tr<?php echo $usuario->nombre->RowAttributes ?>>
		<td class="ewTableHeader">Nombre(s)<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $usuario->nombre->CellAttributes() ?>><span id="el_nombre">
<?php if ($usuario->CurrentAction <> "F") { ?>
<input type="text" name="x_nombre" id="x_nombre" size="30" maxlength="100" value="<?php echo $usuario->nombre->EditValue ?>"<?php echo $usuario->nombre->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $usuario->nombre->ViewAttributes() ?>><?php echo $usuario->nombre->ViewValue ?></div>
<input type="hidden" name="x_nombre" id="x_nombre" value="<?php echo ew_HtmlEncode($usuario->nombre->FormValue) ?>">
<?php } ?>
</span><?php echo $usuario->nombre->CustomMsg ?></td>
	</tr>
	<tr<?php echo $usuario->paterno->RowAttributes ?>>
		<td class="ewTableHeader">Apellido Paterno<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $usuario->paterno->CellAttributes() ?>><span id="el_paterno">
<?php if ($usuario->CurrentAction <> "F") { ?>
<input type="text" name="x_paterno" id="x_paterno" size="30" maxlength="100" value="<?php echo $usuario->paterno->EditValue ?>"<?php echo $usuario->paterno->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $usuario->paterno->ViewAttributes() ?>><?php echo $usuario->paterno->ViewValue ?></div>
<input type="hidden" name="x_paterno" id="x_paterno" value="<?php echo ew_HtmlEncode($usuario->paterno->FormValue) ?>">
<?php } ?>
</span><?php echo $usuario->paterno->CustomMsg ?></td>
	</tr>
	<tr<?php echo $usuario->materno->RowAttributes ?>>
		<td class="ewTableHeader">Apellido Materno</td>
		<td<?php echo $usuario->materno->CellAttributes() ?>><span id="el_materno">
<?php if ($usuario->CurrentAction <> "F") { ?>
<input type="text" name="x_materno" id="x_materno" size="30" maxlength="100" value="<?php echo $usuario->materno->EditValue ?>"<?php echo $usuario->materno->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $usuario->materno->ViewAttributes() ?>><?php echo $usuario->materno->ViewValue ?></div>
<input type="hidden" name="x_materno" id="x_materno" value="<?php echo ew_HtmlEncode($usuario->materno->FormValue) ?>">
<?php } ?>
</span><?php echo $usuario->materno->CustomMsg ?></td>
	</tr>
	<tr<?php echo $usuario->ci->RowAttributes ?>>
		<td class="ewTableHeader">C.I<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $usuario->ci->CellAttributes() ?>><span id="el_ci">
<?php if ($usuario->CurrentAction <> "F") { ?>
<input type="text" name="x_ci" id="x_ci" size="30" value="<?php echo $usuario->ci->EditValue ?>"<?php echo $usuario->ci->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $usuario->ci->ViewAttributes() ?>><?php echo $usuario->ci->ViewValue ?></div>
<input type="hidden" name="x_ci" id="x_ci" value="<?php echo ew_HtmlEncode($usuario->ci->FormValue) ?>">
<?php } ?>
</span><?php echo $usuario->ci->CustomMsg ?></td>
	</tr>
	<tr<?php echo $usuario->cargo->RowAttributes ?>>
		<td class="ewTableHeader">Cargo en la Iglesia<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $usuario->cargo->CellAttributes() ?>><span id="el_cargo">
<?php if ($usuario->CurrentAction <> "F") { ?>
<input type="text" name="x_cargo" id="x_cargo" size="30" maxlength="100" value="<?php echo $usuario->cargo->EditValue ?>"<?php echo $usuario->cargo->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $usuario->cargo->ViewAttributes() ?>><?php echo $usuario->cargo->ViewValue ?></div>
<input type="hidden" name="x_cargo" id="x_cargo" value="<?php echo ew_HtmlEncode($usuario->cargo->FormValue) ?>">
<?php } ?>
</span><?php echo $usuario->cargo->CustomMsg ?></td>
	</tr>
	<tr<?php echo $usuario->zlogin->RowAttributes ?>>
		<td class="ewTableHeader">Login<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $usuario->zlogin->CellAttributes() ?>><span id="el_zlogin">
<?php if ($usuario->CurrentAction <> "F") { ?>
<input type="text" name="x_zlogin" id="x_zlogin" size="30" maxlength="50" value="<?php echo $usuario->zlogin->EditValue ?>"<?php echo $usuario->zlogin->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $usuario->zlogin->ViewAttributes() ?>><?php echo $usuario->zlogin->ViewValue ?></div>
<input type="hidden" name="x_zlogin" id="x_zlogin" value="<?php echo ew_HtmlEncode($usuario->zlogin->FormValue) ?>">
<?php } ?>
</span><?php echo $usuario->zlogin->CustomMsg ?></td>
	</tr>
	<tr<?php echo $usuario->password->RowAttributes ?>>
		<td class="ewTableHeader">Password<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $usuario->password->CellAttributes() ?>><span id="el_password">
<?php if ($usuario->CurrentAction <> "F") { ?>
<input type="text" name="x_password" id="x_password" size="30" maxlength="50" value="<?php echo $usuario->password->EditValue ?>"<?php echo $usuario->password->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $usuario->password->ViewAttributes() ?>><?php echo $usuario->password->ViewValue ?></div>
<input type="hidden" name="x_password" id="x_password" value="<?php echo ew_HtmlEncode($usuario->password->FormValue) ?>">
<?php } ?>
</span><?php echo $usuario->password->CustomMsg ?></td>
	</tr>
	<tr<?php echo $usuario->password->RowAttributes ?>>
		<td class="ewTableHeader">Confirmar Password</td>
		<td<?php echo $usuario->password->CellAttributes() ?>>
<?php if ($usuario->CurrentAction <> "F") { ?>
<input type="text" name="c_password" id="c_password" size="30" maxlength="50" value="<?php echo $usuario->password->EditValue ?>"<?php echo $usuario->password->EditAttributes() ?>>
<?php } else { ?>
<div<?php echo $usuario->password->ViewAttributes() ?>><?php echo $usuario->password->ViewValue ?></div>
<input type="hidden" name="c_password" id="c_password" value="<?php echo ew_HtmlEncode($usuario->password->FormValue) ?>">
<?php } ?>
</td>
	</tr>
</table>
</div>
</td></tr></table>
<p>
<?php if ($usuario->CurrentAction <> "F") { // Confirm page ?>
<input type="submit" name="btnAction" id="btnAction" value=" Registrar " onclick="this.form.a_register.value='F';">
<?php } else { ?>
<input type="submit" name="btnCancel" id="btnCancel" value=" Cancelar " onclick="this.form.a_register.value='X';">
<input type="submit" name="btnAction" id="btnAction" value=" Confirmar ">
<?php } ?>
</form>
<?php if ($usuario->CurrentAction <> "F") { ?>
<?php } ?>
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
class cregister {

	// Page ID
	var $PageID = 'register';

	// Page Object Name
	var $PageObjName = 'register';

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
	function cregister() {
		global $conn;

		// Initialize table object
		$GLOBALS["usuario"] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'register', TRUE);

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
		global $conn, $gsFormError, $objForm, $usuario;
		$bUserExists = FALSE;

		// Create form object
		$objForm = new cFormObj();
		if (@$_POST["a_register"] <> "") {

			// Get action
			$usuario->CurrentAction = $_POST["a_register"];
			$this->LoadFormValues(); // Get form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$usuario->CurrentAction = "I"; // Form error, reset action
				$this->setMessage($gsFormError);
			}
		} else {
			$usuario->CurrentAction = "I"; // Display blank record
			$this->LoadDefaultValues(); // Load default values
		}
		switch ($usuario->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "A": // Add

				// Check for duplicate User ID
				$sFilter = "(`login` = '" . ew_AdjustSql($usuario->zlogin->CurrentValue) . "')";

				// Set up filter (SQL WHERE Clause) and get return SQL
				// SQL constructor in usuario class, usuarioinfo.php

				$usuario->CurrentFilter = $sFilter;
				$sUserSql = $usuario->SQL();
				if ($rs = $conn->Execute($sUserSql)) {
					if (!$rs->EOF) {
						$bUserExists = TRUE;
						$this->RestoreFormValues(); // Restore form values
						$this->setMessage("¡El Usuario ya existe!"); // Set user exist message
					}
					$rs->Close();
				}
				if (!$bUserExists) {
					$usuario->SendEmail = TRUE; // Send email on add success
					if ($this->AddRow()) { // Add record
						$this->setMessage("Registro Exitoso"); // Register success
						$this->Page_Terminate("login.php"); // Return
					} else {
						$this->RestoreFormValues(); // Restore form values
					}
				}
		}

		// Render row
		if ($usuario->CurrentAction == "F") { // Confirm page
			$usuario->RowType = EW_ROWTYPE_VIEW; // Render view
		} else {
			$usuario->RowType = EW_ROWTYPE_ADD; // Render add
		}
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $usuario;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $usuario;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $usuario;
		$usuario->idUsuario->setFormValue($objForm->GetValue("x_idUsuario"));
		$usuario->nombre->setFormValue($objForm->GetValue("x_nombre"));
		$usuario->paterno->setFormValue($objForm->GetValue("x_paterno"));
		$usuario->materno->setFormValue($objForm->GetValue("x_materno"));
		$usuario->ci->setFormValue($objForm->GetValue("x_ci"));
		$usuario->cargo->setFormValue($objForm->GetValue("x_cargo"));
		$usuario->zlogin->setFormValue($objForm->GetValue("x_zlogin"));
		$usuario->password->setFormValue($objForm->GetValue("x_password"));
		$usuario->password->ConfirmValue = $objForm->GetValue("c_password");
	}

	// Restore form values
	function RestoreFormValues() {
		global $usuario;
		$usuario->idUsuario->CurrentValue = $usuario->idUsuario->FormValue;
		$usuario->nombre->CurrentValue = $usuario->nombre->FormValue;
		$usuario->paterno->CurrentValue = $usuario->paterno->FormValue;
		$usuario->materno->CurrentValue = $usuario->materno->FormValue;
		$usuario->ci->CurrentValue = $usuario->ci->FormValue;
		$usuario->cargo->CurrentValue = $usuario->cargo->FormValue;
		$usuario->zlogin->CurrentValue = $usuario->zlogin->FormValue;
		$usuario->password->CurrentValue = $usuario->password->FormValue;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $usuario;

		// Call Row_Rendering event
		$usuario->Row_Rendering();

		// Common render codes for all row types
		// idUsuario

		$usuario->idUsuario->CellCssStyle = "";
		$usuario->idUsuario->CellCssClass = "";

		// nombre
		$usuario->nombre->CellCssStyle = "";
		$usuario->nombre->CellCssClass = "";

		// paterno
		$usuario->paterno->CellCssStyle = "";
		$usuario->paterno->CellCssClass = "";

		// materno
		$usuario->materno->CellCssStyle = "";
		$usuario->materno->CellCssClass = "";

		// ci
		$usuario->ci->CellCssStyle = "";
		$usuario->ci->CellCssClass = "";

		// cargo
		$usuario->cargo->CellCssStyle = "";
		$usuario->cargo->CellCssClass = "";

		// login
		$usuario->zlogin->CellCssStyle = "";
		$usuario->zlogin->CellCssClass = "";

		// password
		$usuario->password->CellCssStyle = "";
		$usuario->password->CellCssClass = "";
		if ($usuario->RowType == EW_ROWTYPE_VIEW) { // View row

			// idUsuario
			$usuario->idUsuario->ViewValue = $usuario->idUsuario->CurrentValue;
			$usuario->idUsuario->CssStyle = "";
			$usuario->idUsuario->CssClass = "";
			$usuario->idUsuario->ViewCustomAttributes = "";

			// idRol
			if ($Security->CanAdmin()) { // System admin
			if (strval($usuario->idRol->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `nombre` FROM `rol` WHERE `idRol` = " . ew_AdjustSql($usuario->idRol->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `nombre` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$usuario->idRol->ViewValue = $rswrk->fields('nombre');
					$rswrk->Close();
				} else {
					$usuario->idRol->ViewValue = $usuario->idRol->CurrentValue;
				}
			} else {
				$usuario->idRol->ViewValue = NULL;
			}
			} else {
				$usuario->idRol->ViewValue = "********";
			}
			$usuario->idRol->CssStyle = "";
			$usuario->idRol->CssClass = "";
			$usuario->idRol->ViewCustomAttributes = "";

			// nombre
			$usuario->nombre->ViewValue = $usuario->nombre->CurrentValue;
			$usuario->nombre->CssStyle = "";
			$usuario->nombre->CssClass = "";
			$usuario->nombre->ViewCustomAttributes = "";

			// paterno
			$usuario->paterno->ViewValue = $usuario->paterno->CurrentValue;
			$usuario->paterno->CssStyle = "";
			$usuario->paterno->CssClass = "";
			$usuario->paterno->ViewCustomAttributes = "";

			// materno
			$usuario->materno->ViewValue = $usuario->materno->CurrentValue;
			$usuario->materno->CssStyle = "";
			$usuario->materno->CssClass = "";
			$usuario->materno->ViewCustomAttributes = "";

			// ci
			$usuario->ci->ViewValue = $usuario->ci->CurrentValue;
			$usuario->ci->CssStyle = "";
			$usuario->ci->CssClass = "";
			$usuario->ci->ViewCustomAttributes = "";

			// cargo
			$usuario->cargo->ViewValue = $usuario->cargo->CurrentValue;
			$usuario->cargo->CssStyle = "";
			$usuario->cargo->CssClass = "";
			$usuario->cargo->ViewCustomAttributes = "";

			// login
			$usuario->zlogin->ViewValue = $usuario->zlogin->CurrentValue;
			$usuario->zlogin->CssStyle = "";
			$usuario->zlogin->CssClass = "";
			$usuario->zlogin->ViewCustomAttributes = "";

			// password
			$usuario->password->ViewValue = $usuario->password->CurrentValue;
			$usuario->password->CssStyle = "";
			$usuario->password->CssClass = "";
			$usuario->password->ViewCustomAttributes = "";

			// idUsuario
			$usuario->idUsuario->HrefValue = "";

			// nombre
			$usuario->nombre->HrefValue = "";

			// paterno
			$usuario->paterno->HrefValue = "";

			// materno
			$usuario->materno->HrefValue = "";

			// ci
			$usuario->ci->HrefValue = "";

			// cargo
			$usuario->cargo->HrefValue = "";

			// login
			$usuario->zlogin->HrefValue = "";

			// password
			$usuario->password->HrefValue = "";
		} elseif ($usuario->RowType == EW_ROWTYPE_ADD) { // Add row

			// idUsuario
			// nombre

			$usuario->nombre->EditCustomAttributes = "";
			$usuario->nombre->EditValue = ew_HtmlEncode($usuario->nombre->CurrentValue);

			// paterno
			$usuario->paterno->EditCustomAttributes = "";
			$usuario->paterno->EditValue = ew_HtmlEncode($usuario->paterno->CurrentValue);

			// materno
			$usuario->materno->EditCustomAttributes = "";
			$usuario->materno->EditValue = ew_HtmlEncode($usuario->materno->CurrentValue);

			// ci
			$usuario->ci->EditCustomAttributes = "";
			$usuario->ci->EditValue = ew_HtmlEncode($usuario->ci->CurrentValue);

			// cargo
			$usuario->cargo->EditCustomAttributes = "";
			$usuario->cargo->EditValue = ew_HtmlEncode($usuario->cargo->CurrentValue);

			// login
			$usuario->zlogin->EditCustomAttributes = "";
			$usuario->zlogin->EditValue = ew_HtmlEncode($usuario->zlogin->CurrentValue);

			// password
			$usuario->password->EditCustomAttributes = "";
			$usuario->password->EditValue = ew_HtmlEncode($usuario->password->CurrentValue);
		}

		// Call Row Rendered event
		$usuario->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $usuario;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($usuario->nombre->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Nombre(s)";
		}
		if ($usuario->paterno->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Apellido Paterno";
		}
		if ($usuario->ci->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - C.I";
		}
		if (!ew_CheckInteger($usuario->ci->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Entero Incorrecto - C.I";
		}
		if ($usuario->cargo->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Cargo en la Iglesia";
		}
		if ($usuario->zlogin->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Login";
		}
		if ($usuario->password->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Password";
		}
		if ($usuario->password->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Ingrese contraseña";
		}
		if ($usuario->password->ConfirmValue <> $usuario->password->FormValue) {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Contraseñas no coinciden";
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $sFormCustomError;
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow() {
		global $conn, $Security, $usuario;
		$rsnew = array();

		// Field idUsuario
		// Field nombre

		$usuario->nombre->SetDbValueDef($usuario->nombre->CurrentValue, "");
		$rsnew['nombre'] =& $usuario->nombre->DbValue;

		// Field paterno
		$usuario->paterno->SetDbValueDef($usuario->paterno->CurrentValue, "");
		$rsnew['paterno'] =& $usuario->paterno->DbValue;

		// Field materno
		$usuario->materno->SetDbValueDef($usuario->materno->CurrentValue, NULL);
		$rsnew['materno'] =& $usuario->materno->DbValue;

		// Field ci
		$usuario->ci->SetDbValueDef($usuario->ci->CurrentValue, 0);
		$rsnew['ci'] =& $usuario->ci->DbValue;

		// Field cargo
		$usuario->cargo->SetDbValueDef($usuario->cargo->CurrentValue, "");
		$rsnew['cargo'] =& $usuario->cargo->DbValue;

		// Field login
		$usuario->zlogin->SetDbValueDef($usuario->zlogin->CurrentValue, "");
		$rsnew['login'] =& $usuario->zlogin->DbValue;

		// Field password
		$usuario->password->SetDbValueDef($usuario->password->CurrentValue, "");
		$rsnew['password'] =& $usuario->password->DbValue;

		// Call Row Inserting event
		$bInsertRow = $usuario->Row_Inserting($rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($usuario->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($usuario->CancelMessage <> "") {
				$this->setMessage($usuario->CancelMessage);
				$usuario->CancelMessage = "";
			} else {
				$this->setMessage("Insertar cancelado");
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {
			$usuario->idUsuario->setDbValue($conn->Insert_ID());
			$rsnew['idUsuario'] =& $usuario->idUsuario->DbValue;

			// Call Row Inserted event
			$usuario->Row_Inserted($rsnew);
		}
		return $AddRow;
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
