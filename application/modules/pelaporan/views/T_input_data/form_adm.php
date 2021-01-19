
  <br>
  <p style="font-weight: bold; font-size: 14px">DATA <?php echo strtoupper(str_replace('_',' ', $type)); ?></p>
  <!-- hidden form -->
  <input type="hidden" name="type" value="<?php echo $type; ?>">

  <div class="checkbox">
    <label>
      <input name="surat_kelahiran" value="1" type="checkbox" class="ace">
      <span class="lbl"> Surat Kelahiran dari Dokter/Bidan/Penolong</span>
    </label>
  </div>

  <div class="checkbox">
    <label>
      <input name="identitas_saksi" value="1" type="checkbox" class="ace">
      <span class="lbl"> Nama dan Identitas Saksi Kelahiran</span>
    </label>
  </div>

  <div class="checkbox">
    <label>
      <input name="kk_ort" value="1" type="checkbox" class="ace">
      <span class="lbl"> Kartu Keluarga (KK) Orang Tua</span>
    </label>
  </div>

  <div class="checkbox">
    <label>
      <input name="ktp_ort" value="1" type="checkbox" class="ace">
      <span class="lbl"> Kartu Tanda Penduduk (KTP) Orang Tua</span>
    </label>
  </div>

  <div class="checkbox">
    <label>
      <input name="akta_nikah" value="1" type="checkbox" class="ace">
      <span class="lbl"> Kutipan Akta Nikah/Akta Perkawinan Orang Tua</span>
    </label>
  </div>

  <div class="checkbox">
    <label>
      <input name="sptjm_kelahiran" value="1" type="checkbox" class="ace">
      <span class="lbl"> SPTJM Kebenaran Data Kelahiran</span>
    </label>
  </div>

  <div class="checkbox">
    <label>
      <input name="sptjm_sutri" value="1" type="checkbox" class="ace">
      <span class="lbl"> SPTJM Kebenaran Sebagai Pasangan Suami-Istri</span>
    </label>
  </div>

  <div class="row">
    <div class="form-actions center">
      <?php if($flag != 'read'):?>
      <button type="reset" id="btnReset" class="btn btn-sm btn-danger">
          <i class="ace-icon fa fa-close icon-on-right bigger-110"></i>
          Reset Form
      </button>
      <button type="submit" id="btnSave" name="submit" class="btn btn-sm btn-info">
          <i class="ace-icon fa fa-check-square-o icon-on-right bigger-110"></i>
          Simpan Data
      </button>
      <?php endif; ?>
    </div>
  </div>


