<?php
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
{_header_}
<title>{_appname_}</title>
<style>
.text-bold {
  font-weight: bold;
  font-size: 18px !important;
  position: absolute;
  top: 2px;
  padding-left: 70px;
}
</style>
<body>
  <header id="header" class="page-topbar">
    <div class="navbar-fixed">
      <nav class="light-blue darken-3">
        <div class="nav-wrapper">
          <ul class="left">
            <li class="no-hover"><a href="#" data-activates="slide-out" class="menu-sidebar-collapse btn-floating btn-flat btn-medium waves-effect waves-light light-blue darken-3"><i class="mdi-navigation-menu"></i></a></li>
            <li>
                <a href="<?= base_url(); ?>"><span class="logo-text" style="font-size: 220% !important">SMARTBPOM</span></a>
            </li>
            <li>
				<div style="line-height: 1.3em; color: #81c784 !important; margin-top: 17px" class="ultra-small">Selamat Datang, <span style="color: #c8e6c9 !important;"><?= $this->newsession->userdata('USER_NAME'); ?></span><br><i class="mdi-action-account-balance left" style="font-size: .77rem; line-height: 1.2em; margin-right: 5px"></i><span style="color: #c8e6c9 !important;"><?= $uOffice ?></span></div>
				
            </li>
          </ul>
          <ul class="right hide-on-med-and-down">
            <li><img src="<?= base_url(); ?>public/images/bpom-white.png" style="height:50px; margin: 5px 10px 0 0;"></li>
            <li><img src="<?= base_url(); ?>public/images/halobpom.png" style="height:50px; margin: 5px 10px 0 0;"></li>
        </ul>
      </div>
    </nav>
  </div>
</header>
<div id="main" style="padding-left:0px;">
  <div class="wrapper">
    <aside id="left-sidebar-nav">
    <ul id="slide-out" class="side-nav leftside-navigation ps-container ps-active-y" style="left: -250px; height: 663px;">
      <li class="user-details light-blue darken-3">
        <div class="row">
          <div class="col col s4 m4 l4">
            <img src="<?= base_url(); ?>public/images/logo/<?= $logo ?>" alt="" class="responsive-img valign profile-image">
          </div>
        </div>
      </li>
      <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
          <li class="bold">
            <a href="<?= site_url('dashboard'); ?>" class="waves-effect waves-cyan"><i class="mdi-action-dashboard"></i> Beranda</a>
          </li>
          <?php
          #User Menu
          if($this->newsession->userdata('USER_ROLE') == 'User')
          {
			  if(($this->newsession->userdata('GA_ID') == '1' && $this->newsession->userdata('OFFICE_ID') == '0') || $this->newsession->userdata('GA_ID')=='2')
			  { #User BPOM
            ?>
            <li class="bold">
              <a href="<?= site_url('v/inspection'); ?>" class="waves-effect waves-cyan"><i class="mdi-file-folder"></i> Pemeriksaan</a>
            </li>
            <li class="bold active"><a class="collapsible-header waves-effect waves-light"><i class="mdi-file-folder"></i><span>Rekomendasi</span></a>
                <div class="collapsible-body" style="display: block;">
                <ul>
                  <li class="bold"><a href="<?= site_url('v/recomendation/new'); ?>" class="waves-effect waves-cyan">Baru</a></li>
                  <li class="bold"><a href="<?= site_url('v/recomendation/sent'); ?>" class="waves-effect waves-cyan">Terkirim</a></li>
                </ul>
                </div>
            </li>      
            <li class="bold">
              <a href="<?= site_url('v/followup'); ?>" class="waves-effect waves-cyan"><i class="mdi-file-folder-open"></i> Tindak Lanjut</a>
            </li>
            <li class="bold">
              <a href="<?= site_url('v/hello'); ?>" class="waves-effect waves-cyan"><i class="mdi-action-perm-phone-msg"></i> Halo BPOM</a>
            </li>
            <li class="bold">
              <a href="<?= site_url('v/inbox'); ?>" class="waves-effect waves-cyan"><i class="mdi-communication-forum"></i> Private Message</a>
            </li>
            <?php
			  }
			  else{
			?>
            <li class="bold">
              <a href="<?= site_url('v/recomendation'); ?>" class="waves-effect waves-cyan"><i class="mdi-file-folder"></i> Rekomendasi</a>
            </li>
            <li class="bold active"><a class="collapsible-header waves-effect waves-light"><i class="mdi-file-folder"></i><span>Tindak Lanjut</span></a>
                <div class="collapsible-body" style="display: block;">
                <ul>
                  <li class="bold"><a href="<?= site_url('v/followup/incoming'); ?>" class="waves-effect waves-cyan">Baru</a></li>
                  <li class="bold"><a href="<?= site_url('v/followup/process'); ?>" class="waves-effect waves-cyan">Dalam Proses</a></li>
                  <li class="bold"><a href="<?= site_url('v/followup/done'); ?>" class="waves-effect waves-cyan">Selesai</a></li>
                </ul>
                </div>
            </li>

            <li class="bold">
              <a href="<?= site_url('v/inbox'); ?>" class="waves-effect waves-cyan"><i class="mdi-communication-forum"></i> Private Message</a>
            </li>
			<?php
			  }
          }
          ?>
          <?php
          #Administrator Menu
          if($this->newsession->userdata('USER_ROLE') == 'Administrator')
          { 
            ?>
                <li class="bold active"><a class="collapsible-header waves-effect waves-light"><i class="mdi-action-settings"></i><span>Pengaturan</span></a>
                  <div class="collapsible-body" style="display: block;">
                  <ul>
                    <li><a href="<?= site_url('settings/manages/user'); ?>" class="waves-effect waves-light">Manajemen User</a></li>
                    <li><a href="<?= site_url('v/sla'); ?>" class="waves-effect waves-light">Manajemen SLA</a></li>
                    <li><a href="<?= site_url('v/report'); ?>" class="waves-effect waves-light">Pelaporan</a></li>
                  </ul>
                  </div>
              </li>
            <?php
          }
          ?>
          <li class="bold">
            <a href="<?= site_url('logout'); ?>" class="waves-effect waves-cyan"><i class="mdi-action-input"></i> Keluar</a>
          </li>

        </ul>
      </li>
    </ul>
    </aside>
    <section id="content">
      <div class="container">
        {_content_}
      </div>
    </section>
  </div>
</div>
<footer class="page-footer light-blue darken-3" style="padding-left:0px;">
  <div class="footer-copyright">
    <div class="container center">
      Hak Cipta © <?= date('Y'); ?> SMARTBPOM
    </div>
  </div>
</footer>
 <script type="text/javascript" src="<?= base_url(); ?>public/js/jquery-1.11.2.min.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>public/js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>public/js/materialize.min.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>public/js/moment-with-locales.min.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>public/js/app.js"></script>
</body>
</html>