<?php
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg6.php" ?>
<?php include "ewmysql6.php" ?>
<?php include "phpfn6.php" ?>
<?php include "saldo_cuentainfo.php" ?>
<?php include "usuarioinfo.php" ?>
<?php include "userfn6.php" ?>
<?php include "Connections/conexion.php" ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php

// Define page object
$saldo_cuenta_list = new csaldo_cuenta_list();
$Page =& $saldo_cuenta_list;

// Page init processing
$saldo_cuenta_list->Page_Init();

// Page main processing
$saldo_cuenta_list->Page_Main();
?>
<?php include "header.php" ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_cuenta = "SELECT cuenta FROM cuenta WHERE idCuenta='".$_GET['idCuenta']."'";
$mostrar_cuenta= mysql_query($query_cuenta, $conexion) or die(mysql_error());
$row_cuenta= mysql_fetch_assoc($mostrar_cuenta);
?>
<?php if ($saldo_cuenta->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var saldo_cuenta_list = new ew_Page("saldo_cuenta_list");

// page properties
saldo_cuenta_list.PageID = "list"; // page ID
var EW_PAGE_ID = saldo_cuenta_list.PageID; // for backward compatibility

// extend page with ValidateForm function
saldo_cuenta_list.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_idCuenta"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Cuenta");
		elm = fobj.elements["x" + infix + "_fecha"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Fecha");
		elm = fobj.elements["x" + infix + "_fecha"];
		if (elm && !ew_CheckEuroDate(elm.value))
			return ew_OnError(this, elm, "Fecha incorrecta, formato = dd-mm-yyyy - Fecha");
		elm = fobj.elements["x" + infix + "_nro_fact_recibo"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "Entero Incorrecto - Nro Recibo");
		elm = fobj.elements["x" + infix + "_detalle"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, "Por favor ingrese los campos requeridos - Detalle");
		elm = fobj.elements["x" + infix + "_ingreso"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "N�mero de Punto Flotante Incorrecto - Ingreso");
		elm = fobj.elements["x" + infix + "_egreso"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "N�mero de Punto Flotante Incorrecto - Egreso");

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
saldo_cuenta_list.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
saldo_cuenta_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
saldo_cuenta_list.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<link rel="stylesheet" type="text/css" media="all" href="calendar/calendar-win2k-1.css" title="win2k-1">
<script type="text/javascript" src="calendar/calendar.js"></script>
<script type="text/javascript" src="calendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="calendar/calendar-setup.js"></script>
<script type="text/javascript">
<!--
var ew_DHTMLEditors = [];

//-->
</script>
<?php } ?>
<?php if ($saldo_cuenta->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = ($saldo_cuenta->Export == "" && $saldo_cuenta->SelectLimit);
	if (!$bSelectLimit)
		$rs = $saldo_cuenta_list->LoadRecordset();
	$saldo_cuenta_list->lTotalRecs = ($bSelectLimit) ? $saldo_cuenta->SelectRecordCount() : $rs->RecordCount();
	$saldo_cuenta_list->lStartRec = 1;
	if ($saldo_cuenta_list->lDisplayRecs <= 0) // Display all records
		$saldo_cuenta_list->lDisplayRecs = $saldo_cuenta_list->lTotalRecs;
	if (!($saldo_cuenta->ExportAll && $saldo_cuenta->Export <> ""))
		$saldo_cuenta_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $saldo_cuenta_list->LoadRecordset($saldo_cuenta_list->lStartRec-1, $saldo_cuenta_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">
<?php if ($saldo_cuenta->Export == "" && $saldo_cuenta->CurrentAction == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $saldo_cuenta_list->PageUrl() ?>export=excel">Exportar a Excel</a>
<?php } ?>
</span></p>
<?php $saldo_cuenta_list->ShowMessage() ?>
<div style="color: blue; font-size: 15px">CUENTA:<b> <?php echo strtoupper($row_cuenta['cuenta'])?></b></div>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<form name="fsaldo_cuentalist" id="fsaldo_cuentalist" class="ewForm" action="<?php echo ew_CurrentPage() ?>?idCuenta=<?php echo $_GET['idCuenta']?>" method="post">
<input type="hidden" name="t" id="t" value="saldo_cuenta">
<?php if ($saldo_cuenta_list->lTotalRecs > 0 || $saldo_cuenta->CurrentAction == "add" || $saldo_cuenta->CurrentAction == "copy") { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php
	$saldo_cuenta_list->lOptionCnt = 0;
if ($Security->IsLoggedIn()) {
	$saldo_cuenta_list->lOptionCnt++; // edit
}
if ($Security->IsLoggedIn()) {
	$saldo_cuenta_list->lOptionCnt++; // Delete
}
	$saldo_cuenta_list->lOptionCnt += count($saldo_cuenta_list->ListOptions->Items); // Custom list options
?>
<?php echo $saldo_cuenta->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($saldo_cuenta->idSaldoCuenta->Visible) { // idSaldoCuenta ?>
	<?php if ($saldo_cuenta->SortUrl($saldo_cuenta->idSaldoCuenta) == "") { ?>
		<td>No</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $saldo_cuenta->SortUrl($saldo_cuenta->idSaldoCuenta) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>No</td><td style="width: 10px;"><?php if ($saldo_cuenta->idSaldoCuenta->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($saldo_cuenta->idSaldoCuenta->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($saldo_cuenta->fecha->Visible) { // fecha ?>
	<?php if ($saldo_cuenta->SortUrl($saldo_cuenta->fecha) == "") { ?>
		<td>Fecha</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $saldo_cuenta->SortUrl($saldo_cuenta->fecha) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Fecha</td><td style="width: 10px;"><?php if ($saldo_cuenta->fecha->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($saldo_cuenta->fecha->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($saldo_cuenta->nro_fact_recibo->Visible) { // nro_fact_recibo ?>
	<?php if ($saldo_cuenta->SortUrl($saldo_cuenta->nro_fact_recibo) == "") { ?>
		<td>Nro Recibo</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $saldo_cuenta->SortUrl($saldo_cuenta->nro_fact_recibo) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Nro Recibo</td><td style="width: 10px;"><?php if ($saldo_cuenta->nro_fact_recibo->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($saldo_cuenta->nro_fact_recibo->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($saldo_cuenta->detalle->Visible) { // detalle ?>
	<?php if ($saldo_cuenta->SortUrl($saldo_cuenta->detalle) == "") { ?>
		<td>Detalle</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $saldo_cuenta->SortUrl($saldo_cuenta->detalle) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Detalle</td><td style="width: 10px;"><?php if ($saldo_cuenta->detalle->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($saldo_cuenta->detalle->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($saldo_cuenta->ingreso->Visible) { // ingreso ?>
	<?php if ($saldo_cuenta->SortUrl($saldo_cuenta->ingreso) == "") { ?>
		<td>Ingreso</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $saldo_cuenta->SortUrl($saldo_cuenta->ingreso) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Ingreso</td><td style="width: 10px;"><?php if ($saldo_cuenta->ingreso->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($saldo_cuenta->ingreso->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>		
<?php if ($saldo_cuenta->egreso->Visible) { // egreso ?>
	<?php if ($saldo_cuenta->SortUrl($saldo_cuenta->egreso) == "") { ?>
		<td>Egreso</td>
	<?php } else { ?>
		<td class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $saldo_cuenta->SortUrl($saldo_cuenta->egreso) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr><td>Egreso</td><td style="width: 10px;"><?php if ($saldo_cuenta->egreso->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($saldo_cuenta->egreso->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></table>
		</td>
	<?php } ?>
<?php } ?>
                <td>Saldo</td>
<?php if ($saldo_cuenta->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($saldo_cuenta_list->lOptionCnt == 0 && $saldo_cuenta->CurrentAction == "add") { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php

// Custom list options
foreach ($saldo_cuenta_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->HeaderCellHtml;
}
?>
<?php } ?>
	</tr>
</thead>
<?php
if ($saldo_cuenta->ExportAll && $saldo_cuenta->Export <> "") {
	$saldo_cuenta_list->lStopRec = $saldo_cuenta_list->lTotalRecs;
} else {
	$saldo_cuenta_list->lStopRec = $saldo_cuenta_list->lStartRec + $saldo_cuenta_list->lDisplayRecs - 1; // Set the last record to display
}
$saldo_cuenta_list->lRecCount = $saldo_cuenta_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$saldo_cuenta->SelectLimit && $saldo_cuenta_list->lStartRec > 1)
		$rs->Move($saldo_cuenta_list->lStartRec - 1);
}
$saldo_cuenta_list->lRowCnt = 0;
$saldo_cuenta_list->lEditRowCnt = 0;
$contador=1;
$saldo=0;
if ($saldo_cuenta->CurrentAction == "edit")
	$saldo_cuenta_list->lRowIndex = 1;
while (($saldo_cuenta->CurrentAction == "gridadd" || !$rs->EOF) &&
	$saldo_cuenta_list->lRecCount < $saldo_cuenta_list->lStopRec) {
	$saldo_cuenta_list->lRecCount++;
	if (intval($saldo_cuenta_list->lRecCount) >= intval($saldo_cuenta_list->lStartRec)) {
		$saldo_cuenta_list->lRowCnt++;

	// Init row class and style
	$saldo_cuenta->CssClass = "";
	$saldo_cuenta->CssStyle = "";
	$saldo_cuenta->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	if ($saldo_cuenta->CurrentAction == "gridadd") {
		$saldo_cuenta_list->LoadDefaultValues(); // Load default values
	} else {
		$saldo_cuenta_list->LoadRowValues($rs); // Load row values
	}
	$saldo_cuenta->RowType = EW_ROWTYPE_VIEW; // Render view
	if ($saldo_cuenta->CurrentAction == "edit") {
		if ($saldo_cuenta_list->CheckInlineEditKey() && $saldo_cuenta_list->lEditRowCnt == 0) // Inline edit
			$saldo_cuenta->RowType = EW_ROWTYPE_EDIT; // Render edit
	}
	if ($saldo_cuenta->RowType == EW_ROWTYPE_EDIT && $saldo_cuenta->EventCancelled) { // Update failed
		if ($saldo_cuenta->CurrentAction == "edit")
			$saldo_cuenta_list->RestoreFormValues(); // Restore form values
	}
	if ($saldo_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit row
		$saldo_cuenta_list->lEditRowCnt++;
		$saldo_cuenta->RowClientEvents = "onmouseover='this.edit=true;ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
	}
	if ($saldo_cuenta->RowType == EW_ROWTYPE_ADD || $saldo_cuenta->RowType == EW_ROWTYPE_EDIT) // Add / Edit row
			$saldo_cuenta->CssClass = "ewTableEditRow";

	// Render row
	$saldo_cuenta_list->RenderRow();
?>
	<tr<?php echo $saldo_cuenta->RowAttributes() ?>>
	<?php if ($saldo_cuenta->idSaldoCuenta->Visible) { // idSaldoCuenta ?>
		<td<?php echo $saldo_cuenta->idSaldoCuenta->CellAttributes() ?>>
<?php if ($saldo_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<div<?php echo $saldo_cuenta->idSaldoCuenta->ViewAttributes() ?>><?php echo $contador ?></div><input type="hidden" name="x<?php echo $saldo_cuenta_list->lRowIndex ?>_idSaldoCuenta" id="x<?php echo $saldo_cuenta_list->lRowIndex ?>_idSaldoCuenta" value="<?php echo ew_HtmlEncode($saldo_cuenta->idSaldoCuenta->CurrentValue) ?>">
<?php } ?>
<?php if ($saldo_cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $saldo_cuenta->idSaldoCuenta->ViewAttributes() ?>><?php echo $contador ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($saldo_cuenta->idCuenta->Visible) { // idCuenta ?>
<?php if ($saldo_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="hidden" id="x<?php echo $saldo_cuenta_list->lRowIndex ?>_idCuenta" name="x<?php echo $saldo_cuenta_list->lRowIndex ?>_idCuenta" value="<?php echo strval($saldo_cuenta->idCuenta->CurrentValue)?>">
<?php } ?>
	<?php } ?>
	<?php if ($saldo_cuenta->fecha->Visible) { // fecha ?>
		<td<?php echo $saldo_cuenta->fecha->CellAttributes() ?>>
<?php if ($saldo_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
                    <input type="text" name="x<?php echo $saldo_cuenta_list->lRowIndex ?>_fecha" id="x<?php echo $saldo_cuenta_list->lRowIndex ?>_fecha" value="<?php echo $saldo_cuenta->fecha->EditValue ?>"<?php echo $saldo_cuenta->fecha->EditAttributes() ?> size="12">
&nbsp;<img src="images/calendar.png" id="cal_x<?php echo $saldo_cuenta_list->lRowIndex ?>_fecha" name="cal_x<?php echo $saldo_cuenta_list->lRowIndex ?>_fecha" alt="Seleccione una fecha" style="cursor:pointer;cursor:hand;">
<script type="text/javascript">
Calendar.setup({
	inputField : "x<?php echo $saldo_cuenta_list->lRowIndex ?>_fecha", // ID of the input field
	ifFormat : "%d-%m-%Y", // the date format
	button : "cal_x<?php echo $saldo_cuenta_list->lRowIndex ?>_fecha" // ID of the button
});
</script>
<?php } ?>
<?php if ($saldo_cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $saldo_cuenta->fecha->ViewAttributes() ?>><?php echo $saldo_cuenta->fecha->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($saldo_cuenta->nro_fact_recibo->Visible) { // nro_fact_recibo ?>
		<td<?php echo $saldo_cuenta->nro_fact_recibo->CellAttributes() ?>>
<?php if ($saldo_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $saldo_cuenta_list->lRowIndex ?>_nro_fact_recibo" id="x<?php echo $saldo_cuenta_list->lRowIndex ?>_nro_fact_recibo" size="10" value="<?php echo $saldo_cuenta->nro_fact_recibo->EditValue ?>"<?php echo $saldo_cuenta->nro_fact_recibo->EditAttributes() ?>>
<?php } ?>
<?php if ($saldo_cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $saldo_cuenta->nro_fact_recibo->ViewAttributes() ?>><?php echo $saldo_cuenta->nro_fact_recibo->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($saldo_cuenta->detalle->Visible) { // detalle ?>
		<td<?php echo $saldo_cuenta->detalle->CellAttributes() ?>>
<?php if ($saldo_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $saldo_cuenta_list->lRowIndex ?>_detalle" id="x<?php echo $saldo_cuenta_list->lRowIndex ?>_detalle" size="30" maxlength="255" value="<?php echo $saldo_cuenta->detalle->EditValue ?>"<?php echo $saldo_cuenta->detalle->EditAttributes() ?>>
<?php } ?>
<?php if ($saldo_cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $saldo_cuenta->detalle->ViewAttributes() ?>><?php echo $saldo_cuenta->detalle->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($saldo_cuenta->ingreso->Visible) { // ingreso ?>
		<td<?php echo $saldo_cuenta->ingreso->CellAttributes() ?>>
<?php if ($saldo_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $saldo_cuenta_list->lRowIndex ?>_ingreso" id="x<?php echo $saldo_cuenta_list->lRowIndex ?>_ingreso" size="10" value="<?php echo $saldo_cuenta->ingreso->EditValue ?>"<?php echo $saldo_cuenta->ingreso->EditAttributes() ?>>
<?php } ?>
<?php if ($saldo_cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $saldo_cuenta->ingreso->ViewAttributes() ?> align="right"><?php if($saldo_cuenta->ingreso->ListViewValue()<>'0'){echo $saldo_cuenta->ingreso->ListViewValue();} ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($saldo_cuenta->egreso->Visible) { // egreso ?>
		<td<?php echo $saldo_cuenta->egreso->CellAttributes() ?>>
<?php if ($saldo_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $saldo_cuenta_list->lRowIndex ?>_egreso" id="x<?php echo $saldo_cuenta_list->lRowIndex ?>_egreso" size="10" value="<?php echo $saldo_cuenta->egreso->EditValue ?>"<?php echo $saldo_cuenta->egreso->EditAttributes() ?>>
<?php } ?>
<?php if ($saldo_cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $saldo_cuenta->egreso->ViewAttributes() ?> align="right"><?php if($saldo_cuenta->egreso->ListViewValue()<>'0'){echo $saldo_cuenta->egreso->ListViewValue();} ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($saldo_cuenta->egreso->Visible) { // egreso ?>
		<td<?php echo $saldo_cuenta->egreso->CellAttributes() ?>>
<?php if ($saldo_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
                    &nbsp;
<?php } ?>
<?php if ($saldo_cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
                    <div<?php echo $saldo_cuenta->egreso->ViewAttributes() ?> align="right"><?php $saldo=$saldo+$saldo_cuenta->ingreso->ListViewValue()-$saldo_cuenta->egreso->ListViewValue(); echo number_format($saldo, 2)?></div>
<?php } ?>
</td>
	<?php } ?>
<?php if ($saldo_cuenta->RowType == EW_ROWTYPE_ADD || $saldo_cuenta->RowType == EW_ROWTYPE_EDIT) { ?>
<?php if ($saldo_cuenta->CurrentAction == "edit") { ?>
<td colspan="<?php echo $saldo_cuenta_list->lOptionCnt ?>"><span class="phpmaker">
<a href="" onclick="if (saldo_cuenta_list.ValidateForm(document.fsaldo_cuentalist)) document.fsaldo_cuentalist.submit();return false;">Guardar</a>&nbsp;<a href="<?php echo $saldo_cuenta_list->PageUrl() ?>a=cancel&idCuenta=<?php echo $_GET['idCuenta']?>">Cancelar</a>
<input type="hidden" name="a_list" id="a_list" value="update">
</span></td>
<?php } ?>
<?php } else { ?>
<?php if ($saldo_cuenta->Export == "") { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a href="<?php echo $saldo_cuenta->InlineEditUrl() ?>&idCuenta=<?php echo $_GET['idCuenta']?>">Editar</a>
</span></td>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($saldo_cuenta_list->lOptionCnt == 0 && $saldo_cuenta->CurrentAction == "add") { ?>
<td style="white-space: nowrap;">&nbsp;</td>
<?php } ?>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<td style="white-space: nowrap;"><span class="phpmaker">
<a onclick="ew_ClickDelete(this);return ew_ConfirmDelete('<?php echo $saldo_cuenta_list->sDeleteConfirmMsg ?>', this);" href="<?php echo $saldo_cuenta->DeleteUrl() ?>&idCuenta=<?php echo $_GET['idCuenta']?>">Borrar</a>
</span></td>
<?php } ?>
<?php

// Custom list options
foreach ($saldo_cuenta_list->ListOptions->Items as $ListOption) {
	if ($ListOption->Visible)
		echo $ListOption->BodyCellHtml;
}
?>
<?php } ?>
<?php } ?>
	</tr>
<?php if ($saldo_cuenta->RowType == EW_ROWTYPE_EDIT) { ?>
<?php } ?>
<?php
	}
$contador++;
	if ($saldo_cuenta->CurrentAction <> "gridadd")
		$rs->MoveNext();
}
?>
</tbody>
<?php
	if ($saldo_cuenta->CurrentAction == "add" || $saldo_cuenta->CurrentAction == "copy") {
		$saldo_cuenta_list->lRowIndex = 1;
		if ($saldo_cuenta->CurrentAction == "add")
			$saldo_cuenta_list->LoadDefaultValues();
		if ($saldo_cuenta->EventCancelled) // Insert failed
			$saldo_cuenta_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$saldo_cuenta->CssClass = "ewTableEditRow";
		$saldo_cuenta->CssStyle = "";
		$saldo_cuenta->RowClientEvents = "onmouseover='ew_MouseOver(event, this);' onmouseout='ew_MouseOut(event, this);' onclick='ew_Click(event, this);'";
		$saldo_cuenta->RowType = EW_ROWTYPE_ADD;

		// Render row
		$saldo_cuenta_list->RenderRow();
?>
	<tr<?php echo $saldo_cuenta->RowAttributes() ?>>
	<?php if ($saldo_cuenta->idSaldoCuenta->Visible) { // idSaldoCuenta ?>
		<td>&nbsp;</td>
	<?php } ?>
	<?php if ($saldo_cuenta->idCuenta->Visible) { // idCuenta ?>
<input type="hidden" id="x<?php echo $saldo_cuenta_list->lRowIndex ?>_idCuenta" name="x<?php echo $saldo_cuenta_list->lRowIndex ?>_idCuenta" value="<?php echo $_GET['idCuenta']?>">
	<?php } ?>
	<?php if ($saldo_cuenta->fecha->Visible) { // fecha ?>
		<td>
<input type="text" name="x<?php echo $saldo_cuenta_list->lRowIndex ?>_fecha" id="x<?php echo $saldo_cuenta_list->lRowIndex ?>_fecha" size="12">
&nbsp;<img src="images/calendar.png" id="cal_x<?php echo $saldo_cuenta_list->lRowIndex ?>_fecha" name="cal_x<?php echo $saldo_cuenta_list->lRowIndex ?>_fecha" alt="Seleccione una fecha" style="cursor:pointer;cursor:hand;">
<script type="text/javascript">
Calendar.setup({
	inputField : "x<?php echo $saldo_cuenta_list->lRowIndex ?>_fecha", // ID of the input field
	ifFormat : "%d-%m-%Y", // the date format
	button : "cal_x<?php echo $saldo_cuenta_list->lRowIndex ?>_fecha" // ID of the button
});
</script>
</td>
	<?php } ?>
	<?php if ($saldo_cuenta->nro_fact_recibo->Visible) { // nro_fact_recibo ?>
		<td>
<input type="text" name="x<?php echo $saldo_cuenta_list->lRowIndex ?>_nro_fact_recibo" id="x<?php echo $saldo_cuenta_list->lRowIndex ?>_nro_fact_recibo" size="10">
</td>
	<?php } ?>
	<?php if ($saldo_cuenta->detalle->Visible) { // detalle ?>
		<td>
<input type="text" name="x<?php echo $saldo_cuenta_list->lRowIndex ?>_detalle" id="x<?php echo $saldo_cuenta_list->lRowIndex ?>_detalle" size="30" maxlength="255" >
</td>
	<?php } ?>
	<?php if ($saldo_cuenta->ingreso->Visible) { // ingreso ?>
		<td>
<input type="text" name="x<?php echo $saldo_cuenta_list->lRowIndex ?>_ingreso" id="x<?php echo $saldo_cuenta_list->lRowIndex ?>_ingreso" size="12">
</td>
	<?php } ?>
	<?php if ($saldo_cuenta->egreso->Visible) { // egreso ?>
		<td>
<input type="text" name="x<?php echo $saldo_cuenta_list->lRowIndex ?>_egreso" id="x<?php echo $saldo_cuenta_list->lRowIndex ?>_egreso" size="12" >
</td>
<td>&nbsp;</td>
	<?php } ?>
<td colspan="<?php echo $saldo_cuenta_list->lOptionCnt ?>"><span class="phpmaker">
<a href="" onclick="if (saldo_cuenta_list.ValidateForm(document.fsaldo_cuentalist)) document.fsaldo_cuentalist.submit();return false;">Guardar</a>&nbsp;<a href="<?php echo $saldo_cuenta_list->PageUrl() ?>a=cancel&idCuenta=<?php echo $_GET['idCuenta']?>">Cancelar</a>
<input type="hidden" name="a_list" id="a_list" value="insert">
</span></td>
	</tr>
<?php
}
?>
</table>
<?php } ?>
<?php if ($saldo_cuenta->CurrentAction == "add" || $saldo_cuenta->CurrentAction == "copy") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $saldo_cuenta_list->lRowIndex ?>">
<?php } ?>
<?php if ($saldo_cuenta->CurrentAction == "edit") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $saldo_cuenta_list->lRowIndex ?>">
<?php } ?>
</form>
<?php

// Close recordset
if ($rs)
	$rs->Close();
?>
</div>
<?php if ($saldo_cuenta->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($saldo_cuenta->CurrentAction <> "gridadd" && $saldo_cuenta->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($saldo_cuenta_list->Pager)) $saldo_cuenta_list->Pager = new cPrevNextPager($saldo_cuenta_list->lStartRec, $saldo_cuenta_list->lDisplayRecs, $saldo_cuenta_list->lTotalRecs) ?>
<?php if ($saldo_cuenta_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">P�gina&nbsp;</span></td>
<!--first page button-->
	<?php if ($saldo_cuenta_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $saldo_cuenta_list->PageUrl() ?>start=<?php echo $saldo_cuenta_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="Primera" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="Primera" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($saldo_cuenta_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $saldo_cuenta_list->PageUrl() ?>start=<?php echo $saldo_cuenta_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Anterior" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Anterior" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $saldo_cuenta_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($saldo_cuenta_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $saldo_cuenta_list->PageUrl() ?>start=<?php echo $saldo_cuenta_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Siguiente" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Siguiente" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($saldo_cuenta_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $saldo_cuenta_list->PageUrl() ?>start=<?php echo $saldo_cuenta_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Ultima" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Ultima" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;de <?php echo $saldo_cuenta_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker">Registro <?php echo $saldo_cuenta_list->Pager->FromIndex ?> a <?php echo $saldo_cuenta_list->Pager->ToIndex ?> de <?php echo $saldo_cuenta_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($saldo_cuenta_list->sSrchWhere == "0=101") { ?>
	<span class="phpmaker">Por favor ingrese criterio de busqueda</span>
	<?php } else { ?>
	<span class="phpmaker">No se encontraron registros</span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($saldo_cuenta_list->lTotalRecs > 0) { ?>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><table border="0" cellspacing="0" cellpadding="0"><tr><td>Registros por p�gina&nbsp;</td><td>
<input type="hidden" id="t" name="t" value="saldo_cuenta">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" id="<?php echo EW_TABLE_REC_PER_PAGE ?>" onchange="this.form.submit();" class="phpmaker">
<option value="20"<?php if ($saldo_cuenta_list->lDisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="50"<?php if ($saldo_cuenta_list->lDisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="ALL"<?php if ($saldo_cuenta->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>>Todos los registros</option>
</select></td></tr></table>
		</td>
<?php } ?>
	</tr>
</table>
</form>
<?php } ?>
<?php //if ($saldo_cuenta_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<a href="<?php echo $saldo_cuenta_list->PageUrl() ?>a=add&idCuenta=<?php echo $_GET['idCuenta']?>">Adicionar Transaccion</a>&nbsp;&nbsp;
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<br>
<br>
<?php
mysql_select_db($database_conexion, $conexion);
$query_cuentaSaldo = "SELECT * FROM cuenta WHERE estado = 1 Order by cuenta";
$mostrar_cuentaSaldo= mysql_query($query_cuentaSaldo, $conexion) or die(mysql_error());
$total_cuentaSaldo= mysql_num_rows($mostrar_cuentaSaldo);
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
    <tr class="ewTableHeader">
        <td>No</td>
        <td>Cuenta</td>
        <td>Saldo</td>
    </tr>
<?php
$totalsaldo=0;
while($row_cuentaSaldo=mysql_fetch_assoc($mostrar_cuentaSaldo)){

mysql_select_db($database_conexion, $conexion);
$query_saldo= "SELECT idCuenta, sum(ingreso)-sum(egreso) as saldo FROM saldo_cuenta WHERE idCuenta='".$row_cuentaSaldo['idCuenta']."' AND estado=1 GROUP BY idCuenta";
$mostrar_saldo= mysql_query($query_saldo, $conexion) or die(mysql_error());
$row_saldo=mysql_fetch_assoc($mostrar_saldo);
$total_saldo= mysql_num_rows($mostrar_saldo);
?>
    <tr>
        <td><?php echo $row_cuentaSaldo['idCuenta']?></td>
        <td><?php echo $row_cuentaSaldo['cuenta']?></td>
        <td align="right"><?php printf("%0.2f",$row_saldo['saldo'])?></td>
    </tr>
 <?php    
 $totalsaldo=$totalsaldo+$row_saldo['saldo'];
 }
?>
    <tr style="background: navy; color: white">
        <td></td>
        <td>TOTAL SALDO</td>
        <td><?php printf("%0.2f",$totalsaldo)?></td>
    </tr>
</table>
</div></td></tr></table>
<?php include "footer.php" ?>
<?php

//
// Page Class
//
class csaldo_cuenta_list {

	// Page ID
	var $PageID = 'list';

	// Table Name
	var $TableName = 'saldo_cuenta';

	// Page Object Name
	var $PageObjName = 'saldo_cuenta_list';

	// Page Name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page Url
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $saldo_cuenta;
		if ($saldo_cuenta->UseTokenInUrl) $PageUrl .= "t=" . $saldo_cuenta->TableVar . "&"; // add page token
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
		global $objForm, $saldo_cuenta;
		if ($saldo_cuenta->UseTokenInUrl) {

			//IsPageRequest = False
			if ($objForm)
				return ($saldo_cuenta->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($saldo_cuenta->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	//  Class initialize
	//  - init objects
	//  - open connection
	//
	function csaldo_cuenta_list() {
		global $conn;

		// Initialize table object
		$GLOBALS["saldo_cuenta"] = new csaldo_cuenta();

		// Initialize other table object
		$GLOBALS['usuario'] = new cusuario();

		// Intialize page id (for backward compatibility)
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Initialize table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'saldo_cuenta', TRUE);

		// Open connection to the database
		$conn = ew_Connect();

		// Initialize list options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $saldo_cuenta;
		global $Security;
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
	$saldo_cuenta->Export = @$_GET["export"]; // Get export parameter
	$gsExport = $saldo_cuenta->Export; // Get export parameter, used in header
	$gsExportFile = $saldo_cuenta->TableVar; // Get export file, used in header
	if ($saldo_cuenta->Export == "excel") {
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
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
	var $lDisplayRecs; // Number of display records
	var $lStartRec;
	var $lStopRec;
	var $lTotalRecs;
	var $lRecRange;
	var $sSrchWhere;
	var $lRecCnt;
	var $lEditRowCnt;
	var $lRowCnt;
	var $lRowIndex;
	var $lOptionCnt;
	var $lRecPerRow;
	var $lColCnt;
	var $sDeleteConfirmMsg; // Delete confirm message
	var $sDbMasterFilter;
	var $sDbDetailFilter;
	var $bMasterRecordExists;	
	var $ListOptions;
	var $sMultiSelectKey;

	//
	// Page main processing
	//
	function Page_Main() {
		global $objForm, $gsSearchError, $Security, $saldo_cuenta;
		$this->lDisplayRecs = 20;
		$this->lRecRange = 10;
		$this->lRecCnt = 0; // Record count

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		$this->sSrchWhere = ""; // Search WHERE clause
		$this->sDeleteConfirmMsg = "�Quiere borrar este registro?"; // Delete confirm message

		// Master/Detail
		$this->sDbMasterFilter = ""; // Master filter
		$this->sDbDetailFilter = ""; // Detail filter

		// Create form object
		$objForm = new cFormObj();
		if ($this->IsPageRequest()) { // Validate request

			// Set up records per page dynamically
			$this->SetUpDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$saldo_cuenta->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($saldo_cuenta->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to inline edit mode
				if ($saldo_cuenta->CurrentAction == "edit")
					$this->InlineEditMode();

				// Switch to inline add mode
				if ($saldo_cuenta->CurrentAction == "add" || $saldo_cuenta->CurrentAction == "copy")
					$this->InlineAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$saldo_cuenta->CurrentAction = $_POST["a_list"]; // Get action

					// Inline Update
					if ($saldo_cuenta->CurrentAction == "update" && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();

					// Insert Inline
					if ($saldo_cuenta->CurrentAction == "insert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "add")
						$this->InlineInsert();
				}
			}

			// Set Up Sorting Order
			$this->SetUpSortOrder();
		} // End Validate Request

		// Restore display records
		if ($saldo_cuenta->getRecordsPerPage() <> "") {
			//$this->lDisplayRecs =$saldo_cuenta->getRecordsPerPage(); // Restore from Session
                        $this->lDisplayRecs =-1; 
		} else {
			//$this->lDisplayRecs =20; // Load default
                        $this->lDisplayRecs =-1;
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "($sFilter) AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "($sFilter) AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Set up filter in Session
		$saldo_cuenta->setSessionWhere($sFilter);
		$saldo_cuenta->CurrentFilter = "";

		// Export data only
		if (in_array($saldo_cuenta->Export, array("html","word","excel","xml","csv"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		global $saldo_cuenta;
		$sWrk = @$_GET[EW_TABLE_REC_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->lDisplayRecs = intval($sWrk);
			} else {
				if (strtolower($sWrk) == "all") { // Display all records
					$this->lDisplayRecs = -1;
				} else {
					$this->lDisplayRecs = 20; // Non-numeric, load default
				}
			}
			$saldo_cuenta->setRecordsPerPage($this->lDisplayRecs); // Save to Session

			// Reset start position
			$this->lStartRec = 1;
			$saldo_cuenta->setStartRecordNumber($this->lStartRec);
		}
	}

	//  Exit out of inline mode
	function ClearInlineMode() {
		global $saldo_cuenta;
		$saldo_cuenta->setKey("idSaldoCuenta", ""); // Clear inline edit key
		$saldo_cuenta->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Inline Edit Mode
	function InlineEditMode() {
		global $Security, $saldo_cuenta;
		$bInlineEdit = TRUE;
		if (@$_GET["idSaldoCuenta"] <> "") {
			$saldo_cuenta->idSaldoCuenta->setQueryStringValue($_GET["idSaldoCuenta"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$saldo_cuenta->setKey("idSaldoCuenta", $saldo_cuenta->idSaldoCuenta->CurrentValue); // Set up inline edit key
				$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
			}
		}
	}

	// Peform update to inline edit record
	function InlineUpdate() {
		global $objForm, $gsFormError, $saldo_cuenta;
		$objForm->Index = 1; 
		$this->LoadFormValues(); // Get form values

		// Validate Form
		$bInlineUpdate = TRUE;
		if (!$this->ValidateForm()) {	
			$bInlineUpdate = FALSE; // Form error, reset action
			$this->setMessage($gsFormError);
		} else {
			$bInlineUpdate = FALSE;	
			if ($this->CheckInlineEditKey()) { // Check key
				$saldo_cuenta->SendEmail = TRUE; // Send email on update success
				$bInlineUpdate = $this->EditRow(); // Update record
			} else {
				$bInlineUpdate = FALSE;
			}
		}
		if ($bInlineUpdate) { // Update success
			$this->setMessage("Actualizacion exitosa"); // Set success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getMessage() == "")
				$this->setMessage("Actualizacion a fallado"); // Set update failed message
			$saldo_cuenta->EventCancelled = TRUE; // Cancel event
			$saldo_cuenta->CurrentAction = "edit"; // Stay in edit mode
		}
	}

	// Check inline edit key
	function CheckInlineEditKey() {
		global $saldo_cuenta;

		//CheckInlineEditKey = True
		if (strval($saldo_cuenta->getKey("idSaldoCuenta")) <> strval($saldo_cuenta->idSaldoCuenta->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Switch to Inline Add Mode
	function InlineAddMode() {
		global $Security, $saldo_cuenta;
		$saldo_cuenta->CurrentAction = "add";
		$_SESSION[EW_SESSION_INLINE_MODE] = "add"; // Enable inline add
	}

	// Peform update to inline add/copy record
	function InlineInsert() {
		global $objForm, $gsFormError, $saldo_cuenta;
		$objForm->Index = 1;
		$this->LoadFormValues(); // Get form values

		// Validate Form
		if (!$this->ValidateForm()) {
			$this->setMessage($gsFormError); // Set validation error message
			$saldo_cuenta->EventCancelled = TRUE; // Set event cancelled
			$saldo_cuenta->CurrentAction = "add"; // Stay in add mode
			return;
		}
		$saldo_cuenta->SendEmail = TRUE; // Send email on add success
		if ($this->AddRow()) { // Add record
			$this->setMessage("Registro agregado satisfactoriamente"); // Set add success message
			$this->ClearInlineMode(); // Clear inline add mode
		} else { // Add failed
			$saldo_cuenta->EventCancelled = TRUE; // Set event cancelled
			$saldo_cuenta->CurrentAction = "add"; // Stay in add mode
		}
	}

	// Set up Sort parameters based on Sort Links clicked
	function SetUpSortOrder() {
		global $saldo_cuenta;

		// Check for an Order parameter
		if (@$_GET["order"] <> "") {
			$saldo_cuenta->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$saldo_cuenta->CurrentOrderType = @$_GET["ordertype"];
			$saldo_cuenta->UpdateSort($saldo_cuenta->idSaldoCuenta); // Field 
			$saldo_cuenta->UpdateSort($saldo_cuenta->idCuenta); // Field 
			$saldo_cuenta->UpdateSort($saldo_cuenta->fecha); // Field 
			$saldo_cuenta->UpdateSort($saldo_cuenta->nro_fact_recibo); // Field 
			$saldo_cuenta->UpdateSort($saldo_cuenta->detalle); // Field 
			$saldo_cuenta->UpdateSort($saldo_cuenta->ingreso); // Field 
			$saldo_cuenta->UpdateSort($saldo_cuenta->egreso); // Field 
			$saldo_cuenta->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load Sort Order parameters
	function LoadSortOrder() {
		global $saldo_cuenta;
		$sOrderBy = $saldo_cuenta->getSessionOrderBy(); // Get order by from Session
		if ($sOrderBy == "") {
			if ($saldo_cuenta->SqlOrderBy() <> "") {
				$sOrderBy = $saldo_cuenta->SqlOrderBy();
				$saldo_cuenta->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command based on querystring parameter cmd=
	// - RESET: reset search parameters
	// - RESETALL: reset search & master/detail parameters
	// - RESETSORT: reset sort parameters
	function ResetCmd() {
		global $saldo_cuenta;

		// Get reset cmd
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset sort criteria
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$saldo_cuenta->setSessionOrderBy($sOrderBy);
				$saldo_cuenta->idSaldoCuenta->setSort("");
				$saldo_cuenta->idCuenta->setSort("");
				$saldo_cuenta->fecha->setSort("");
				$saldo_cuenta->nro_fact_recibo->setSort("");
				$saldo_cuenta->detalle->setSort("");
				$saldo_cuenta->ingreso->setSort("");
				$saldo_cuenta->egreso->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$saldo_cuenta->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up Starting Record parameters based on Pager Navigation
	function SetUpStartRec() {
		global $saldo_cuenta;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request			
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$saldo_cuenta->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$saldo_cuenta->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $saldo_cuenta->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$saldo_cuenta->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$saldo_cuenta->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$saldo_cuenta->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load default values
	function LoadDefaultValues() {
		global $saldo_cuenta;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $saldo_cuenta;
		$saldo_cuenta->idSaldoCuenta->setFormValue($objForm->GetValue("x_idSaldoCuenta"));
		$saldo_cuenta->idCuenta->setFormValue($objForm->GetValue("x_idCuenta"));
		$saldo_cuenta->fecha->setFormValue($objForm->GetValue("x_fecha"));
		$saldo_cuenta->fecha->CurrentValue = ew_UnFormatDateTime($saldo_cuenta->fecha->CurrentValue, 7);
		$saldo_cuenta->nro_fact_recibo->setFormValue($objForm->GetValue("x_nro_fact_recibo"));
		$saldo_cuenta->detalle->setFormValue($objForm->GetValue("x_detalle"));
		$saldo_cuenta->ingreso->setFormValue($objForm->GetValue("x_ingreso"));
		$saldo_cuenta->egreso->setFormValue($objForm->GetValue("x_egreso"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $saldo_cuenta;
		$saldo_cuenta->idSaldoCuenta->CurrentValue = $saldo_cuenta->idSaldoCuenta->FormValue;
		$saldo_cuenta->idCuenta->CurrentValue = $saldo_cuenta->idCuenta->FormValue;
		$saldo_cuenta->fecha->CurrentValue = $saldo_cuenta->fecha->FormValue;
		$saldo_cuenta->fecha->CurrentValue = ew_UnFormatDateTime($saldo_cuenta->fecha->CurrentValue, 7);
		$saldo_cuenta->nro_fact_recibo->CurrentValue = $saldo_cuenta->nro_fact_recibo->FormValue;
		$saldo_cuenta->detalle->CurrentValue = $saldo_cuenta->detalle->FormValue;
		$saldo_cuenta->ingreso->CurrentValue = $saldo_cuenta->ingreso->FormValue;
		$saldo_cuenta->egreso->CurrentValue = $saldo_cuenta->egreso->FormValue;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $saldo_cuenta;

		// Call Recordset Selecting event
		$saldo_cuenta->Recordset_Selecting($saldo_cuenta->CurrentFilter);

		// Load list page SQL
		$sSql = $saldo_cuenta->SelectSQL();
		if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';	
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$saldo_cuenta->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $saldo_cuenta;
		$sFilter = $saldo_cuenta->KeyFilter();

		// Call Row Selecting event
		$saldo_cuenta->Row_Selecting($sFilter);

		// Load sql based on filter
		$saldo_cuenta->CurrentFilter = $sFilter;
		$sSql = $saldo_cuenta->SQL();
		if ($rs = $conn->Execute($sSql)) {
			if ($rs->EOF) {
				$LoadRow = FALSE;
			} else {
				$LoadRow = TRUE;
				$rs->MoveFirst();
				$this->LoadRowValues($rs); // Load row values

				// Call Row Selected event
				$saldo_cuenta->Row_Selected($rs);
			}
			$rs->Close();
		} else {
			$LoadRow = FALSE;
		}
		return $LoadRow;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $saldo_cuenta;
		$saldo_cuenta->idSaldoCuenta->setDbValue($rs->fields('idSaldoCuenta'));
		$saldo_cuenta->idCuenta->setDbValue($rs->fields('idCuenta'));
		$saldo_cuenta->fecha->setDbValue($rs->fields('fecha'));
		$saldo_cuenta->nro_fact_recibo->setDbValue($rs->fields('nro_fact_recibo'));
		$saldo_cuenta->detalle->setDbValue($rs->fields('detalle'));
		$saldo_cuenta->ingreso->setDbValue($rs->fields('ingreso'));
		$saldo_cuenta->egreso->setDbValue($rs->fields('egreso'));
		$saldo_cuenta->fechaCreacion->setDbValue($rs->fields('fechaCreacion'));
		$saldo_cuenta->fechaModificacion->setDbValue($rs->fields('fechaModificacion'));
		$saldo_cuenta->diezmo->setDbValue($rs->fields('diezmo'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $saldo_cuenta;

		// Call Row_Rendering event
		$saldo_cuenta->Row_Rendering();

		// Common render codes for all row types
		// idSaldoCuenta

		$saldo_cuenta->idSaldoCuenta->CellCssStyle = "";
		$saldo_cuenta->idSaldoCuenta->CellCssClass = "";

		// idCuenta
		$saldo_cuenta->idCuenta->CellCssStyle = "";
		$saldo_cuenta->idCuenta->CellCssClass = "";

		// fecha
		$saldo_cuenta->fecha->CellCssStyle = "";
		$saldo_cuenta->fecha->CellCssClass = "";

		// nro_fact_recibo
		$saldo_cuenta->nro_fact_recibo->CellCssStyle = "";
		$saldo_cuenta->nro_fact_recibo->CellCssClass = "";

		// detalle
		$saldo_cuenta->detalle->CellCssStyle = "";
		$saldo_cuenta->detalle->CellCssClass = "";

		// ingreso
		$saldo_cuenta->ingreso->CellCssStyle = "";
		$saldo_cuenta->ingreso->CellCssClass = "";

		// egreso
		$saldo_cuenta->egreso->CellCssStyle = "";
		$saldo_cuenta->egreso->CellCssClass = "";
		if ($saldo_cuenta->RowType == EW_ROWTYPE_VIEW) { // View row

			// idSaldoCuenta
			$saldo_cuenta->idSaldoCuenta->ViewValue = $saldo_cuenta->idSaldoCuenta->CurrentValue;
			$saldo_cuenta->idSaldoCuenta->CssStyle = "";
			$saldo_cuenta->idSaldoCuenta->CssClass = "";
			$saldo_cuenta->idSaldoCuenta->ViewCustomAttributes = "";

			// idCuenta
			if (strval($saldo_cuenta->idCuenta->CurrentValue) <> "") {
				$sSqlWrk = "SELECT `cuenta` FROM `cuenta` WHERE `idCuenta` = " . ew_AdjustSql($saldo_cuenta->idCuenta->CurrentValue) . "";
				$sSqlWrk .= " ORDER BY `cuenta` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
					$saldo_cuenta->idCuenta->ViewValue = $rswrk->fields('cuenta');
					$rswrk->Close();
				} else {
					$saldo_cuenta->idCuenta->ViewValue = $saldo_cuenta->idCuenta->CurrentValue;
				}
			} else {
				$saldo_cuenta->idCuenta->ViewValue = NULL;
			}
			$saldo_cuenta->idCuenta->CssStyle = "";
			$saldo_cuenta->idCuenta->CssClass = "";
			$saldo_cuenta->idCuenta->ViewCustomAttributes = "";

			// fecha
			$saldo_cuenta->fecha->ViewValue = $saldo_cuenta->fecha->CurrentValue;
			$saldo_cuenta->fecha->ViewValue = ew_FormatDateTime($saldo_cuenta->fecha->ViewValue, 7);
			$saldo_cuenta->fecha->CssStyle = "";
			$saldo_cuenta->fecha->CssClass = "";
			$saldo_cuenta->fecha->ViewCustomAttributes = "";

			// nro_fact_recibo
			$saldo_cuenta->nro_fact_recibo->ViewValue = $saldo_cuenta->nro_fact_recibo->CurrentValue;
			$saldo_cuenta->nro_fact_recibo->CssStyle = "";
			$saldo_cuenta->nro_fact_recibo->CssClass = "";
			$saldo_cuenta->nro_fact_recibo->ViewCustomAttributes = "";

			// detalle
			$saldo_cuenta->detalle->ViewValue = $saldo_cuenta->detalle->CurrentValue;
			$saldo_cuenta->detalle->CssStyle = "";
			$saldo_cuenta->detalle->CssClass = "";
			$saldo_cuenta->detalle->ViewCustomAttributes = "";

			// ingreso
			$saldo_cuenta->ingreso->ViewValue = $saldo_cuenta->ingreso->CurrentValue;
			$saldo_cuenta->ingreso->CssStyle = "";
			$saldo_cuenta->ingreso->CssClass = "";
			$saldo_cuenta->ingreso->ViewCustomAttributes = "";

			// egreso
			$saldo_cuenta->egreso->ViewValue = $saldo_cuenta->egreso->CurrentValue;
			$saldo_cuenta->egreso->CssStyle = "";
			$saldo_cuenta->egreso->CssClass = "";
			$saldo_cuenta->egreso->ViewCustomAttributes = "";

			// idSaldoCuenta
			$saldo_cuenta->idSaldoCuenta->HrefValue = "";

			// idCuenta
			$saldo_cuenta->idCuenta->HrefValue = "";

			// fecha
			$saldo_cuenta->fecha->HrefValue = "";

			// nro_fact_recibo
			$saldo_cuenta->nro_fact_recibo->HrefValue = "";

			// detalle
			$saldo_cuenta->detalle->HrefValue = "";

			// ingreso
			$saldo_cuenta->ingreso->HrefValue = "";

			// egreso
			$saldo_cuenta->egreso->HrefValue = "";
		} elseif ($saldo_cuenta->RowType == EW_ROWTYPE_ADD) { // Add row

			// idSaldoCuenta
			// idCuenta

			$saldo_cuenta->idCuenta->EditCustomAttributes = "";
			$sSqlWrk = "SELECT `idCuenta`, `cuenta`, '' AS Disp2Fld, '' AS SelectFilterFld FROM `cuenta`";
			$sWhereWrk = "";
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE $sWhereWrk";
			$sSqlWrk .= " ORDER BY `cuenta` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", "Por favor Seleccione"));
			$saldo_cuenta->idCuenta->EditValue = $arwrk;

			// fecha
			$saldo_cuenta->fecha->EditCustomAttributes = "";
			$saldo_cuenta->fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime($saldo_cuenta->fecha->CurrentValue, 7));

			// nro_fact_recibo
			$saldo_cuenta->nro_fact_recibo->EditCustomAttributes = "";
			$saldo_cuenta->nro_fact_recibo->EditValue = ew_HtmlEncode($saldo_cuenta->nro_fact_recibo->CurrentValue);

			// detalle
			$saldo_cuenta->detalle->EditCustomAttributes = "";
			$saldo_cuenta->detalle->EditValue = ew_HtmlEncode($saldo_cuenta->detalle->CurrentValue);

			// ingreso
			$saldo_cuenta->ingreso->EditCustomAttributes = "";
			$saldo_cuenta->ingreso->EditValue = ew_HtmlEncode($saldo_cuenta->ingreso->CurrentValue);

			// egreso
			$saldo_cuenta->egreso->EditCustomAttributes = "";
			$saldo_cuenta->egreso->EditValue = ew_HtmlEncode($saldo_cuenta->egreso->CurrentValue);
		} elseif ($saldo_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// idSaldoCuenta
			$saldo_cuenta->idSaldoCuenta->EditCustomAttributes = "";
			$saldo_cuenta->idSaldoCuenta->EditValue = $saldo_cuenta->idSaldoCuenta->CurrentValue;
			$saldo_cuenta->idSaldoCuenta->CssStyle = "";
			$saldo_cuenta->idSaldoCuenta->CssClass = "";
			$saldo_cuenta->idSaldoCuenta->ViewCustomAttributes = "";

			// idCuenta
			$saldo_cuenta->idCuenta->EditCustomAttributes = "";
			$sSqlWrk = "SELECT `idCuenta`, `cuenta`, '' AS Disp2Fld, '' AS SelectFilterFld FROM `cuenta`";
			$sWhereWrk = "";
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE $sWhereWrk";
			$sSqlWrk .= " ORDER BY `cuenta` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", "Por favor Seleccione"));
			$saldo_cuenta->idCuenta->EditValue = $arwrk;

			// fecha
			$saldo_cuenta->fecha->EditCustomAttributes = "";
			$saldo_cuenta->fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime($saldo_cuenta->fecha->CurrentValue, 7));

			// nro_fact_recibo
			$saldo_cuenta->nro_fact_recibo->EditCustomAttributes = "";
			$saldo_cuenta->nro_fact_recibo->EditValue = ew_HtmlEncode($saldo_cuenta->nro_fact_recibo->CurrentValue);

			// detalle
			$saldo_cuenta->detalle->EditCustomAttributes = "";
			$saldo_cuenta->detalle->EditValue = ew_HtmlEncode($saldo_cuenta->detalle->CurrentValue);

			// ingreso
			$saldo_cuenta->ingreso->EditCustomAttributes = "";
			$saldo_cuenta->ingreso->EditValue = ew_HtmlEncode($saldo_cuenta->ingreso->CurrentValue);

			// egreso
			$saldo_cuenta->egreso->EditCustomAttributes = "";
			$saldo_cuenta->egreso->EditValue = ew_HtmlEncode($saldo_cuenta->egreso->CurrentValue);

			// Edit refer script
			// idSaldoCuenta

			$saldo_cuenta->idSaldoCuenta->HrefValue = "";

			// idCuenta
			$saldo_cuenta->idCuenta->HrefValue = "";

			// fecha
			$saldo_cuenta->fecha->HrefValue = "";

			// nro_fact_recibo
			$saldo_cuenta->nro_fact_recibo->HrefValue = "";

			// detalle
			$saldo_cuenta->detalle->HrefValue = "";

			// ingreso
			$saldo_cuenta->ingreso->HrefValue = "";

			// egreso
			$saldo_cuenta->egreso->HrefValue = "";
		}

		// Call Row Rendered event
		$saldo_cuenta->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $gsFormError, $saldo_cuenta;

		// Initialize
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($saldo_cuenta->idCuenta->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Cuenta";
		}
		if ($saldo_cuenta->fecha->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Fecha";
		}
		if (!ew_CheckEuroDate($saldo_cuenta->fecha->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Fecha incorrecta, formato = dd-mm-yyyy - Fecha";
		}
		if (!ew_CheckInteger($saldo_cuenta->nro_fact_recibo->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "Entero Incorrecto - Nro Recibo";
		}
		if ($saldo_cuenta->detalle->FormValue == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= "Por favor ingrese los campos requeridos - Detalle";
		}
		if (!ew_CheckNumber($saldo_cuenta->ingreso->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "N�mero de Punto Flotante Incorrecto - Ingreso";
		}
		if (!ew_CheckNumber($saldo_cuenta->egreso->FormValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= "N�mero de Punto Flotante Incorrecto - Egreso";
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
		global $conn, $Security, $saldo_cuenta;
		$sFilter = $saldo_cuenta->KeyFilter();
		$saldo_cuenta->CurrentFilter = $sFilter;
		$sSql = $saldo_cuenta->SQL();
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

			// Field idSaldoCuenta
			// Field idCuenta

			$saldo_cuenta->idCuenta->SetDbValueDef($saldo_cuenta->idCuenta->CurrentValue, 0);
			$rsnew['idCuenta'] =& $saldo_cuenta->idCuenta->DbValue;

			// Field fecha
			$saldo_cuenta->fecha->SetDbValueDef(ew_UnFormatDateTime($saldo_cuenta->fecha->CurrentValue, 7), ew_CurrentDate());
			$rsnew['fecha'] =& $saldo_cuenta->fecha->DbValue;

			// Field nro_fact_recibo
			$saldo_cuenta->nro_fact_recibo->SetDbValueDef($saldo_cuenta->nro_fact_recibo->CurrentValue, NULL);
			$rsnew['nro_fact_recibo'] =& $saldo_cuenta->nro_fact_recibo->DbValue;

			// Field detalle
			$saldo_cuenta->detalle->SetDbValueDef($saldo_cuenta->detalle->CurrentValue, "");
			$rsnew['detalle'] =& $saldo_cuenta->detalle->DbValue;

			// Field ingreso
			$saldo_cuenta->ingreso->SetDbValueDef($saldo_cuenta->ingreso->CurrentValue, 0);
			$rsnew['ingreso'] =& $saldo_cuenta->ingreso->DbValue;

			// Field egreso
			$saldo_cuenta->egreso->SetDbValueDef($saldo_cuenta->egreso->CurrentValue, 0);
			$rsnew['egreso'] =& $saldo_cuenta->egreso->DbValue;
                        
                        // Field fechaModificacion
			//$saldo_cuenta->egreso->SetDbValueDef($saldo_cuenta->egreso->CurrentValue, 0);
			$rsnew['fechaModificacion'] =& date("Y-m-d H:i:s");

			// Call Row Updating event
			$bUpdateRow = $saldo_cuenta->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($saldo_cuenta->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($saldo_cuenta->CancelMessage <> "") {
					$this->setMessage($saldo_cuenta->CancelMessage);
					$saldo_cuenta->CancelMessage = "";
				} else {
					$this->setMessage("Actualizacion cancelada");
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$saldo_cuenta->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Add record
	function AddRow() {
		global $conn, $Security, $saldo_cuenta;
		$rsnew = array();

		// Field idSaldoCuenta
		// Field idCuenta

		$saldo_cuenta->idCuenta->SetDbValueDef($saldo_cuenta->idCuenta->CurrentValue, 0);
		$rsnew['idCuenta'] =& $saldo_cuenta->idCuenta->DbValue;

		// Field fecha
		$saldo_cuenta->fecha->SetDbValueDef(ew_UnFormatDateTime($saldo_cuenta->fecha->CurrentValue, 7), ew_CurrentDate());
		$rsnew['fecha'] =& $saldo_cuenta->fecha->DbValue;

		// Field nro_fact_recibo
		$saldo_cuenta->nro_fact_recibo->SetDbValueDef($saldo_cuenta->nro_fact_recibo->CurrentValue, NULL);
		$rsnew['nro_fact_recibo'] =& $saldo_cuenta->nro_fact_recibo->DbValue;

		// Field detalle
		$saldo_cuenta->detalle->SetDbValueDef($saldo_cuenta->detalle->CurrentValue, "");
		$rsnew['detalle'] =& $saldo_cuenta->detalle->DbValue;

		// Field ingreso
		$saldo_cuenta->ingreso->SetDbValueDef($saldo_cuenta->ingreso->CurrentValue, 0);
		$rsnew['ingreso'] =& $saldo_cuenta->ingreso->DbValue;

		// Field egreso
		$saldo_cuenta->egreso->SetDbValueDef($saldo_cuenta->egreso->CurrentValue, 0);
		$rsnew['egreso'] =& $saldo_cuenta->egreso->DbValue;
                
                // Field fechaCreacion
		//$saldo_cuenta->egreso->SetDbValueDef($saldo_cuenta->egreso->CurrentValue, 0);
		$rsnew['fechaCreacion'] =& date("Y-m-d H:i:s");
                
                // Field Fecha Modificacion
		//$saldo_cuenta->egreso->SetDbValueDef($saldo_cuenta->egreso->CurrentValue, 0);
		$rsnew['fechaModificacion'] =& date("Y-m-d H:i:s");

		// Call Row Inserting event
		$bInsertRow = $saldo_cuenta->Row_Inserting($rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($saldo_cuenta->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($saldo_cuenta->CancelMessage <> "") {
				$this->setMessage($saldo_cuenta->CancelMessage);
				$saldo_cuenta->CancelMessage = "";
			} else {
				$this->setMessage("Insertar cancelado");
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {
			$saldo_cuenta->idSaldoCuenta->setDbValue($conn->Insert_ID());
			$rsnew['idSaldoCuenta'] =& $saldo_cuenta->idSaldoCuenta->DbValue;

			// Call Row Inserted event
			$saldo_cuenta->Row_Inserted($rsnew);
		}
		return $AddRow;
	}

	// Export data in XML or CSV format
	function ExportData() {
		global $saldo_cuenta;
		$sCsvStr = "";

		// Default export style
		$sExportStyle = "h";

		// Load recordset
		$rs = $this->LoadRecordset();
		$this->lTotalRecs = $rs->RecordCount();
		$this->lStartRec = 1;

		// Export all
		if ($saldo_cuenta->ExportAll) {
			$this->lStopRec = $this->lTotalRecs;
		} else { // Export 1 page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->lDisplayRecs < 0) {
				$this->lStopRec = $this->lTotalRecs;
			} else {
				$this->lStopRec = $this->lStartRec + $this->lDisplayRecs - 1;
			}
		}
		if ($saldo_cuenta->Export == "xml") {
			$XmlDoc = new cXMLDocument();
		} else {
			echo ew_ExportHeader($saldo_cuenta->Export);

			// Horizontal format, write header
			if ($sExportStyle <> "v" || $saldo_cuenta->Export == "csv") {
				$sExportStr = "";
				ew_ExportAddValue($sExportStr, 'idSaldoCuenta', $saldo_cuenta->Export);
				ew_ExportAddValue($sExportStr, 'idCuenta', $saldo_cuenta->Export);
				ew_ExportAddValue($sExportStr, 'fecha', $saldo_cuenta->Export);
				ew_ExportAddValue($sExportStr, 'nro_fact_recibo', $saldo_cuenta->Export);
				ew_ExportAddValue($sExportStr, 'detalle', $saldo_cuenta->Export);
				ew_ExportAddValue($sExportStr, 'ingreso', $saldo_cuenta->Export);
				ew_ExportAddValue($sExportStr, 'egreso', $saldo_cuenta->Export);
				echo ew_ExportLine($sExportStr, $saldo_cuenta->Export);
			}
		}

		// Move to first record
		$this->lRecCnt = $this->lStartRec - 1;
		if (!$rs->EOF) {
			$rs->MoveFirst();
			$rs->Move($this->lStartRec - 1);
		}
		while (!$rs->EOF && $this->lRecCnt < $this->lStopRec) {
			$this->lRecCnt++;
			if (intval($this->lRecCnt) >= intval($this->lStartRec)) {
				$this->LoadRowValues($rs);

				// Render row for display
				$saldo_cuenta->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($saldo_cuenta->Export == "xml") {
					$XmlDoc->BeginRow();
					$XmlDoc->AddField('idSaldoCuenta', $saldo_cuenta->idSaldoCuenta->CurrentValue);
					$XmlDoc->AddField('idCuenta', $saldo_cuenta->idCuenta->CurrentValue);
					$XmlDoc->AddField('fecha', $saldo_cuenta->fecha->CurrentValue);
					$XmlDoc->AddField('nro_fact_recibo', $saldo_cuenta->nro_fact_recibo->CurrentValue);
					$XmlDoc->AddField('detalle', $saldo_cuenta->detalle->CurrentValue);
					$XmlDoc->AddField('ingreso', $saldo_cuenta->ingreso->CurrentValue);
					$XmlDoc->AddField('egreso', $saldo_cuenta->egreso->CurrentValue);
					$XmlDoc->EndRow();
				} else {
					if ($sExportStyle == "v" && $saldo_cuenta->Export <> "csv") { // Vertical format
						echo ew_ExportField('idSaldoCuenta', $saldo_cuenta->idSaldoCuenta->ExportValue($saldo_cuenta->Export, $saldo_cuenta->ExportOriginalValue), $saldo_cuenta->Export);
						echo ew_ExportField('idCuenta', $saldo_cuenta->idCuenta->ExportValue($saldo_cuenta->Export, $saldo_cuenta->ExportOriginalValue), $saldo_cuenta->Export);
						echo ew_ExportField('fecha', $saldo_cuenta->fecha->ExportValue($saldo_cuenta->Export, $saldo_cuenta->ExportOriginalValue), $saldo_cuenta->Export);
						echo ew_ExportField('nro_fact_recibo', $saldo_cuenta->nro_fact_recibo->ExportValue($saldo_cuenta->Export, $saldo_cuenta->ExportOriginalValue), $saldo_cuenta->Export);
						echo ew_ExportField('detalle', $saldo_cuenta->detalle->ExportValue($saldo_cuenta->Export, $saldo_cuenta->ExportOriginalValue), $saldo_cuenta->Export);
						echo ew_ExportField('ingreso', $saldo_cuenta->ingreso->ExportValue($saldo_cuenta->Export, $saldo_cuenta->ExportOriginalValue), $saldo_cuenta->Export);
						echo ew_ExportField('egreso', $saldo_cuenta->egreso->ExportValue($saldo_cuenta->Export, $saldo_cuenta->ExportOriginalValue), $saldo_cuenta->Export);
					}	else { // Horizontal format
						$sExportStr = "";
						ew_ExportAddValue($sExportStr, $saldo_cuenta->idSaldoCuenta->ExportValue($saldo_cuenta->Export, $saldo_cuenta->ExportOriginalValue), $saldo_cuenta->Export);
						ew_ExportAddValue($sExportStr, $saldo_cuenta->idCuenta->ExportValue($saldo_cuenta->Export, $saldo_cuenta->ExportOriginalValue), $saldo_cuenta->Export);
						ew_ExportAddValue($sExportStr, $saldo_cuenta->fecha->ExportValue($saldo_cuenta->Export, $saldo_cuenta->ExportOriginalValue), $saldo_cuenta->Export);
						ew_ExportAddValue($sExportStr, $saldo_cuenta->nro_fact_recibo->ExportValue($saldo_cuenta->Export, $saldo_cuenta->ExportOriginalValue), $saldo_cuenta->Export);
						ew_ExportAddValue($sExportStr, $saldo_cuenta->detalle->ExportValue($saldo_cuenta->Export, $saldo_cuenta->ExportOriginalValue), $saldo_cuenta->Export);
						ew_ExportAddValue($sExportStr, $saldo_cuenta->ingreso->ExportValue($saldo_cuenta->Export, $saldo_cuenta->ExportOriginalValue), $saldo_cuenta->Export);
						ew_ExportAddValue($sExportStr, $saldo_cuenta->egreso->ExportValue($saldo_cuenta->Export, $saldo_cuenta->ExportOriginalValue), $saldo_cuenta->Export);
						echo ew_ExportLine($sExportStr, $saldo_cuenta->Export);
					}
				}
			}
			$rs->MoveNext();
		}

		// Close recordset
		$rs->Close();
		if ($saldo_cuenta->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} else {
			echo ew_ExportFooter($saldo_cuenta->Export);
		}
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
