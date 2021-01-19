<div class="row">
  <div class="col-xs-12">
  <br>
    <div class="row">
      <div class="pull-left">
          <button type="button" onclick="PopupCenter('pelaporan/T_daftar_cetak/preview_print/<?php echo $reg_id; ?>','PRINT AKTA KELAHIRAN',500,800)" id="btnSave" name="submit" class="btn btn-sm btn-danger">
              <i class="ace-icon fa fa-print icon-on-right bigger-110"></i>
              Cetak Akta Kelahiran
          </button>
      </div>
    </div>
    <center>
    <table border="0" width="60%">
      <tr>
        <td width="250px"><u><b>Nomor Induk Kependudukan</b></u><br><i>Personal Registration Number</i></td>
        <td colspan="3">: <b><?php echo ($value['bayi']) ? $value['bayi']->nik : '-' ; ?></b></td>
      <tr>

      <tr>
        <td class="center" colspan="4">
          <img src="<?php echo base_url().'assets/images/garuda.png'?>" width="70"><br>
          <b>REPUBLIK INDONESIA</b>
        </td>
      </tr>

      <tr>
        <td class="center" colspan="4">
          <br>
          <b><u>PENCATATAN SIPIL</u></b><br><i>REGISTRY OFFICE</i>
        </td>
      </tr>

      <tr>
        <td class="center" colspan="4">
          <br>
          <b><u>WARGA NEGARA INDONESIA</u></b><br><i>NATIONALITY INDONESIA</i>
        </td>
      </tr>

      <tr>
        <td class="center" colspan="4">
          <br>
          <b><u>KUTIPAN AKTA KELAHIRAN</u></b><br><i>EXCERPT OF BIRTH CERTIFICATE</i>
        </td>
      </tr>

      <tr>
        <td>
          <br>
          <u>Berdasarkan Akta Kelahiran Nomor</u><br><i>By virtue of Birt Certificate Number</i>
        </td>
        <td colspan="3"><b><?php echo ($value['bayi']) ? $value['bayi']->no_akta : '-' ; ?></b></td>
      </tr>
      <!-- explode format tgl lahir -->
      <?php
        sscanf(($value['bayi']) ? $value['bayi']->tgl_lhr : date('Y-m-d'), '%d-%d-%d', $y, $m, $d);
        sscanf(($value['bayi']) ? $value['bayi']->tgl_generated_no_akta : date('Y-m-d'), '%d-%d-%d', $y2, $m2, $d2);
      ?>
      <tr>
        <td>
          <u>Bahwa di <b>JAKARTA</b></u><br><i>That in</i>
        </td>
        <td width="150px">
          <u>pada tanggal</u><br><i>on date</i>
        </td>
        <td colspan="2">
          <u><?php echo strtoupper($this->master->convert_num_to_text_ind($d)) ; ?></u><br><i>THE <?php echo strtoupper(NumbersToWords::convert($d))?> OF</i>
        </td>
      </tr>

      <tr>
        <td>
          <b><?php echo strtoupper($this->tanggal->getBulan($m))?><br><i><?php echo strtoupper($this->tanggal->getBulanEn($m))?></i></b>
        </td>
        <td>
          tahun<br><i>on year</i>
        </td>
        <td width="250px">
          <b><?php echo strtoupper($this->master->convert_num_to_text_ind($y)) ; ?><br><i>THE <?php echo strtoupper(NumbersToWords::convert($y))?></i></b>
        </td>
        <td>
          <u>telah lahir</u><br><i>was born</i>
        </td>
      </tr>

      <tr>
        <td colspan="4" style="text-align: center">
          <br>
          <b><?php echo ($value['bayi']) ? strtoupper($value['bayi']->nama) : '-' ; ?></b>
        </td>
      </tr>

      <tr>
        <td colspan="4">
          <br>
          <u>anak ke </u> <b><?php echo ($value['bayi']) ? strtoupper($this->master->convert_num_to_text_ind($value['bayi']->lhr_ke) ): '-' ; ?>, LAKI-LAKI AYAH <?php echo ($value['ayah']) ? strtoupper($value['ayah']->nama) : '-' ; ?> DAN IBU <?php echo ($value['ibu']) ? strtoupper($value['ibu']->nama) : '-' ; ?> </b>
        </td>
      </tr>

      <tr>
        <td colspan="4">
          <br>
          <u>child no </u> <b>FIRST SON FROM FATHER <?php echo ($value['ayah']) ? strtoupper($value['ayah']->nama) : '-' ; ?> AND MOTHER <?php echo ($value['ibu']) ? strtoupper($value['ibu']->nama) : '-' ; ?> </b>
        </td>
      </tr>

      <tr>
        <td colspan="2">
          <br>
        </td>
        <td colspan="2">
          <br>
          <p style="text-align: justify">
          Kutipan ini dikeluarkan Di <b>JAKARTA SELATAN</b><br> <i>This excerpt is issued</i><br>
          <span style="width:100px"><u>pada tanggal</u></span> &nbsp;&nbsp;&nbsp; <b><?php echo strtoupper($this->master->convert_num_to_text_ind($d2)) ; ?></b><br>
          <span style="width:100px"><i>on date</i></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b><?php echo strtoupper(NumbersToWords::convert($d2))?> OF <?php echo strtoupper($this->tanggal->getBulanEn($m2))?></b><br>

          <u>Tahun</u> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo strtoupper($this->master->convert_num_to_text_ind($y2)) ; ?></b><br>
          <i>on year</i> &nbsp;&nbsp;&nbsp;<b><?php echo strtoupper(NumbersToWords::convert($y2))?> </b><br>

          <u>Pejabat Pencatatan Sipil</u> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>DINAS KEPENDUDUKAN</b><br>
          <i>Officer of Civil Registration</i> &nbsp;&nbsp;<b>DAN PENCATATAN SIPIL<br>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PROVINSI DKI JAKARTA</b><br>
          <br><br><br>
          <b><u>NINING KUSWIDIANINGSIH, SE</u><br>
          NIP. 197102021993032003</b>
          </p>
        </td>
      </tr>

    </table>
  </div><!-- /.col -->
</div><!-- /.row -->




