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
        <form method="post" action="<?= $action; ?>" autocomplete="off" id="preview-inspeksi" name="preview-inspeksi">

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
                                            <input type="hidden" name="objRecomInspection[INSPECTION_ID][]" value="<?= $obj[$i]['INSPECTION_ID']; ?>">
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
                            <input type="text" id="txtNomorSurat" isnull="false" name="objRecom[RECOM_NUMBER]" placeholder=" ">
                            <label for="txtNomorSurat">Nomor Surat *</label>
                        </div>
                        <div class="input-field col s12 l6 m6">
                            <input type="text" id="txtTanggalSurat" isnull="false" name="objRecom[RECOM_DATE]" value="<?= date('d-m-Y') ?>">
                            <label for="txtTanggalSurat">Tanggal Surat *</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l12 m12">
                            <input type="text" id="txtPerihal" isnull="false" name="objRecom[RECOM_FOLLOWUP]" placeholder=" ">
                            <label for="txtPerihal" class="">Perihal *</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l12 m12">
                            <input type="text" id="txtTembusan" isnull="false" name="objRecom[RECOM_CC]" placeholder="Jika lebih dari satu pisahkan dengan titik koma">
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
                            <?= form_dropdown('instansi', $selectGroupAgency, '', 'id="txt_group_agency" isnull="false" onchange="setGovAgency($(this), \'#txt_office\'); return false;" is_materialize = "true" data-url = "'.site_url('request/get_gov_agency').'"'); ?>
                            <label for="txt_group_agency">Jenis Instansi *</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l12 m12">
                            <?= form_dropdown('objRecom[GA_ID]', $selectGroupOffice, '', 'id="txt_office" is_materialize = "true" isnull="false"'); ?>
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
<br>&nbsp;
            <div clas="row">
                <div class="col s12 m12 l12">
                    <div class="row">
                        <div class="col s12">
                            <a class="waves-effect waves-light btn blue" id="<?= substr(md5(rand()), 10, 25); ?>" onClick="post('#preview-inspeksi',$(this));">Proses</a> 
                            <a class="waves-effect waves-light btn red darken-2" id="<?= substr(md5(rand()), 10, 25); ?>" onClick="canceled($(this));" data-url = "<?= site_url('v/inspection'); ?>" data-title = "Preview Data Pemeriksaan">Batal</a>
                        </div>
                    </div>
                </div>
            </div>

        </form>
        <div class="clearfix" style="height:50px !important;">&nbsp;</div>
    </div>
  </div>
</div>

<script>
	$(document).ready(function(){
		$('#txtTanggalSurat').bootstrapMaterialDatePicker({ format : 'DD-MM-YYYY', weekStart : 1, time: false, lang: 'id'});
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