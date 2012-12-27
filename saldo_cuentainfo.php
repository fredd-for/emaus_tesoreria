<?php

// PHPMaker 6 configuration for Table saldo_cuenta
$saldo_cuenta = NULL; // Initialize table object

// Define table class
class csaldo_cuenta {

	// Define table level constants
	var $TableVar;
	var $TableName;
	var $SelectLimit = FALSE;
	var $idSaldoCuenta;
	var $idCuenta;
	var $fecha;
	var $nro_fact_recibo;
	var $detalle;
	var $ingreso;
	var $egreso;
	var $fechaCreacion;
	var $fechaModificacion;
	var $diezmo;
	var $fields = array();
	var $UseTokenInUrl = EW_USE_TOKEN_IN_URL;
	var $Export; // Export
	var $ExportOriginalValue = EW_EXPORT_ORIGINAL_VALUE;
	var	$ExportAll = EW_EXPORT_ALL;
	var $SendEmail; // Send Email
	var $TableCustomInnerHtml; // Custom Inner Html

	function csaldo_cuenta() {
		$this->TableVar = "saldo_cuenta";
		$this->TableName = "saldo_cuenta";
		$this->SelectLimit = TRUE;
		$this->idSaldoCuenta = new cField('saldo_cuenta', 'x_idSaldoCuenta', 'idSaldoCuenta', "`idSaldoCuenta`", 3, -1, FALSE);
		$this->fields['idSaldoCuenta'] =& $this->idSaldoCuenta;
		$this->idCuenta = new cField('saldo_cuenta', 'x_idCuenta', 'idCuenta', "`idCuenta`", 3, -1, FALSE);
		$this->fields['idCuenta'] =& $this->idCuenta;
		$this->fecha = new cField('saldo_cuenta', 'x_fecha', 'fecha', "`fecha`", 133, 7, FALSE);
		$this->fields['fecha'] =& $this->fecha;
		$this->nro_fact_recibo = new cField('saldo_cuenta', 'x_nro_fact_recibo', 'nro_fact_recibo', "`nro_fact_recibo`", 3, -1, FALSE);
		$this->fields['nro_fact_recibo'] =& $this->nro_fact_recibo;
		$this->detalle = new cField('saldo_cuenta', 'x_detalle', 'detalle', "`detalle`", 200, -1, FALSE);
		$this->fields['detalle'] =& $this->detalle;
		$this->ingreso = new cField('saldo_cuenta', 'x_ingreso', 'ingreso', "`ingreso`", 4, -1, FALSE);
		$this->fields['ingreso'] =& $this->ingreso;
		$this->egreso = new cField('saldo_cuenta', 'x_egreso', 'egreso', "`egreso`", 4, -1, FALSE);
		$this->fields['egreso'] =& $this->egreso;
		$this->fechaCreacion = new cField('saldo_cuenta', 'x_fechaCreacion', 'fechaCreacion', "`fechaCreacion`", 135, 7, FALSE);
		$this->fields['fechaCreacion'] =& $this->fechaCreacion;
		$this->fechaModificacion = new cField('saldo_cuenta', 'x_fechaModificacion', 'fechaModificacion', "`fechaModificacion`", 135, 7, FALSE);
		$this->fields['fechaModificacion'] =& $this->fechaModificacion;
		$this->diezmo = new cField('saldo_cuenta', 'x_diezmo', 'diezmo', "`diezmo`", 3, -1, FALSE);
		$this->fields['diezmo'] =& $this->diezmo;
	}

	// Records per page
	function getRecordsPerPage() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_REC_PER_PAGE];
	}

	function setRecordsPerPage($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_REC_PER_PAGE] = $v;
	}

	// Start record number
	function getStartRecordNumber() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_START_REC];
	}

	function setStartRecordNumber($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_START_REC] = $v;
	}

	// Search Highlight Name
	function HighlightName() {
		return "saldo_cuenta_Highlight";
	}

	// Advanced search
	function getAdvancedSearch($fld) {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ADVANCED_SEARCH . "_" . $fld];
	}

	function setAdvancedSearch($fld, $v) {
		if (@$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ADVANCED_SEARCH . "_" . $fld] <> $v) {
			$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ADVANCED_SEARCH . "_" . $fld] = $v;
		}
	}

	// Basic search Keyword
	function getBasicSearchKeyword() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH];
	}

	function setBasicSearchKeyword($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH] = $v;
	}

	// Basic Search Type
	function getBasicSearchType() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH_TYPE];
	}

	function setBasicSearchType($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_BASIC_SEARCH_TYPE] = $v;
	}

	// Search where clause
	function getSearchWhere() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_SEARCH_WHERE];
	}

	function setSearchWhere($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_SEARCH_WHERE] = $v;
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Session WHERE Clause
	function getSessionWhere() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_WHERE];
	}

	function setSessionWhere($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_WHERE] = $v;
	}

	// Session ORDER BY
	function getSessionOrderBy() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY];
	}

	function setSessionOrderBy($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY] = $v;
	}

	// Session Key
	function getKey($fld) {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_KEY . "_" . $fld];
	}

	function setKey($fld, $v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_KEY . "_" . $fld] = $v;
	}

	// Table level SQL
	function SqlSelect() { // Select
		return " SELECT * FROM `saldo_cuenta`";
	}

	function SqlWhere() { // Where
		return " estado = 1 AND idCuenta=".$_GET['idCuenta'];
	}

	function SqlGroupBy() { // Group By
		return "";
	}

	function SqlHaving() { // Having
		return "";
	}

	function SqlOrderBy() { // Order By
		//return " ";
                return " fecha, idSaldoCuenta asc";
	}

	// SQL variables
	var $CurrentFilter; // Current filter
	var $CurrentOrder; // Current order
	var $CurrentOrderType; // Current order type

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$sFilter, $sSort);
	}

	// Return table sql with list page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		if ($this->CurrentFilter <> "") {
			if ($sFilter <> "") $sFilter = "($sFilter) AND ";
			$sFilter .= "(" . $this->CurrentFilter . ")";
		}
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$sFilter, $sSort);
	}

	// Return record count
	function SelectRecordCount() {
		global $conn;
		$cnt = -1;
		$sFilter = $this->CurrentFilter;
		$this->Recordset_Selecting($this->CurrentFilter);
		if ($this->SelectLimit) {
			$sSelect = $this->SelectSQL();
			if (strtoupper(substr($sSelect, 0, 13)) == "SELECT * FROM") {
				$sSelect = "SELECT COUNT(*) FROM" . substr($sSelect, 13);
				if ($rs = $conn->Execute($sSelect)) {
					if (!$rs->EOF)
						$cnt = $rs->fields[0];
					$rs->Close();
				}
			}
		}
		if ($cnt == -1) {
			if ($rs = $conn->Execute($this->SelectSQL())) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $sFilter;
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= (is_null($value) ? "NULL" : ew_QuotedValue($value, $this->fields[$name]->FldDataType)) . ",";
		}
		if (substr($names, -1) == ",") $names = substr($names, 0, strlen($names)-1);
		if (substr($values, -1) == ",") $values = substr($values, 0, strlen($values)-1);
		return "INSERT INTO `saldo_cuenta` ($names,estado) VALUES ($values,'1')";
	}

	// UPDATE statement
	function UpdateSQL(&$rs) {
		$SQL = "UPDATE `saldo_cuenta` SET ";
		foreach ($rs as $name => $value) {
			$SQL .= $this->fields[$name]->FldExpression . "=" .
					(is_null($value) ? "NULL" : ew_QuotedValue($value, $this->fields[$name]->FldDataType)) . ",";
		}
		if (substr($SQL, -1) == ",") $SQL = substr($SQL, 0, strlen($SQL)-1);
		if ($this->CurrentFilter <> "")	$SQL .= " WHERE " . $this->CurrentFilter;
		return $SQL;
	}

	// DELETE statement
	function DeleteSQL(&$rs) {
            $SQL = "UPDATE `saldo_cuenta` SET estado = 0 WHERE idSaldoCuenta = ".ew_QuotedValue($rs['idSaldoCuenta'], $this->idSaldoCuenta->FldDataType);
//		$SQL = "DELETE FROM `saldo_cuenta` WHERE ";
//		$SQL .= EW_DB_QUOTE_START . 'idSaldoCuenta' . EW_DB_QUOTE_END . '=' .	ew_QuotedValue($rs['idSaldoCuenta'], $this->idSaldoCuenta->FldDataType) . ' AND ';
//		if (substr($SQL, -5) == " AND ") $SQL = substr($SQL, 0, strlen($SQL)-5);
//		if ($this->CurrentFilter <> "")	$SQL .= " AND " . $this->CurrentFilter;
		return $SQL;
	}

	// Key filter for table
	function SqlKeyFilter() {
		return "`idSaldoCuenta` = @idSaldoCuenta@";
	}

	// Return Key filter for table
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->idSaldoCuenta->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@idSaldoCuenta@", ew_AdjustSql($this->idSaldoCuenta->CurrentValue), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return url
	function getReturnUrl() {

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] <> "") {
			return $_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL];
		} else {
			return "saldo_cuentalist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// View url
	function ViewUrl() {
		return $this->KeyUrl("saldo_cuentaview.php", $this->UrlParm());
	}

	// Add url
	function AddUrl() {
		$AddUrl = "saldo_cuentaadd.php";
		$sUrlParm = $this->UrlParm();
		if ($sUrlParm <> "")
			$AddUrl .= "?" . $sUrlParm;
		return $AddUrl;
	}

	// Edit url
	function EditUrl() {
		return $this->KeyUrl("saldo_cuentaedit.php", $this->UrlParm());
	}

	// Inline edit url
	function InlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy url
	function CopyUrl() {
		return $this->KeyUrl("saldo_cuentaadd.php", $this->UrlParm());
	}

	// Inline copy url
	function InlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete url
	function DeleteUrl() {
		return $this->KeyUrl("saldo_cuentadelete.php", $this->UrlParm());
	}

	// Key url
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->idSaldoCuenta->CurrentValue)) {
			$sUrl .= "idSaldoCuenta=" . urlencode($this->idSaldoCuenta->CurrentValue);
		} else {
			return "javascript:alert('Llave incorrecta es nula');";
		}
		return $sUrl;
	}

	// Sort Url
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			($fld->FldType == 205)) { // Unsortable data type
			return "";
		} else {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		}
	}

	// URL parm
	function UrlParm($parm = "") {
		$UrlParm = ($this->UseTokenInUrl) ? "t=saldo_cuenta" : "";
		if ($parm <> "") {
			if ($UrlParm <> "")
				$UrlParm .= "&";
			$UrlParm .= $parm;
		}
		return $UrlParm;
	}

	// Function LoadRs
	// - Load rows based on filter
	function LoadRs($sFilter) {
		global $conn;

		// Set up filter (Sql Where Clause) and get Return Sql
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		return $conn->Execute($sSql);
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->idSaldoCuenta->setDbValue($rs->fields('idSaldoCuenta'));
		$this->idCuenta->setDbValue($rs->fields('idCuenta'));
		$this->fecha->setDbValue($rs->fields('fecha'));
		$this->nro_fact_recibo->setDbValue($rs->fields('nro_fact_recibo'));
		$this->detalle->setDbValue($rs->fields('detalle'));
		$this->ingreso->setDbValue($rs->fields('ingreso'));
		$this->egreso->setDbValue($rs->fields('egreso'));
		$this->fechaCreacion->setDbValue($rs->fields('fechaCreacion'));
		$this->fechaModificacion->setDbValue($rs->fields('fechaModificacion'));
		$this->diezmo->setDbValue($rs->fields('diezmo'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

		// idSaldoCuenta
		$this->idSaldoCuenta->ViewValue = $this->idSaldoCuenta->CurrentValue;
		$this->idSaldoCuenta->CssStyle = "";
		$this->idSaldoCuenta->CssClass = "";
		$this->idSaldoCuenta->ViewCustomAttributes = "";

		// idCuenta
		if (strval($this->idCuenta->CurrentValue) <> "") {
			$sSqlWrk = "SELECT `cuenta` FROM `cuenta` WHERE `idCuenta` = " . ew_AdjustSql($this->idCuenta->CurrentValue) . "";
			$sSqlWrk .= " ORDER BY `cuenta` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup value(s) found
				$this->idCuenta->ViewValue = $rswrk->fields('cuenta');
				$rswrk->Close();
			} else {
				$this->idCuenta->ViewValue = $this->idCuenta->CurrentValue;
			}
		} else {
			$this->idCuenta->ViewValue = NULL;
		}
		$this->idCuenta->CssStyle = "";
		$this->idCuenta->CssClass = "";
		$this->idCuenta->ViewCustomAttributes = "";

		// fecha
		$this->fecha->ViewValue = $this->fecha->CurrentValue;
		$this->fecha->ViewValue = ew_FormatDateTime($this->fecha->ViewValue, 7);
		$this->fecha->CssStyle = "";
		$this->fecha->CssClass = "";
		$this->fecha->ViewCustomAttributes = "";

		// nro_fact_recibo
		$this->nro_fact_recibo->ViewValue = $this->nro_fact_recibo->CurrentValue;
		$this->nro_fact_recibo->CssStyle = "";
		$this->nro_fact_recibo->CssClass = "";
		$this->nro_fact_recibo->ViewCustomAttributes = "";

		// detalle
		$this->detalle->ViewValue = $this->detalle->CurrentValue;
		$this->detalle->CssStyle = "";
		$this->detalle->CssClass = "";
		$this->detalle->ViewCustomAttributes = "";

		// ingreso
		$this->ingreso->ViewValue = $this->ingreso->CurrentValue;
		$this->ingreso->CssStyle = "";
		$this->ingreso->CssClass = "";
		$this->ingreso->ViewCustomAttributes = "";

		// egreso
		$this->egreso->ViewValue = $this->egreso->CurrentValue;
		$this->egreso->CssStyle = "";
		$this->egreso->CssClass = "";
		$this->egreso->ViewCustomAttributes = "";

		// idSaldoCuenta
		$this->idSaldoCuenta->HrefValue = "";

		// idCuenta
		$this->idCuenta->HrefValue = "";

		// fecha
		$this->fecha->HrefValue = "";

		// nro_fact_recibo
		$this->nro_fact_recibo->HrefValue = "";

		// detalle
		$this->detalle->HrefValue = "";

		// ingreso
		$this->ingreso->HrefValue = "";

		// egreso
		$this->egreso->HrefValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $CurrentAction; // Current action
	var $EventName; // Event name
	var $EventCancelled; // Event cancelled
	var $CancelMessage; // Cancel message
	var $RowType; // Row Type
	var $CssClass; // Css class
	var $CssStyle; // Css style
	var $RowClientEvents; // Row client events

	// Row Attribute
	function RowAttributes() {
		$sAtt = "";
		if (trim($this->CssStyle) <> "") {
			$sAtt .= " style=\"" . trim($this->CssStyle) . "\"";
		}
		if (trim($this->CssClass) <> "") {
			$sAtt .= " class=\"" . trim($this->CssClass) . "\"";
		}
		if ($this->Export == "") {
			if (trim($this->RowClientEvents) <> "") {
				$sAtt .= " " . trim($this->RowClientEvents);
			}
		}
		return $sAtt;
	}

	// Field objects
	function fields($fldname) {
		return $this->fields[$fldname];
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// Row Inserting event
	function Row_Inserting(&$rs) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted(&$rs) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating(&$rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated(&$rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}
}
?>
