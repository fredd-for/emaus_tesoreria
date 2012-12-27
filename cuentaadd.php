<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "cuentainfo.php" ?>
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
$cuenta_add = new ccuenta_add();
$Page =& $cuenta_add;

// Page init processing
$cuenta_add->Page_Init();

// Page main processing
$cuenta_add->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var cuenta_add = new ew_Page("cuenta_add");

// page properties
cuenta_add.PageID = "add"; // page ID
var EW_PAGE_ID = cuenta_add.PageID; // for backward compatibility

// extend page with ValidateForm function
cuenta_add.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_cuenta"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Cuenta");
		elm = fobj.elements["x" + infix + "_porcentaje"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Porcentaje");
		elm = fobj.elements["x" + infix + "_porcentaje"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "N�mero de Punto Flotante Incorrecto - Porcentaje");
		elm = fobj.elements["x" + infix + "_estado"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Estado");
		elm = fobj.elements["x" + infix + "_estado"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Entero Incorrecto - Estado");
		elm = fobj.elements["x" + infix + "_fechaCreacion"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Fecha Creacion");
		elm = fobj.elements["x" + infix + "_fechaCreacion"];
		if (elm && !ew_CheckEuroDate(elm.value))
			return ew_OnError(this, elm, "Fecha incorrecta, formato = dd-mm-yyyy - Fecha Creacion");
		elm = fobj.elements["x" + infix + "_fechaModificacion"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Fecha Modificacion");
		elm = fobj.elements["x" + infix + "_fechaModificacion"];
		if (elm && !ew_CheckEuroDate(elm.value))
			return ew_OnError(this, elm, "Fecha incorrecta, formato = dd-mm-yyyy - Fecha Modificacion");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
cuenta_add.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
cuenta_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cuenta_add.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Agregar a TABLA: Cuenta<br><br>
<a href="<?php echo $cuenta->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $cuenta_add->ShowMessage() ?>
<form name="fcuentaadd" id="fcuentaadd" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return cuenta_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="cuenta">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($cuenta->cuenta->Visible) { // cuenta ?>
	<tr<?php echo $cuenta->cuenta->RowAttributes ?>>
		<td class="ewTableHeader">Cuenta<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $cuenta->cuenta->CellAttributes() ?>><span id="el_cuenta">
<input type="text" name="x_cuenta" id="x_cuenta" size="30" maxlength="100" value="<?php echo $cuenta->cuenta->EditValue ?>"<?php echo $cuenta->cuenta->EditAttributes() ?>>
</span><?php echo $cuenta->cuenta->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cuenta->porcentaje->Visible) { // porcentaje ?>
	<tr<?php echo $cuenta->porcentaje->RowAttributes ?>>
		<td class="ewTableHeader">Porcentaje<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $cuenta->porcentaje->CellAttributes() ?>><span id="el_porcentaje">
<input type="text" name="x_porcentaje" id="x_porcentaje" size="30" maxlength="255" value="<?php echo $cuenta->porcentaje->EditValue ?>"<?php echo $cuenta->porcentaje->EditAttributes() ?>>
</span><?php echo $cuenta->porcentaje->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cuenta->estado->Visible) { // estado ?>
	<tr<?php echo $cuenta->estado->RowAttributes ?>>
		<td class="ewTableHeader">Estado<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $cuenta->estado->CellAttributes() ?>><span id="el_estado">
<input type="text" name="x_estado" id="x_estado" size="30" value="<?php echo $cuenta->estado->EditValue ?>"<?php echo $cuenta->estado->EditAttributes() ?>>
</span><?php echo $cuenta->estado->CustomMsg ?></td>
	</tr>
<?php } ?>

</table>
</div>
</td></tr></table>
<p>
    <input type="hidden" name="x_fechaCreacion" id="x_fechaCreacion" value="<?php echo date("d-m-Y H:i:s") ?>"<?php echo $cuenta->fechaCreacion->EditAttributes() ?>>
    <input type="hidden" name="x_fechaModificacion" id="x_fechaModificacion" value="<?php echo date("d-m-Y H:i:s") ?>"<?php echo $cuenta->fechaModificacion->EditAttributes() ?>>
<input type="submit" name="btnAction" id="btnAction" value="  AGREGAR  ">
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
class ccuenta_add {

	// Page ID
	var $PageID = 'add';

	// Table Name
	var $TableName = 'cuenta';

	// Page Object Name
	var $PageObjName = 'cuenta_add';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $cuenta;
		if ($cuenta->UseTokenInUrl) $PageUrl .= "t=" . $cuenta->TableVar . "&"; // add page token
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
		global $objForm, $cuenta;
		if ($cuenta->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($cuenta->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($cuenta->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function ccuenta_add() {
		global $conn;

		// Initialize table object
		$GLOBALS["cuenta"] = new ccuenta();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cuenta', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $cuenta;
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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("cuentalist.php");
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
	var $x_ewPriv = 0;

	// 
	// Page main processing
	//
	function Page_Main() {
		global $objForm, $gsFormError, $cuenta;

		// Load key values from QueryString
		$bCopy = TRUE;
		if (@$_GET["idCuenta"] != "") {
		  $cuenta->idCuenta->setQueryStringValue($_GET["idCuenta"]);
		} else {
		  $bCopy = FALSE;
		}

		// Create form object
		$objForm = new cFormObj();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
		   $cuenta->CurrentAction = $_POST["a_add"]; // Get form action
		  $this->LoadFormValues(); // Load form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$cuenta->CurrentAction = "I"; // Form error, reset action
				$this->setMessage($gsFormError);
			}
		} else { // Not post back
		  if ($bCopy) {
		    $cuenta->CurrentAction = "C"; // Copy Record
		  } else {
		    $cuenta->CurrentAction = "I"; // Display Blank Record
		    $this->LoadDefaultValues(); // Load default values
		  }
		}

		// Perform action based on action code
		switch ($cuenta->CurrentAction) {
		  case "I": // Blank record, no action required
				break;
		  case "C": // Copy an existing record
		   if (!$this->LoadRow()) { // Load record based on key
		      $this->setMessage("No se encontraron registros"); // No record found
		      $this->Page_Terminate("cuentalist.php"); // No matching record, return to list
		    }
				break;
		  case "A": // ' Add new record
				$cuenta->SendEmail = TRUE; // Send email on add success
		    if ($this->AddRow()) { // Add successful
		      $this->setMessage("Registro agregado satisfactoriamente"); // Set up success message
					$sReturnUrl = $cuenta->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Clean up and return
		    } else {
		      $this->RestoreFormValues(); // Add failed, restore form values
		    }
		}

		// Render row based on row type
		$cuenta->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $cuenta;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $cuenta;
		$cuenta->estado->CurrentValue = 1;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $cuenta;
		$cuenta->cuenta->setFormValue($objForm->GetValue("x_cuenta"));
		$cuenta->porcentaje->setFormValue($objForm->GetValue("x_porcentaje"));
		$cuenta->estado->setFormValue($objForm->GetValue("x_estado"));
		$cuenta->fechaCreacion->setFormValue($objForm->GetValue("x_fechaCreacion"));
		$cuenta->fechaCreacion->CurrentValue = ew_UnFormatDateTime($cuenta->fechaCreacion->CurrentValue, 7);
		$cuenta->fechaModificacion->setFormValue($objForm->GetValue("x_fechaModificacion"));
		$cuenta->fechaModificacion->CurrentValue = ew_UnFormatDateTime($cuenta->fechaModificacion->CurrentValue, 7);
		$cuenta->idCuenta->setFormValue($objForm->GetValue("x_idCuenta"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $cuenta;
		$cuenta->idCuenta->CurrentValue = $cuenta->idCuenta->FormValue;
		$cuenta->cuenta->CurrentValue = $cuenta->cuenta->FormValue;
		$cuenta->porcentaje->CurrentValue = $cuenta->porcentaje->FormValue;
		$cuenta->estado->CurrentValue = $cuenta->estado->FormValue;
		$cuenta->fechaCreacion->CurrentValue = $cuenta->fechaCreacion->FormValue;
		$cuenta->fechaCreacion->CurrentValue = ew_UnFormatDateTime($cuenta->fechaCreacion->CurrentValue, 7);
		$cuenta->fechaModificacion->CurrentValue = $cuenta->fechaModificacion->FormValue;
		$cuenta->fechaModificacion->CurrentValue = ew_UnFormatDateTime($cuenta->fechaModificacion->CurrentValue, 7);
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $cuenta;
		$sFilter = $cuenta->KeyFilter();

		// Call Row Selecting event
		$cuenta->Row_Selecting($sFilter);

		// Load sql based on filter
		$cuenta->CurrentFilter = $sFilter;
		$sSql = $cuenta->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$cuenta->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $cuenta;
		$cuenta->idCuenta->setDbValue($rs->fields('idCuenta'));
		$cuenta->cuenta->setDbValue($rs->fields('cuenta'));
		$cuenta->porcentaje->setDbValue($rs->fields('porcentaje'));
		$cuenta->estado->setDbValue($rs->fields('estado'));
		$cuenta->fechaCreacion->setDbValue($rs->fields('fechaCreacion'));
		$cuenta->fechaModificacion->setDbValue($rs->fields('fechaModificacion'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $cuenta;

		// Call Row_Rendering event
		$cuenta->Row_Rendering();

		// Common render codes for all row types
		// cuenta

		$cuenta->cuenta->CellCssStyle = "";
		$cuenta->cuenta->CellCssClass = "";

		// porcentaje
		$cuenta->porcentaje->CellCssStyle = "";
		$cuenta->porcentaje->CellCssClass = "";

		// estado
		$cuenta->estado->CellCssStyle = "";
		$cuenta->estado->CellCssClass = "";

		// fechaCreacion
		$cuenta->fechaCreacion->CellCssStyle = "";
		$cuenta->fechaCreacion->CellCssClass = "";

		// fechaModificacion
		$cuenta->fechaModificacion->CellCssStyle = "";
		$cuenta->fechaModificacion->CellCssClass = "";
		if ($cuenta->RowType == EW_ROWTYPE_VIEW) { // View row

			// idCuenta
			$cuenta->idCuenta->ViewValue = $cuenta->idCuenta->CurrentValue;
			$cuenta->idCuenta->CssStyle = "";
			$cuenta->idCuenta->CssClass = "";
			$cuenta->idCuenta->ViewCustomAttributes = "";

			// cuenta
			$cuenta->cuenta->ViewValue = $cuenta->cuenta->CurrentValue;
			$cuenta->cuenta->CssStyle = "";
			$cuenta->cuenta->CssClass = "";
			$cuenta->cuenta->ViewCustomAttributes = "";

			// porcentaje
			$cuenta->porcentaje->ViewValue = $cuenta->porcentaje->CurrentValue;
			$cuenta->porcentaje->CssStyle = "";
			$cuenta->porcentaje->CssClass = "";
			$cuenta->porcentaje->ViewCustomAttributes = "";

			// estado
			$cuenta->estado->ViewValue = $cuenta->estado->CurrentValue;
			$cuenta->estado->CssStyle = "";
			$cuenta->estado->CssClass = "";
			$cuenta->estado->ViewCustomAttributes = "";

			// fechaCreacion
			$cuenta->fechaCreacion->ViewValue = $cuenta->fechaCreacion->CurrentValue;
			$cuenta->fechaCreacion->ViewValue = ew_FormatDateTime($cuenta->fechaCreacion->ViewValue, 7);
			$cuenta->fechaCreacion->CssStyle = "";
			$cuenta->fechaCreacion->CssClass = "";
			$cuenta->fechaCreacion->ViewCustomAttributes = "";

			// fechaModificacion
			$cuenta->fechaModificacion->ViewValue = $cuenta->fechaModificacion->CurrentValue;
			$cuenta->fechaModificacion->ViewValue = ew_FormatDateTime($cuenta->fechaModificacion->ViewValue, 7);
			$cuenta->fechaModificacion->CssStyle = "";
			$cuenta->fechaModificacion->CssClass = "";
			$cuenta->fechaModificacion->ViewCustomAttributes = "";

			// cuenta
			$cuenta->cuenta->HrefValue = "";

			// porcentaje
			$cuenta->porcentaje->HrefValue = "";

			// estado
			$cuenta->estado->HrefValue = "";

			// fechaCreacion
			$cuenta->fechaCreacion->HrefValue = "";

			// fechaModificacion
			$cuenta->fechaModificacion->HrefValue = "";
		} elseif ($cuenta->RowType == EW_ROWTYPE_ADD) { // Add row

			// cuenta
			$cuenta->cuenta->EditCustomAttributes = "";
			$cuenta->cuenta->EditValue = ew_HtmlEncode($cuenta->cuenta->CurrentValue);

			// porcentaje
			$cuenta->porcentaje->EditCustomAttributes = "";
			$cuenta->porcentaje->EditValue = ew_HtmlEncode($cuenta->porcentaje->CurrentValue);

			// estado
			$cuenta->estado->EditCustomAttributes = "";
			$cuenta->estado->EditValue = ew_HtmlEncode($cuenta->estado->CurrentValue);

			// fechaCreacion
			$cuenta->fechaCreacion->EditCustomAttributes = "";
			$cuenta->fechaCreacion->EditValue = ew_HtmlEncode(ew_FormatDateTime($cuenta->fechaCreacion->CurrentValue, 7));

			// fechaModificacion
			$cuenta->fechaModificacion->EditCustomAttributes = "";
			$cuenta->fechaModificacion->EditValue = ew_HtmlEncode(ew_FormatDateTime($cuenta->fechaModificacion->CurrentValue, 7));
		}

		// Call Row Rendered event
		$cuenta->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $cuenta;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($cuenta->cuenta->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Cuenta";
		}
		if ($cuenta->porcentaje->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Porcentaje";
		}
		if (!ew_CheckNumber($cuenta->porcentaje->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "N�mero de Punto Flotante Incorrecto - Porcentaje";
		}
		if ($cuenta->estado->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Estado";
		}
		if (!ew_CheckInteger($cuenta->estado->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Entero Incorrecto - Estado";
		}
		if ($cuenta->fechaCreacion->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Fecha Creacion";
		}
		if (!ew_CheckEuroDate($cuenta->fechaCreacion->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Fecha incorrecta, formato = dd-mm-yyyy - Fecha Creacion";
		}
		if ($cuenta->fechaModificacion->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Fecha Modificacion";
		}
		if (!ew_CheckEuroDate($cuenta->fechaModificacion->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Fecha incorrecta, formato = dd-mm-yyyy - Fecha Modificacion";
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
		global $conn, $Security, $cuenta;
		$rsnew = array();

		// Field cuenta
		$cuenta->cuenta->SetDbValueDef($cuenta->cuenta->CurrentValue, "");
		$rsnew['cuenta'] =& $cuenta->cuenta->DbValue;

		// Field porcentaje
		$cuenta->porcentaje->SetDbValueDef($cuenta->porcentaje->CurrentValue, 0);
		$rsnew['porcentaje'] =& $cuenta->porcentaje->DbValue;

		// Field estado
		$cuenta->estado->SetDbValueDef($cuenta->estado->CurrentValue, 0);
		$rsnew['estado'] =& $cuenta->estado->DbValue;

		// Field fechaCreacion
		$cuenta->fechaCreacion->SetDbValueDef(ew_UnFormatDateTime($cuenta->fechaCreacion->CurrentValue, 7), ew_CurrentDate());
		$rsnew['fechaCreacion'] =& $cuenta->fechaCreacion->DbValue;

		// Field fechaModificacion
		$cuenta->fechaModificacion->SetDbValueDef(ew_UnFormatDateTime($cuenta->fechaModificacion->CurrentValue, 7), ew_CurrentDate());
		$rsnew['fechaModificacion'] =& $cuenta->fechaModificacion->DbValue;

		// Call Row Inserting event
		$bInsertRow = $cuenta->Row_Inserting($rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($cuenta->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($cuenta->CancelMessage <> "") {
				$this->setMessage($cuenta->CancelMessage);
				$cuenta->CancelMessage = "";
			} else {
				$this->setMessage("Insertar cancelado");
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {
			$cuenta->idCuenta->setDbValue($conn->Insert_ID());
			$rsnew['idCuenta'] =& $cuenta->idCuenta->DbValue;

			// Call Row Inserted event
			$cuenta->Row_Inserted($rsnew);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
