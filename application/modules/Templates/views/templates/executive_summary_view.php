<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <table border="0" width="100%">
    <tr>
      <td width="12%"><img src="<?php echo base_url().'assets/images/BNPB.png'?>" width="200px"></td>
      <td width="88%">
        <table>
          <tr>
            <td width="35%">Nama Bencana</td>
            <td>: <?php echo $disaster->nama_bencana?></td>
          </tr>
          <tr>
            <td>Waktu Kejadian</td>
            <td>: <?php echo $this->tanggal->formatDateFormDmy($disaster->tanggal_kejadian).' '.$disaster->jam_kejadian.' '.$disaster->zona_waktu?></td>
          </tr>
          <tr>
            <td>Jenis & Level Bencana</td>
            <td>: <?php echo $disaster->nama_jenis_bencana.' ('.$disaster->nama_level.')'?></td>
          </tr>
          <tr>
            <td>Status Bencana</td>
            <td>: <?php echo $disaster->nama_status_bencana?></td>
          </tr>
          <tr>
            <td>Nomor SK Kedaruratan</td>
            <td>: <?php echo $disaster->no_sk_darurat?></td>
          </tr>
        </table>
      </td>
    </tr>
    
    <tr><td width="100%"><hr style="border-style: dotted"></td></tr>
  </table>
  
  <table border="0" width="100%">
    <?php 
      if ($disaster->updated_date) {
          $decode = json_decode($disaster->updated_by);
          $exc_by = (is_object($decode) > 0) ? $decode->fullname : $disaster->updated_by;
          $last_date = $this->tanggal->formatDateTime($disaster->updated_date);
      } else {
          $decode = json_decode($disaster->created_by);
          $exc_by = (is_object($decode) > 0) ? $decode->fullname : $disaster->created_by;
          $last_date = $this->tanggal->formatDateTime($disaster->created_date);
      }
    ?>
    
    <tr>
      <td align="left"><br>Bencana ID : <?php echo '0'.$disaster->jenis_bencana.'.'.$disaster->provinsi.'.00'.$disaster->id_bencana?></td>
      <td align="right"><br>Update terakhir: <?php echo $last_date?></td>
    </tr>
    <!-- <tr><td colspan="2"><b>DATA BENCANA</b></td></tr>
    <tr>
      <td width="35%">Nama Bencana</td>
      <td>: <?php echo $disaster->nama_bencana?></td>
    </tr>
    <tr>
      <td>Waktu Kejadian</td>
      <td>: <?php echo $this->tanggal->formatDateFormDmy($disaster->tanggal_kejadian).' '.$disaster->jam_kejadian.' '.$disaster->zona_waktu?></td>
    </tr>
    <tr>
      <td>Jenis & Level Bencana</td>
      <td>: <?php echo $disaster->nama_jenis_bencana.' ('.$disaster->nama_level.')'?></td>
    </tr>
    <tr>
      <td>Status Bencana</td>
      <td>: <?php echo $disaster->nama_status_bencana?></td>
    </tr>
    <tr>
      <td>Nomor SK Kedaruratan</td>
      <td>: <?php echo $disaster->no_sk_darurat?></td>
    </tr> -->

    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><td colspan="2"><br><b>WILAYAH BENCANA</b></td></tr>
    <tr>
      <td width="35%">Provinsi</td>
      <td>: <?php echo $disaster->nama_prov?></td>
    </tr>
    <tr>
      <td>Kab/Kota</td>
      <td>: <?php echo $disaster->nama_kab?></td>
    </tr>
    <tr>
      <td>Latitude/Longitude</td>
      <td>: <?php echo $disaster->latitude.' - '.$disaster->longitude?></td>
    </tr>
    <tr>
      <td>Wilayah Terdampak</td>
      <td>: <?php echo ucwords($disaster->wilayah_terdampak)?></td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><td colspan="2"><br><b>KRONOLOGIS</b></td></tr>
    <tr>
      <td colspan="2"><?php echo ucfirst($disaster->kronologis)?></td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><td colspan="2"><br><b>UPAYA PEMERINTAH PUSAT DAN DAERAH</b></td></tr>
    <tr>
      <td colspan="2"><?php echo ucfirst($disaster->bantuan_bnpb)?></td>
    </tr>

    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><td colspan="2"><br><b>LOGISTIK & PERALATAN</b></td></tr>
    <tr>
      <td colspan="2" align="left">
        <table border="1" width="100%">
          <tr style="background-color: grey; color: white; height: 50px !important; font-weight: bold">
            <th width="20%"> Tanggal</th>
            <th width="55%"> Deskripsi</th>
            <th width="20%"> Jenis</th>
            <th width="20%"> Jumlah</th>
          </tr>
          <?php 
            if(count($logistik > 0 )) : 
              foreach($logistik as $row_logistik) :
          ?>
              <tr>
                <td> <?php echo $this->tanggal->formatDateFormDmy($row_logistik->tanggal)?></td>
                <td> <?php echo $row_logistik->nama_logistik?></td>
                <td> <?php echo $row_logistik->jenis_logistik?></td>
                <td> <?php echo $row_logistik->total_tersedia.' '.$row_logistik->satuan?></td>
              </tr>
          <?php 
              endforeach; 
            else: 
              echo '<tr><td>-Tidak ada data-</td></tr>';
          endif;
          ?>
        </table>
      </td>
    </tr>

    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><td colspan="2"><br><b>PERSONIL & RELAWAN</b></td></tr>
    <tr>
      <td colspan="2" align="left">
        <table border="0" width="100%">
          <?php 
            $arr_relawan = array();
            if(count($personil > 0 )) :
            foreach($personil as $row_personil) :?>
          <tr>
            <td width="30%">Tanggal</td>
            <td width="70%">: <?php echo $this->tanggal->formatDateFormDmy($row_personil->tanggal_kedatangan)?></td>
          </tr>
          <tr>
            <td>Nama Relawan</td>
            <td>: <?php echo $row_personil->nama_personil?></td>
          </tr>
          <tr>
            <td>Asal Relawan</td>
            <td>: <?php echo $row_personil->asal_personil?></td>
          </tr>
          <tr>
            <td>Jumlah</td>
            <td>: <?php echo $row_personil->jumlah_personil?></td>
          </tr>
          <tr>
            <td>Keterangan</td>
            <td>: <?php echo $row_personil->keterangan?></td>
          </tr>
          <tr><td colspan="2"><hr></td></tr>

          <?php 
              $arr_relawan[] = $row_personil->jumlah_personil;
              endforeach; 
            else: echo '<tr><td colspan="2">-Tidak ada data-</td></tr>';
          endif;
          ?>
          
          <tr>
            <td colspan="2"><b>Total Relawan : <?php echo array_sum($arr_relawan)?> Personil</b></td>
          </tr>

        </table>
      </td>
    </tr>
    
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><td colspan="2"><br><b>INFO KORBAN</b></td></tr>
    <tr>
      <td colspan="2" align="left">
        
          
          <?php 
            if(count($korban > 0 )) :
              foreach($korban as $row_korban) :
          ?>
            <?php echo $this->tanggal->formatDateFormDmy($row_korban->tanggal).' '.$row_korban->jam.' '.$row_korban->zona_waktu?><br>
            <table border="1" width="100%">
              <tr style="background-color: grey; color: white; height: 50px !important; font-weight: bold">
                  <th width="23%"> Meninggal</th>
                  <th width="23%"> Luka/Sakit</th>
                  <th width="23%"> Mengungsi</th>
                  <th width="23%"> Hilang</th>
                  <th width="23%"> Terdampak</th>
                </tr>
              <tr>
              <?php 
                // meninggal
                $arr_mnggl = json_decode($row_korban->meninggal);
                $val_mnggl = isset($arr_mnggl->value)?$arr_mnggl->value:$row_korban->meninggal;
                $sat_mnggl = isset($arr_mnggl->satuan)?$arr_mnggl->satuan:'Jiwa';
                echo '<td align="center">'.$val_mnggl.' '.$sat_mnggl.'</td>';

                // luka
                $arr_luka = json_decode($row_korban->luka);
                $val_luka = isset($arr_luka->value)?$arr_luka->value:$row_korban->luka;
                $sat_luka = isset($arr_luka->satuan)?$arr_luka->satuan:'Jiwa';
                echo '<td align="center">'.$val_luka.' '.$sat_luka.'</td>';
                
                // mengungsi
                $arr_mengungsi = json_decode($row_korban->mengungsi);
                $val_mengungsi = isset($arr_mengungsi->value)?$arr_mengungsi->value:$row_korban->mengungsi;
                $sat_mengungsi = isset($arr_mengungsi->satuan)?$arr_mengungsi->satuan:'Jiwa';
                echo '<td align="center">'.$val_mengungsi.' '.$sat_mengungsi.'</td>';

                // hilang
                $arr_hilang = json_decode($row_korban->hilang);
                $val_hilang = isset($arr_hilang->value)?$arr_hilang->value:$row_korban->hilang;
                $sat_hilang = isset($arr_hilang->satuan)?$arr_hilang->satuan:'Jiwa';
                echo '<td align="center">'.$val_hilang.' '.$sat_hilang.'</td>';

                // terdampak
                $arr_terdampak = json_decode($row_korban->terdampak);
                $val_terdampak = isset($arr_terdampak->value)?$arr_terdampak->value:$row_korban->terdampak;
                $sat_terdampak = isset($arr_terdampak->satuan)?$arr_terdampak->satuan:'Jiwa';
                echo '<td align="center">'.$val_terdampak.' '.$sat_terdampak.'</td>';
                
              ?>
              </tr>
              <tr><td colspan="5"><?php echo $row_korban->keterangan?></td></tr>
            </table>
            <?php 
                endforeach; 
              else: 
                echo '-Tidak ada data-';
            endif;
            ?>
      </td>
    </tr>

    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><td colspan="2"><br><b>DAMPAK KERUSAKAN</b></td></tr>
    <tr>
      <td colspan="2" align="left">
        <table border="1" width="100%">
          <tr style="background-color: grey; color: white; height: 50px !important; font-weight: bold">
            <th width="35%"> Tanggal</th>
            <th width="35%"> Deskripsi</th>
            <th width="25%"> Kategori</th>
            <th width="20%"> Jumlah</th>
          </tr>
          <?php if(count($dampak > 0 )) : foreach($dampak as $row_dampak) :?>
          <tr>
            <td> <?php echo $this->tanggal->formatDateFormDmy($row_dampak->tanggal).' '.$row_dampak->jam.' '.$row_dampak->zona_waktu?></td>
            <td> <?php echo $row_dampak->kategori_dampak?></td>
            <td> <?php echo $row_dampak->label?></td>
            <td align="center"> <?php echo $row_dampak->value.' '.$row_dampak->satuan?></td>
          </tr>
          <?php 
              endforeach; 
            else: echo '<tr><td colspan="4">-Tidak ada data-</td></tr>';
          endif;
          ?>
        </table>
      </td>
    </tr>
    
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><td colspan="2"><br><b>PERKEMBANGAN BENCANA</b></td></tr>
    <tr>
      <td colspan="2" align="left">
        <table border="0" width="100%">
          <?php 
            if(count($perkembangan > 0 )) :
            foreach($perkembangan as $row_perkembangan) :?>
          <tr>
            <td width="30%">Tanggal</td>
            <td width="70%">: <?php echo $this->tanggal->formatDateFormDmy($row_perkembangan->tanggal).' '.$row_perkembangan->waktu.' '.$row_perkembangan->zona_waktu?></td>
          </tr>
          <tr>
            <td>Kendala</td>
            <td>: <?php echo $row_perkembangan->kendala?></td>
          </tr>
          <tr>
            <td>Kondisi Mutakhir</td>
            <td>: <?php echo $row_perkembangan->kondisi?></td>
          </tr>
          <tr>
            <td>Kebutuhan</td>
            <td>: <?php echo $row_perkembangan->kebutuhan?></td>
          </tr>
          <tr><td colspan="2"><hr></td></tr>
          <?php 
              endforeach; 
            else: echo '<tr><td colspan="2">-Tidak ada data-</td></tr>';
          endif;
          ?>
          
        </table>
      </td>
    </tr>
  </table>
  <table width="100%">
    <tr>
      <td width="30%">&nbsp;</td>
      <td width="30%">&nbsp;</td>
      <td width="40%" align="center">
        Petugas Input<br><br><br><br><br>
        (
          <?php 
            $decode = json_decode($disaster->created_by);
            $exc_by = (is_object($decode) > 0) ? $decode->fullname : 'i Tangguh Sistem';
            echo $exc_by;
          ?>
        )
      </td>
    </tr>
  </table>
</body>
</html>