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
	                    			<input type="hidden" name="m" value="goList">
			                    	<h4 class="card-title">
			                    		Quản lí giờ dạy giảng viên
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
												<th style="max-width: 90px;">Giảng viên</th>
												<th>Mã môn</th>
												<th>Tên môn</th>
												<th>Mã lớp</th>
												<th>Sĩ số</th>
												<th>Số tiết</th>
												<th>Số giờ</th>
												<th>Hệ số</th>
			                          		</tr>
			                        	</thead>
			                        	<tbody>
			                        		<?php foreach ($rawsMap as $key => $item) : ?>
			                        			<?php $teacherName = ""; ?>
			                        			<?php $totalPeriods = 0; $totalHour = 0; $i = 0; ?>
			                        			<?php foreach ($item as $index => $classRoom) : ?>
			                        				<?php $totalPeriods += $classRoom['numberOfPeriods']; ?>
			                        				<?php $totalHour += $classRoom['numberOfHour']; ?>
			                        				<?php $teacherName = $classRoom['teacherName']; ?>
			                        				<tr>
					                        			<td rowspan="<?= count($item) ?>" <?= ($index != 0) ? 'class="d-none"' : "" ?>><?= $teacherName; ?></td>
					                        			<td><?= $classRoom['code']; ?></td>
					                        			<td><?= $classRoom['name']; ?></td>
					                        			<td><?= $classRoom['className']; ?></td>
					                        			<td><?= $classRoom['studentCount']; ?></td>
					                        			<td><?= $classRoom['numberOfPeriods']; ?></td>
					                        			<td><?= $classRoom['numberOfHour']; ?></td>
					                        			<td>
					                        				<?php if($classRoom['code'] == "TH1601" || $classRoom['code'] == "TH3529") : ?>
				                        						<input type="number" name="point" style="width: 50px" step="0.1" class="text-black" value="<?= $classRoom['point']; ?>">
				                        					<?php else : ?>
					                        					<?= $classRoom['point']; ?>
				                        					<?php endif; ?>
				                        				</td>
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
				                        				<form action="?m=update" method="POST">
				                        					<input type="hidden" name="class_code" value="<?= $classCode; ?>">
				                        					<div class="form-group row">
										                        <div class="col">
										                          	<label>Nhóm:</label>
										                          	<input class="form-control" type="number" name="group" min="1" max="4" value="<?= $group; ?>">
										                        </div>
										                        <div class="col">
										                          	<label>Địa điểm thực tập:</label>
										                          	<input class="form-control" name="location" value="<?= $location; ?>">
										                        </div>
										                        <div class="col">
										                          	<label>Số sinh viên:</label>
										                          	<input type="number" name="student_count" step="0.1" class="form-control" value="<?= $studentCount; ?>">
										                        </div>
										                        <div class="col">
										                        	<label> </label>
										                        	<button type="submit" class="btn btn-primary">Lưu</button>
										                        </div>
										                    </div>

					                        			</form>
				                        			</td>
				                        			<td colspan="2" class="text-center"><?= $numberOfPeriods ?></td>
				                        			<td></td>
				                        		</tr>
			                        			<tr style="background: #2F3442; font-style: italic;">
			                        				<td colspan="5">Tổng số</td>
			                        				<td><?= $totalPeriods; ?></td>
			                        				<td><?= $totalHour; ?></td>
			                        				<td></td>
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