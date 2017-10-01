<style>
table {
	width: 100%;
}

tr {
	cursor: pointer;
}

tr:hover {
	background: #F7EED4;
}

td {
	padding: 10px 4px;
}

.highlight {
	background: #E7D18A;
}

.highlight:hover {
	background: #E7D18A;
}
</style>
<form id="Form1" method="post" enctype="multipart/form-data"
	class="form-horizontal">

	<input type="hidden" id=id name="RequestBorrow[id]"
		value="<?php echo $data->id;?>" />

	<div class="alert alert-danger display-hide">
		<button class="close" data-close="alert"></button>
		You have some form errors. Please check below.
	</div>
	<div class="alert alert-success display-hide">
		<button class="close" data-close="alert"></button>
		Your form validation is successful!
	</div>

	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-cogs"></i> Request Borrow Prepare Item

			</div>
			<div class="actions"></div>
		</div>
		<div class="portlet-body form">
			<div class="form-body">
				<!-- BEGIN FORM-->
				<div class="row">
					<div class="col-md-9">
						<div class="form-group">
							<label class="control-label col-md-3">Receive Date:</label>
							<div class="col-md-5">
								<label id="from_date"><?php echo $data->from_date;?></label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-9">
						<div class="form-group">
							<label class="control-label col-md-3">Return Date:</label>
							<div class="col-md-5">
								<label id="from_date"><?php echo $data->to_date;?></label>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-9">
						<div class="form-group">
							<label class="control-label col-md-3">Place of use:</label>
							<div class="col-md-5">
								<label id="location"><?php echo ($data->location ="1")? "In MUIC":"Outside MUIC";?></label>
							</div>
						</div>
					</div>
				</div>




				<div class="row">
					<div class="col-md-9">
						<div class="form-group">
							<label class="control-label col-md-3">Phone Number:</label>
							<div class="col-md-5">
								<label id="mobile_phone"><?php echo UserLoginUtils::getUsersLoginById($data->create_by)->mobile_phone;?></label>


							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-9">
						<div class="form-group">
							<label class="control-label col-md-3">Purpose of borrow:<span
								class="required">*</span></label>
							<div class="col-md-5">
								<label id="remark"><?php echo $data->remark;?></label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END FORM-->
		</div>
	</div>
	<!-- BEGIN EXAMPLE TABLE PORTLET-->
	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-cogs"></i> Equipment Info
			</div>
			<div class="actions"></div>
		</div>
		<div class="portlet-body">
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label class="control-label col-md-3">BarCode:<span
							class="required">*</span></label>
						<div class="col-md-5">
							<input id="barcode" class="form-control placeholder-no-fix"
								type="text">

						</div>
					</div>
				</div>

			</div>
		</div>


		<div id="divHidden"></div>

		<div class="row">
			<div class="col-md-9">
				<span>*ใส่เลข Barcode</span>

				<table id="tbEquipmentList"
					class="table">
					<thead>
						<tr>
							<th width="5%">#</th>
							<th width="20%">Equipment Type.</th>
							<th width="40%">Equipment</th>
							<th width="10%">Barcode</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$requestBorrowDetails = RequestBorrowDetail::model ()->findAll ( array (
							'condition' => "request_borrow_id = '" . $data->id . "'" 
					) );
					
					if (count ( $requestBorrowDetails ) > 0) {
						$rowCount = 1;
						foreach ( $requestBorrowDetails as $item ) {
							?>
							<tr id="<?php echo "eid_".$item->equipment->id?>">
							<td><?php echo $rowCount;?></td>
							<td><?php echo $item->equipment->equipment_group->equipment_type->name; ?></td>
							<td><?php echo $item->equipment->name;?></td>
							<td><?php echo $item->equipment->barcode;?></td>
						</tr>								
								
								<?php
							$rowCount ++;
						}
					}
					?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-md-9">
				<div class="form-group">
					<label class="control-label col-md-3">Other Device:<span
						class="required">*</span></label>
					<div class="col-md-5">
						<label id="from_date"><?php echo $data->otherDevice;?></label>


					</div>
				</div>
			</div>
		</div>


	</div>
	<div class="form-actions">
		<div class="row">
			<div class="col-md-9">
				<div class="row">
					<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn green uppercase">Save</button>
						<button type="reset" class="btn default uppercase">Cencel</button>
					</div>
				</div>
			</div>
			<div class="col-md-9"></div>
		</div>
	</div>
 <p>
 
	<script
		src="<?php echo ConfigUtil::getAppName();?>/assets/global/plugins/jquery-1.12.1.min.js"
		type="text/javascript"></script>

	<script>
	var host = 'http://iceq.muic.mahidol.ac.th';
    jQuery(document).ready(function () {
        
    	var $rows = $("table tr");
    	$rows.click(function() {    
        		    
    	    console.log(this.id+' value = '+$('#i'+this.id).val());

    		var divHidden = $('#divHidden');
    		
    		if( $('#i'+this.id).val() == undefined){
    			$(this).addClass('highlight');
       			divHidden.append('<input id="i'+this.id+'" type="text" name="selectedItems['+this.id+']\" value="'+this.id+'">');
    		}else{
    			$('#i'+this.id).remove();
    			$(this).removeClass('highlight');
    		}

    	});

    	$('#barcode').bind('keydown', (function(e) {
        
//     		if (e.ctrlKey) {
//     			return false;
//     		}
    		
    		if (e.keyCode == 13) {
    			// enter
    			var code = $('#barcode').val();
    			code = code.split(' ').join('');
    			if (code != '') {
    				prepare(code);
    			}
    			$('#barcode').val('');
    		}
    		
    	}));

    });

//     function returnCheckChange($detailId) {


// 		var divHidden = $('#divHidden');
// 		divHidden.html('');
//     	 $('#tbEquipmentList').find('input[type="checkbox"]:checked').each(function () {
// 			var eqid = 'eq_'+this.id.replace('eqItem_','');
//         	 //console.log();
//     	      if( $('#'+eqid).val() === undefined){
//     	       		divHidden.append('<input id="'+eqid+'" type="text" name="selectedItems['+eqid+','+$detailId+']\" value="'+eqid+'">');
//     	      }else{
//     	      }
//     	    });

//     }
    
    function prepare($code) {



    	$.ajax({
		     url: host+"/index.php/AjaxRequest/GetEquipmentDetailByBarcode",
		     type: "GET",
		     data: { id: $code },
		     
		     dataType: "json",
		     success: function (json) {
		    	 console.log('equipment id = '+json.id+' val = '+$('#eqItem_'+json.id).val());
		 		var divHidden = $('#divHidden');
		    	 
// 					var eqid = 'eq_'+json.id;
		        	 //console.log();
		    	      if( $('#ieid_'+json.id).val() === undefined){
		         			divHidden.append('<input id="ieid_'+json.id+'" type="text" name="selectedItems['+json.id+']\" value="ieid_'+json.id+'">');
		    	      }else{
		    	      }
		    	      
		    	 $('#eid_'+json.id).addClass('highlight');
		     },
		     error: function (xhr, ajaxOptions, thrownError) {
		
		     }
   	});

    }

    
</script>

</form>