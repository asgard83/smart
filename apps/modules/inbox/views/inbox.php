<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<style>
.nopadding {
    padding: 0;
}
.nomargin { 
    margin: 0;
}
.text-bold {
    font-weight: bold;
    font-size: 11px;
}
.f11 {
    font-size: 11px;
}
</style>
<div class="container" style="min-height:535px;">
  <div class="row">
    <div class="col s12 m12 l12">
      <div style="height:20px;">&nbsp;</div>
    </div>
  </div>
    <div id="mail-app" class="section">
        <div class="row">
            <div class="col s12">
                <nav class="light-blue darken-1">
                    <div class="nav-wrapper">
                        <div class="left col s12 m5 l5">
                            <ul>
                            <li><a href="<?= site_url('v/inbox'); ?>" class="email-type">Private Message</a>
                            </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="col s12">
                <div id="email-list" class="col s10 m4 l4 card-panel z-depth-1" style="min-height:400px;">
                    <ul class="collection">
                    <?php
                        $countListMessage = count($listMessage);
                        if($countListMessage > 0)
                        {

                            for($i = 0; $i < $countListMessage; $i++)
                            {
                                ?>
                                    <li class="collection-item avatar email-unread messages" id = "<?= rand(); ?>" data-url = "<?= site_url('post/get_message/' . $listMessage[$i]['MESSAGE_ID']); ?>">
                                        <span class="circle blue lighten-1"><?= substr($listMessage[$i]['SENDER'], 0, 1); ?></span>
										<?php
										if($listMessage[$i]['USER_ID']==$this->newsession->userdata('USER_ID')){
										?>
                                        kepada <span class="email-title"><?= $listMessage[$i]['RECEIVER']; ?></span>
										<?php
										}else{
										?>
                                        dari <span class="email-title"><?= $listMessage[$i]['SENDER']; ?></span>
										<?php
										}
										?>
                                        <p style="line-height:1em"><span class="ultra-small"><i class="mdi-content-redo"></i></span> <span class="blue-text ultra-small"><?= dateindo($listMessage[$i]['MESSAGE_DATE_CREATED']); ?> <?= $listMessage[$i]['MESSAGE_DATE_CREATED_TIME']; ?> ( <?= timeago(strtotime($listMessage[$i]['MESSAGE_DATE_CREATED_AGO'])); ?> )</span><br>
										<?php
										if($listMessage[$i]['MESSAGE_DATE_REPLY']!=""){
										?>
                                        <span class="ultra-small"><i class="mdi-content-undo"></i></span> <span class="ultra-small" style="color: #e91e63 !important"><?= dateindo($listMessage[$i]['MESSAGE_DATE_REPLY']); ?> <?= $listMessage[$i]['MESSAGE_DATE_REPLY_TIME']; ?> ( <?= timeago(strtotime($listMessage[$i]['MESSAGE_DATE_REPLY_AGO'])); ?> )</span>
										<?php
										}else{
										?>
                                        <span class="ultra-small"><i class="mdi-content-undo"></i></span> <span class="ultra-small" style="color: #e91e63 !important">Belum dibalas</span>
										<?php
										}
										?>
										</p>
                                        <p style="margin-top:5px" class="truncate grey-text ultra-small"><?= character_limiter($listMessage[$i]['MESSAGE'], 100); ?></p>
                                    </li>
                                <?php
                            }
                        }
                        else
                        {
                            ?>
                            <li class="collection-item avatar email-unread">
                                <i class="mdi-social-group icon blue-text"></i>
                                <span class="email-title">Administrator</span>
                                <p class="truncate grey-text ultra-small">Tidak ada pesan masuk</p>
                            </li>
                            <?php
                        }
                    ?>
                    </ul>
                </div>
                <div id="email-details" class="col s12 m8 l8 card-panel" style="min-height:400px;">
                    <p>Untuk menampilkan detail pesan, klik salah satu pesan di panel kiri</p>
                </div>
            </div>    
        </div>

        <!-- Compose Email Trigger -->
        <div class="fixed-action-btn" style="bottom: 50px; right: 19px;">
            <a class="btn-floating btn-large red modal-trigger" href="#modal1">
            <i class="mdi-editor-border-color"></i>
            </a>
        </div>



        <!-- Compose Email Structure -->
        <div id="modal1" class="modal">
            <div class="modal-content">
                <nav class="light-blue darken-1">
                    <div class="nav-wrapper">
                    <div class="left col s12 m5 l5">
                        <ul>
                        <li><a href="#!" class="email-menu"><i class="modal-action modal-close  mdi-hardware-keyboard-backspace"></i></a>
                        </li>
                        <li><a href="#!" class="email-type">Compose</a>
                        </li>
                        </ul>
                    </div>
                    <div class="col s12 m7 l7 hide-on-med-and-down">
                        <ul class="right">
                        <li><a javascript:void(0) class="mdi-content-send" id="<?= substr(md5(rand()), 10, 25); ?>" onClick="post('#composeMessage',$(this));"></a>
                        </li>
                        </ul>
                    </div>

                    </div>
                </nav>
            </div>
            <div class="model-email-content">
                <div class="row">
                    <form method="post" action="<?= $actionCompose; ?>" autocomplete="off" id="composeMessage" name="composeMessage">
                        <div class="row">
                            <div class="input-field col s12 l12 m12">
                            <?= form_dropdown('objMessage[MESSAGE_RECEIVER]', $selectGroupUser, '', 'id="receiver" isnull="false"'); ?>
                            <label for="receiver">To</label>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="input-field col s12">
                            <input id="subject" type="text" class="validate" isnull="false">
                            <label for="subject">Subject</label>
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="input-field col s12 l12 m12">
                            <textarea id="compose" class="materialize-textarea" length="500" isnull="false" name="objMessage[MESSAGE]"></textarea>
                            <label for="compose">Compose message</label>
                            <span class="character-counter" style="float: right; font-size: 12px; height: 1px;"></span></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        $(".messages").click(function(){
            var $this = $(this);
            $.get($this.attr("data-url"), function(data){
                $("#email-details").html(data);
            });
        });
    });
</script>