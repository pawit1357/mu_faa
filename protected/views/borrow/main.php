<form id="Form1" method="POST" enctype="multipart/form-data"
	class="form-horizontal">

	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption">
				<i class="icon-equalizer font-red-sunglo"></i> <span
					class="caption-subject font-red-sunglo bold uppercase">Search
					Condition</span> <span class="caption-helper"></span>
			</div>
			<div class="tools"></div>
		</div>
		<div class="portlet-body form">
			<div class="form-body">
				<!-- BEGIN FORM-->

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-3">Receive Date:<span
								class="required">*</span></label>
							<div class="col-md-6">
								<input class="form-control placeholder-no-fix" type="text"
									placeholder="" id="start_date" name="AdPlan[start_date]" />

								<!-- 								<div class="input-group input-medium date date-picker" -->
								<!-- 									data-date-format="yyyy/mm/dd" data-date-viewmode="years" -->
								<!-- 									data-date-minviewmode="months"> -->
								<!-- 									<input class="form-control placeholder-no-fix" type="text" -->
								<!-- 										placeholder="" name="AdPlan[start_date]" /> <span -->
								<!-- 										class="input-group-btn"> -->
								<!-- 										<button class="btn default" type="button"> -->
								<!-- 											<i class="fa fa-calendar"></i> -->
								<!-- 										</button> -->
								<!-- 									</span> -->
								<!-- 								</div> -->
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-3">Return Date:<span
								class="required">*</span></label>
							<div class="col-md-6">
								<input class="form-control placeholder-no-fix" type="text"
									placeholder="" id="end_date" name="AdPlan[end_date]" />
								<!-- 								<div class="input-group input-medium date date-picker" -->
								<!-- 									data-date-format="yyyy/mm/dd" data-date-viewmode="years" -->
								<!-- 									data-date-minviewmode="months"> -->
								<!-- 									<input class="form-control placeholder-no-fix" type="text" -->
								<!-- 										placeholder="" name="AdPlan[start_date]" /> <span -->
								<!-- 										class="input-group-btn"> -->
								<!-- 										<button class="btn default" type="button"> -->
								<!-- 											<i class="fa fa-calendar"></i> -->
								<!-- 										</button> -->
								<!-- 									</span> -->
								<!-- 								</div> -->
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-3">Document No/User:<span
								class="required">*</span></label>
							<div class="col-md-6">
								<input class="form-control placeholder-no-fix" type="text"
									placeholder="" name="AdPlan[vedio_time]" />
							</div>
						</div>
					</div>
				</div>
				<div class="form-actions">
					<div class="row">
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-offset-3 col-md-9">
									<button type="button" class="btn green uppercase">Search</button>
									<button type="reset" class="btn default uppercase">Cencel</button>
								</div>
							</div>
						</div>
						<div class="col-md-6"></div>
					</div>
				</div>

				<!-- END FORM-->
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet box blue-dark">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-cogs"></i>Search Result
					</div>
					<div class="actions">
						<!-- 						<i class="fa fa-plus"></i> -->
					<?php echo CHtml::link('Request',array('Borrow/Create'),array('class'=>'btn btn-default btn-sm'));?>
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-striped table-hover table-bordered">
						<thead>
							<tr>
								<th width="5%">#</th>
								<th width="10%">Doc No.</th>
								<th width="20%">Name</th>
								<th width="20%">Receive Date</th>
								<th width="20%">Return Date</th>
								<th width="10%">Status</th>
								<th width="10%">Action</th>
							</tr>
						</thead>
						<tbody>
	<?php
	$counter = 1;
	$dataProvider = $data->search ();
	
	foreach ( $dataProvider->data as $data ) {
		?>
				<tr class="line-<?php echo $counter%2 == 0 ? '1' : '2'?>">
								<td class="center"><?php echo $counter;?></td>
								<td class="center"><?php echo $data->DocumentNo?></td>
								<td class="center"><?php echo $data->user_login->username?></td>
								<td class="center"><?php echo $data->from_date?></td>
								<td class="center"><?php echo $data->to_date?></td>
								<td class="center"><?php echo $data->status_code?></td>
								<td class="center">
								
								<?php
		switch (UserLoginUtils::getUserRole ()) {
			case 1 : // Admin
				switch ($data->status_code) {
					case 'PREPARE_EQUIPMENT' :
						?>
												<a title="Prepare" class="fa fa-tasks"
									href="<?php echo Yii::app()->CreateUrl('Borrow/Prepare/id/'.$data->id)?>"></a>
												<?php
						break;
					case 'READY' :
						?>
												<a title="Return" class="fa fa-truck"
									href="<?php echo Yii::app()->CreateUrl('Borrow/Return/id/'.$data->id)?>"></a>
												<?php
						break;
				}
				?>
										|
											<a title="Edit" class="fa fa-edit"
									href="<?php echo Yii::app()->CreateUrl('Borrow/Edit/id/'.$data->id)?>"></a>
									<a title="Delete"
									onclick="return confirm('Are you sure to delete?')"
									class="fa fa-trash"
									href="<?php echo Yii::app()->CreateUrl('Borrow/Delete/id/'.$data->id)?>"></a>
										<?php
				break;
			case 3 : // Approver 1
			case 4 : // Approver 2
				switch ($data->status_code) {
					case 'WAIT_APPROVE_1' :
					case 'WAIT_APPROVE_2' :
										?>
											<a title="Approve" class="fa fa-check"
									href="<?php echo Yii::app()->CreateUrl('Borrow/Approve/id/'.$data->id)?>"></a>
									<a title="DisApprove" class="fa fa-close"
									href="<?php echo Yii::app()->CreateUrl('Borrow/DisApprove/id/'.$data->id)?>"></a>
										<?php
						break;
				}
				break;
			default : // Other specail
				break;
		}
		?>
								</td>
							</tr>
			<?php
			$counter++;
	}
	?>
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>
	<script
		src="<?php echo ConfigUtil::getAppName();?>/assets/global/plugins/jquery.min.js"
		type="text/javascript"></script>

	<script>


    jQuery(document).ready(function () {


    	$( "#start_date" ).datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            numberOfMonths: 1,
            changeYear: true,
            onClose: function( selectedDate, inst ) {
        }});
    	$( "#end_date" ).datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            numberOfMonths: 1,
            changeYear: true,
            onClose: function( selectedDate, inst ) {
        }});
        
    	});
	</script>
</form>