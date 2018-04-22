 <?php if($this->bEnableLoading):?>
<link rel="stylesheet" type="text/css" href="guriddo/css/jquery-ui.css" media="screen" />
<link rel="stylesheet" type="text/css" href="guriddo/css/trirand/ui.jqgrid.css" media="screen" />
<link rel="stylesheet" type="text/css" href="guriddo/css/ui.multiselect.css" media="screen" />

<script src="guriddo/js/jquery.min.js" type="text/javascript"></script>
<script src="guriddo/js/trirand/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="guriddo/js/trirand/jquery.jqGrid.min.js" type="text/javascript"></script>
<script src="guriddo/js/jquery-ui.min.js" type="text/javascript"></script>

<script type="text/javascript">
$.jgrid.no_legacy_api = true;
$.jgrid.useJSON = true;
$.jgrid.defaults.width = "<?php echo $this->iWidth?>";
</script>
<?php endif;?>

 <div>
          <table id='<?php echo $this->idTable?>'></table>
		  <div id='pager<?php echo $this->idTable?>'></div>
		  <script type='text/javascript'>
			  jQuery(document).ready(function($) {jQuery('#<?php echo $this->idTable?>').jqGrid(
			{
				<?php if($this->sUrlEdit):?>
				"editurl": '<?php echo $this->sUrlEdit?>',
                "mtype": "POST",
                <?php endif;?>
				
				"hoverrows":false,
				"viewrecords":true,
				"jsonReader":{
						  "repeatitems":false,
						  "subgrid":{
							  "repeatitems":false
						  }
				},
				"xmlReader":{
					"repeatitems":false,
					"subgrid":{
						"repeatitems":false
					}
				},
				"gridview":true,
				"viewrecords": true,
				"url":"<?php echo _root::getLink($this->sJsonLink)?>",
				"rowNum":<?php echo $this->iLimit?>,
				"sortname":"<?php echo $this->defaultSortField?>",
				"sortorder":"<?php echo $this->sDefaultSide?>",
				"height":<?php echo $this->iHeight?>,
				"datatype":"json",
				<?php if($this->tRowList):?>
				"rowList":<?php echo json_encode($this->tRowList)?>,
				<?php endif;?>
				<?php if($this->bAltRows):?>
				"altRows":true,
				<?php endif;?>
				<?php if($this->bSortable):?>
				"sortable": true,
				<?php endif;?>
				"colModel":[
					


					<?php foreach($this->tHeader as $tDetail):?>
							{
						<?php foreach($tDetail as $sKey => $sValue):?>
							
							'<?php echo $sKey?>':<?php if(in_array($sKey,array('formatter','cellattr'))){ echo $sValue; }else{ echo json_encode($sValue);}?>,
						<?php endforeach;?>
						 
						 <?php if($this->sUrlEdit and !isset($tDetail['editable'])):?>
						 'editable': true,
						 <?php endif;?>

						
						 
						},
					<?php endforeach;?>
				],
				"postData":{
					"oper":"grid"
				},
				"prmNames":{
					"page":"page",
					"rows":"rows",
					"sort":"sidx",
					"order":"sord",
					"search":"_search",
					"nd":"nd",
					"id":"id",
					"filter":"filters",
					"searchField":"searchField",
					"searchOper":"searchOper",
					"searchString":"searchString",
					"oper":"oper",
					"query":"grid",
					"addoper":"add",
					"editoper":"edit",
					"deloper":"del",
					"excel":"excel",
					"subgrid":"subgrid",
					"totalrows":"totalrows",
					"autocomplete":"autocmpl"
				},
				"loadError":function(xhr,status, err){ 
					try {
						jQuery.jgrid.info_dialog(jQuery.jgrid.errors.errcap,'<div class="ui-state-error">'+ xhr.responseText +'</div>', jQuery.jgrid.edit.bClose,{buttonalign:'right'});
					} catch(e) { 
						alert(xhr.responseText);
					} 
				},
				"pager":"#pager<?php echo $this->idTable?>",
				
				
				  
			});
			
			<?php if($this->tGroupHeader):?>
			jQuery('#<?php echo $this->idTable?>').setGroupHeaders({
						useColSpanStyle: true,
						groupHeaders: <?php echo json_encode($this->tGroupHeader)?>
			});
			<?php endif;?>
			
			<?php if($this->bEditEnable or $this->bAddEnable or $this->bDeleteEnable):?>
			 jQuery("#<?php echo $this->idTable?>").navGrid("#pager<?php echo $this->idTable?>",
                { edit: <?php echo $this->bEditEnable?>, add: <?php echo $this->bAddEnable?>, del: <?php echo $this->bDeleteEnable?>,view: <?php echo $this->bShowEnable?>, align: "left" ,search:false},
                { closeAfterEdit: true }
            );
            <?php endif;?>
        
			
			jQuery('#<?php echo $this->idTable?>').jqGrid('filterToolbar',{"stringResult":true});
			
			 
			<?php if($this->tFormatter):?>
			<?php foreach($this->tFormatter as $sFormatter):?>
				<?php echo $sFormatter?>
			<?php endforeach;?>
			<?php endif;?>
			
			
 });
 
 

 
 
 </script>      
 </div>



