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

    <div class="clearfix" style="margin-bottom:-20px">
      <?php echo $this->authuser->show_button('posting/attachment','D','',5)?>
      <div class="pull-right tableTools-container"></div>
    </div>
    <hr class="separator">
    <!-- div.table-responsive -->

    <!-- div.dataTables_borderWrap -->
    <div style="margin-top:-20px">
      <table id="dynamic-table" class="table table-striped table-bordered table-hover">
       <thead>
        <tr>  
          <th width="30px"></th>
          <th width="30px" class="center">ID</th>
          <th width="100px" class="left">Title</th>
          <th width="70px" class="center">Owner</th>
          <th width="70px" class="left">Filename</th>
          <th width="70px" class="center">Size</th>
          <th width="70px" class="center">Type</th>
          <th width="70px" class="center">Created Date</th>
          <th width="70px" class="center">Download</th>
          <th width="70px" class="center">Delete</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
    </div>
  </div><!-- /.col -->
</div><!-- /.row -->


<script src="<?php echo base_url()?>/assets/js/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url()?>/assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
<script src="<?php echo base_url()?>/assets/js/dataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
<script src="<?php echo base_url()?>/assets/js/dataTables/extensions/ColVis/js/dataTables.colVis.js"></script>
<script src="<?php echo base_url().'assets/js/custom/posting/attachment.js'?>"></script>



