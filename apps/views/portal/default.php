<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
  html,
body {
    height: 100%;
    background-image: url(./public/images/71b8a4c1665319e860b3219bdbe3833d.png);
    background-repeat: no-repeat;
	background-attachment:fixed;
    background-position: center;
    background-size: 95%;
    width: 100%;
    background-color: #fff !important;
    display: table-cell;
    vertical-align: middle;
}
html {
    display: table;
    margin: auto;
}
</style>
<div>
  <div id="login-page" class="row" style="width: 305px; margin-top: 25px">
    <div class="col s12 z-depth-4 card-panel">
      <form class="login-form" method="post" action="<?= site_url(); ?>authentication/get_login/<?= $this->session->userdata('session_id'); ?>" autocomplete="off" id="login-form">
        <div class="row">
          <div class="input-field col s12 center">
            <img class="logo-bpom" src="<?= base_url(); ?>public/images/logo-2016-s.png" title="Badan Pengawasan Obat dan Makanan RI" style="width:90px">
            <p class="center login-form-text text-bold" style="font-size: 100%">SMARTBPOM</p>
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-social-person-outline prefix"></i>
            <input id="username" type="text" isnull = "false" name="uid">
            <label for="username" class="center-align">User ID</label>
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-action-lock-outline prefix"></i>
            <input id="password" type="password" isnull = "false" name="pwd">
            <label for="password">Password</label>
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s4">
            <a href="javascript:changeImage();" title="Klik pada gambar untuk mengganti Kode Keamanan"><img src="<?= base_url(); ?>keycode.php?<?= md5("YmdHis"); ?>" style="height:50px; margin-left:-25px" id="img-keycode" align="abstop"></a>
          </div>
		  <div class="input-field col s8">
            <input type="text" class="form-control" style="text-align: center;" name="cpth" isnull = "false" maxlength="4" id="cpth">
			<label for="cpth">Kode Keamanan</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <a href="javascript:void(0);" class="btn waves-effect waves-light col s12 light-blue darken-3" onClick="auth('#login-form',$(this));" id="<?= md5(rand()); ?>">Masuk</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<center>
<a href="https://www.kemenkopmk.go.id/" target="_blank"><img src="<?= base_url(); ?>public/images/logo/pmk.png" title="Kementerian Koordinator Bidang Pembangunan Manusia dan Kebudayaan RI" style="width:50px; border-radius:50%; background: #fff; border: 1px solid #ccc;"></a>&nbsp;
<a href="http://www.depkes.go.id/" target="_blank"><img src="<?= base_url(); ?>public/images/logo/kemenkes.png" title="Kementerian Kesehatan RI" style="width:50px; border-radius:50%; background: #fff; border: 1px solid #ccc;"></a>&nbsp;
<a href="http://www.kemendag.go.id/en" target="_blank"><a href="https://www.kemenkopmk.go.id/" target="_blank"><img src="<?= base_url(); ?>public/images/logo/kemendag.jpg" title="Kementerian Perdagangan RI" style="width:50px; border-radius:50%; background: #fff; border: 1px solid #ccc;"></a>&nbsp;
<a href="http://www.kemenperin.go.id/" target="_blank"><img src="<?= base_url(); ?>public/images/logo/kemenperin.png" title="Kementerian Perindustrian RI" style="width:50px; border-radius:50%; background: #fff; border: 1px solid #ccc;"></a>&nbsp;
<a href="http://www.pertanian.go.id/" target="_blank"><img src="<?= base_url(); ?>public/images/logo/kementan.png" title="Kementerian Pertanian RI" style="width:50px; border-radius:50%; background: #fff; border: 1px solid #ccc;"></a>&nbsp;
<a href="https://www.menpan.go.id/" target="_blank"><img src="<?= base_url(); ?>public/images/logo/kemenpanrb.png" title="Kementerian Pendayagunaan Aparatur Negara dan Reformasi Birokrasi RI" style="width:50px; border-radius:50%; background: #fff; border: 1px solid #ccc;"></a>&nbsp;
<a href="http://www.kemendagri.go.id/" target="_blank"><img src="<?= base_url(); ?>public/images/logo/kemendagri.png" title="Kementerian Dalam Negeri RI" style="width:50px; border-radius:50%; background: #fff; border: 1px solid #ccc;"></a>&nbsp;
<a href="http://kkp.go.id/" target="_blank"><img src="<?= base_url(); ?>public/images/logo/kkp.png" title="Kementerian Kelautan dan Perikanan RI" style="width:50px; border-radius:50%; background: #fff; border: 1px solid #ccc;"></a>&nbsp;
<a href="https://www.kominfo.go.id/" target="_blank"><img src="<?= base_url(); ?>public/images/logo/kemkominfo.png" title="Kementerian Komunikasi dan Informatika RI" style="width:50px; border-radius:50%; background: #fff; border: 1px solid #ccc;"></a>&nbsp;
<img src="<?= base_url(); ?>public/images/logo/garuda.png" title="Pemerintah Daerah" style="width:50px; border-radius:50%; background: #fff; border: 1px solid #ccc;">
<br><br>
<img src="<?= base_url(); ?>public/images/halobpom.png" title="Halo BPOM"><p>Jalan Percetakan Negara Nomor 23, Jakarta - 10560 - Indonesia<br>
<a href="https://www.facebook.com/BadanPengawasObatdanMakananRI" target="_blank" class="waves-effect waves-cyan"><span class="socicon socicon-facebook"></span> Badan POM</a> &nbsp; <a href="https://twitter.com/bpom_ri" target="_blank" class="waves-effect waves-cyan"><span class="socicon socicon-twitter"></span> @bpom_ri</a> &nbsp; <a href="https://www.instagram.com/bpom_ri/" target="_blank" class="waves-effect waves-cyan"><span class="socicon socicon-instagram"></span> @bpom_ri</a> &nbsp; <a href="https://www.youtube.com/channel/UCO5Oi2m_M-uQhTaKDyGA0nA" target="_blank" class="waves-effect waves-cyan"><span class="socicon socicon-youtube"></span> Badan POM</a> &nbsp; <a href="mailto:halobpom@pom.go.id" target="_blank" class="waves-effect waves-cyan"><span class="socicon socicon-mail"></span> halobpom@pom.go.id</a></p>
</center>
<script type="text/javascript"> function changeImage(){ document.getElementById("img-keycode").src = "<?= base_url(); ?>keycode.php?rnd="+Math.random(); } </script>