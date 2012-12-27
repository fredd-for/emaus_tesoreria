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
$usuario_edit = new cusuario_edit();
$Page =& $usuario_edit;

// Page init processing
$usuario_edit->Page_Init();

// Page main processing
$usuario_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var usuario_edit = new ew_Page("usuario_edit");

// page properties
usuario_edit.PageID = "edit"; // page ID
var EW_PAGE_ID = usuario_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
usuario_edit.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_idRol"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Rol");
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

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
usuario_edit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
usuario_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
usuario_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Editar TABLA: Usuario<br><br>
<a href="<?php echo $usuario->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $usuario_edit->ShowMessage() ?>
<form name="fusuarioedit" id="fusuarioedit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return usuario_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="usuario">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($usuario->idUsuario->Visible) { // idUsuario ?>
	<tr<?php echo $usuario->idUsuario->RowAttributes ?>>
		<td class="ewTableHeader">No</td>
		<td<?php echo $usuario->idUsuario->CellAttributes() ?>><span id="el_idUsuario">
<div<?php echo $usuario->idUsuario->ViewAttributes() ?>><?php echo $usuario->idUsuario->EditValue ?></div><input type="hidden" name="x_idUsuario" id="x_idUsuario" value="<?php echo ew_HtmlEncode($usuario->idUsuario->CurrentValue) ?>">
</span><?php echo $usuario->idUsuario->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($usuario->idRol->Visible) { // idRol ?>
	<tr<?php echo $usuario->idRol->RowAttributes ?>>
		<td class="ewTableHeader">Rol<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $usuario->idRol->CellAttributes() ?>><span id="el_idRol">
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<div<?php echo $usuario->idRol->ViewAttributes() ?>><?php echo $usuario->idRol->EditValue ?></div>
<?php } else { ?>
<select id="x_idRol" name="x_idRol"<?php echo $usuario->idRol->EditAttributes() ?>>
<?php
if (is_array($usuario->idRol->EditValue)) {
	$arwrk = $usuario->idRol->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($usuario->idRol->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
<?php } ?>
</span><?php echo $usuario->idRol->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($usuario->nombre->Visible) { // nombre ?>
	<tr<?php echo $usuario->nombre->RowAttributes ?>>
		<td class="ewTableHeader">Nombre(s)<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $usuario->nombre->CellAttributes() ?>><span id="el_nombre">
<input type="text" name="x_nombre" id="x_nombre" size="30" maxlength="100" value="<?php echo $usuario->nombre->EditValue ?>"<?php echo $usuario->nombre->EditAttributes() ?>>
</span><?php echo $usuario->nombre->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($usuario->paterno->Visible) { // paterno ?>
	<tr<?php echo $usuario->paterno->RowAttributes ?>>
		<td class="ewTableHeader">Apellido Paterno<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $usuario->paterno->CellAttributes() ?>><span id="el_paterno">
<input type="text" name="x_paterno" id="x_paterno" size="30" maxlength="100" value="<?php echo $usuario->paterno->EditValue ?>"<?php echo $usuario->paterno->EditAttributes() ?>>
</span><?php echo $usuario->paterno->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($usuario->materno->Visible) { // materno ?>
	<tr<?php echo $usuario->materno->RowAttributes ?>>
		<td class="ewTableHeader">Apellido Materno</td>
		<td<?php echo $usuario->materno->CellAttributes() ?>><span id="el_materno">
<input type="text" name="x_materno" id="x_materno" size="30" maxlength="100" value="<?php echo $usuario->materno->EditValue ?>"<?php echo $usuario->materno->EditAttributes() ?>>
</span><?php echo $usuario->materno->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($usuario->ci->Visible) { // ci ?>
	<tr<?php echo $usuario->ci->RowAttributes ?>>
		<td class="ewTableHeader">C.I<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $usuario->ci->CellAttributes() ?>><span id="el_ci">
<input type="text" name="x_ci" id="x_ci" size="30" value="<?php echo $usuario->ci->EditValue ?>"<?php echo $usuario->ci->EditAttributes() ?>>
</span><?php echo $usuario->ci->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($usuario->cargo->Visible) { // cargo ?>
	<tr<?php echo $usuario->cargo->RowAttributes ?>>
		<td class="ewTableHeader">Cargo en la Iglesia<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $usuario->cargo->CellAttributes() ?>><span id="el_cargo">
<input type="text" name="x_cargo" id="x_cargo" size="30" maxlength="100" value="<?php echo $usuario->cargo->EditValue ?>"<?php echo $usuario->cargo->EditAttributes() ?>>
</span><?php echo $usuario->cargo->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="  EDITAR  ">
</form>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php

//
// Page Class
//
class cusuario_edit {

	// Page ID
	var $PageID = 'edit';

	// Table Name
	var $TableName = 'usuario';

	// Page Object Name
	var $PageObjName = 'usuario_edit';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $usuario;
		if ($usuario->UseTokenInUrl) $PageUrl .= "t=" . $usuario->TableVar . "&"; // add page token
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
		global $objForm, $usuario;
		if ($usuario->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($usuario->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($usuario->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cusuario_edit() {
		global $conn;

		// Initialize table object
		$GLOBALS["usuario"] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'usuario', TRUE);

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
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		$Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->TableName);
		$Security->TablePermission_Loaded();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("usuariolist.php");
		}

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
		global $objForm, $gsFormError, $usuario;

		// Load key from QueryString
		if (@$_GET["idUsuario"] <> "")
			$usuario->idUsuario->setQueryStringValue($_GET["idUsuario"]);

		// Create form object
		$objForm = new cFormObj();
		if (@$_POST["a_edit"] <> "") {
			$usuario->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$usuario->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$this->RestoreFormValues();
			}
		} else {
			$usuario->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($usuario->idUsuario->CurrentValue == "")
			$this->Page_Terminate("usuariolist.php"); // Invalid key, return to list
		switch ($usuario->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage("No se encontraron registros"); // No record found
					$this->Page_Terminate("usuariolist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$usuario->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage("Actualizacion exitosa"); // Update success
					$sReturnUrl = $usuario->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$usuario->RowType = EW_ROWTYPE_EDIT; // Render as edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $usuario;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $usuario;
		$usuario->idUsuario->setFormValue($objForm->GetValue("x_idUsuario"));
		$usuario->idRol->setFormValue($objForm->GetValue("x_idRol"));
		$usuario->nombre->setFormValue($objForm->GetValue("x_nombre"));
		$usuario->paterno->setFormValue($objForm->GetValue("x_paterno"));
		$usuario->materno->setFormValue($objForm->GetValue("x_materno"));
		$usuario->ci->setFormValue($objForm->GetValue("x_ci"));
		$usuario->cargo->setFormValue($objForm->GetValue("x_cargo"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $usuario;
		$this->LoadRow();
		$usuario->idUsuario->CurrentValue = $usuario->idUsuario->FormValue;
		$usuario->idRol->CurrentValue = $usuario->idRol->FormValue;
		$usuario->nombre->CurrentValue = $usuario->nombre->FormValue;
		$usuario->paterno->CurrentValue = $usuario->paterno->FormValue;
		$usuario->materno->CurrentValue = $usuario->materno->FormValue;
		$usuario->ci->CurrentValue = $usuario->ci->FormValue;
		$usuario->cargo->CurrentValue = $usuario->cargo->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $usuario;
		$sFilter = $usuario->KeyFilter();

		// Call Row Selecting event
		$usuario->Row_Selecting($sFilter);

		// Load sql based on filter
		$usuario->CurrentFilter = $sFilter;
		$sSql = $usuario->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$usuario->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $usuario;
		$usuario->idUsuario->setDbValue($rs->fields('idUsuario'));
		$usuario->idRol->setDbValue($rs->fields('idRol'));
		$usuario->nombre->setDbValue($rs->fields('nombre'));
		$usuario->paterno->setDbValue($rs->fields('paterno'));
		$usuario->materno->setDbValue($rs->fields('materno'));
		$usuario->ci->setDbValue($rs->fields('ci'));
		$usuario->cargo->setDbValue($rs->fields('cargo'));
		$usuario->zlogin->setDbValue($rs->fields('login'));
		$usuario->password->setDbValue($rs->fields('password'));
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

		// idRol
		$usuario->idRol->CellCssStyle = "";
		$usuario->idRol->CellCssClass = "";

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

			// idUsuario
			$usuario->idUsuario->HrefValue = "";

			// idRol
			$usuario->idRol->HrefValue = "";

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
		} elseif ($usuario->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// idUsuario
			$usuario->idUsuario->EditCustomAttributes = "";
			$usuario->idUsuario->EditValue = $usuario->idUsuario->CurrentValue;
			$usuario->idUsuario->CssStyle = "";
			$usuario->idUsuario->CssClass = "";
			$usuario->idUsuario->ViewCustomAttributes = "";

			// idRol
			$usuario->idRol->EditCustomAttributes = "";
			if (!$Security->CanAdmin()) { // System admin
				$usuario->idRol->EditValue = "********";
			} else {
			$sSqlWrk = "SELECT `idRol`, `nombre`, '' AS Disp2Fld, '' AS SelectFilterFld FROM `rol`";
			$sWhereWrk = "";
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE $sWhereWrk";
			$sSqlWrk .= " ORDER BY `nombre` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", "Por favor Seleccione"));
			$usuario->idRol->EditValue = $arwrk;
			}

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

			// Edit refer script
			// idUsuario

			$usuario->idUsuario->HrefValue = "";

			// idRol
			$usuario->idRol->HrefValue = "";

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
		if ($usuario->idRol->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Rol";
		}
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

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $usuario;
		$sFilter = $usuario->KeyFilter();
		$usuario->CurrentFilter = $sFilter;
		$sSql = $usuario->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold =& $rs->fields;
			$rsnew = array();

			// Field idUsuario
			// Field idRol

			if ($Security->CanAdmin()) { // System admin
			$usuario->idRol->SetDbValueDef($usuario->idRol->CurrentValue, 0);
			$rsnew['idRol'] =& $usuario->idRol->DbValue;
			}

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

			// Call Row Updating event
			$bUpdateRow = $usuario->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($usuario->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($usuario->CancelMessage <> "") {
					$this->setMessage($usuario->CancelMessage);
					$usuario->CancelMessage = "";
				} else {
					$this->setMessage("Actualizacion cancelada");
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$usuario->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
