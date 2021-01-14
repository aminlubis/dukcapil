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
    </div>
    <hr class="separator">
    <!-- div.table-responsive -->

    <!-- div.dataTables_borderWrap -->
    <div style="margin-top:-27px">
      <table id="dynamic-table" base-url="setting/Tmp_user_has_role" class="table table-bordered table-hover">
       <thead>
        <tr>  
          <th width="30px" class="center"></th>
          <th width="50px">&nbsp;</th>
          <th width="50px">ID</th>
          <th>Fullname</th>
          <th>Email</th>
          <th>Username</th>
          <th>User Group</th>
          <th>Status</th>
          <th width="100px">Last Update</th>
          
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
    </div>
  </div><!-- /.col -->
</div><!-- /.row -->


<script src="<?php echo base_url().'assets/js/custom/als_datatable.js'?>"></script>


