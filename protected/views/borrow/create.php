<form id="Form1" method="post" enctype="multipart/form-data"
	class="form-horizontal">
	<input type="hidden" id="hRole"
		value="<?php echo UserLoginUtils::getUserRole();?>">

	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-cogs"></i> Borrow Info

			</div>
			<div class="actions"></div>
		</div>
		<div class="portlet-body form">
			<div class="form-body">
				<!-- BEGIN FORM-->

				<div class="form-group">
					<label class="control-label col-md-3">Receive Date:</label>
					<div class="col-md-3">
						<input type="text" class="form-control" id="from_date"
							name="RequestBorrow[from_date]" readonly>

					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">Return Date:</label>
					<div class="col-md-3">
						<input type="text" class="form-control" id="to_date"
							name="RequestBorrow[to_date]" readonly>

					</div>
				</div>


				<div class="form-group">
					<label class="control-label col-md-3">Place of use <span
						class="required"> * </span>
					</label>
					<div class="col-md-3">
						<div class="radio-list"
							data-error-container="#form_2_membership_error">
							<label> <input type="radio" name="RequestBorrow[location]"
								value="1" checked="checked" /> In MUIC
							</label> <label> <input type="radio"
								name="RequestBorrow[location]" value="2" /> Outside MUIC
							</label>
						</div>
						<div id="form_2_membership_error"></div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">Purpose of borrow:<span
						class="required">*</span></label>
					<div class="col-md-3">
						<textarea class="form-control" name="RequestBorrow[remark]"></textarea>
					</div>
				</div>

			</div>
			<!-- END FORM-->
		</div>
	</div>


	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN Portlet PORTLET-->
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-speech"></i> <span
							class="caption-subject bold uppercase"> Equipment Info</span> <span
							class="caption-helper">...</span>
					</div>
					<div class="actions">
						<a class="btn btn-circle btn-icon-only btn-default fullscreen"
							href="javascript:;"> </a>
					</div>
				</div>
				<div class="portlet-body">
					<div class="scroller" style="height: 500px" data-rail-visible="1"
						data-rail-color="yellow" data-handle-color="#a1b2bd">
						<div class="form-group">
							<label class="control-label col-md-3">Equipment Type:<span
								class="required">*</span></label>
							<div class="col-md-5">
								<select class="select2_category form-control" id="equipmentType"
									name="equipmentType">
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Equipment:<span
								class="required">*</span></label>
							<div class="col-md-5">
								<select class="select2_category form-control"
									name="equipmentGroup" id="equipmentGroup">
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Quantity:<span
								class="required">*</span></label>
							<div class="col-md-4">
								<input id="quantity" type="text" value="0" name="quantity" />
							</div>
							<div class="col-md-1">
								<label class="control-label" id="quanTotal"></label>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Image:</label>
							<div class="col-md-5">
								<img id="img_path" src="">
							</div>
						</div>

						<button id="btnAddEquipment" type="button"
							class="btn green uppercase">Add Equipment</button>
						<table id="tbEquipmentList"
							class="table table-striped table-hover table-bordered">
							<thead>
								<tr>
									<th width="5%">#</th>
									<th width="20%">Equipment Type.</th>
									<th width="20%">Equipment</th>
									<th width="20%">Quantity</th>
									<th width="5%"></th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>

						<div class="form-group">
							<label class="control-label col-md-3">Other Device:<span
								class="required">*</span></label>
							<div class="col-md-5">
								<textarea class="form-control" name="RequestBorrow[otherDevice]"></textarea>

							</div>
						</div>

					</div>
				</div>
			</div>
			<!-- END Portlet PORTLET-->
		</div>

		<!-- 		<div class="col-md-6"> -->
		<!-- BEGIN Portlet PORTLET-->
		<!-- 			<div class="portlet light"> -->
		<!-- 				<div class="portlet-title"> -->
		<!-- 					<div class="caption font-green-sharp"> -->
		<!-- 						<i class="icon-share font-green-sharp"></i> <span -->
		<!-- 							class="caption-subject bold uppercase"> Equipment Image</span> <span -->
		<!-- 							class="caption-helper">...</span> -->
		<!-- 					</div> -->
		<!-- 					<div class="actions"></div> -->
		<!-- 				</div> -->
		<!-- 				<div class="portlet-body"> -->



		<!-- 				</div> -->
		<!-- 			</div> -->
		<!-- END Portlet PORTLET-->
		<!-- 		</div> -->


	</div>

	<!-- BEGIN EXAMPLE TABLE PORTLET-->

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
	function getDateFormat(date, format) {
		var res = date.split("-");
		format = format.replace('dd', res[0]);
		format = format.replace('mm', res[1]);
		format = format.replace('yy', res[2]);
		return format;
	}

    jQuery(document).ready(function () {

    	$userRole = $("#hRole").val();
    	$minDate = 0;
    	if($userRole == 6){
			$minDate = 3;
    	}

    	$( "#from_date" ).datepicker({
            minDate: $minDate,
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            numberOfMonths: 1,
            changeYear: true,
            beforeShowDay:($minDate ==0)? $.datepicker.Weekends: $.datepicker.noWeekends,
            onClose: function( selectedDate, inst ) {
            	selectedDate = getDateFormat(selectedDate, 'yy-mm-dd');
                var minDate = new Date(Date.parse(selectedDate));
                var maxDate = new Date(Date.parse(selectedDate));
                minDate.setDate(minDate.getDate());
                maxDate.setDate(maxDate.getDate() + 4);
                $( "#to_date" ).datepicker( "option", "minDate", minDate);
                $( "#to_date" ).datepicker( "option", "maxDate", maxDate);
                $(".removeRow").remove();
                }
        });


        $( "#to_date" ).datepicker({
            minDate: "+1D",
           	dateFormat: "yy-mm-dd",
            changeMonth: true,
            numberOfMonths: 1,
            changeYear: true,
            beforeShowDay:($minDate ==0)? $.datepicker.Weekends: $.datepicker.noWeekends,
            onClose: function( selectedDate, inst ) { 
            	$(".removeRow").remove();                   
            }
        });

		initEquipmentType();
        $('#equipmentType').on('change', function() {
        	onchangeEquipment(this.value);
        });
        $('#equipmentGroup').on('change', function() {
	         
        	onchangeEquipmentGroup(this.value);
        });

        $("#quantity").TouchSpin({
            min: 0,
            max: 0,
            step: 1,
        });
        /*------- ADD EQUIPMENT -------*/
    	$("#btnAddEquipment").click(function(){    
    		var eqType = $('#equipmentType option:selected').text();
    		var eqGroupName = $('#equipmentGroup option:selected').text();
    		var eqGroupValue = $('#equipmentGroup option:selected').val();
    		
    		var eqQuantity = $('#quantity').val();
    		var rowCount = $('#tbEquipmentList tr').length;
    		
			if(eqQuantity>0){
				var item = $('#eq_' + eqGroupValue);
				if (typeof (item.val()) == "undefined") {
	    		
	        		var newRowContent = "<tr class=\"removeRow\" id=\"eq_"+eqGroupValue+"\"><td>"+rowCount+
	        		"</td><td>"+eqType+
	        		"</td><td>"+eqGroupName+
	        		"</td><td>"+eqQuantity+
	        		"</td><td>"+
	        		"<a class=\"fa fa-trash\" href=\"javascript:deleteEq("+ eqGroupValue +")\"> </a>"+
	        		"<input type=\"hidden\" name=\"eqs["+eqGroupValue+','+eqQuantity+"]\" value=\"\">"+
	        		"</td>"+
	        		"</tr>";
	
	        		$("#tbEquipmentList tbody").append(newRowContent);
	
	        		$("#equipmentType").val("0");
	        		$("#equipmentGroup").val("0");
	        		$("#quantity").val("0");
		    		$("#quanTotal").text("");
	        		
	        		
	            }
			}
    	});
        /*------- END ADD EQUIPMENT -------*/
    });

    function noneSelectable(date) {
    	return [false, "small-date", ""];
    }
    function deleteEq(eq) {
    	if (confirm('Confirm remove?')) {
    		var item = $('#eq_' + eq);
    		if (typeof (item.val()) !== "undefined") {
    			item.remove();
    		}
    	}
    }
    function initEquipmentType(){
    	$.ajax({
		     url: host+"/index.php/AjaxRequest/GetEquipmentType",
		     type: "GET",
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
    function onchangeEquipmentGroup($id) {
    	$borrow_date = $('#from_date').val();
    	$.ajax({
		     url: host+"/index.php/AjaxRequest/GetEquipmentGroupById",
		     type: "GET",
		     data: { id: $id },
		     
		     dataType: "json",
		     success: function (json) {
			     
		    	 $('#img_path').attr('src',host+'/faa'+json.img_path);
//
		    	$.ajax({
				     url: host+"/index.php/AjaxRequest/GetEquipmentRemain",
				     type: "GET",
				     data: { equipment_group_id: $id, borrow_date: $borrow_date},
				     dataType: "json",
				     success: function (json) {
				    	 	$( "#quantity" ).val(0);
				    	 	$( "#quantity" ).trigger("touchspin.updatesettings", {max: json.remainEquip});
				    		$("#quanTotal").text("/ "+json.remainEquip);
						    	
				     },
				     error: function (xhr, ajaxOptions, thrownError) {
						alert('ERROR');
				     }
		    	});
		     },
		     	error: function (xhr, ajaxOptions, thrownError) {
		     }
   	});
    }
</script>
</form>