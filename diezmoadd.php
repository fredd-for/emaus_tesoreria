<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "diezmoinfo.php" ?>
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
$diezmo_add = new cdiezmo_add();
$Page =& $diezmo_add;

// Page init processing
$diezmo_add->Page_Init();

// Page main processing
$diezmo_add->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var diezmo_add = new ew_Page("diezmo_add");

// page properties
diezmo_add.PageID = "add"; // page ID
var EW_PAGE_ID = diezmo_add.PageID; // for backward compatibility

// extend page with ValidateForm function
diezmo_add.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_idMiembro"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Id Miembro");
		elm = fobj.elements["x" + infix + "_idMiembro"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Entero Incorrecto - Id Miembro");
		elm = fobj.elements["x" + infix + "_fecha"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Fecha");
		elm = fobj.elements["x" + infix + "_fecha"];
		if (elm && !ew_CheckEuroDate(elm.value))
			return ew_OnError(this, elm, "Fecha incorrecta, formato = dd-mm-yyyy - Fecha");
		elm = fobj.elements["x" + infix + "_montoDiezmo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Monto Diezmo");
		elm = fobj.elements["x" + infix + "_montoDiezmo"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "Número de Punto Flotante Incorrecto - Monto Diezmo");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
diezmo_add.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
diezmo_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
diezmo_add.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker">Agregar a TABLA: Diezmo<br><br>
<a href="<?php echo $diezmo->getReturnUrl() ?>">Volver atras</a></span></p>
<?php $diezmo_add->ShowMessage() ?>
<form name="fdiezmoadd" id="fdiezmoadd" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return diezmo_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="diezmo">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($diezmo->idMiembro->Visible) { // idMiembro ?>
	<tr<?php echo $diezmo->idMiembro->RowAttributes ?>>
		<td class="ewTableHeader">Id Miembro<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $diezmo->idMiembro->CellAttributes() ?>><span id="el_idMiembro">
<input type="text" name="x_idMiembro" id="x_idMiembro" size="30" value="<?php echo $diezmo->idMiembro->EditValue ?>"<?php echo $diezmo->idMiembro->EditAttributes() ?>>
</span><?php echo $diezmo->idMiembro->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($diezmo->fecha->Visible) { // fecha ?>
	<tr<?php echo $diezmo->fecha->RowAttributes ?>>
		<td class="ewTableHeader">Fecha<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $diezmo->fecha->CellAttributes() ?>><span id="el_fecha">
<input type="text" name="x_fecha" id="x_fecha" value="<?php echo $diezmo->fecha->EditValue ?>"<?php echo $diezmo->fecha->EditAttributes() ?>>
</span><?php echo $diezmo->fecha->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($diezmo->montoDiezmo->Visible) { // montoDiezmo ?>
	<tr<?php echo $diezmo->montoDiezmo->RowAttributes ?>>
		<td class="ewTableHeader">Monto Diezmo<span class="ewRequired">&nbsp;*</span></td>
		<td<?php echo $diezmo->montoDiezmo->CellAttributes() ?>><span id="el_montoDiezmo">
<input type="text" name="x_montoDiezmo" id="x_montoDiezmo" size="30" value="<?php echo $diezmo->montoDiezmo->EditValue ?>"<?php echo $diezmo->montoDiezmo->EditAttributes() ?>>
</span><?php echo $diezmo->montoDiezmo->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
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
class cdiezmo_add {

	// Page ID
	var $PageID = 'add';

	// Table Name
	var $TableName = 'diezmo';

	// Page Object Name
	var $PageObjName = 'diezmo_add';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $diezmo;
		if ($diezmo->UseTokenInUrl) $PageUrl .= "t=" . $diezmo->TableVar . "&"; // add page token
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
		global $objForm, $diezmo;
		if ($diezmo->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($diezmo->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($diezmo->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function cdiezmo_add() {
		global $conn;

		// Initialize table object
		$GLOBALS["diezmo"] = new cdiezmo();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'diezmo', TRUE);

		// Open connection to the database
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $diezmo;
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
			$this->Page_Terminate("diezmolist.php");
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
		global $objForm, $gsFormError, $diezmo;

		// Load key values from QueryString
		$bCopy = TRUE;
		if (@$_GET["idDiezmo"] != "") {
		  $diezmo->idDiezmo->setQueryStringValue($_GET["idDiezmo"]);
		} else {
		  $bCopy = FALSE;
		}

		// Create form object
		$objForm = new cFormObj();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
		   $diezmo->CurrentAction = $_POST["a_add"]; // Get form action
		  $this->LoadFormValues(); // Load form values

			// Validate Form
			if (!$this->ValidateForm()) {
				$diezmo->CurrentAction = "I"; // Form error, reset action
				$this->setMessage($gsFormError);
			}
		} else { // Not post back
		  if ($bCopy) {
		    $diezmo->CurrentAction = "C"; // Copy Record
		  } else {
		    $diezmo->CurrentAction = "I"; // Display Blank Record
		    $this->LoadDefaultValues(); // Load default values
		  }
		}

		// Perform action based on action code
		switch ($diezmo->CurrentAction) {
		  case "I": // Blank record, no action required
				break;
		  case "C": // Copy an existing record
		   if (!$this->LoadRow()) { // Load record based on key
		      $this->setMessage("No se encontraron registros"); // No record found
		      $this->Page_Terminate("diezmolist.php"); // No matching record, return to list
		    }
				break;
		  case "A": // ' Add new record
				$diezmo->SendEmail = TRUE; // Send email on add success
		    if ($this->AddRow()) { // Add successful
		      $this->setMessage("Registro agregado satisfactoriamente"); // Set up success message
					$sReturnUrl = $diezmo->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Clean up and return
		    } else {
		      $this->RestoreFormValues(); // Add failed, restore form values
		    }
		}

		// Render row based on row type
		$diezmo->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $diezmo;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $diezmo;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $diezmo;
		$diezmo->idMiembro->setFormValue($objForm->GetValue("x_idMiembro"));
		$diezmo->fecha->setFormValue($objForm->GetValue("x_fecha"));
		$diezmo->fecha->CurrentValue = ew_UnFormatDateTime($diezmo->fecha->CurrentValue, 7);
		$diezmo->montoDiezmo->setFormValue($objForm->GetValue("x_montoDiezmo"));
		$diezmo->idDiezmo->setFormValue($objForm->GetValue("x_idDiezmo"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $diezmo;
		$diezmo->idDiezmo->CurrentValue = $diezmo->idDiezmo->FormValue;
		$diezmo->idMiembro->CurrentValue = $diezmo->idMiembro->FormValue;
		$diezmo->fecha->CurrentValue = $diezmo->fecha->FormValue;
		$diezmo->fecha->CurrentValue = ew_UnFormatDateTime($diezmo->fecha->CurrentValue, 7);
		$diezmo->montoDiezmo->CurrentValue = $diezmo->montoDiezmo->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $diezmo;
		$sFilter = $diezmo->KeyFilter();

		// Call Row Selecting event
		$diezmo->Row_Selecting($sFilter);

		// Load sql based on filter
		$diezmo->CurrentFilter = $sFilter;
		$sSql = $diezmo->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$diezmo->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $diezmo;
		$diezmo->idDiezmo->setDbValue($rs->fields('idDiezmo'));
		$diezmo->idMiembro->setDbValue($rs->fields('idMiembro'));
		$diezmo->fecha->setDbValue($rs->fields('fecha'));
		$diezmo->montoDiezmo->setDbValue($rs->fields('montoDiezmo'));
		$diezmo->monto2->setDbValue($rs->fields('monto2'));
		$diezmo->monto3->setDbValue($rs->fields('monto3'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $diezmo;

		// Call Row_Rendering event
		$diezmo->Row_Rendering();

		// Common render codes for all row types
		// idMiembro

		$diezmo->idMiembro->CellCssStyle = "";
		$diezmo->idMiembro->CellCssClass = "";

		// fecha
		$diezmo->fecha->CellCssStyle = "";
		$diezmo->fecha->CellCssClass = "";

		// montoDiezmo
		$diezmo->montoDiezmo->CellCssStyle = "";
		$diezmo->montoDiezmo->CellCssClass = "";
		if ($diezmo->RowType == EW_ROWTYPE_VIEW) { // View row

			// idDiezmo
			$diezmo->idDiezmo->ViewValue = $diezmo->idDiezmo->CurrentValue;
			$diezmo->idDiezmo->CssStyle = "";
			$diezmo->idDiezmo->CssClass = "";
			$diezmo->idDiezmo->ViewCustomAttributes = "";

			// idMiembro
			$diezmo->idMiembro->ViewValue = $diezmo->idMiembro->CurrentValue;
			$diezmo->idMiembro->CssStyle = "";
			$diezmo->idMiembro->CssClass = "";
			$diezmo->idMiembro->ViewCustomAttributes = "";

			// fecha
			$diezmo->fecha->ViewValue = $diezmo->fecha->CurrentValue;
			$diezmo->fecha->ViewValue = ew_FormatDateTime($diezmo->fecha->ViewValue, 7);
			$diezmo->fecha->CssStyle = "";
			$diezmo->fecha->CssClass = "";
			$diezmo->fecha->ViewCustomAttributes = "";

			// montoDiezmo
			$diezmo->montoDiezmo->ViewValue = $diezmo->montoDiezmo->CurrentValue;
			$diezmo->montoDiezmo->CssStyle = "";
			$diezmo->montoDiezmo->CssClass = "";
			$diezmo->montoDiezmo->ViewCustomAttributes = "";

			// idMiembro
			$diezmo->idMiembro->HrefValue = "";

			// fecha
			$diezmo->fecha->HrefValue = "";

			// montoDiezmo
			$diezmo->montoDiezmo->HrefValue = "";
		} elseif ($diezmo->RowType == EW_ROWTYPE_ADD) { // Add row

			// idMiembro
			$diezmo->idMiembro->EditCustomAttributes = "";
			$diezmo->idMiembro->EditValue = ew_HtmlEncode($diezmo->idMiembro->CurrentValue);

			// fecha
			$diezmo->fecha->EditCustomAttributes = "";
			$diezmo->fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime($diezmo->fecha->CurrentValue, 7));

			// montoDiezmo
			$diezmo->montoDiezmo->EditCustomAttributes = "";
			$diezmo->montoDiezmo->EditValue = ew_HtmlEncode($diezmo->montoDiezmo->CurrentValue);
		}

		// Call Row Rendered event
		$diezmo->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $diezmo;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($diezmo->idMiembro->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Id Miembro";
		}
		if (!ew_CheckInteger($diezmo->idMiembro->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Entero Incorrecto - Id Miembro";
		}
		if ($diezmo->fecha->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Fecha";
		}
		if (!ew_CheckEuroDate($diezmo->fecha->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Fecha incorrecta, formato = dd-mm-yyyy - Fecha";
		}
		if ($diezmo->montoDiezmo->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Monto Diezmo";
		}
		if (!ew_CheckNumber($diezmo->montoDiezmo->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Número de Punto Flotante Incorrecto - Monto Diezmo";
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
		global $conn, $Security, $diezmo;
		$rsnew = array();

		// Field idMiembro
		$diezmo->idMiembro->SetDbValueDef($diezmo->idMiembro->CurrentValue, 0);
		$rsnew['idMiembro'] =& $diezmo->idMiembro->DbValue;

		// Field fecha
		$diezmo->fecha->SetDbValueDef(ew_UnFormatDateTime($diezmo->fecha->CurrentValue, 7), ew_CurrentDate());
		$rsnew['fecha'] =& $diezmo->fecha->DbValue;

		// Field montoDiezmo
		$diezmo->montoDiezmo->SetDbValueDef($diezmo->montoDiezmo->CurrentValue, 0);
		$rsnew['montoDiezmo'] =& $diezmo->montoDiezmo->DbValue;

		// Call Row Inserting event
		$bInsertRow = $diezmo->Row_Inserting($rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($diezmo->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($diezmo->CancelMessage <> "") {
				$this->setMessage($diezmo->CancelMessage);
				$diezmo->CancelMessage = "";
			} else {
				$this->setMessage("Insertar cancelado");
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {
			$diezmo->idDiezmo->setDbValue($conn->Insert_ID());
			$rsnew['idDiezmo'] =& $diezmo->idDiezmo->DbValue;

			// Call Row Inserted event
			$diezmo->Row_Inserted($rsnew);
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
