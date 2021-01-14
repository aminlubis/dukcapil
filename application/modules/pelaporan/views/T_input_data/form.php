
<script>
    $(document).ready(function(){
      getMenuTabs('pelaporan/T_input_data/form_flag?flag=bayi&id=<?php echo isset($value)?$value->reg_id:''?>', 'tabs_load_content');
    })
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
    <!-- hidden form -->
    <input type="hidden" id="zona_waktu_hidden">
    
      <div class="widget-body">
        <div class="widget-main no-padding">
            <div class="tabbable">
              <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                <li class="active">
                    <a data-toggle="tab" data-url="pelaporan/T_input_data/form_flag?flag=bayi&id=<?php echo isset($value)?$value->reg_id:''?>" id="tabs_bayi" href="#" onclick="getMenuTabs(this.getAttribute('data-url'), 'tabs_load_content')" >
                      <i class="purple ace-icon fa fa-list bigger-120"></i>
                      <?php echo strtoupper('Data Bayi/Anak'); ?>
                    </a>
                </li>
                
                <li>
                    <a data-toggle="tab" data-url="pelaporan/T_input_data/form_flag?flag=ibu&id=<?php echo isset($value)?$value->reg_id:''?>" id="tabs_ibu" href="#" onclick="getMenuTabs(this.getAttribute('data-url'), 'tabs_load_content')" >
                      <i class="purple ace-icon fa fa-leaf bigger-120"></i>
                      <?php echo strtoupper('Data Ibu'); ?>
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" data-url="pelaporan/T_input_data/form_flag?flag=ayah&id=<?php echo isset($value)?$value->reg_id:''?>" id="tabs_ayah" href="#" onclick="getMenuTabs(this.getAttribute('data-url'), 'tabs_load_content')" >
                      <i class="purple ace-icon fa fa-user bigger-120"></i>
                      <?php echo strtoupper('Data Ayah'); ?>
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" data-url="pelaporan/T_input_data/form_flag?flag=pelapor&id=<?php echo isset($value)?$value->reg_id:''?>" id="tabs_pelapor" href="#" onclick="getMenuTabs(this.getAttribute('data-url'), 'tabs_load_content')" >
                      <i class="purple ace-icon fa fa-file bigger-120"></i>
                      <?php echo strtoupper('Data Pelapor'); ?>
                    </a>
                </li>
                <li>
                  <a data-toggle="tab" data-url="pelaporan/T_input_data/form_flag?flag=saksi_1&id=<?php echo isset($value)?$value->reg_id:''?>" id="tabs_saksi_1" href="#" onclick="getMenuTabs(this.getAttribute('data-url'), 'tabs_load_content')" >
                    <i class="purple ace-icon fa fa-folder bigger-120"></i>
                    <?php echo strtoupper('Data Saksi I (Satu)'); ?>
                  </a>
                </li>
                <li>
                  <a data-toggle="tab" data-url="pelaporan/T_input_data/form_flag?flag=saksi_2&id=<?php echo isset($value)?$value->reg_id:''?>" id="tabs_saksi_2" href="#" onclick="getMenuTabs(this.getAttribute('data-url'), 'tabs_load_content')" >
                    <i class="purple ace-icon fa fa-history bigger-120"></i>
                    <?php echo strtoupper('Data Saksi II (Dua)'); ?>
                  </a>
                </li>

                <li>
                  <a data-toggle="tab" data-url="pelaporan/T_input_data/form_flag?flag=administrasi&id=<?php echo isset($value)?$value->reg_id:''?>" id="tabs_administrasi" href="#" onclick="getMenuTabs(this.getAttribute('data-url'), 'tabs_load_content')" >
                    <i class="purple ace-icon fa fa-book bigger-120"></i>
                    <?php echo strtoupper('Data Administrasi'); ?>
                  </a>
                </li>
                
              </ul>
              <div class="tab-content">

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

              </div>
            </div>
        </div>
      </div>
    <!-- PAGE CONTENT ENDS -->
  </div><!-- /.col -->
</div><!-- /.row -->

