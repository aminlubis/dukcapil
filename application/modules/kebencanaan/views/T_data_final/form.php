<script>
    $(document).ready(function(){
      getMenuTabs('kebencanaan/T_bencana/form_data_awal/<?php echo isset($value)?$value->id_bencana:''?>', 'tabs_load_content');
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
      <div class="widget-body">
        <div class="widget-main no-padding">
            <div class="tabbable">
              <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                <li class="active">
                    <a data-toggle="tab" data-url="kebencanaan/T_bencana/form_data_awal/<?php echo isset($value)?$value->id_bencana:''?>?readonly=true" id="tabs_bencana_data_awal" href="#" onclick="getMenuTabs(this.getAttribute('data-url'), 'tabs_load_content')" >
                      <i class="purple ace-icon fa fa-list bigger-120"></i>
                      DATA AWAL SEMENTARA
                    </a>
                </li>
                <?php if( $flag != 'create' ) : ?>
                <li>
                    <a data-toggle="tab" data-url="kebencanaan/T_logistik?readonly=true&id_bencana=<?php echo isset($value)?$value->id_bencana:''?>" id="tabs_logistik" href="#" onclick="getMenuTabs(this.getAttribute('data-url'), 'tabs_load_content')" >
                      <i class="purple ace-icon fa fa-leaf bigger-120"></i>
                      LOGISTIK & PERALATAN
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" data-url="kebencanaan/T_personil?readonly=true&id_bencana=<?php echo isset($value)?$value->id_bencana:''?>" id="tabs_personil" href="#" onclick="getMenuTabs(this.getAttribute('data-url'), 'tabs_load_content')" >
                      <i class="purple ace-icon fa fa-user bigger-120"></i>
                      PERSONIL & RELAWAN
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" data-url="kebencanaan/T_korban?readonly=true&id_bencana=<?php echo isset($value)?$value->id_bencana:''?>" id="tabs_personil" href="#" onclick="getMenuTabs(this.getAttribute('data-url'), 'tabs_load_content')" >
                      <i class="purple ace-icon fa fa-file bigger-120"></i>
                      KORBAN BENCANA
                    </a>
                </li>
                <li>
                  <a data-toggle="tab" data-url="kebencanaan/T_dokumentasi?readonly=true&id_bencana=<?php echo isset($value)?$value->id_bencana:''?>" id="tabs_dokumentasi_bencana" href="#" onclick="getMenuTabs(this.getAttribute('data-url'), 'tabs_load_content')" >
                    <i class="purple ace-icon fa fa-folder bigger-120"></i>
                    DOKUMENTASI
                  </a>
                </li>
                <li>
                  <a data-toggle="tab" data-url="kebencanaan/T_perkembangan?readonly=true&id_bencana=<?php echo isset($value)?$value->id_bencana:''?>" id="tabs_dokumentasi_bencana" href="#" onclick="getMenuTabs(this.getAttribute('data-url'), 'tabs_load_content')" >
                    <i class="purple ace-icon fa fa-history bigger-120"></i>
                    PERKEMBANGAN BENCANA
                  </a>
                </li>
                <?php endif;?>
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
