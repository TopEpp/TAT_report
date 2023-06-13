<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
<div class="row" style="margin-top: 150px; margin-bottom: 250px;">
	<div class="col-6" style="text-align: center;">
		<a href="<?php echo base_url('main/daily')?>">
			<img src="<?php echo base_url('public/img/daily_banner.png')?>">
		</a>
	</div>
	<div class="col-6" style="text-align: center;">
		<a href="<?php echo base_url('main/monthly_period')?>">
			<img src="<?php echo base_url('public/img/monthly_banner.png')?>">
		</a>
	</div>
</div>

<?= $this->endSection() ?>