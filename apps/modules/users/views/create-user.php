<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<div class="container" style="min-height:535px;">
  <div class="row">
    <div class="col s12 m12 l12">
      <h5 class="breadcrumbs-title">MANAJEMEN USER</h5>
      <div style="height:10xp;">&nbsp;</div>
    </div>
  </div>
  <div class="widgets">
    <div class="row">
        <form method="post" action="<?= $action; ?>" autocomplete="off" id="create-user" name="create-user">
            <div class="row">
                <div class="col s12 m7 l7">
                    <div class="row">
                        <div class="col s12">
                            <div class="section-title blue-border">
                                <h2 style="border-right: none !important;">Data User</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="objRegister[USER_NIP]" id="txt_nip" type="text" isnull="false">
                            <label for="txt_nip">Nomor Induk Pegawai *</label>
                        </div>
                    </div>       
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="objRegister[USER_PASSWORD]" id="txt_password" type="password" isnull="false">
                            <label for="txt_password">Password *</label>
                        </div>
                    </div>       
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="objRegister[USER_NAME]" id="txt_user_name" type="text" isnull="false">
                            <label for="txt_user_name">Nama Lengkap *</label>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="objRegister[USER_EMAIL]" id="txt_user_email" type="text" isnull="false">
                            <label for="txt_user_email">Email *</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="objRegister[USER_PHONE]" id="txt_user_phone" type="text" isnull="false">
                            <label for="txt_user_phone">Nomor Telpon / <i>Handphone</i> *</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <?= form_dropdown('objRegister[USER_ROLE]', $selectRole, '', 'id="txt_role" isnull="false" is_materialize = "true"'); ?>
                            <label for="txt_role">Hak Akses *</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <?= form_dropdown('objRegister[GA_ID]', $selectGroupAgency, '', 'id="txt_group_agency" isnull="false" onchange="setGovAgency($(this), \'#txt_ga_id\'); return false;" is_materialize = "true" data-url = "'.site_url('request/get_gov_agency').'"'); ?>
                            <label for="txt_group_agency">Jenis Instansi *</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <?= form_dropdown('objRegister[OFFICE_ID]', $selectGroupAgencyId, '', 'id="txt_ga_id" isnull="false"'); ?>
                            <label for="txt_ga_id">Kementerian/Lembaga/Daerah *</label>
                        </div>
                    </div>
                    <div class="row">&nbsp;</div>
                    <div class="row">
                        <div class="col s12">
                            <a class="waves-effect waves-light btn blue" id="<?= substr(md5(rand()), 10, 25); ?>" onClick="post('#create-user',$(this));">Simpan</a> 
                            <a class="waves-effect waves-light btn red darken-2" id="<?= substr(md5(rand()), 10, 25); ?>" onClick="canceled($(this));" data-url = "<?= site_url('settings/manages/user'); ?>" data-title = "Registrasi pengguna baru">Batal</a>
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
                $this.attr("name", "objRegister[OFFICE_ID]");
                $target.attr("name", "objRegister[GA_ID]");
            }
            else if(parseInt($this.val()) == 1)
            {
                $this.attr("name", "objRegister[GA_ID]");
                $target.attr("name", "objRegister[OFFICE_ID]");
            }
            else
            {
                $this.attr("name", "objRegister[GA_ID]");
                $target.attr("name", "objRegister[OFFICE_ID]");
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