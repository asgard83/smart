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
  <div class="widgets">
    <div class="row">
        <form method="post" action="<?= $action; ?>" autocomplete="off" id="preview-rekomendasi" name="preview-rekomendasi">

            <div class="row">
                <div class="col s12 m6 l6">
                    <div class="row">
                        <div class="col s12">
                            <div class="section-title blue-border">
                                <h2 style="border-right: none !important;">Detil Pemeriksaan Sarana</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l6 m6">
                            <input type="text" readonly="readonly" value="<?= $obj['INSPECTION_DATE_START']; ?>">
                            <label>Tanggal Awal Periksa</label>
                        </div>
                        <div class="input-field col s12 l6 m6">
                            <input type="text" readonly="readonly" value="<?= $obj['INSPECTION_DATE_END']; ?>">
                            <label>Tanggal Akhir Periksa</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l6 m6">
                            <input type="text" readonly="readonly" value="<?= $obj['INSPECTION_RESULT']; ?>">
                            <label>Hasil Pemeriksaan Balai</label>
                        </div>
                        <div class="input-field col s12 l6 m6">
                            <input type="text" readonly="readonly" value="<?= strlen(trim($obj['INSPECTION_BBPOM_RESULT'])) == 0 ? '-' : $obj['INSPECTION_BBPOM_RESULT']; ?>">
                            <label>Hasil Pemeriksaan Pusat</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l12 m12">
                            <input type="text" readonly="readonly" value="<?= $obj['-']; ?> ">
                            <label>Tindak Lanjut Pusat/Balai</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l12 m12">
                            <input type="text" readonly="readonly" value="<?= $obj['BBPOM_NAME']; ?>">
                            <label>Pusat/Balai Pemeriksa</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6 l12 m12">
                            <input type="text" readonly="readonly" value="<?= $obj['BBPOM_ADDRESS']; ?>">
                            <label>Alamat</label>
                        </div>
                    </div>
                </div>

                <div class="col s12 m6 l6">
                    <div class="row">
                        <div class="col s12">
                            <div class="section-title blue-border">
                                <h2 style="border-right: none !important;">Detil Sarana</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l12 m12">
                            <input type="text" readonly="readonly" value="<?= $obj['TRADER_NAME']; ?>">
                            <label>Nama Sarana</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12 l12 m12">
                            <input type="text" readonly="readonly" value="<?= $obj['TRADER_ADDRESS_1']; ?>">
                            <label>Alamat</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l6 m6">
                            <input type="text" readonly="readonly" value="<?= $obj['TRADER_PHONE']; ?>/<?= strlen(trim($obj['TRADER_FAX'])) == 0 ? '-' : $obj['TRADER_FAX']; ?>">
                            <label>Telpon/Fax</label>
                        </div>
                        <div class="input-field col s12 l6 m6">
                            <input type="text" readonly="readonly" value="<?= strlen(trim($obj['TRADER_OWNER'])) == 0 ? '-' : $obj['TRADER_OWNER']; ?>">
                            <label>Nama Pemilik</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l12 m12">
                            <input type="text" readonly="readonly" value="<?= strlen(trim($obj['TRADER_PERMIT'])) == 0 ? '-' : $obj['TRADER_PERMIT']; ?>">
                            <label>Nomor Izin</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12 l12">
                    <a href="<?= site_url('download/inspection/'. $obj['INSPECTION_ID'] .''); ?>" target="_blank" class="waves-effect waves-light btn blue" style="text-transform: capitalize !important;"><i class="mdi-file-cloud-download right"></i>Download Data Pemeriksaan</a>
                </div>
            </div>
            <br> &nbsp;
            <div class="row">
                <div class="col s12 m6 l6">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div class="section-title blue-border">
                                <h2 style="border-right: none !important;">Detil Rekomendasi</h2>
                            </div>
                        </div>
                    </div>
					<div class="row">
                        <div class="input-field col s12 l6 m6">
                            <input type="text" readonly="readonly" value="<?= $obj['RECOM_NUMBER']; ?>">
                            <label>Nomor Rekomendasi *</label>
                        </div>
                        <div class="input-field col s12 l6 m6">
                            <input type="text" readonly="readonly" value="<?= $obj['RECOM_DATE']; ?>">
                            <label>Tanggal Rekomendasi *</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m12 l12">
                            <input type="text" readonly="readonly" id="txt_recom_follow_up" value="<?= $obj['RECOM_FOLLOWUP']; ?>">
                            <label for="txt_recom_follow_up">Perihal *</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m12 l12">
                            <input type="text" readonly="readonly" value="<?= $obj['RECOM_CC']; ?> ">
                            <label>Tembusan *</label>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l6">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div class="section-title blue-border">
                                <h2 style="border-right: none !important;">Detil Tindak Lanjut</h2>
                            </div>
                        </div>
                    </div>
                    <?php
                    if($isProcessed)
                    {
                        ?>
                        <div class="row">
                            <div class="input-field col s12 m12 l12">
                                <input type="text" id="txt_followup_number" name="objRecom[FOLLOWUP_NUMBER]" placeholder=" ">
                                <label for="txt_followup_number">Nomor Tindak Lanjut *</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m12 l12">
                                <input type="text" id="txt_date_followup" name="objRecom[FOLLOWUP_DATE]" value="<?= date('d-m-Y'); ?>">
                                <label for="txt_date_followup">Tanggal Tindak Lanjut *</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m12 l12">
                                <input type="text" id="txt_followup" name="objRecom[FOLLOWUP]" placeholder=" ">
                                <label for="txt_followup">Tindak Lanjut *</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 l12 m12">
                                <input type="text" id="txtCatatan" name="comments" isnull="false" placeholder=" ">
                                <label for="txtCatatan" class="">Catatan *</label>
                            </div>
                        </div>
                        <?php
                    }
                    else
                    {
                        ?>
						<div class="row">
                        <div class="input-field col s12 l6 m6">
                            <input type="text" readonly="readonly" value="<?= $obj['FOLLOWUP_NUMBER']; ?> ">
                            <label>Nomor Tindak Lanjut *</label>
                        </div>
                        <div class="input-field col s12 l6 m6">
                            <input type="text" readonly="readonly" value="<?= $obj['FOLLOWUP_DATE']; ?>">
                            <label>Tanggal Tindak Lanjut *</label>
                        </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m12 l12">
                                <input type="text" readonly="readonly" value="<?= $govAgency; ?> ">
                            <label>Kementerian/Lembaga/Dinas *</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m12 l12">
                                <input type="text" readonly="readonly" value="<?= $obj['FOLLOWUP']; ?> ">
                            <label>Tindak Lanjut *</label>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
<br>&nbsp;
            <div class="row">
                <div class="col s12 m12 l12">
                    <?php 
                    if($isProcessed)
                    {
                        ?>
                        <a class="waves-effect waves-light btn blue" id="<?= substr(md5(rand()), 10, 25); ?>" onClick="post('#preview-rekomendasi',$(this));">Proses</a> 
                        <?php
                    }
                    ?>
                    <a class="waves-effect waves-light btn red darken-2" id="<?= substr(md5(rand()), 10, 25); ?>" onClick="canceled($(this));" data-url = "<?= site_url('v/followup'); ?>" data-title = "<?= $isProcessed ? 'Tindak Lanjut Pemeriksaan Sarana': ''; ?>"><?= $isProcessed ? 'Batal' : 'Kembali'; ?></a>
                </div>
            </div>
			<div class="row" style="margin-top: 20px">
                <div class="col s12 m12 l12">
                    <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                        <li class="">
                            <div class="collapsible-header">Detil Log</div>
                            <div class="collapsible-body" style="display: none;">
                                <div id="email-list" class="col s12 m12 l12 card-panel z-depth-1">
                                    <ul class="collection">
                                    <?php
                                        $iCounter_Log = count($TlRecom);
                                        if($iCounter_Log > 0)
                                        {

                                            for($i = 0; $i < $iCounter_Log; $i++)
                                            {
                                                ?>
                                                <li class="collection-item avatar email-unread">
                                                    <span class="circle blue lighten-1"><?= substr($TlRecom[$i]['USER_NAME'], 0, 1); ?></span>
                                                    <span class="email-title"><?= $TlRecom[$i]['USER_NAME']; ?></span>
                                                    <p style="margin: 0px !important; padding:0 !important;">
                                                    <?= $TlRecom[$i]['RECOM_LOG_NOTE']; ?>
                                                    <br>
                                                    <span class="grey-text ultra-small"><?= $TlRecom[$i]['RECOM_LOG_ACTION']; ?> - <?= $TlRecom[$i]['RECOM_LOG_STATUS']; ?></span> 
                                                    </p>
                                                    <a href="javascript:void(0);" class="secondary-content email-time"><span class="blue-text ultra-small"><?= dateindo($TlRecom[$i]['RECOM_LOG_DATE_CREATED']); ?> <?= $TlRecom[$i]['RECOM_LOG_DATE_CREATED_TIME']; ?> ( <?= timeago(strtotime($TlRecom[$i]['RECOM_LOG_DATE_CREATED_AGO'])); ?> )</span></a>
                                                </li>
                                                <?php
                                            }
                                        }
                                    ?>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <input type="hidden" readonly="readonly" value="<?= $obj['RECOM_ID']; ?>" name="objRecom[RECOM_ID]">
            <input type="hidden" readonly="readonly" value="<?= $obj['INSPECTION_ID']; ?>" name="objRecom[INSPECTION_ID]">
        </form>
        <div class="clearfix" style="height:50px !important;">&nbsp;</div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function(){ 
        $('#txt_date_followup').bootstrapMaterialDatePicker({ format : 'DD-MM-YYYY', weekStart : 1, time: false, lang: 'id', minDate : new Date() });
    });
</script>