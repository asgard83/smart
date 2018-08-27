<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
$whois = "DINAS";
if($this->newsession->userdata('GA_ID')=='1' && $this->newsession->userdata('OFFICE_ID')=='0'){
	$whois = "BBPOM";
	$logo = 'bpom.png';
	$uOffice = $this->main->get_uraian("SELECT BBPOM_NAME FROM TR_BBPOM WHERE BBPOM_ID = '".$this->newsession->userdata('BBPOM_ID')."'", "BBPOM_NAME");
}elseif($this->newsession->userdata('GA_ID')!='1' && $this->newsession->userdata('OFFICE_ID')=='0'){
	$logo = $this->newsession->userdata('GA_LOGO');
	if($this->newsession->userdata('USER_ID')=='8') $logo = 'puan.jpeg';
	$uOffice = $this->main->get_uraian("SELECT GA_NAME FROM TR_GA WHERE GA_ID = '".$this->newsession->userdata('GA_ID')."'", "GA_NAME");
	if($this->newsession->userdata('GA_ID')=='2') $whois = "PMK";
}else{
	$logo = 'garuda.png';
	$uOffice = $this->newsession->userdata('OFFICE_NAME');
}
?>
<div class="row">
	&nbsp;
</div>
<div class="row">
	<div class="col s12">
		<div class="section-title blue-border">
			<h2 style="border-right: 0px !important;">BERANDA</h2>
		</div>
	</div>
</div>
<div class="row">
	<div class="col s12 m3 l4">
		<div id="profile-card" class="card">
			<div class="card-image waves-effect waves-block waves-light">
				<img class="activator" src="<?= base_url(); ?>public/images/user-bg-2.jpg" alt="user bg">
			</div>
			<div class="card-content">
				<img src="<?= base_url(); ?>public/images/logo/<?= $logo ?>" alt="" class="circle responsive-img activator card-profile-image" style="background:rgba(255,255,255, 0.7)">
				<a class="btn-floating activator btn-move-up waves-effect waves-light darken-2 right light-blue darken-3">
				<i class="mdi-editor-mode-edit"></i>
				</a>
				<div class="card-title activator grey-text text-darken-4" style="font-size: 140%; padding-top: 10px"><?= $this->newsession->userdata('USER_NAME'); ?></div>
				<p style="font-size: 110%; margin: 1px 0; padding-left: 20px"><i class="mdi-action-account-balance" style="margin-left: -20px"></i> <?= $uOffice; ?></p>
				<p style="font-size: 110%; margin: 1px 0; padding-left: 20px"><i class="mdi-communication-email" style="margin-left: -20px"></i> <?= $this->newsession->userdata('USER_EMAIL'); ?></p>
			</div>
			<div class="card-reveal">
				<span class="card-title grey-text text-darken-4"><?= $this->newsession->userdata('USER_NAME'); ?> <i class="mdi-navigation-close right"></i></span>
				<p style="font-size: 110%; margin: 10px 0 1px 0; padding-left: 20px"><i class="mdi-action-account-balance" style="margin-left: -20px"></i> <?= $uOffice; ?></p>
				<p style="font-size: 110%; margin: 1px 0; padding-left: 20px"><i class="mdi-action-perm-identity" style="margin-left: -20px"></i> <?= $this->newsession->userdata('USER_ROLE'); ?></p>
				<p style="font-size: 110%; margin: 1px 0; padding-left: 20px"><i class="mdi-action-perm-phone-msg" style="margin-left: -20px"></i> <?= $this->newsession->userdata('USER_PHONE'); ?></p>
				<p style="font-size: 110%; margin: 1px 0; padding-left: 20px"><i class="mdi-communication-email" style="margin-left: -20px"></i> <?= $this->newsession->userdata('USER_EMAIL'); ?></p>
				<p style="font-size: 110%; margin: 1px 0; padding-left: 20px"><i class="mdi-action-schedule" style="margin-left: -20px"></i> <?= $this->newsession->userdata('USER_DATE_LOGIN'); ?></p>
			</div>
		</div>
		<div id="profile-card" class="card" style="margin-top: 25px">
			<div class="card-content" style="padding: 4px">
			<ul id="task-card" class="collection with-header" style="margin: 0">
				<li class="collection-header cyan">
					<h4 class="task-card-title" style="font-size: 170%">Private Message</h4>
					<p class="task-card-date" style="margin:0; font-size: 110%">Tanya Jawab</p>
				</li>
				<?php
					$countListMessage = count($privateMessage);
					if($countListMessage > 0)
					{

						for($i = 0; $i < $countListMessage; $i++)
						{
							$idLabel = rand();
							?>
								<li class="collection-item dismissable" style="touch-action: pan-y; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
									<input type="checkbox" id="<?= $idLabel; ?>">
									<label for="<?= $idLabel; ?>" style="text-decoration: none;"><?= $privateMessage[$i]['SENDER']; ?> <a href="#" class="secondary-content"><span class="ultra-small"><?= timeago(strtotime($privateMessage[$i]['MESSAGE_DATE_CREATED_AGO'])); ?></span></a>
									</label>
									<small style="margin-left: 35px;"><?= character_limiter($privateMessage[$i]['MESSAGE'], 75); ?></small>
								</li>
							<?php
						}
					}
					else
					{
						?>
						<li class="collection-item dismissable" style="touch-action: pan-y; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
							<input type="checkbox" id="task11">
							<label for="task11" style="text-decoration: none;">Tidak ada kotak masuk</label>
						</li>
						<?php
					}
				?>
			</ul>
			</div>
		</div>
	</div>
	<div class="col s12 m3 l4">
		<ul id="task-card" class="collection with-header">
			<li class="collection-header cyan">
				<?php
				if($whois=="BBPOM"){
				?>
				<h4 class="task-card-title" style="font-size: 170%">Hasil Pemeriksaan Sarana</h4>
				<?php
				}elseif($whois=="PMK"){
				?>
				<h4 class="task-card-title" style="font-size: 170%">Data Halo BPOM</h4>
				<?php
				}else{
				?>
				<h4 class="task-card-title" style="font-size: 170%">Data Rekomendasi</h4>
				<?php
				}
				?>
				<p class="task-card-date" style="margin:0; font-size: 110%">Terakhir</p>
			</li>
			<?php
			if($this->newsession->userdata('GA_ID')=='1' && $this->newsession->userdata('BBPOM_ID')!='00'){
				$qInspection = "WHERE A.BBPOM_ID = '".$this->newsession->userdata('BBPOM_ID')."'";
				$qTop = "8";
			}elseif($this->newsession->userdata('GA_ID')=='2'){
				$qTop = "12";
			}else{
				$qInspection = "WHERE B.PROVINCE_ID = '".$this->newsession->userdata('PROVINCE_ID')."'";
				$qTop = "12";
			}
			$iCharlimit = 40;
			if($whois=="BBPOM"){
				$qInspection = "SELECT TOP $qTop REPLACE(CONVERT(VARCHAR, A.INSPECTION_DATE_END, 111), '/', '-') INSPECTION_DATE_END, B.TRADER_NAME, C.REGION_NAME FROM TM_INSPECTION A LEFT JOIN TM_TRADER B ON B.TRADER_ID = A.TRADER_ID LEFT JOIN TR_REGION C ON C.REGION_ID = B.PROVINCE_ID $qInspection ORDER BY A.INSPECTION_DATE_START DESC";
			}elseif($whois=="PMK"){
				$qInspection = "SELECT TOP 9 REPLACE(CONVERT(VARCHAR, A.tanggal_pertanyaan, 111), '/', '-') INSPECTION_DATE_END, A.pertanyaan TRADER_NAME, A.klasifikasi REGION_NAME FROM V_HALOBPOM A";
				$this->db->simple_query('SET ANSI_NULLS ON');
				$this->db->simple_query('SET ANSI_WARNINGS ON');
				$iCharlimit = 80;
			}else{
				$qInspection = "SELECT TOP 8 REPLACE(CONVERT(VARCHAR, Z.RECOM_DATE, 111), '/', '-') INSPECTION_DATE_END, B.TRADER_NAME REGION_NAME, Z.RECOM_NUMBER TRADER_NAME FROM TX_RECOM Z LEFT JOIN TM_INSPECTION A ON A.INSPECTION_ID = Z.INSPECTION_ID LEFT JOIN TM_TRADER B ON B.TRADER_ID = A.TRADER_ID $qInspection ORDER BY Z.RECOM_DATE DESC";
			}
			$dQuery = $this->main->get_result($qInspection);
			if($dQuery)
			{
				foreach($qInspection->result_array() as $row)
				{
			?>
			<li class="collection-item dismissable" style="padding-left:20px">
				<?= character_limiter($row['TRADER_NAME'], $iCharlimit); ?> <a href="#" class="secondary-content"><span class="ultra-small"><?= $row['INSPECTION_DATE_END'] ?></span></a>
				<br><span class="task-cat green" style="margin-left:0;"><?= $row['REGION_NAME'] ?></span>
			</li>
			<?php
				}
			}
			?>
		</ul>
	</div>
	<div class="col s12 m3 l4">
		<ul id="task-card" class="collection with-header">
		<li class="collection-header cyan">
			<h4 class="task-card-title" style="font-size: 170%">Dashboard</h4>
				<p class="task-card-date" style="margin:0; font-size: 110%"><?= date("Y-m-d"); ?></p>
		</li>
		<?php
		if(($this->newsession->userdata('GA_ID')=='1' && $this->newsession->userdata('BBPOM_ID')=='00') || $this->newsession->userdata('GA_ID')=='2'){
		?>
		<li class="collection-item dismissable" style="padding-left: 90px">
			<img src="<?= base_url(); ?>public/images/logo/garuda.png" title="Pemerintah Daerah" style="width:55px; border-radius:50%; background: #fff; border: 1px solid #ccc; position: absolute; margin: 8px 0 0 -70px">
			<label style="text-decoration: none; font-size: 95%; margin-bottom: 1px">Tindak Lanjut &le; 1 Bulan <a href="<?= site_url('v/monitoring/99/under'); ?>" class="secondary-content"><span class="task-cat green time__count" id="<?= rand(); ?>" data-url = "<?= site_url('post/get_counting_dashboard/99/under'); ?>" style="font-size: 90%;">0</span></a></label>
			<label style="text-decoration: none; font-size: 95%; margin-bottom: 1px">Tindak Lanjut &gt; 1 Bulan &le; 3 Bulan <a href="<?= site_url('v/monitoring/99/between'); ?>" class="secondary-content"><span class="task-cat yellow time__count" id="<?= rand(); ?>" data-url = "<?= site_url('post/get_counting_dashboard/99/between'); ?>" style="font-size: 90%;">0</span></a></label>
			<label style="text-decoration: none; font-size: 95%; margin-bottom: 1px">Tindak Lanjut &gt; 3 Bulan <a href="<?= site_url('v/monitoring/99/upper'); ?>" class="secondary-content"><span class="task-cat red time__count" id="<?= rand(); ?>" data-url = "<?= site_url('post/get_counting_dashboard/99/upper'); ?>" style="font-size: 90%;">0</span></a></label>
		</li>
		<li class="collection-item dismissable" style="padding-left: 90px">
			<img src="<?= base_url(); ?>public/images/logo/kemenkes.png" title="Kementerian Kesehatan RI" style="width:55px; border-radius:50%; background: #fff; border: 1px solid #ccc; position: absolute; margin: 8px 0 0 -70px">
			<label style="text-decoration: none; font-size: 95%; margin-bottom: 1px">Tindak Lanjut &le; 1 Bulan <a href="<?= site_url('v/monitoring/3/under'); ?>" class="secondary-content"><span class="task-cat green time__count" id="<?= rand(); ?>" data-url = "<?= site_url('post/get_counting_dashboard/3/under'); ?>" style="font-size: 90%;">0</span></a></label>
			<label style="text-decoration: none; font-size: 95%; margin-bottom: 1px">Tindak Lanjut &gt; 1 Bulan &le; 3 Bulan <a href="<?= site_url('v/monitoring/3/between'); ?>" class="secondary-content"><span class="task-cat yellow time__count" id="<?= rand(); ?>" data-url = "<?= site_url('post/get_counting_dashboard/3/between'); ?>" style="font-size: 90%;">0</span></a></label>
			<label style="text-decoration: none; font-size: 95%; margin-bottom: 1px">Tindak Lanjut &gt; 3 Bulan <a href="<?= site_url('v/monitoring/3/upper'); ?>" class="secondary-content"><span class="task-cat red time__count" id="<?= rand(); ?>" data-url = "<?= site_url('post/get_counting_dashboard/3/upper'); ?>" style="font-size: 90%;">0</span></a></label>
		</li>
		<li class="collection-item dismissable" style="padding-left: 90px">
			<img src="<?= base_url(); ?>public/images/logo/kemendag.jpg" title="Kementerian Perdagangan RI" style="width:55px; border-radius:50%; background: #fff; border: 1px solid #ccc; position: absolute; margin: 8px 0 0 -70px">
			<label style="text-decoration: none; font-size: 95%; margin-bottom: 1px">Tindak Lanjut &le; 1 Bulan <a href="<?= site_url('v/monitoring/4/under'); ?>" class="secondary-content"><span class="task-cat green time__count" id="<?= rand(); ?>" data-url = "<?= site_url('post/get_counting_dashboard/4/under'); ?>" style="font-size: 90%;">0</span></a></label>
			<label style="text-decoration: none; font-size: 95%; margin-bottom: 1px">Tindak Lanjut &gt; 1 Bulan &le; 3 Bulan <a href="<?= site_url('v/monitoring/4/between'); ?>" class="secondary-content"><span class="task-cat yellow time__count" id="<?= rand(); ?>" data-url = "<?= site_url('post/get_counting_dashboard/4/between'); ?>" style="font-size: 90%;">0</span></a></label>
			<label style="text-decoration: none; font-size: 95%; margin-bottom: 1px">Tindak Lanjut &gt; 3 Bulan <a href="<?= site_url('v/monitoring/4/upper'); ?>" class="secondary-content"><span class="task-cat red time__count" id="<?= rand(); ?>" data-url = "<?= site_url('post/get_counting_dashboard/4/upper'); ?>" style="font-size: 90%;">0</span></a></label>
		</li>
		<li class="collection-item dismissable" style="padding-left: 90px">
			<img src="<?= base_url(); ?>public/images/logo/kemenperin.png" title="Kementerian Perindustrian RI" style="width:55px; border-radius:50%; background: #fff; border: 1px solid #ccc; position: absolute; margin: 8px 0 0 -70px">
			<label style="text-decoration: none; font-size: 95%; margin-bottom: 1px">Tindak Lanjut &le; 1 Bulan <a href="<?= site_url('v/monitoring/5/under'); ?>" class="secondary-content"><span class="task-cat green time__count" id="<?= rand(); ?>" data-url = "<?= site_url('post/get_counting_dashboard/5/under'); ?>" style="font-size: 90%;">0</span></a></label>
			<label style="text-decoration: none; font-size: 95%; margin-bottom: 1px">Tindak Lanjut &gt; 1 Bulan &le; 3 Bulan <a href="<?= site_url('v/monitoring/5/between'); ?>" class="secondary-content"><span class="task-cat yellow time__count" id="<?= rand(); ?>" data-url = "<?= site_url('post/get_counting_dashboard/5/between'); ?>" style="font-size: 90%;">0</span></a></label>
			<label style="text-decoration: none; font-size: 95%; margin-bottom: 1px">Tindak Lanjut &gt; 3 Bulan <a href="<?= site_url('v/monitoring/5/upper'); ?>" class="secondary-content"><span class="task-cat red time__count" id="<?= rand(); ?>" data-url = "<?= site_url('post/get_counting_dashboard/5/upper'); ?>" style="font-size: 90%;">0</span></a></label>
		</li>
		<li class="collection-item dismissable" style="padding-left: 90px">
			<img src="<?= base_url(); ?>public/images/logo/kementan.png" title="Kementerian Pertanian RI" style="width:55px; border-radius:50%; background: #fff; border: 1px solid #ccc; position: absolute; margin: 8px 0 0 -70px">
			<label style="text-decoration: none; font-size: 95%; margin-bottom: 1px">Tindak Lanjut &le; 1 Bulan <a href="<?= site_url('v/monitoring/6/under'); ?>" class="secondary-content"><span class="task-cat green time__count" id="<?= rand(); ?>" data-url = "<?= site_url('post/get_counting_dashboard/6/under'); ?>" style="font-size: 90%;">0</span></a></label>
			<label style="text-decoration: none; font-size: 95%; margin-bottom: 1px">Tindak Lanjut &gt; 1 Bulan &le; 3 Bulan <a href="<?= site_url('v/monitoring/6/between'); ?>" class="secondary-content"><span class="task-cat yellow time__count" id="<?= rand(); ?>" data-url = "<?= site_url('post/get_counting_dashboard/6/between'); ?>" style="font-size: 90%;">0</span></a></label>
			<label style="text-decoration: none; font-size: 95%; margin-bottom: 1px">Tindak Lanjut &gt; 3 Bulan <a href="<?= site_url('v/monitoring/6/upper'); ?>" class="secondary-content"><span class="task-cat red time__count" id="<?= rand(); ?>" data-url = "<?= site_url('post/get_counting_dashboard/6/upper'); ?>" style="font-size: 90%;">0</span></a></label>
		</li>
		<li class="collection-item dismissable" style="padding-left: 90px">
			<img src="<?= base_url(); ?>public/images/logo/kemenpanrb.png" title="Kementerian Pendayagunaan Aparatur Negara dan Reformasi Birokrasi RI" style="width:55px; border-radius:50%; background: #fff; border: 1px solid #ccc; position: absolute; margin: 8px 0 0 -70px">
			<label style="text-decoration: none; font-size: 95%; margin-bottom: 1px">Tindak Lanjut &le; 1 Bulan <a href="<?= site_url('v/monitoring/7/under'); ?>" class="secondary-content"><span class="task-cat green time__count" id="<?= rand(); ?>" data-url = "<?= site_url('post/get_counting_dashboard/7/under'); ?>" style="font-size: 90%;">0</span></a></label>
			<label style="text-decoration: none; font-size: 95%; margin-bottom: 1px">Tindak Lanjut &gt; 1 Bulan &le; 3 Bulan <a href="<?= site_url('v/monitoring/7/between'); ?>" class="secondary-content"><span class="task-cat yellow time__count" id="<?= rand(); ?>" data-url = "<?= site_url('post/get_counting_dashboard/7/between'); ?>" style="font-size: 90%;">0</span></a></label>
			<label style="text-decoration: none; font-size: 95%; margin-bottom: 1px">Tindak Lanjut &gt; 3 Bulan <a href="<?= site_url('v/monitoring/7/upper'); ?>" class="secondary-content"><span class="task-cat red time__count" id="<?= rand(); ?>" data-url = "<?= site_url('post/get_counting_dashboard/7/upper'); ?>" style="font-size: 90%;">0</span></a></label>
		</li>
		<li class="collection-item dismissable" style="padding-left: 90px">
			<img src="<?= base_url(); ?>public/images/logo/kemendagri.png" title="Kementerian Dalam Negeri RI" style="width:55px; border-radius:50%; background: #fff; border: 1px solid #ccc; position: absolute; margin: 8px 0 0 -70px">
			<label style="text-decoration: none; font-size: 95%; margin-bottom: 1px">Tindak Lanjut &le; 1 Bulan <a href="<?= site_url('v/monitoring/8/under'); ?>" class="secondary-content"><span class="task-cat green time__count" id="<?= rand(); ?>" data-url = "<?= site_url('post/get_counting_dashboard/8/under'); ?>" style="font-size: 90%;">0</span></a></label>
			<label style="text-decoration: none; font-size: 95%; margin-bottom: 1px">Tindak Lanjut &gt; 1 Bulan &le; 3 Bulan <a href="<?= site_url('v/monitoring/8/between'); ?>" class="secondary-content"><span class="task-cat yellow time__count" id="<?= rand(); ?>" data-url = "<?= site_url('post/get_counting_dashboard/8/between'); ?>" style="font-size: 90%;">0</span></a></label>
			<label style="text-decoration: none; font-size: 95%; margin-bottom: 1px">Tindak Lanjut &gt; 3 Bulan <a href="<?= site_url('v/monitoring/8/upper'); ?>" class="secondary-content"><span class="task-cat red time__count" id="<?= rand(); ?>" data-url = "<?= site_url('post/get_counting_dashboard/8/upper'); ?>" style="font-size: 90%;">0</span></a></label>
		</li>
		<li class="collection-item dismissable" style="padding-left: 90px">
			<img src="<?= base_url(); ?>public/images/logo/kkp.png" title="Kementerian Kelautan dan Perikanan RI" style="width:55px; border-radius:50%; background: #fff; border: 1px solid #ccc; position: absolute; margin: 8px 0 0 -70px">
			<label style="text-decoration: none; font-size: 95%; margin-bottom: 1px">Tindak Lanjut &le; 1 Bulan <a href="<?= site_url('v/monitoring/9/under'); ?>" class="secondary-content"><span class="task-cat green time__count" id="<?= rand(); ?>" data-url = "<?= site_url('post/get_counting_dashboard/9/under'); ?>" style="font-size: 90%;">0</span></a></label>
			<label style="text-decoration: none; font-size: 95%; margin-bottom: 1px">Tindak Lanjut &gt; 1 Bulan &le; 3 Bulan <a href="<?= site_url('v/monitoring/9/between'); ?>" class="secondary-content"><span class="task-cat yellow time__count" id="<?= rand(); ?>" data-url = "<?= site_url('post/get_counting_dashboard/9/between'); ?>" style="font-size: 90%;">0</span></a></label>
			<label style="text-decoration: none; font-size: 95%; margin-bottom: 1px">Tindak Lanjut &gt; 3 Bulan <a href="<?= site_url('v/monitoring/9/upper'); ?>" class="secondary-content"><span class="task-cat red time__count" id="<?= rand(); ?>" data-url = "<?= site_url('post/get_counting_dashboard/9/upper'); ?>" style="font-size: 90%;">0</span></a></label>
		</li>
		<li class="collection-item dismissable" style="padding-left: 90px">
			<img src="<?= base_url(); ?>public/images/logo/kemkominfo.png" title="Kementerian Komunikasi dan Informatika RI" style="width:55px; border-radius:50%; background: #fff; border: 1px solid #ccc; position: absolute; margin: 8px 0 0 -70px">
			<label style="text-decoration: none; font-size: 95%; margin-bottom: 1px">Tindak Lanjut &le; 1 Bulan <a href="<?= site_url('v/monitoring/10/under'); ?>" class="secondary-content"><span class="task-cat green time__count" id="<?= rand(); ?>" data-url = "<?= site_url('post/get_counting_dashboard/10/under'); ?>" style="font-size: 90%;">0</span></a></label>
			<label style="text-decoration: none; font-size: 95%; margin-bottom: 1px">Tindak Lanjut &gt; 1 Bulan &le; 3 Bulan <a href="<?= site_url('v/monitoring/10/between'); ?>" class="secondary-content"><span class="task-cat yellow time__count" id="<?= rand(); ?>" data-url = "<?= site_url('post/get_counting_dashboard/10/between'); ?>" style="font-size: 90%;">0</span></a></label>
			<label style="text-decoration: none; font-size: 95%; margin-bottom: 1px">Tindak Lanjut &gt; 3 Bulan <a href="<?= site_url('v/monitoring/10/upper'); ?>" class="secondary-content"><span class="task-cat red time__count" id="<?= rand(); ?>" data-url = "<?= site_url('post/get_counting_dashboard/10/upper'); ?>" style="font-size: 90%;">0</span></a></label>
		</li>
		<?php
		}else{
			if($this->newsession->userdata('GA_ID') == '1')
			{
				$act = (int)$this->main->get_uraian("SELECT COUNT(RECOM_STATUS) AS JML FROM TX_RECOM A LEFT JOIN TM_INSPECTION B ON A.INSPECTION_ID = B.INSPECTION_ID  WHERE A.RECOM_STATUS = 'Proses Tindak Lanjut' AND B.BBPOM_ID = '" . $this->newsession->userdata('BBPOM_ID'). "' GROUP BY RECOM_STATUS", "JML");
				$new = (int)$this->main->get_uraian("SELECT COUNT(RECOM_STATUS) AS JML FROM TX_RECOM A LEFT JOIN TM_INSPECTION B ON A.INSPECTION_ID = B.INSPECTION_ID  WHERE A.RECOM_STATUS = 'Baru' AND B.BBPOM_ID = '" . $this->newsession->userdata('BBPOM_ID'). "' GROUP BY RECOM_STATUS", "JML");
				$end = (int)$this->main->get_uraian("SELECT COUNT(RECOM_STATUS) AS JML FROM TX_RECOM A LEFT JOIN TM_INSPECTION B ON A.INSPECTION_ID = B.INSPECTION_ID  WHERE A.RECOM_STATUS = 'Selesai' AND B.BBPOM_ID = '" . $this->newsession->userdata('BBPOM_ID'). "' GROUP BY RECOM_STATUS", "JML");
			}
			else
			{
				if($this->newsession->userdata('OFFICE_ID') == '0'){
					$end = (int)$this->main->get_uraian("SELECT COUNT(1) AS JML FROM TX_RECOM WHERE GA_ID = ". $this->newsession->userdata("GA_ID") ." AND RECOM_STATUS = 'Selesai'", "JML");
					$new = (int)$this->main->get_uraian("SELECT COUNT(1) AS JML FROM TX_RECOM WHERE GA_ID = ". $this->newsession->userdata("GA_ID") ." AND RECOM_STATUS = 'Baru'", "JML");
					$act = (int)$this->main->get_uraian("SELECT COUNT(1) AS JML FROM TX_RECOM WHERE GA_ID = ". $this->newsession->userdata("GA_ID") ." AND RECOM_STATUS = 'Proses Tindak Lanjut'", "JML");
				}else{
					$end = (int)$this->main->get_uraian("SELECT COUNT(1) AS JML FROM TX_RECOM WHERE OFFICE_ID = ". $this->newsession->userdata("OFFICE_ID") ." AND RECOM_STATUS = 'Selesai'", "JML");
					$new = (int)$this->main->get_uraian("SELECT COUNT(1) AS JML FROM TX_RECOM WHERE OFFICE_ID = ". $this->newsession->userdata("OFFICE_ID") ." AND RECOM_STATUS = 'Baru'", "JML");
					$act = (int)$this->main->get_uraian("SELECT COUNT(1) AS JML FROM TX_RECOM WHERE OFFICE_ID = ". $this->newsession->userdata("OFFICE_ID") ." AND RECOM_STATUS = 'Proses Tindak Lanjut'", "JML");
				}
			}
		?>
		<li class="collection-item dismissable" style="touch-action: pan-y; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
			<label style="text-decoration: none; font-size: 15px">Tindak Lanjut Selesai <a href="<?= site_url('v/followup/done'); ?>" class="secondary-content"><span class="task-cat green" style="font-size: 15px;"><?= $end; ?></span></a></label>
		</li>
		<li class="collection-item dismissable" style="touch-action: pan-y; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
			<label style="text-decoration: none; font-size: 15px">Pemeriksaan Sarana Baru <a href="<?= site_url('v/followup/incoming'); ?>" class="secondary-content"><span class="task-cat yellow" style="font-size: 15px;"><?= $new; ?></span></a></label>
		</li>
		<li class="collection-item dismissable" style="touch-action: pan-y; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
			<label style="text-decoration: none; font-size: 15px">Tindak Lanjut Belum Diproses <a href="<?= site_url('v/followup/process'); ?>" class="secondary-content"><span class="task-cat red" style="font-size: 15px;"><?= $act; ?></span></a></label>
		</li>
		<?php
		}
		?>
		</ul>
	</div>
</div>

<script>
	$(document).ready(function(){
		$(".time__count").each(function(){
			var $this = $(this);
			$.get($this.attr("data-url"), function(data){
				$this.html(data);
			})
		})
	})	
</script>