jQuery(function($) {
    var grid_selector = "#grid-table";
    var pager_selector = "#grid-pager";
    
    //resize to fit page size
    $(window).on('resize.jqGrid', function () {
      $(grid_selector).jqGrid( 'setGridWidth', $(".page-content").width() );
    })

    //resize on sidebar collapse/expand
    var parent_column = $(grid_selector).closest('[class*="col-"]');
    $(document).on('settings.ace.jqGrid' , function(ev, event_name, collapsed) {
      if( event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed' ) {
        //setTimeout is for webkit only to give time for DOM changes and then redraw!!!
        setTimeout(function() {
          $(grid_selector).jqGrid( 'setGridWidth', parent_column.width() );
        }, 0);
      }
    })
    
    jQuery(grid_selector).jqGrid({
      //direction: "rtl",
      
      url:'jqgrid/get_data', 
      mtype: 'POST',
      emptyrecords: 'Tidak ada data',
      datatype: "json",
      jsonReader: {
            page: "page",
            total: "totalPages",
            records: "records",
            root: "rows",
            cell: "",
            id: "0"
        },

      height: 'auto',
      colNames:['ID','Name','Class', 'Link', 'Icon','Parent ID','Last Update','Action'],
      colModel:[
        
        {name:'id',index:'id', width:60, sorttype:"int"},
        {name:'name',index:'name', width:150},
        {name:'class',index:'class',width:90},
        {name:'link',index:'link', width:70},
        {name:'icon',index:'icon', width:90},
        {name:'parent',index:'parent', width:150},
        {name:'updated_date',index:'updated_date', sorttype:"date", width:150},
        {name:'myid',index:'myid', sorttype:"int", width:80, formatter:formatterAction},

      ], 
  
      viewrecords : true,
      rowNum:5,
      rowList:[5,10,20,30],
      pager : pager_selector,
      
      beforeRequest:function(){
        search_by=$('#search_by').val()?$('#search_by').val():'';
        keyword=$('#keyword').val()?$('#keyword').val():'';
        $(grid_selector).setGridParam({postData:{'search_by':search_by,'keyword':keyword}})
      },

      /*beforeSelectRow: function(rowid, e) {
          return false;
      },*/

      altRows: false,
      multiselect: true,
      multiboxonly: true,

      //subgrid options
      subGrid : true,
      subGridOptions : {
      plusicon : "ace-icon fa fa-plus center bigger-110 blue",
      minusicon  : "ace-icon fa fa-minus center bigger-110 blue",
      openicon : "ace-icon fa fa-chevron-right center orange"
      },
      //for this example we are using local data
      subGridRowExpanded: function (subgridDivId, rowId) {
        var rowval = $(grid_selector).jqGrid('getRowData', rowId);
        var parent_id = rowval.id;
        var name_data = rowval.name;

        var subgridTableId = subgridDivId + "_t";
        var htm='';
        htm += '<br><h5><b>Submenu '+name_data+'</b></h5>';
        htm += "<table id='" + subgridTableId + "'></table>";

        $("#" + subgridDivId).html(htm);
        $("#" + subgridTableId).jqGrid({

          url:'jqgrid/get_sub_data', 
          rownumbers:true,
          mtype: 'POST',
          datatype: "json", 
          colNames: ['No','Item Name','Qty', 'Action'],
          colModel: [
            { name: 'id', width: 50 },
            { name: 'name', width: 150 },
            { name: 'qty', width: 50 },
            {name:'mysubid',index:'mysubid', sorttype:"int", width:80, formatter:formatterAction},
          ],

          beforeRequest:function(){
            $('#'+subgridTableId).setGridParam({postData:{'parent':parent_id}})
          },

        });
      },
      
      loadComplete : function() {
        var table = this;
        setTimeout(function(){
        updatePagerIcons(table);
        }, 0);
      },

      autowidth: true,
      height: '100%',
  
    });

    $(window).triggerHandler('resize.jqGrid');//trigger window resize to make the grid get the correct size
    
    // BUTTON SEARCH //
    $('#btn_search_ex_master').click(function (event) {
       event.preventDefault();
        $(grid_selector).trigger("reloadGrid");
    });

    // BUTTON RESET //
    $('#btn_reset_ex_master').click(function (event) {
      event.preventDefault();
      $('#form_ex_reference')[0].reset();
      $(grid_selector).trigger("reloadGrid");
    });

    // BUTTON ADD //
    $('#btn_add_menu').click(function () {
      $('#page-area-content').html(loading);
      $('#page-area-content').load('jqgrid/form/'+ '?_=' + (new Date()).getTime());
    });

    // FORMATTER ACTION //
    function formatterAction(cellvalue, options, rowObject) {
      var content = '';
      content  += '<a rel="' + cellvalue + '" class="btn btn-sm-action btn-primary" onclick="edit('+cellvalue+')" title="Edit"><i class="fa fa-pencil"></i></a> ';
      content  += '<a rel="' + cellvalue + '" class="btn btn-sm-action btn-danger" onclick="delete_data('+cellvalue+')" title="Delete"><i class="fa fa-trash-o"></i></a> ';
      return content;
    }

    // PAGER BUTTON
    jQuery(grid_selector).jqGrid('navGrid',pager_selector,
      {   //navbar options
        edit: false, editicon : 'ace-icon fa fa-pencil blue',
        add: false, addicon : 'ace-icon fa fa-plus-circle purple',
        del: false, delicon : 'ace-icon fa fa-trash-o red',
        search: false, searchicon : 'ace-icon fa fa-search orange',
        refresh: true, refreshicon : 'ace-icon fa fa-refresh green',
        view: false, viewicon : 'ace-icon fa fa-search-plus grey',
      }
    )

    //replace icons with FontAwesome icons like above
    function updatePagerIcons(table) {
      var replacement = 
      {
        'ui-icon-seek-first' : 'fa fa-angle-double-left bigger-140',
        'ui-icon-seek-prev' : 'fa fa-angle-left bigger-140',
        'ui-icon-seek-next' : 'fa fa-angle-right bigger-140',
        'ui-icon-seek-end' : 'fa fa-angle-double-right bigger-140'
      };
      $('.ui-pg-table:not(.navtable) > tbody > tr > .ui-pg-button > .ui-icon').each(function(){
        var icon = $(this);
        var $class = $.trim(icon.attr('class').replace('ui-icon', ''));
        
        if($class in replacement) icon.attr('class', 'ui-icon '+replacement[$class]);
      })
    }
  
    
  });
  

  function backlist(){
    $('#page-area-content').html(loading);
    $('#page-area-content').load('jqgrid?_=' + (new Date()).getTime());
  }

  function edit(id){
    $('#page-area-content').html(loading);
    $('#page-area-content').load('jqgrid/form/'+ id + '?_=' + (new Date()).getTime());
  }

  function delete_data(id){
    //achtungShowLoader();
    if(confirm('Apakah anda yakin akan menghapus data ini?'))
      {
        // ajax delete data to database
          $.ajax({
            url: 'jqgrid/ajax_delete',
            type: "post",
            data: {ID:id},
            dataType: "json",
            success: function(data) {
              greatComplete(data);
              backlist();
            },
            error: function(xhr, ajaxOptions, thrownError){
              greatComplete({message:'Error code '+xhr.status+' : '+thrownError, gritter:'gritter-error'});
            },
          });
         
      }

    
  }


$.validator.setDefaults({
  submitHandler: function() { 
    
     url = "jqgrid/ajax_add";

       // ajax adding data to database
          $.ajax({
            url : url,
            type: "POST",
            data: $('#form_jqgrid').serialize(),
            dataType: "JSON",

            success: function(data) {
              greatComplete(data);
              backlist();
            },
            error: function(xhr, ajaxOptions, thrownError){
              greatComplete({message:'Error code '+xhr.status+' : '+thrownError, gritter:'gritter-error'});
            },

        });

  }

});

function disabledBtn()
  {
    $('#btnSave').disabled = true;
    return true;
  }


// jquery validation //
$().ready(function() {

  // validate signup form on keyup and submit
  $("#form_jqgrid").validate({
    rules: {
      
      name: {
        required: true,
        maxlength: 30
      },
      link: {
        required: true
      },
      counter: {
        required: true,
        number: true
      },
      active: "required"

    },

    messages: {
      name: {
        required: "Masukan nama menu!",
        manlength: "Nama menu harus diisi maksimal 30 karaketer"
      },
      link: {
        required: "Masukan link!"
      },
      counter: {
        required: "Masukan counter!",
        number: "Counter harus diisi dengan angka!"
      },
    }
  });


});


 