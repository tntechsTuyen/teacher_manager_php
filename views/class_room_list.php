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
		                    	<h4 class="card-title">Danh sách</h4>
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
			                        		<tr>
			                        			<td colspan="4">Thực tập tốt nghiệp</td>
			                        			<td>
			                        				<form action="?m=update" method="POST">
			                        					<input type="hidden" name="class_code" value="TTTN">
				                        				<input type="number" name="student_count" style="width: 50px" step="0.1" class="text-black" value="<?= $tttn['student_count']; ?>">
				                        				<button type="submit" class="btn btn-primary btn-sm">Lưu</button>
				                        			</form>
			                        			</td>
			                        			<td colspan="2" class="text-center"><?= $tttn['number_of_periods']; ?></td>
			                        			<td></td>
			                        		</tr>
			                        		<?php foreach ($rawsMap as $key => $item) : ?>
			                        			<?php $totalPeriods = 0; $totalHour = 0; $i = 0; ?>
			                        			<?php foreach ($item as $index => $classRoom) : ?>
			                        				<?php $totalPeriods += $classRoom['numberOfPeriods']; ?>
			                        				<?php $totalHour += $classRoom['numberOfHour']; ?>
			                        				<tr>
					                        			<td rowspan="<?= count($item) ?>" <?= ($index != 0) ? 'class="d-none"' : "" ?>><?= $classRoom['teacherName']; ?></td>
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
			                        				
</div>
</body>
</html>