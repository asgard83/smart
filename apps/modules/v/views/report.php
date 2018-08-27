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
            <div clas="row">
                <div class="col s12 m12 l12">
                    <div class="row">
                        <div class="col s12">
                            <div class="section-title blue-border">
                                <h2 style="border-right: none !important;">Smart BPOM Report</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <ul class="tabs">
                                <li class="tab col s12 m6 l6"><a class="active" href="#rptRecom"><i class="mdi-communication-quick-contacts-mail"></i> Periode Rekomendasi</a>
                                </li>
                                <li class="tab col s12 m6 l6"><a class="" href="#rptFollowup"><i class="mdi-notification-event-note"></i> Periode Tindak Lanjut</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col s12 m12 l12">
                            <div id="rptRecom" class="col s12" style="display: block;">
                                <form method="post" action="<?= $actRecom; ?>" autocomplete="off" id="report-recom" name="report-recom">
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="row">
                                        <div class="input-field col s12 l6 m6">
                                            <input type="text" id="txtRecomStart" isnull="false" name="objRecom[RECOM_DATE_START]" placeholder=" " class="dates">
                                            <label for="txtRecomStart">Periode Awal Rekomendasi *</label>
                                        </div>
                                        <div class="input-field col s12 l6 m6">
                                            <input type="text" id="txtRecomEnd" isnull="false" name="objRecom[RECOM_DATE_END]" placeholder=" " class="dates">
                                            <label for="txtRecomEnd">Periode Akhir Rekomendasi *</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12 l6 m6">
                                            <button class="btn waves-effect waves-light light-blue darken-4 report" data-form="#report-recom" id="btnReportRecom">Download<i class="mdi-file-cloud-download right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="rptFollowup" class="col s12" style="display: none;">
                                <form method="post" action="<?= $actFollowUp; ?>" autocomplete="off" id="report-followup" name="report-followup">
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="row">
                                        <div class="input-field col s12 l6 m6">
                                            <input type="text" id="txtFollowUpStart" isnull="false" name="objRecom[FOLLOWUP_DATE_START]" placeholder=" " class="dates">
                                            <label for="txtFollowUpStart">Periode Awal Tindak Lanjut *</label>
                                        </div>
                                        <div class="input-field col s12 l6 m6">
                                            <input type="text" id="txtFollowUpEnd" isnull="false" name="objRecom[FOLLOWUP_DATE_END]" placeholder=" " class="dates">
                                            <label for="txtFollowUpEnd">Periode Akhir Tindak Lanjut *</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12 l6 m6">
                                            <button class="btn waves-effect waves-light light-blue darken-4 report" data-form="#report-followup" id="btnReportFollowUp">Download<i class="mdi-file-cloud-download right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="clearfix" style="height:50px !important;">&nbsp;</div>
    </div>
  </div>
</div>

<script>
	$(document).ready(function(){
		$('.dates').bootstrapMaterialDatePicker({ format : 'DD-MM-YYYY', weekStart : 1, time: false, lang: 'id'});
        $('.report').click(function(){
            var $this = $(this);
            alert(JSON.stringify($this));
            return false;
        });
	});
</script>