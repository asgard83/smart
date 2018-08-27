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

            <div clas="row">
                <div class="col s12 m12 l12">
                    <div class="row">
                        <div class="col s12">
                            <div class="section-title blue-border">
                                <h2 style="border-right: none !important;">Detil Pemeriksaan Sarana</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l6 m6">
                            <input type="text" readonly="readonly" value="<?= $letter['LETTER_NUMBER']; ?>">
                            <label>Nomor Surat Tugas</label>
                        </div>
                        <div class="input-field col s12 l6 m6">
                            <input type="text" readonly="readonly" value="<?= $letter['LETTER_DATE']; ?>">
                            <label>Tanggal Surat Tugas</label>
                        </div>
                    </div>
                </div>
            </div>
<br>&nbsp;
            <div clas="row">
                <div class="col s12 m12 l12">
                    <div class="row" style="margin-left: 0; margin-right: 0">
                        <table class="responsive-table striped">
                            <thead>
                                <tr>
                                    <th width="50%">Nama Sarana</th>
                                    <th width="20">Tanggal Pemeriksaan</th>
                                    <th width="15%">Hasil Pemeriksaan</th>
                                    <th width="15%">Detail Pemeriksaan</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $count = count($obj);
                            if($count > 0)
                            {
                                for($i = 0; $i < $count; $i++){
                                    ?>
                                    <tr>
                                        <td>
                                            <b><?= $obj[$i]['TRADER_NAME']; ?></b>
                                            <div>
                                                <?= strlen($obj[$i]['TRADER_NPWP']) > 0 ? '<p class="nopadding nomargin f11"><span class="text-bold">' .$obj[$i]['TRADER_NPWP']. '</span></p>' : ''; ?>
                                                <p class="nopadding nomargin f11"><?= $obj[$i]['TRADER_ADDRESS_1']; ?></p>
                                                <p class="nopadding nomargin f11"><span class="text-bold">Telp. / Fax </span> <?= $obj[$i]['TRADER_PHONE']; ?> / <?= $obj[$i]['TRADER_FAX']; ?></p>
                                                <p class="nopadding nomargin f11"><span class="text-bold">No. Izin </span> <?= $obj[$i]['TRADER_PERMIT']; ?></p>
                                            </div>
                                        </td>
                                        <td><?= $obj[$i]['INSPECTION_DATE_START']; ?> s.d <?= $obj[$i]['INSPECTION_DATE_END']; ?></td>
                                        <td><?= $obj[$i]['INSPECTION_RESULT']; ?></td>
                                        <td><a href="<?= site_url('download/inspection/'. $obj[$i]['INSPECTION_ID'] .''); ?>" target="_blank"> <i class="mdi-file-file-download"></i><span> Download </a></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>

            <div class="clearfix">&nbsp;</div>

            <div class="col s12 m6 l6">
                <div class="row">
                    <div class="col s12">
                            <div class="section-title blue-border">
                                <h2 style="border-right: none !important;">Surat Rekomendasi</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l6 m6">
                            <input type="text" id="txtNomorSurat" isnull="false" 
                            <?= $enableInput ? '' : 'readonly="readonly"' ?> name="objRecom[RECOM_NUMBER]" value="<?= $objRecom['RECOM_NUMBER']; ?>">
                            <label for="txtNomorSurat">Nomor Surat *</label>
                        </div>
                        <div class="input-field col s12 l6 m6">
                            <input type="text"  <?= $enableInput ? 'id="txtTanggalSurat"' : 'readonly="readonly"' ?> isnull="false" name="objRecom[RECOM_DATE]" value="<?= $objRecom['RECOM_DATE']; ?>">
                            <label for="txtTanggalSurat">Tanggal Surat *</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l12 m12">
                            <input type="text" id="txtPerihal" <?= $enableInput ? '' : 'readonly="readonly"' ?> isnull="false" name="objRecom[RECOM_FOLLOWUP]" value="<?= $objRecom['RECOM_FOLLOWUP']; ?>">
                            <label for="txtPerihal" class="">Perihal *</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l12 m12">
                            <input type="text" id="txtTembusan" <?= $enableInput ? 'isnull="false"' : 'readonly="readonly"' ?> name="objRecom[RECOM_CC]" value="<?= $objRecom['RECOM_CC']; ?>" placeholder="Jika lebih dari satu pisahkan dengan titik koma">
                            <label for="txtTembusan" class="">Tembusan *</label>
                        </div>
                    </div>
                </div>

                <div class="col s12 m6 l6">
                    <div class="row">
                        <div class="col s12">
                            <div class="section-title blue-border">
                                <h2 style="border: none !important;">&nbsp;</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l12 m12">
                            <?php
                            if($enableInput)
                            {
                                echo form_dropdown('instansi', $selectGroupAgency, $objGroupSelected, 'id="txt_group_agency" isnull="false" onchange="setGovAgency($(this), \'#txt_office\'); return false;" is_materialize = "true" data-url = "'.site_url('request/get_gov_agency').'"');
                                
                            }
                            else
                            {
                                ?>
                                <input type="text" id="txt_group_agency" readonly="readonly" value="<?= $labelInstansi; ?>">
                                <?php
                            }
                            ?>
                            <label for="txt_group_agency">Jenis Instansi *</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l12 m12">
                            <?php
                            if($enableInput)
                            {
                                echo form_dropdown($objSelectName, $selectGroupOffice, $objValue, 'id="txt_office" is_materialize = "true" isnull="false"'); 
                                
                            }
                            else
                            {
                                ?>
                                <input type="text" id="txt_office" readonly="readonly" value="<?= $namaInstansi; ?>">
                                <?php
                            }
                            ?>
                            <label for="txt_office">Kementerian/Lembaga/Daerah *</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l12 m12">
                            <input type="text" id="txtCatatan" name="comments" isnull="false" placeholder=" ">
                            <label for="txtCatatan" class="">Catatan *</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
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
<br>&nbsp;
            <div clas="row">
                <div class="col s12 m12 l12">
                    <div class="row">
                        <div class="col s12">
                            <a class="waves-effect waves-light btn blue" id="<?= substr(md5(rand()), 10, 25); ?>" onClick="post('#preview-rekomendasi',$(this));">Proses</a> 
                            <a class="waves-effect waves-light btn red darken-2" id="<?= substr(md5(rand()), 10, 25); ?>" onClick="canceled($(this));" data-url = "<?= site_url('v/inspection'); ?>" data-title = "Preview Data Pemeriksaan">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" readonly="readonly" value="<?= $objRecom['RECOM_ID']; ?>" name="objRecom[RECOM_ID]">
            <input type="hidden" readonly="readonly" value="<?= $objRecom['INSPECTION_ID']; ?>" name="objRecom[INSPECTION_ID]">
            <input type="hidden" readonly="readonly" value="<?= $objRecom['RECOM_STATUS']; ?>" name="objRecom[RECOM_STATUS]">

        </form>
        <div class="clearfix" style="height:50px !important;">&nbsp;</div>
    </div>
  </div>
</div>

<script>
	$(document).ready(function(){
		$('#txtTanggalSurat').bootstrapMaterialDatePicker({ format : 'DD-MM-YYYY', weekStart : 1, time: false, lang: 'id', minDate : new Date() });
	});

    function setGovAgency(cb_start, cb_distance, options_keys)
    {
        options_keys = typeof options_keys !== 'undefined' ? options_keys : false;
        var $this = $(cb_start);
        var $target = $(cb_distance);
        
        if($this.attr("data-url"))
        {
            $target.html('');

            if(parseInt($this.val()) == 0)
            {
                $target.attr("name", "objRecom[GA_ID]");
            }
            else if(parseInt($this.val()) == 1)
            {
                $target.attr("name", "objRecom[OFFICE_ID]");
            }
            else
            {
                $this.attr("name", "objRecom[GA_ID]");
            }


            var dataString = 'params='+ $this.val();
            if(options_keys)
            {
                var $keys = $(options_keys);
                dataString = 'params='+ $this.val() + '&keys=' + $keys.val();
            }
            $.ajax({
                type:"POST",
                url: $this.attr("data-url"),
                data: dataString,
                dataType: "json",
                beforeSend: function()
                {
                    preloader.on();
                },
                complete: function()
                {
                    preloader.off();
                },
                success: function(data)
                {
                    if(data.error != "")
                    {
                        alertify.error(data.error);
                        return false;
                    }
                    else
                    {
                        var length = data.message.length;

                        for(var j = 0; j < length; j++)
                        {
                            if($this.attr("is_materialize"))
                            {
                                $target.append($("<option></option>")
                                                .attr("value",data.message[j].value)
                                                .text(data.message[j].option)
                                );

                            }
                            else
                            {
                                var nuoption = $('<option/>');
                                nuoption.attr('value', data.message[j].value);
                                nuoption.text(data.message[j].option);
                                $target.append(nuoption);    
                            }
                            if($this.attr("is_materialize")) $target.material_select();
                        }
                    }
                },
                error: function (data, status, e){
                    alertify.alert(e);
                }
            });
        }
        else
        {
            return false;
        }
        return false;
    }
</script>