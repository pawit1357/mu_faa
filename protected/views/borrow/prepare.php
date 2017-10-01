
<form id="Form1" method="post" enctype="multipart/form-data"
	class="form-horizontal">
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



		<div class="row">
			<div class="col-md-9">
				<span>*คลิ๊กที่รายการ Barcode อุปกรณ์ที่ต้องการลบ</span>
				<table id="tbEquipmentList"
					class="table table-striped table-hover table-bordered">
					<thead>
						<tr>
							<th width="5%">#</th>
							<th width="20%">Equipment Type.</th>
							<th width="40%">Equipment</th>
							<th width="10%">Barcode</th>
							<th width="20%">Quantity</th>
							<th width="5%"></th>
						</tr>
					</thead>
					<tbody>
					<?php
						$requestBorrowQuantitys = RequestBorrowQuantity::model ()->findAll ( array ('condition' => "request_borrow_id = '" . $data->id . "'") );
						
						if (count ( $requestBorrowQuantitys ) > 0) {
							$rowCount = 1;
							foreach ( $requestBorrowQuantitys as $item ) {
								?>
								<tr id="<?php echo "eq_".$item->equipment_group_id?>">
							<td><?php echo $rowCount;?></td>
							<td><?php echo $item->equipment_group->equipment_type->name; ?></td>
							<td><?php echo $item->equipment_group->name;?></td>
							<td><div class="eqGroup"
									id="<?php echo "eqg_".$item->equipment_group_id;?>"></div></td>
							<td><div
									id="<?php echo "eqg_quantity_".$item->equipment_group_id;?>"> <?php echo $item->quantity;?></div></td>
							<td>
							<a class="fa fa-trash" href="javascript:deleteEq('<?php echo $item->equipment_group_id;?>')"></a>
							<!-- <input type="hidden" name="eqs['']" value=""> -->
							</td>
						</tr>								
								
								<?php								
								$rowCount++;
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
						<input class="form-control placeholder-no-fix" type="text"
							placeholder="" id="otherDevice" name="RequestBorrow[otherDevice]"
							value="<?php echo $data->otherDevice;?>" />
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


	<script
		src="<?php echo ConfigUtil::getAppName();?>/assets/global/plugins/jquery.min.js"
		type="text/javascript"></script>

	<script>
	var host = 'http://iceq.muic.mahidol.ac.th';
    jQuery(document).ready(function () {
        

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
    	
    	$(document).on('click', 'span', function () {
    	      
    	      	var groupId = $(this).closest('.eqGroup').attr('id').replace('eqg_','');

				var eqg_quantity = $('#eqg_quantity_' + groupId);
				var eq = $('#eqg_' + groupId);
				//remove click item
				$(this).remove();
				//update count of equipment
				eqg_quantity.html(eq.find("span").length);

				if( eq.find("span").length == 0 ){
               		 $('#eq_' + groupId).remove();
				}
			

                
    	});
    });

    function prepare($code) {



    	$.ajax({
		     url: host+"/index.php/AjaxRequest/GetEquipmentDetailByBarcode",
		     type: "GET",
		     data: { id: $code },
		     
		     dataType: "json",
		     success: function (json) {

		    		var eq = $('#eqg_' + json.equipment_group_id);
		    		var eqg_quantity = $('#eqg_quantity_' + json.equipment_group_id);
		    		
		    		if(eq.length > 0){
			    		var countBarcode = $('#bcode_'+json.barcode);
			    		if (countBarcode.length == 0 ){
				    		
				    		if(eq.find("span").length>0 ){

					    		eq.append('<br>');
				    		}
		    				eq.append('<span id="bcode_'+json.barcode+'">'+json.barcode+'<input type="hidden" name="eqItems['+json.equipment_group_id+','+json.id+']\" value=""></span>');
				    		eqg_quantity.html(''+eq.find("span").length);

    					}
		    		}else{
		 		 		var rowCount = $('#tbEquipmentList tr').length;
		         		var newRowContent = '<tr id=\"eq_'+json.equipment_group_id+'">'+
		         		'<td>'+rowCount+'</td>'+
		         		'<td>'+json.equipment_type_name+'</td>'+
		         		'<td>'+json.equipment_group_name+'</td>'+
		         		'<td><div class="eqGroup" id="eqg_'+json.equipment_group_id+'"><span id="bcode_'+json.barcode+'">'+json.barcode+'<input type="hidden" name="eqItems['+json.equipment_group_id+','+json.id+']\" value=""></span></div></td>'+
		         		'<td><div id=\"eqg_quantity_'+json.equipment_group_id+'">1</div></td>'+
			         	'<td>'+
		         		'<a class="fa fa-trash" href=\"javascript:deleteEq('+ json.equipment_group_id +')\"> </a>'+
		         		
		         		''+
		         		'</td>'+
		         		'</tr>';

		         		$("#tbEquipmentList tbody").append(newRowContent);
			    	}
			    	//Quantity
			    	//alert(eq.children().length);
		    		eqg_quantity.html(''+eq.find("span").length);
		    		
		     },
		     error: function (xhr, ajaxOptions, thrownError) {
		
		     }
   	});

    }

    
    function deleteEq(eq) {
    	if (confirm('Confirm remove?')) {
    		var item = $('#eq_' + eq);
    		if (typeof (item.val()) !== "undefined") {
    			item.remove();
    		}
    	}
    }
	function changeEquipmentRemain() {
		//$('#EquipmentTypeQty').val(0)
	}

    function initTypeOfEvent(){

    	$.ajax({
		     url: host+"/index.php/AjaxRequest/GetTypeOfEvent",
		     type: "GET",
		     dataType: "json",
		     success: function (json) {
		            $('#type_of_event_id').empty();
		            $('#type_of_event_id').append($('<option>').text("Select"));
		            $.each(json, function(i, obj){
		                    $('#type_of_event_id').append($('<option>').text(obj.name).attr('value', obj.id));
		            });
     	
		     },
		     error: function (xhr, ajaxOptions, thrownError) {
		
		     }
    	});
    	
    }
    function onchangeEquipmentType($id){
    	$.ajax({
		     url: host+"/index.php/AjaxRequest/GetEquipmentType",
		     type: "GET",
		     data: { typeOfEventID: $id },
		     dataType: "json",
		     success: function (json) {
		            $('#equipmentType').empty();
		            $('#equipmentType').append($('<option>').text("Select"));
		            $.each(json, function(i, obj){
		                    $('#equipmentType').append($('<option>').text(obj.name).attr('value', obj.id));
		            });
     	
		     },
		     error: function (xhr, ajaxOptions, thrownError) {
				alert('ERROR');
		     }
    	});
    }
    function onchangeEquipment($id){
    	$.ajax({
		     url: host+"/index.php/AjaxRequest/GetEquipmentGroup",
		     type: "GET",
		     data: { equipment_type_id: $id },
		     dataType: "json",
		     success: function (json) {
		            $('#equipmentGroup').empty();
		            $('#equipmentGroup').append($('<option>').text("Select"));
		            $.each(json, function(i, obj){
		                    $('#equipmentGroup').append($('<option>').text(obj.name).attr('value', obj.id));
		            });
     	
		     },
		     error: function (xhr, ajaxOptions, thrownError) {
				alert('ERROR');
		     }
    	});
    }
</script>

</form>