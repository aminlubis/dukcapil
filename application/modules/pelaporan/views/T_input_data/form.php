
<script>
    var reg_id = $('#reg_id').val();

    $(document).ready(function(){
      clickOnTabs('pelaporan/T_input_data/form_flag?flag=bayi&reg_id='+reg_id+'', 'tabs_bayi');

      oTable = $('#table-saved-data-input').DataTable({ 
          
          "processing": true, //Feature control the processing indicator.
          "serverSide": true, //Feature control DataTables' server-side processing mode.
          "ordering": false,
          "scrollX": false,
          "searching": false,
          "bInfo": false,
          "paging": false,
          // Load data for the table's content from an Ajax source
          "ajax": {
              "url": "pelaporan/T_input_data/get_data?reg_id="+reg_id+"",
              "type": "POST"
          },
    
        });

    })

    function clickOnTabs(link, tabs_id){
      $('#tabs_load_content').load(link+'&reg_id='+reg_id);
      if(tabs_id == 'tabs_administrasi'){
        $('#form-default').attr('action', 'pelaporan/T_input_data/process_adm');
      }else{
        $('#form-default').attr('action', 'pelaporan/T_input_data/process');
      }
    }

    function reset_table_data(){
      oTable.ajax.url("pelaporan/T_input_data/get_data?reg_id="+reg_id+"").load();

    }
</script>
<div class="page-header">
  <h1>
    <?php echo $title?>
    <small>
      <i class="ace-icon fa fa-angle-double-right"></i>
      <?php echo $breadcrumbs?>
    </small>
  </h1>
</div><!-- /.page-header -->

<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <p class="center">
      <span style="font-size: 20px">FORM PENGISIAN AKTA KELAHIRAN</span><br>
      Silahkan Lengkapi Form Pada Tabs Dibawah ini.
    </p>
    
    
      <div class="widget-body">
        <div class="widget-main no-padding">
            <div class="tabbable">
              <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                <li class="active">
                    <a data-toggle="tab" data-url="pelaporan/T_input_data/form_flag?flag=bayi" id="tabs_bayi" href="#" onclick="clickOnTabs(this.getAttribute('data-url'), 'tabs_bayi')" >
                      <i class="purple ace-icon fa fa-list bigger-120"></i>
                      <?php echo strtoupper('Data Bayi/Anak'); ?>
                    </a>
                </li>
                
                <li>
                    <a data-toggle="tab" data-url="pelaporan/T_input_data/form_flag?flag=ibu" id="tabs_ibu" href="#" onclick="clickOnTabs(this.getAttribute('data-url'), 'tabs_ibu')" >
                      <i class="purple ace-icon fa fa-leaf bigger-120"></i>
                      <?php echo strtoupper('Data Ibu'); ?>
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" data-url="pelaporan/T_input_data/form_flag?flag=ayah" id="tabs_ayah" href="#" onclick="clickOnTabs(this.getAttribute('data-url'), 'tabs_ayah')" >
                      <i class="purple ace-icon fa fa-user bigger-120"></i>
                      <?php echo strtoupper('Data Ayah'); ?>
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" data-url="pelaporan/T_input_data/form_flag?flag=pelapor" id="tabs_pelapor" href="#" onclick="clickOnTabs(this.getAttribute('data-url'), 'tabs_pelapor')" >
                      <i class="purple ace-icon fa fa-file bigger-120"></i>
                      <?php echo strtoupper('Data Pelapor'); ?>
                    </a>
                </li>
                <li>
                  <a data-toggle="tab" data-url="pelaporan/T_input_data/form_flag?flag=saksi_1" id="tabs_saksi_1" href="#" onclick="clickOnTabs(this.getAttribute('data-url'), 'tabs_saksi_1')" >
                    <i class="purple ace-icon fa fa-folder bigger-120"></i>
                    <?php echo strtoupper('Data Saksi I (Satu)'); ?>
                  </a>
                </li>
                <li>
                  <a data-toggle="tab" data-url="pelaporan/T_input_data/form_flag?flag=saksi_2" id="tabs_saksi_2" href="#" onclick="clickOnTabs(this.getAttribute('data-url'), 'tabs_saksi_2')" >
                    <i class="purple ace-icon fa fa-history bigger-120"></i>
                    <?php echo strtoupper('Data Saksi II (Dua)'); ?>
                  </a>
                </li>

                <li>
                  <a data-toggle="tab" data-url="pelaporan/T_input_data/form_flag?flag=administrasi" id="tabs_administrasi" href="#" onclick="clickOnTabs(this.getAttribute('data-url'), 'tabs_administrasi')" >
                    <i class="purple ace-icon fa fa-book bigger-120"></i>
                    <?php echo strtoupper('Data Administrasi'); ?>
                  </a>
                </li>
                
              </ul>
              <div class="tab-content">
                <form class="form-horizontal" method="post" id="form-default" action="<?php echo site_url('pelaporan/T_input_data/process')?>" enctype="multipart/form-data">
                <!-- hidden form -->
                  <input type="hidden" id="reg_id" name="reg_id">
                  <div id="tabs_load_content">
                    <div class="alert alert-block alert-success">
                        <p>
                          <strong>
                            <i class="ace-icon fa fa-check"></i>
                            Selamat Datang!
                          </strong> 
                          Silahkan klik tab di atas untuk menampilkan data!
                        </p>
                      </div>
                  </div>
                  <!-- <table id="table-saved-data-input" class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>  
                        <th style="background: black"  width="30px" class="center"></th>
                        <th style="background: black"  width="40px" class="center"></th>
                        <th style="background: black"  width="40px" class="center"></th>
                        <th style="background: black"  width="40px"></th>
                        <th style="background: black"  width="70px">ID</th>
                        <th style="background: black" >NIK</th>
                        <th style="background: black" >Nama Lengkap</th>
                        <th style="background: black" >Tgl Lahir</th>
                        <th style="background: black" >Status</th>
                        <th style="background: black"  width="180px">Last Update</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table> -->
                </form>
              </div>

            </div>
            
        </div>
      </div>
    <!-- PAGE CONTENT ENDS -->
  </div><!-- /.col -->
</div><!-- /.row -->

