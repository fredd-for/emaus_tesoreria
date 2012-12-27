<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "rolinfo.php" ?>
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
$rol_edit = new crol_edit();
$Page =& $rol_edit;

// Page init processing
$rol_edit->Page_Init();

// Page main processing
$rol_edit->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var rol_edit = new ew_Page("rol_edit");

// page properties
rol_edit.PageID = "edit"; // page ID
var EW_PAGE_ID = rol_edit.PageID; // for backward compatibility

// extend page with ValidateForm function
rol_edit.ValidateForm = function(fobj) {
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
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Id Rol");
		elm = fobj.elements["x" + infix + "_idRol"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Entero Incorrecto - Id Rol");
		elm = fobj.elements["x" + infix + "_nombre"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Nombre");
		elmId = fobj.elements["x" + infix + "_idRol"];
		elmName = fobj.elements["x" + infix + "_nombre"];
		if (elmId && elmName) {
			elmId.value = elmId.value.replace(/^\s+|\s+$/, '');
			elmName.value = elmName.value.replace(/^\s+|\s+$/, '');
			if (elmId && !ew_CheckInteger(elmId.value))
				return ew_OnError(this, elmId, "El Nivel de Usuario debe ser un Entero");
			var level = parseInt(elmId.value);
			if (level == 0) {
				if (elmName.value.toLowerCase() != "default")
					return ew_OnError(this, elmName, "User level name for user level 0 must be 'Default'");
			} else if (level == -1) { 
				if (elmName.value.toLowerCase() != "administrator")
					return ew_OnError(this, elmName, "El nombre de usuario para el usuario nivel -1 debe ser 'Admninistrator'");
			} else if (level < -1) {
				return ew_OnError(this, elmId, "User defined User Level ID must be larger than 0");
			} else if (level > 0) { 
				if (elmName.value.toLowerCase() == "administrator" || elmName.value.toLowerCase() == "default")
					return ew_OnError(this, elmName, "User defined User Level name cannot be 'Administrator' or 'Default'");
			}
		}

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
rol_edit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
rol_edit.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
rol_edit.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Editar TABLA: Rol<br><br>
<a href="<?php echo $rol->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $rol_edit->ShowMessage() ?>
<form name="froledit" id="froledit" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return rol_edit.ValidateForm(this);">
<p>
<input type="hidden" name="a_table" id="a_table" value="rol">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($rol->idRol->Visible) { // idRol ?>
	<tr<?php echo $rol->idRol->RowAttributes ?>>
		<td class="ewTableHeader">Id Rol<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $rol->idRol->CellAttributes() ?>><span id="el_idRol">
<div<?php echo $rol->idRol->ViewAttributes() ?>><?php echo $rol->idRol->EditValue ?></div><input type="hidden" name="x_idRol" id="x_idRol" value="<?php echo ew_HtmlEncode($rol->idRol->CurrentValue) ?>">
</span><?php echo $rol->idRol->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($rol->nombre->Visible) { // nombre ?>
	<tr<?php echo $rol->nombre->RowAttributes ?>>
		<td class="ewTableHeader">Nombre<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $rol->nombre->CellAttributes() ?>><span id="el_nombre">
<input type="text" name="x_nombre" id="x_nombre" size="30" maxlength="50" value="<?php echo $rol->nombre->EditValue ?>"<?php echo $rol->nombre->EditAttributes() ?>>
</span><?php echo $rol->nombre->CustomMsg ?></td>
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
class crol_edit {

	// Page ID
	var $PageID = 'edit';

	// Table Name
	var $TableName = 'rol';

	// Page Object Name
	var $PageObjName = 'rol_edit';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $rol;
		if ($rol->UseTokenInUrl) $PageUrl .= "t=" . $rol->TableVar . "&"; // add page token
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
		global $objForm, $rol;
		if ($rol->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($rol->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($rol->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function crol_edit() {
		global $conn;

		// Initialize table object
		$GLOBALS["rol"] = new crol();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'rol', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $rol;
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
		if (!$Security->CanAdmin()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
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
		global $objForm, $gsFormError, $rol;

		// Load key from QueryString
		if (@$_GET["idRol"] <> "")
			$rol->idRol->setQueryStringValue($_GET["idRol"]);

		// Create form object
		$objForm = new cFormObj();
		if (@$_POST["a_edit"] <> "") {
			$rol->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$rol->CurrentAction = ""; // Form error, reset action
				$this->setMessage($gsFormError);
				$this->RestoreFormValues();
			}
		} else {
			$rol->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($rol->idRol->CurrentValue == "")
			$this->Page_Terminate("rollist.php"); // Invalid key, return to list
		switch ($rol->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					$this->setMessage("No se encontraron registros"); // No record found
					$this->Page_Terminate("rollist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$rol->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					$this->setMessage("Actualizacion exitosa"); // Update success
					$sReturnUrl = $rol->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$rol->RowType = EW_ROWTYPE_EDIT; // Render as edit
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $rol;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $rol;
		$rol->idRol->setFormValue($objForm->GetValue("x_idRol"));
		$rol->nombre->setFormValue($objForm->GetValue("x_nombre"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $rol;
		$this->LoadRow();
		$rol->idRol->CurrentValue = $rol->idRol->FormValue;
		$rol->nombre->CurrentValue = $rol->nombre->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $rol;
		$sFilter = $rol->KeyFilter();

		// Call Row Selecting event
		$rol->Row_Selecting($sFilter);

		// Load sql based on filter
		$rol->CurrentFilter = $sFilter;
		$sSql = $rol->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$rol->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $rol;
		$rol->idRol->setDbValue($rs->fields('idRol'));
		if (is_null($rol->idRol->CurrentValue)) {
			$rol->idRol->CurrentValue = 0;
		} else {
			$rol->idRol->CurrentValue = intval($rol->idRol->CurrentValue);
		}
		$rol->nombre->setDbValue($rs->fields('nombre'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $rol;

		// Call Row_Rendering event
		$rol->Row_Rendering();

		// Common render codes for all row types
		// idRol

		$rol->idRol->CellCssStyle = "";
		$rol->idRol->CellCssClass = "";

		// nombre
		$rol->nombre->CellCssStyle = "";
		$rol->nombre->CellCssClass = "";
		if ($rol->RowType == EW_ROWTYPE_VIEW) { // View row

			// idRol
			$rol->idRol->ViewValue = $rol->idRol->CurrentValue;
			$rol->idRol->CssStyle = "";
			$rol->idRol->CssClass = "";
			$rol->idRol->ViewCustomAttributes = "";

			// nombre
			$rol->nombre->ViewValue = $rol->nombre->CurrentValue;
			$rol->nombre->CssStyle = "";
			$rol->nombre->CssClass = "";
			$rol->nombre->ViewCustomAttributes = "";

			// idRol
			$rol->idRol->HrefValue = "";

			// nombre
			$rol->nombre->HrefValue = "";
		} elseif ($rol->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// idRol
			$rol->idRol->EditCustomAttributes = "";
			$rol->idRol->EditValue = $rol->idRol->CurrentValue;
			$rol->idRol->CssStyle = "";
			$rol->idRol->CssClass = "";
			$rol->idRol->ViewCustomAttributes = "";

			// nombre
			$rol->nombre->EditCustomAttributes = "";
			$rol->nombre->EditValue = ew_HtmlEncode($rol->nombre->CurrentValue);

			// Edit refer script
			// idRol

			$rol->idRol->HrefValue = "";

			// nombre
			$rol->nombre->HrefValue = "";
		}

		// Call Row Rendered event
		$rol->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $rol;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($rol->idRol->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Id Rol";
		}
		if (!ew_CheckInteger($rol->idRol->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Entero Incorrecto - Id Rol";
		}
		if ($rol->nombre->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Nombre";
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
		global $conn, $Security, $rol;
		$sFilter = $rol->KeyFilter();
		$rol->CurrentFilter = $sFilter;
		$sSql = $rol->SQL();
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

			// Field idRol
			// Field nombre

			$rol->nombre->SetDbValueDef($rol->nombre->CurrentValue, "");
			$rsnew['nombre'] =& $rol->nombre->DbValue;

			// Call Row Updating event
			$bUpdateRow = $rol->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($rol->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($rol->CancelMessage <> "") {
					$this->setMessage($rol->CancelMessage);
					$rol->CancelMessage = "";
				} else {
					$this->setMessage("Actualizacion cancelada");
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$rol->Row_Updated($rsold, $rsnew);
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
