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
      <h5 class="breadcrumbs-title">Preview Rekomendasi</h5>
      <div style="height:10xp;">&nbsp;</div>
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
                                <h2 style="border-right: none !important;">Data Pemeriksaan</h2>
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
                        <div class="col s12">
                            <div class="section-title blue-border">
                                <h2 style="border-right: none !important;">Balai Pemeriksa</h2>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12 l12 m12">
                            <input type="text" readonly="readonly" value="<?= $obj['BBPOM_NAME']; ?>">
                            <label>Hasil Pemeriksaan Balai</label>
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
                                <h2 style="border-right: none !important;">Data Sarana</h2>
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
                            <input type="text" readonly="readonly" value="<?= $obj['TRADER_PHONE']; ?>">
                            <label>Telpon</label>
                        </div>
                        <div class="input-field col s12 l6 m6">
                            <input type="text" readonly="readonly" value="<?= strlen(trim($obj['TRADER_FAX'])) == 0 ? '-' : $obj['TRADER_FAX']; ?>">
                            <label>Fax</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l12 m12">
                            <input type="text" readonly="readonly" value="<?= $obj['TRADER_OWNER']; ?>">
                            <label>Nama Pemilik</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l12 m12">
                            <input type="text" readonly="readonly" value="<?= strlen(trim($obj['TRADER_PERMIT'])) == 0 ? '-' : $obj['TRADER_PERMIT']; ?>">
                            <label>No. Izin</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m12 l12">
                        <a href="<?= site_url('download/inspection/'. $obj['INSPECTION_ID'] .''); ?>" target="_blank" class="waves-effect waves-light btn blue" style="text-transform: capitalize !important;"><i class="mdi-file-cloud-download right"></i>Download Data Pemeriksaan</a>
                    </div>
                </div>    
            </div>


            <div class="clearfix">&nbsp;</div>
            
            <div class="row">
                <div class="col s12 m6 l6">
                    <div class="section-title blue-border">
                        <h2 style="border-right: none !important;">Rekomendasi</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 l6 m6">
                    <input type="text" readonly="readonly" value="<?= $obj['RECOM_NUMBER']; ?>">
                    <label for="txt_recom_number">Nomor Rekomendasi *</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 l6 m6">
                    <input type="text" readonly="readonly" value="<?= $obj['RECOM_DATE']; ?>">
                    <label for="txt_recom_date">Tanggal *</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 l6 m6">
                    <textarea class="materialize-textarea" id="txt_recom_follow_up" readonly="readonly"><?= $obj['RECOM_FOLLOWUP']; ?></textarea>
                    <label for="txt_recom_follow_up">Perihal *</label>
                </div>
            </div>    

            <div class="row">
                <div class="col s12">
                    <a class="waves-effect waves-light btn blue" id="<?= substr(md5(rand()), 10, 25); ?>" onClick="post('#preview-rekomendasi',$(this));">Proses</a> 
                    <a class="waves-effect waves-light btn red darken-2" id="<?= substr(md5(rand()), 10, 25); ?>" onClick="canceled($(this));" data-url = "<?= site_url('v/recomendation'); ?>" data-title = "Rekomendasi Tindak Lanjut Pemeriksaan Sarana">Batal</a>
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
        $('#txt_recom_date').bootstrapMaterialDatePicker({ format : 'DD-MM-YYYY', weekStart : 1, time: false, lang: 'id', minDate : new Date() });
    });
</script>