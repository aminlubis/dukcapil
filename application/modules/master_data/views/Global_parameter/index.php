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

    <div class="clearfix" style="margin-bottom:-5px">
      <?php echo $this->authuser->show_button('master_data/Global_parameter?flag='.$flag_string.'','C','',7)?>
      <?php echo $this->authuser->show_button('master_data/Global_parameter?flag='.$flag_string.'','D','',5)?>
      <div class="pull-right tableTools-container"></div>
    </div>
    <hr class="separator">
    <!-- div.table-responsive -->

    <!-- div.dataTables_borderWrap -->
    <div style="margin-top:-27px">
      <table id="dynamic-table" base-url="master_data/Global_parameter" data-id="flag=<?php echo $flag_string?>" url-detail="master_data/Global_parameter/get_detail" class="table table-bordered table-hover">

       <thead>
        <tr>  
          <th width="30px" class="center"></th>
          <th width="40px" class="center"></th>
          <th width="40px" class="center"></th>
          <th width="40px"></th>
          <th width="70px">ID</th>
          <th>Label</th>
          <th>Value</th>
          <th width="100px">Status</th>
          <th width="180px">Last Update</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
    </div>
  </div><!-- /.col -->
</div><!-- /.row -->


<script src="<?php echo base_url().'assets/js/custom/als_datatable_with_detail_custom_url.js'?>"></script>



