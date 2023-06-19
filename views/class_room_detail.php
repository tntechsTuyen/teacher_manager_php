<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<?php include_once("views/layout/head.php") ?>
</head>
<body>
<div class="container-scroller">
	<?php include_once("views/layout/sidebar.php") ?>
	<div class="container-fluid page-body-wrapper">
		<?php include_once("views/layout/header.php") ?>
		<div class="main-panel">
			<!-- Content page -->
  			<div class="content-wrapper">
  				<div class="row">
  					<div class="col-lg-12 grid-margin stretch-card">
		                <div class="card">
		                  	<div class="card-body">
	                    		<form id="form-search" method="GET">
	                    			<input type="hidden" name="m" value="goDetail">
			                    	<h4 class="card-title">
			                    		Quản lí giờ dạy giảng viên [<?= $_SESSION['username']; ?>]
				                    	<select name="semester">
				                    		<?php foreach ($files as $key => $file) : ?>
					                        	<option value="<?= $file; ?>" <?= ($semester == $file) ? "selected" : "" ?>>Học kỳ <?= $file; ?></option>
				                    		<?php endforeach; ?>
				                      	</select>
			                    	</h4>
	                    		</form>
		                    	<div class="table-responsive">
			                      	<table class="table table-bordered">
			                        	<thead>
			                          		<tr>
												<th>Mã môn</th>
												<th>Tên môn</th>
												<th>Mã lớp</th>
												<th>Sĩ số</th>
												<th>Số tiết</th>
												<th>Số giờ</th>
												<th>Hệ số</th>
												<th>Số giờ ĐH</th>
			                          		</tr>
			                        	</thead>
			                        	<tbody>
			                        		<?php foreach ($rawsMap as $key => $item) : ?>
			                        			<?php $teacherName = ""; ?>
			                        			<?php $totalPeriods = 0; $totalHour = 0; $totalTmp = 0; ?>
			                        			<?php foreach ($item as $index => $classRoom) : ?>
			                        				<?php $teacherName = $classRoom['teacherName']; ?>
			                        				<?php $totalPeriods += $classRoom['numberOfPeriods']; ?>
			                        				<?php $totalHour += $classRoom['numberOfHour']; ?>
			                        				<?php $totalTmp += ($classRoom['numberOfHour'] + $classRoom['numberOfPeriods']) * $classRoom['point']; ?>
			                        				<tr>
					                        			<td><?= $classRoom['code']; ?></td>
					                        			<td><?= $classRoom['name']; ?></td>
					                        			<td><?= $classRoom['className']; ?></td>
					                        			<td><?= $classRoom['studentCount']; ?></td>
					                        			<td><?= $classRoom['numberOfPeriods']; ?></td>
					                        			<td><?= $classRoom['numberOfHour']; ?></td>
					                        			<td><?= $classRoom['point']; ?></td>
					                        			<td><?= ($classRoom['numberOfHour'] + $classRoom['numberOfPeriods']) * $classRoom['point']; ?></td>
					                        		</tr>
			                        			<?php endforeach; ?>
			                        			<?php 
			                        				$classCode = "TTTN_$semester$teacherName";
			                        				$studentCount = $tttnMap[$classCode]['student_count'];
			                        				$numberOfPeriods = $tttnMap[$classCode]['number_of_periods'];
			                        				$group = $tttnMap[$classCode]['grp'];
			                        				$location = $tttnMap[$classCode]['location'];
			                        			?>
												<tr>
				                        			<td>Thực tập tốt nghiệp</td>
				                        			<td colspan="4">
			                        					<div class="form-group row">
									                        <div class="col">
									                          	<label>Nhóm:</label>
									                          	<div class="form-control"><?= $group; ?></div>
									                        </div>
									                        <div class="col">
									                          	<label>Địa điểm thực tập:</label>
									                          	<div class="form-control"><?= $location; ?></div>
									                        </div>
									                        <div class="col">
									                          	<label>Số sinh viên:</label>
									                          	<div class="form-control"><?= $studentCount; ?></div>
									                        </div>
									                    </div>

				                        			</td>
				                        			<td colspan="2" class="text-center"><?= $numberOfPeriods ?></td>
				                        			<td></td>
				                        		</tr>
			                        			<tr style="background: #2F3442; font-style: italic;">
			                        				<td colspan="4">Tổng số</td>
			                        				<td><?= $totalPeriods; ?></td>
			                        				<td><?= $totalHour; ?></td>
			                        				<td></td>
			                        				<td><?= $totalTmp; ?></td>
			                        			</tr>
			                        		<?php endforeach; ?>
			                        	</tbody>
			                      	</table>
		                    	</div>
		                  	</div>
		                </div>
		            </div>
  				</div>
  			</div>
			<!-- * Content page -->
			<?php include_once("views/layout/footer.php") ?>
		</div>
	</div>

	<script>
		$(`[name="semester"]`).change(function(){
			$("#form-search").submit()
		})
	</script>
</div>
</body>
</html>