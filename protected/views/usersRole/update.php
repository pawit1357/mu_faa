<form id="Form1" method="post" enctype="multipart/form-data"
	class="form-horizontal">

	<div class="portlet box blue">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-cogs"></i> จัดการสิทธิ์การใช้งาน
			</div>
			<div class="actions">
									<?php echo CHtml::link('ย้อนกลับ',array('UsersRole/'),array('class'=>'btn btn-default btn-sm'));?>
			
			</div>
		</div>
		<div class="portlet-body form">
			<div class="form-body">
				<!-- BEGIN FORM-->
				<div class="row">
					<div class="col-md-9">
						<div class="form-group">
							<label class="control-label col-md-3">รหัส:<span class="required">*</span></label>
							<div class="col-md-6">
								<input id="ROLE_ID" type="text"
									value="<?php echo $data->ROLE_ID;?>"
									class="grpOfInt form-control" name="UsersRole[ROLE_ID]"
									readonly>
							</div>
							<div id="divReq-role_id"></div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-9">
						<div class="form-group">
							<label class="control-label col-md-3">สิทธิ์:<span
								class="required">*</span></label>
							<div class="col-md-6">
								<input id="ROLE_NAME" type="text"
									value="<?php echo $data->ROLE_NAME;?>" class="form-control"
									name="UsersRole[ROLE_NAME]">
							</div>
							<div id="divReq-role_name"></div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-9">
						<div class="form-group">
							<label class="control-label col-md-3">หมายเหตุ:</label>
							<div class="col-md-6">
								<input id="ROLE_DESC" type="text"
									value="<?php echo $data->ROLE_DESC;?>" class="form-control"
									name="UsersRole[ROLE_DESC]">
							</div>
						</div>
					</div>
				</div>
				<h4>กำหนดการเข้าถึงเมนู</h4>
				<table class="table table-striped table-hover table-bordered">
					<thead>
						<tr>
							<th>#</th>
							<th>ชื่อเมนู</th>
							<th>ใช้งานเมนู</th>
							<th>บันทึกข้อมูล</th>
							<th>แก้ไขข้อมูล</th>
							<th>ลบข้อมูล</th>
						</tr>
					</thead>
					<tbody>
	<?php
	
	$counter = 1;
	$dataProvider = Menu::model ()->search ();
	$index = 1;
	foreach ( $dataProvider->data as $item ) {
	
		$cri = new CDbCriteria ();
		$cri->condition = "MENU_ID = " . $item->MENU_ID . " AND ROLE_ID=" . $data->ROLE_ID;
		$mr = MenuRole::model ()->findAll ( $cri );
	
	
	
		$criMeu = new CDbCriteria ();
		$criMeu->condition = "MENU_ID = " . $item->PREVIOUS_MENU_ID;
		$m = Menu::model ()->findAll ( $criMeu );
	if(isset($m[0])){
		?>
					<tr class="line-<?php echo $counter%2 == 0 ? '1' : '2'?>">
								<td class="center"><?php echo $index ?></td>
								<td class="center"> <?php echo (($item->PREVIOUS_MENU_ID == -1)? '<i class="fa fa-th"></i>':'<i class="fa fa-angle-double-right"></i>') ?> <?php echo  $m[0]->MENU_NAME.(($item->PREVIOUS_MENU_ID == -1)? '':' <i class="fa fa-arrow-circle-right"></i> ').$item->MENU_NAME?></td>
								<td><input type="checkbox" value="<?php echo $item->MENU_ID?>" <?php echo (isset($mr)? (($mr [0]->IS_ACTIVE)? 'checked=checked':''):'')?>
									name="listOfActive[]" /></td>
								<td><input type="checkbox" value="<?php echo $item->MENU_ID?>" <?php echo (isset($mr)? (($mr [0]->IS_CREATE)? 'checked=checked':''):'')?>
									name="listOfCreate[]" /></td>
								<td><input type="checkbox" value="<?php echo $item->MENU_ID?>" <?php echo (isset($mr)? (($mr [0]->IS_EDIT)? 'checked=checked':''):'')?>
									name="listOfEdit[]" /></td>
								<td><input type="checkbox" value="<?php echo $item->MENU_ID?>" <?php echo (isset($mr)? (($mr [0]->IS_DELETE)? 'checked=checked':''):'')?>
									name="listOfDelete[]" /></td>
							</tr>
				<?php
			$index ++;
	}else{
		$criMeu = new CDbCriteria ();
		$criMeu->condition = "MENU_ID = " . $item->MENU_ID;
		$m = Menu::model ()->findAll ( $criMeu );
		if(isset($m[0])){
		?>
							<tr class="line-<?php echo $counter%2 == 0 ? '1' : '2'?>">
								<td class="center"><?php echo $index ?></td>
								<td class="center"> <?php echo (($item->PREVIOUS_MENU_ID == -1)? '<i class="fa fa-th"></i>':'<i class="fa fa-angle-double-right"></i>') ?> <?php echo  $m[0]->MENU_NAME.(($item->PREVIOUS_MENU_ID == -1)? '':' <i class="fa fa-arrow-circle-right"></i> ').$item->MENU_NAME?></td>
								<td><input type="checkbox" value="<?php echo $item->MENU_ID?>" <?php echo (isset($mr)? (($mr [0]->IS_ACTIVE)? 'checked=checked':''):'')?>
									name="listOfActive[]" /></td>
								<td><input type="checkbox" value="<?php echo $item->MENU_ID?>" <?php echo (isset($mr)? (($mr [0]->IS_CREATE)? 'checked=checked':''):'')?>
									name="listOfCreate[]" /></td>
								<td><input type="checkbox" value="<?php echo $item->MENU_ID?>" <?php echo (isset($mr)? (($mr [0]->IS_EDIT)? 'checked=checked':''):'')?>
									name="listOfEdit[]" /></td>
								<td><input type="checkbox" value="<?php echo $item->MENU_ID?>" <?php echo (isset($mr)? (($mr [0]->IS_DELETE)? 'checked=checked':''):'')?>
									name="listOfDelete[]" /></td>
							</tr>
		<?php
		}
// 		echo "PRV:".$item->PREVIOUS_MENU_ID;
	}
		}
	?>
						</tbody>
				</table>

				<!-- END FORM-->

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
	var host = 'http://localhost:81/mu_rad';
    jQuery(document).ready(function () {
    	 $("#ROLE_ID").attr('maxlength','3');
      	 $("#ROLE_NAME").attr('maxlength','50');
    	 $("#ROLE_DESC").attr('maxlength','100');

 	    $('.grpOfInt').keypress(function (event) {
            return isNumber(event);
        });
        
        	$( "#Form1" ).submit(function( event ) {

            	if($("#ROLE_ID").val().length==0){
            		$("#ROLE_ID").closest('.form-group').addClass('has-error');
            		$("#divReq-role_id").html("<span id=\"id-error\" class=\"help-block help-block-error\">This field is required.</span>");
            		$("#ROLE_ID").focus();
            		return false;
                }else{
                	$("#divReq-role_id").html('');
                	$("#ROLE_ID").closest('.form-group').removeClass('has-error');
            	}
            	
            	if($("#ROLE_NAME").val().length==0){
            		$("#ROLE_NAME").closest('.form-group').addClass('has-error');
            		$("#divReq-role_name").html("<span id=\"id-error\" class=\"help-block help-block-error\">This field is required.</span>");
            		$("#ROLE_NAME").focus();
            		return false;
                }else{
                	$("#divReq-role_name").html('');
                	$("#ROLE_NAME").closest('.form-group').removeClass('has-error');
            	}
            	

            	this.submit();
        	});
    });
    
    function initRayGenerator(){
    	$.ajax({
		     url: host+"/index.php/AjaxRequest/GetRayGenerator",
		     type: "GET",
		     dataType: "json",
		     success: function (json) {
		            $('#ray_generator_id').empty();
		            $('#ray_generator_id').append($('<option>').text("Select"));
		            $.each(json, function(i, obj){
		                    $('#ray_generator_id').append($('<option>').text(obj.name).attr('value', obj.id));
		            });
     	
		     },
		     error: function (xhr, ajaxOptions, thrownError) {
				alert('ERROR');
		     }
    	});
    }

    function initCodeUsage(){
    	$.ajax({
		     url: host+"/index.php/AjaxRequest/GetCodeUsage",
		     type: "GET",
		     dataType: "json",
		     success: function (json) {
		            $('#code_usage_id').empty();
		            $('#code_usage_id').append($('<option>').text("Select"));
		            $.each(json, function(i, obj){
		                    $('#code_usage_id').append($('<option>').text(obj.name).attr('value', obj.id));
		            });
     	
		     },
		     error: function (xhr, ajaxOptions, thrownError) {
				alert('ERROR');
		     }
    	});
    }
    function initManufacturer(){
    	$.ajax({
		     url: host+"/index.php/AjaxRequest/GetManufacturer",
		     type: "GET",
		     dataType: "json",
		     success: function (json) {
		            $('#maufacturer_id').empty();
		            $('#maufacturer_id').append($('<option>').text("Select"));
		            $.each(json, function(i, obj){
		                    $('#maufacturer_id').append($('<option>').text(obj.name).attr('value', obj.id));
		            });
     	
		     },
		     error: function (xhr, ajaxOptions, thrownError) {
				alert('ERROR');
		     }
    	});
    }
    function initUseType(){
    	$.ajax({
		     url: host+"/index.php/AjaxRequest/GetUseType",
		     type: "GET",
		     dataType: "json",
		     success: function (json) {
		            $('#use_type_id').empty();
		            $('#use_type_id').append($('<option>').text("Select"));
		            $.each(json, function(i, obj){
		                    $('#use_type_id').append($('<option>').text(obj.name).attr('value', obj.id));
		            });
     	
		     },
		     error: function (xhr, ajaxOptions, thrownError) {
				alert('ERROR');
		     }
    	});
    }
    function initPower(){
    	$.ajax({
		     url: host+"/index.php/AjaxRequest/GetPower",
		     type: "GET",
		     dataType: "json",
		     success: function (json) {
		            $('#power_id').empty();
		            $('#power_id').append($('<option>').text("Select"));
		            $.each(json, function(i, obj){
		                    $('#power_id').append($('<option>').text(obj.name).attr('value', obj.id));
		            });
     	
		     },
		     error: function (xhr, ajaxOptions, thrownError) {
				alert('ERROR');
		     }
    	});
    }
    function initDealer(){
    	$.ajax({
		     url: host+"/index.php/AjaxRequest/GetDealer",
		     type: "GET",
		     dataType: "json",
		     success: function (json) {
		            $('#dealer_id').empty();
		            $('#dealer_id').append($('<option>').text("Select"));
		            $.each(json, function(i, obj){
		                    $('#dealer_id').append($('<option>').text(obj.name).attr('value', obj.id));
		            });
     	
		     },
		     error: function (xhr, ajaxOptions, thrownError) {
				alert('ERROR');
		     }
    	});
    }
    function initUsageStatus(){
    	$.ajax({
		     url: host+"/index.php/AjaxRequest/GetUsageStatus",
		     type: "GET",
		     dataType: "json",
		     success: function (json) {
		            $('#usage_status_id').empty();
		            $('#usage_status_id').append($('<option>').text("Select"));
		            $.each(json, function(i, obj){
		                    $('#usage_status_id').append($('<option>').text(obj.name).attr('value', obj.id));
		            });
     	
		     },
		     error: function (xhr, ajaxOptions, thrownError) {
				alert('ERROR');
		     }
    	});
    }
    function initCompany(){
    	$.ajax({
		     url: host+"/index.php/AjaxRequest/GetCompany",
		     type: "GET",
		     dataType: "json",
		     success: function (json) {
		            $('#company_id').empty();
		            $('#company_id').append($('<option>').text("Select"));
		            $.each(json, function(i, obj){
		                    $('#company_id').append($('<option>').text(obj.name).attr('value', obj.id));
		            });
     	
		     },
		     error: function (xhr, ajaxOptions, thrownError) {
				alert('ERROR');
		     }
    	});
    }
    function initRoom(){
    	$.ajax({
		     url: host+"/index.php/AjaxRequest/GetRoom",
		     type: "GET",
		     dataType: "json",
		     success: function (json) {
		            $('#room_id').empty();
		            $('#room_id').append($('<option>').text("Select"));
		            $.each(json, function(i, obj){
		                    $('#room_id').append($('<option>').text(obj.name).attr('value', obj.id));
		            });
     	
		     },
		     error: function (xhr, ajaxOptions, thrownError) {
				alert('ERROR');
		     }
    	});
    }

</script>

</form>