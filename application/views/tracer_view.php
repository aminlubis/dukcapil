<script src="<?php echo base_url().'assets/barcode-master/prototype/sample/prototype.js'?>" type="text/javascript"></script>
<script src="<?php echo base_url().'assets/barcode-master/prototype/prototype-barcode.js'?>" type="text/javascript"></script>
<script type="text/javascript">

window.onload = generateBarcode;

  function generateBarcode(){
    $("barcodeTarget").update();
    var value = "00211762-486803";
    var btype = "code128";
    
    var settings = {
      output:"css",
      bgColor: "#FFFFFF",
      color: "#000000",
      barWidth: 1,
      barHeight: 30,
      moduleSize: 5,
      posX: 10,
      posY: 20,
      addQuietZone: false
    };

    $("barcodeTarget").update().show().barcode(value, btype, settings);

  }
    
</script> 
<style type="text/css">
    table {
        font-family: arial;
        font-size: 11px;
        margin-top:10px;
    };
</style>
<table border="0" width="35%">
    <tr>
      <td align="left" colspan="4">
        <!-- <img src="<?php echo base_url()?>assets/images/logo.png" style="width:50px;float:left"> -->
        <div style="float:left;margin-left:10px;margin-top:10px;font-size:15px !important"><b>RS SETIA MITRA</b><br><small style="font-size:10px !important">Jl. RS. Fatmawati No. 80 - 82 Jakarta Selatan</small></div>

      </td>
    </tr>

    <tr>
      <td align="center" colspan="4"><hr></td>
    </tr>

    <tr>
      <td align="center" colspan="4"><h2>TRACER</h2><h3 style="margin-top:-10px !important"><?php echo $result['registrasi']->nama_pasien?><br>( <?php echo $result['registrasi']->no_mr?> ) </h3></td>
    </tr>
    <tr>
      <td colspan="4"><b>Data Registrasi</b></td>
    </tr>

    <tr>
      <td>No. Registrasi</td>
      <td colspan="3"> : <?php echo $result['registrasi']->no_registrasi?></td>
    </tr>

     <tr>
      <td>Tanggal</td>
      <td colspan="3"> : <?php echo $this->tanggal->formatDateTime($result['registrasi']->tgl_jam_masuk)?></td>
    </tr>

    <tr>
      <td>Poli/Klinik</td>
      <td colspan="3"> : <?php echo ucwords($result['registrasi']->poli_tujuan_kunjungan)?></td>
    </tr>

    <tr>
      <td>Dokter</td>
      <td colspan="3"> : <?php echo $result['registrasi']->nama_pegawai?></td>
    </tr>

    <tr>
      <td>Jadwal Praktek</td>
      <td colspan="3"> : Senin, 17.00 s/d 18.00</td>
    </tr>

    <tr>
      <td>Penjamin</td>
      <td colspan="3"> : BPJS Kesehatan </td>
    </tr>

    <tr>
      <td>Petugas</td>
      <td colspan="3"> : Rini </td>
    </tr>

    <tr>
      <td align="right" colspan="4">
        <div id="barcodeTarget" class="barcodeTarget"></div>
      </td>
    </tr>

  </table>