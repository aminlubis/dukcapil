<div class="row">
  <div class="col-xs-12">

    <div class="page-header">
      <h1>
        <?php echo $title?>
        <small>
          <i class="ace-icon fa fa-angle-double-right"></i>
          <?php echo isset($breadcrumbs)?$breadcrumbs:''?>
        </small>
      </h1>
    </div><!-- /.page-header -->
    <form class="form-horizontal" method="post" id="form-default" action="<?php echo site_url('pencarian/T_pencatatan/process')?>" enctype="multipart/form-data">
      <div class="row">
        <div class="pull-right">
            <button type="button" onclick="proses_no_akta(<?php echo isset($value['bayi'])?$value['bayi']->reg_id:''; ?>)" id="btnSave" name="submit" class="btn btn-sm btn-primary">
                <i class="ace-icon fa fa-check-square-o icon-on-right bigger-110"></i>
                Proses Pencatatan Nomor Akta Kelahiran
            </button>
        </div>
        <div class="pull-left">
            <button type="button" onclick="getMenu('pencarian/T_pencatatan')" id="btnSave" name="submit" class="btn btn-sm btn-danger">
                <i class="ace-icon fa fa-arrow-left icon-on-right bigger-110"></i>
                Kembali ke Daftar Pencatatan
            </button>
        </div>
      </div>
      <hr>
      <!-- data bayi -->
      <div class="row">

        <p style="font-weight: bold; font-size: 14px">DATA BAYI</p>
        
        <div class="form-group">
          <label class="col-md-2">NIK</label>
          <div class="col-md-4" style="margin-top: 0px; margin-left: 5px">
            : <?php echo isset($value['bayi'])?$value['bayi']->nik: ''; ?>
          </div>

          <label class="col-md-2">Nama Lengkap</label>
          <div class="col-md-4" style="margin-top: 0px; margin-left: 5px">
            : <?php echo isset($value['bayi'])?$value['bayi']->nama: ''; ?>
          </div>

        </div>

        <div class="form-group">      
          <label class="col-md-2">Jenis Kelamin</label>
          <div class="col-md-4" style="margin-top: 0px; margin-left: 5px">
            : <?php echo isset($value['bayi'])?$value['bayi']->jk: ''; ?>  
          </div>
          <label class="col-md-2">Tempat Dilahirkan</label>
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
            : <?php echo isset($value['bayi'])?$value['bayi']->tempat_dilahirkan: ''; ?>
          </div>

        </div>

        <div class="form-group">
          <label class="col-md-2">Tempat Kelahiran</label>
          <div class="col-md-4" style="margin-top: 0px; margin-left: 5px">
            : <?php echo isset($value['bayi'])?$value['bayi']->tmp_lhr: ''; ?>
          </div>
          <label class="col-md-2">Tanggal Lahir</label>  
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px"s>
            : <?php echo isset($value['bayi'])?$value['bayi']->tgl_lhr: ''; ?>  <?php echo isset($value['bayi'])?$value['bayi']->jam_lhr: ''; ?>
          </div>

        </div>


        <div class="form-group">
          <label class="col-md-2">Kelahiran Ke</label>
          <div class="col-md-4" style="margin-top: 0px; margin-left: 5px">
            : <?php echo isset($value['bayi'])?$value['bayi']->lhr_ke: ''; ?>
          </div>
          <label class="col-md-2">Jenis Kelahiran</label>
          <div class="col-md-3" style="margin-top: 0px; margin-left: 5px">
            : <?php echo isset($value['bayi'])?$value['bayi']->jenis_kelahiran: ''; ?>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-2">Penolong Kelahiran</label>
          <div class="col-md-4" style="margin-top: 0px; margin-left: 5px">
            : <?php echo isset($value['bayi'])?$value['bayi']->penolong_kelahiran: ''; ?>
          </div>

          <label class="col-md-2">Berat Bayi</label>
          <div class="col-md-1" style="margin-top: 0px; margin-left: 5px">
            : <?php echo isset($value['bayi'])?$value['bayi']->bb: ''; ?> Kg
          </div>
          <label class="col-md-1">Panjang</label>
          <div class="col-md-1" style="margin-top: 0px; margin-left: 5px">
            : <?php echo isset($value['bayi'])?$value['bayi']->panjang: ''; ?> Cm
          </div>

        </div>

        <div class="form-group">
          <label class="col-md-2">No Kartu Keluarga</label>
          <div class="col-md-4" style="margin-top: 0px; margin-left: 5px">
            : <?php echo isset($value['bayi'])?$value['bayi']->no_kk: ''; ?>
          </div>
          <label class="col-md-2">Nama Kepala Keluarga</label>
          <div class="col-md-4" style="margin-top: 0px; margin-left: 5px">
            : <?php echo isset($value['bayi'])?$value['bayi']->nama_kk: ''; ?>
          </div>
        </div>
      </div>
      <!-- end data bayi -->
      <hr>
      <!-- data ibu -->
      <div class="row">

        <p style="font-weight: bold; font-size: 14px">DATA IBU</p>

        <div class="form-group">
          <label class="col-md-2">NIK Ibu</label>
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['ibu'])?$value['ibu']->nik: ''; ?>
          </div>

          <label class="col-md-2">Nama Lengkap</label>
          <div class="col-md-3" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['ibu'])?$value['ibu']->nama: ''; ?>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-2">Tanggal Lahir</label>  
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['ibu'])?$value['ibu']->tgl_lhr: ''; ?>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-2">Jenis Pekerjaan</label>
          <div class="col-md-3" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['ibu'])?$value['ibu']->pekerjaan: ''; ?>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-2">Alamat</label>
          <div class="col-md-4" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['ibu'])?$value['ibu']->alamat: ''; ?> RT/RW <?php echo isset($value['ibu'])?$value['ibu']->rt: ''; ?>/<?php echo isset($value['ibu'])?$value['ibu']->rw: ''; ?>
          </div>
        </div>

        <div class="form-group">

            <label class="col-md-2">Provinsi</label>
            <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
            : <?php echo isset($value['ibu'])?$value['ibu']->provinsi: ''; ?>
            </div>


            <label class="col-md-2">Kota / Kabupaten</label>
            <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
            : <?php echo isset($value['ibu'])?$value['ibu']->kabkota: ''; ?>
            </div>

        </div>

        <div class="form-group">
          <label class="col-md-2">Kecamatan</label>
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['ibu'])?$value['ibu']->kecamatan: ''; ?>
          </div>
          
          <label class="col-md-2">Kelurahan</label>
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['ibu'])?$value['ibu']->kelurahan: ''; ?>
          </div>

        </div>
              
        <div class="form-group">
          <label class="col-md-2">Kewarganegaraan</label>
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['ibu'])?$value['ibu']->kewarganegaraan: ''; ?>
          </div>
          <label class="col-md-2">Kebangsaan (WNA)</label>
          <div class="col-md-3" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['ibu'])?$value['ibu']->kebangsaan_wna: ''; ?>
          </div>
        </div>
        
        <div class="form-group">
          <label class="col-md-2">Tanggal Perkawinan</label>  
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['ibu'])?$value['ibu']->tgl_perkawinan: ''; ?>
          </div>
        </div>

      </div>

      <hr>
      <!-- data ayah -->
      <div class="row">

        <p style="font-weight: bold; font-size: 14px">DATA AYAH</p>

        <div class="form-group">
          <label class="col-md-2">NIK Ayah</label>
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['ayah'])?$value['ayah']->nik: ''; ?>
          </div>

          <label class="col-md-2">Nama Lengkap</label>
          <div class="col-md-3" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['ayah'])?$value['ayah']->nama: ''; ?>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-2">Tanggal Lahir</label>  
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['ayah'])?$value['ayah']->tgl_lhr: ''; ?>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-2">Jenis Pekerjaan</label>
          <div class="col-md-3" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['ayah'])?$value['ayah']->pekerjaan: ''; ?>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-2">Alamat</label>
          <div class="col-md-4" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['ayah'])?$value['ayah']->alamat: ''; ?> RT/RW <?php echo isset($value['ayah'])?$value['ayah']->rt: ''; ?>/<?php echo isset($value['ayah'])?$value['ayah']->rw: ''; ?>
          </div>
        </div>

        <div class="form-group">

            <label class="col-md-2">Provinsi</label>
            <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
            : <?php echo isset($value['ayah'])?$value['ayah']->provinsi: ''; ?>
            </div>


            <label class="col-md-2">Kota / Kabupaten</label>
            <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
            : <?php echo isset($value['ayah'])?$value['ayah']->kabkota: ''; ?>
            </div>

        </div>

        <div class="form-group">
          <label class="col-md-2">Kecamatan</label>
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['ayah'])?$value['ayah']->kecamatan: ''; ?>
          </div>
          
          <label class="col-md-2">Kelurahan</label>
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['ayah'])?$value['ayah']->kelurahan: ''; ?>
          </div>

        </div>
              
        <div class="form-group">
          <label class="col-md-2">Kewarganegaraan</label>
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['ayah'])?$value['ayah']->kewarganegaraan: ''; ?>
          </div>
          <label class="col-md-2">Kebangsaan (WNA)</label>
          <div class="col-md-3" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['ayah'])?$value['ayah']->kebangsaan_wna: ''; ?>
          </div>
        </div>
      
      </div>

      <hr>
      <!-- data pelapor -->
      <div class="row">

        <p style="font-weight: bold; font-size: 14px">DATA PELAPOR</p>

        <div class="form-group">
          <label class="col-md-2">NIK Pelapor</label>
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['pelapor'])?$value['pelapor']->nik: ''; ?>
          </div>

          <label class="col-md-2">Nama Lengkap</label>
          <div class="col-md-3" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['pelapor'])?$value['pelapor']->nama: ''; ?>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-2">Tanggal Lahir</label>  
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['pelapor'])?$value['pelapor']->tgl_lhr: ''; ?>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-2">Jenis Pekerjaan</label>
          <div class="col-md-3" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['pelapor'])?$value['pelapor']->pekerjaan: ''; ?>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-2">Alamat</label>
          <div class="col-md-4" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['pelapor'])?$value['pelapor']->alamat: ''; ?> RT/RW <?php echo isset($value['pelapor'])?$value['pelapor']->rt: ''; ?>/<?php echo isset($value['pelapor'])?$value['pelapor']->rw: ''; ?>
          </div>
        </div>

        <div class="form-group">

            <label class="col-md-2">Provinsi</label>
            <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
            : <?php echo isset($value['pelapor'])?$value['pelapor']->provinsi: ''; ?>
            </div>


            <label class="col-md-2">Kota / Kabupaten</label>
            <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
            : <?php echo isset($value['pelapor'])?$value['pelapor']->kabkota: ''; ?>
            </div>

        </div>

        <div class="form-group">
          <label class="col-md-2">Kecamatan</label>
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['pelapor'])?$value['pelapor']->kecamatan: ''; ?>
          </div>
          
          <label class="col-md-2">Kelurahan</label>
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['pelapor'])?$value['pelapor']->kelurahan: ''; ?>
          </div>

        </div>
              
        <div class="form-group">
          <label class="col-md-2">Kewarganegaraan</label>
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['pelapor'])?$value['pelapor']->kewarganegaraan: ''; ?>
          </div>
          <label class="col-md-2">Kebangsaan (WNA)</label>
          <div class="col-md-3" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['pelapor'])?$value['pelapor']->kebangsaan_wna: ''; ?>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-2">Tanggal Lapor</label>  
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['pelapor'])?$value['pelapor']->tgl_lapor: ''; ?>
          </div>
        </div>

      </div>

      <hr>
      <!-- data saksi 1 -->
      <div class="row">

        <p style="font-weight: bold; font-size: 14px">DATA SAKSI 1</p>

        <div class="form-group">
          <label class="col-md-2">NIK Saksi 1</label>
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['saksi_1'])?$value['saksi_1']->nik: ''; ?>
          </div>

          <label class="col-md-2">Nama Lengkap</label>
          <div class="col-md-3" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['saksi_1'])?$value['saksi_1']->nama: ''; ?>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-2">Tanggal Lahir</label>  
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['saksi_1'])?$value['saksi_1']->tgl_lhr: ''; ?>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-2">Jenis Pekerjaan</label>
          <div class="col-md-3" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['saksi_1'])?$value['saksi_1']->pekerjaan: ''; ?>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-2">Alamat</label>
          <div class="col-md-4" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['saksi_1'])?$value['saksi_1']->alamat: ''; ?> RT/RW <?php echo isset($value['saksi_1'])?$value['saksi_1']->rt: ''; ?>/<?php echo isset($value['saksi_1'])?$value['saksi_1']->rw: ''; ?>
          </div>
        </div>

        <div class="form-group">

            <label class="col-md-2">Provinsi</label>
            <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
            : <?php echo isset($value['saksi_1'])?$value['saksi_1']->provinsi: ''; ?>
            </div>


            <label class="col-md-2">Kota / Kabupaten</label>
            <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
            : <?php echo isset($value['saksi_1'])?$value['saksi_1']->kabkota: ''; ?>
            </div>

        </div>

        <div class="form-group">
          <label class="col-md-2">Kecamatan</label>
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['saksi_1'])?$value['saksi_1']->kecamatan: ''; ?>
          </div>
          
          <label class="col-md-2">Kelurahan</label>
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['saksi_1'])?$value['saksi_1']->kelurahan: ''; ?>
          </div>

        </div>
              
        <div class="form-group">
          <label class="col-md-2">Kewarganegaraan</label>
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['saksi_1'])?$value['saksi_1']->kewarganegaraan: ''; ?>
          </div>
          <label class="col-md-2">Kebangsaan (WNA)</label>
          <div class="col-md-3" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['saksi_1'])?$value['saksi_1']->kebangsaan_wna: ''; ?>
          </div>
        </div>
        

      </div>

      <hr>
      <!-- data saksi 2 -->
      <div class="row">

        <p style="font-weight: bold; font-size: 14px">DATA SAKSI 2</p>

        <div class="form-group">
          <label class="col-md-2">NIK Saksi 2</label>
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['saksi_2'])?$value['saksi_2']->nik: ''; ?>
          </div>

          <label class="col-md-2">Nama Lengkap</label>
          <div class="col-md-3" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['saksi_2'])?$value['saksi_2']->nama: ''; ?>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-2">Tanggal Lahir</label>  
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['saksi_2'])?$value['saksi_2']->tgl_lhr: ''; ?>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-2">Jenis Pekerjaan</label>
          <div class="col-md-3" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['saksi_2'])?$value['saksi_2']->pekerjaan: ''; ?>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-2">Alamat</label>
          <div class="col-md-4" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['saksi_2'])?$value['saksi_2']->alamat: ''; ?> RT/RW <?php echo isset($value['saksi_2'])?$value['saksi_2']->rt: ''; ?>/<?php echo isset($value['saksi_2'])?$value['saksi_2']->rw: ''; ?>
          </div>
        </div>

        <div class="form-group">

            <label class="col-md-2">Provinsi</label>
            <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
            : <?php echo isset($value['saksi_2'])?$value['saksi_2']->provinsi: ''; ?>
            </div>


            <label class="col-md-2">Kota / Kabupaten</label>
            <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
            : <?php echo isset($value['saksi_2'])?$value['saksi_2']->kabkota: ''; ?>
            </div>

        </div>

        <div class="form-group">
          <label class="col-md-2">Kecamatan</label>
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['saksi_2'])?$value['saksi_2']->kecamatan: ''; ?>
          </div>
          
          <label class="col-md-2">Kelurahan</label>
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['saksi_2'])?$value['saksi_2']->kelurahan: ''; ?>
          </div>

        </div>
              
        <div class="form-group">
          <label class="col-md-2">Kewarganegaraan</label>
          <div class="col-md-2" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['saksi_2'])?$value['saksi_2']->kewarganegaraan: ''; ?>
          </div>
          <label class="col-md-2">Kebangsaan (WNA)</label>
          <div class="col-md-3" style="margin-top: 0px; margin-left: 5px">
          : <?php echo isset($value['saksi_2'])?$value['saksi_2']->kebangsaan_wna: ''; ?>
          </div>
        </div>
        

      </div>
      
    </form>

  </div><!-- /.col -->
</div><!-- /.row -->

<script>

function proses_no_akta(reg_id){
  if(confirm('Apakah anda yakin akan melanjutkan Proses Pencatatan No Akta?')){
    $.ajax({
      url : $('#form-default').attr('action'),
      type: "POST",
      data: {ID : reg_id},
      dataType: "JSON",        
      beforeSend: function() {
        achtungShowLoader();  
      },
      uploadProgress: function(event, position, total, percentComplete) {
      },
      complete: function(xhr) {     
        var data=xhr.responseText;
        var jsonResponse = JSON.parse(data);
        getMenu('pencarian/T_pencatatan');
        if(jsonResponse.status === 200){
          $.achtung({message: jsonResponse.message, timeout:5});
          reload_table();
        }else{
          $.achtung({message: jsonResponse.message, timeout:5});
        }
        achtungHideLoader();
      }
    });
  }
  
}

</script>



