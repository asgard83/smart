<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
// print_r($messages); die();
$mine = false;
if($messages['MESSAGE_DATE_REPLY']!="") $mine = true;
if($messages['USER_ID']==$this->newsession->userdata('USER_ID')) $mine = true;
?>
<div class="email-content-wrap">
   <div class="row">
      <div class="col s10 m10 l10">
         <ul class="collection">
            <li class="collection-item avatar">
               <span class="circle light-blue"><?= substr($messages['SENDER'], 0, 1); ?></span>
               <span class="email-title"><?= $messages['SENDER']; ?></span>
               <p class="truncate grey-text ultra-small">kepada <?= $messages['RECEIVER']; ?></p>
               <p class="grey-text ultra-small"><?= dateindo($messages['MESSAGE_DATE_CREATED']); ?>, <?= $messages['MESSAGE_DATE_CREATED_TIME']; ?></p> 
			   <div class="email-content" style="padding-top: 10px"><?= $messages['MESSAGE']; ?></div>
            </li>
         </ul>
      </div>
   </div>
</div>
<hr class="grey-text text-lighten-2">
<?php
if($mine){
	if($messages['MESSAGE_DATE_REPLY']!=""){
?>
<div class="email-content-wrap" style="padding-left: 60px">
   <div class="row">
      <div class="col s10 m10 l10">
         <ul class="collection">
            <li class="collection-item avatar">
               <span class="circle light-blue"><?= substr($messages['RECEIVER'], 0, 1); ?></span>
               <span class="email-title"><?= $messages['RECEIVER']; ?></span>
               <p class="truncate grey-text ultra-small">kepada <?= $messages['SENDER']; ?></p>
               <p class="grey-text ultra-small"><?= dateindo($messages['MESSAGE_DATE_REPLY']); ?>, <?= $messages['MESSAGE_DATE_REPLY_TIME']; ?></p> 
			   <div class="email-content" style="padding-top: 10px"><?= $messages['MESSAGE_REPLY']; ?></div>
            </li>
         </ul>
      </div>
   </div>
</div>
<?php
	}else{
		
	}
}else{
?>
<div class="email-reply">
     <form method="post" action="<?= $actionReply; ?>" autocomplete="off" id="replyMessage" name="replyMessage">
        <div class="row">
        <div class="col s12 m12 l12">
            <p><small>Dikirim kepada</small> <b><?= $messages['SENDER']; ?></b></p>
            <textarea id="reply" class="materialize-textarea" length="500" isnull="false" name="objMessage[MESSAGE_REPLY]"></textarea>
            <label for="compose">Balas Pesan *</label>
            <span class="character-counter" style="float: right; font-size: 12px; height: 1px;"></span>
            <input type="hidden" name="messageId" value="<?= $messages['MESSAGE_ID']; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col s12 m12 l12">
            <a href="javascript:void(0);" id="<?= substr(md5(rand()), 10, 25); ?>" onClick="post('#replyMessage',$(this));"><i class="mdi-content-send"></i></a>
        </div>
    </div>
     </form>
</div>
<?php
}
?>