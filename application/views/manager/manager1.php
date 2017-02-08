<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<base href="<?php  echo base_url();?>" />
<title>培训机构后台登录</title>
<link href="res/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="res/css/font-awesome.min.css" />

<link rel="stylesheet" href="res/css/jquery-ui-1.10.3.full.min.css" />
<link rel="stylesheet" href="res/css/datepicker.css" />
<link rel="stylesheet" href="res/css/ui.jqgrid.css" />

<link rel="stylesheet" href="res/css/ace.min.css" />
<link rel="stylesheet" href="res/css/ace-rtl.min.css" />
<link rel="stylesheet" href="res/css/ace-skins.min.css" />
<script src="res/js/ace-extra.min.js"></script>

<script src="res/js/jquery-2.0.3.min.js"></script>
<script src="res/js/bootstrap.min.js"></script>
<script src="res/js/typeahead-bs2.min.js"></script>

<script src="res/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="res/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="res/js/jqGrid/i18n/grid.locale-en.js"></script>

<script src="res/js/ace-elements.min.js"></script>
<script src="res/js/ace.min.js"></script>
<script src="res/js/ace-extra.min.js"></script>
<script src="res/js/jquery-ui-1.10.3.full.min.js"></script>
<script src="res/js/jquery.ui.touch-punch.min.js"></script>

<script type="text/javascript">
			var $path_base = "/";//this will be used in gritter alerts containing images
			var grid_selector = "#grid-table";
				var pager_selector = "#grid-pager";
			$(document).ready(
	           function(){
				     $(window).resize(function(){   
                     $(grid_selector).setGridWidth($(window).width()-50);
                   });
				
					$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
					_title: function(title) {
						var $title = this.options.title || '&nbsp;'
						if( ("title_html" in this.options) && this.options.title_html == true )
							title.html($title);
						else title.text($title);
					}
				}));
				jQuery(grid_selector).jqGrid({
					url:"index.php/manager/managerList",
					datatype:"json",
					mtype:"POST",
					height: "auto",
					colNames:['id','姓名','帐号','添加时间'],
					colModel:[
						{name:'id',index:'id', width:30},
						{name:'nickname',index:'nickname',width:60,sortable:false},
						{name:'username',index:'username', width:60,sortable:false},
						{name:'password',index:'password', width:60,sortable:false} 
					], 
			        sorttable:true,
			        sortname:"id",
			        sortorder:"asc",
			       	pager : pager_selector,
					pgtext:"第 {0} 页 共  {1} 页",
					recordtext: "显示 {0} - {1} 共 {2} 条",
                    emptyrecords: "没有记录",
					viewrecords : true,
                   loadtext: "加载中...",
					altRows: true,
					multiselect: true,
			        multiboxonly: true,
					loadComplete : function() {
						var table = this;
						setTimeout(function(){
							styleCheckbox(table);
							updateActionIcons(table);
							updatePagerIcons(table);
							enableTooltips(table);
						}, 0);
					},
					caption: "用户数据列表",
					autowidth: true
				});
			
				function aceSwitch( cellvalue, options, cell ) {
					setTimeout(function(){
						$(cell) .find('input[type=checkbox]')
								.wrap('<label class="inline" />')
							.addClass('ace ace-switch ace-switch-5')
							.after('<span class="lbl"></span>');
					}, 0);
				}
				//enable datepicker
				function pickDate( cellvalue, options, cell ) {
					setTimeout(function(){
						$(cell) .find('input[type=text]')
								.datepicker({format:'yyyy-mm-dd' , autoclose:true}); 
					}, 0);
				}
			
			
				//navButtons
				jQuery(grid_selector).jqGrid('navGrid',pager_selector,
					{ 	//navbar options
						search: false,
						searchicon : 'icon-search orange',
						refresh: true,
						refreshicon : 'icon-refresh green',
						edit:false,
						add:false,
						del:false
					},
					{
						recreateForm: true,
						beforeShowForm : function(e) {
							var form = $(e[0]);
							form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
							style_edit_form(form);
						}
					},
					{
						closeAfterAdd: true,
						recreateForm: true,
						viewPagerButtons: false,
						beforeShowForm : function(e) {
							var form = $(e[0]);
							form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
							style_edit_form(form);
						}
					},
					{
						//delete record form
						recreateForm: true,
						beforeShowForm : function(e) {
							var form = $(e[0]);
							if(form.data('styled')) return false;
							
							form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
							style_delete_form(form);
							
							form.data('styled', true);
						},
						onClick : function(e) {
						}
					},
					{
						//search form
						recreateForm: true,
						afterShowSearch: function(e){
							var form = $(e[0]);
							form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
							style_search_form(form);
						},
						afterRedraw: function(){
							style_search_filters($(this));
						}
						,
						multipleSearch: true
					},
					{
						//view record form
						recreateForm: true,
						beforeShowForm: function(e){
							var form = $(e[0]);
							form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
						}
					}
				).jqGrid('navButtonAdd',pager_selector,
				{ 
				caption:"", 
				buttonicon:"icon-edit orange",
				 onClickButton:function(){
				 
				 var id=$(grid_selector).jqGrid("getGridParam","selrow");
				 if(id==null){
				    talert("请先选择行");
				 }else{
				             $.ajax({
                      url :"manager/getManagerById.do",
                      type :"post",
                       dataType :"json",
                      data:{id:$(grid_selector).jqGrid("getGridParam","selrow")},
                      success :function(adata){
                            $("#userid").val(adata.id);
                            $("#username").val(adata.username);
                            $("#password").val(adata.password);
                            $("#re_password").val(adata.password);
                            $("#nickname").val(adata.nickname);
                         savaData();
                      
                                }
                               });
				    
				    
				 }
				 
				 },
				  position: "first",
				   title:"", 
				   cursor: "pointer"}
				   ).jqGrid('navButtonAdd',pager_selector,
				{ 
				caption:"", 
				buttonicon:"icon-plus-sign green",
				 onClickButton:function(){
                         savaData();
                         				  
				 },
				  position: "first",
				   title:"", 
				   cursor: "pointer"}
				   );
			
			  
			  
				
				function style_edit_form(form) {
					//enable datepicker on "sdate" field and switches for "stock" field
					form.find('input[name=sdate]').datepicker({format:'yyyy-mm-dd' , autoclose:true})
						.end().find('input[name=stock]')
							  .addClass('ace ace-switch ace-switch-5').wrap('<label class="inline" />').after('<span class="lbl"></span>');
			
					//update buttons classes
					var buttons = form.next().find('.EditButton .fm-button');
					buttons.addClass('btn btn-sm').find('[class*="-icon"]').remove();//ui-icon, s-icon
					buttons.eq(0).addClass('btn-primary').prepend('<i class="icon-ok"></i>');
					buttons.eq(1).prepend('<i class="icon-remove"></i>')
					
					buttons = form.next().find('.navButton a');
					buttons.find('.ui-icon').remove();
					buttons.eq(0).append('<i class="icon-chevron-left"></i>');
					buttons.eq(1).append('<i class="icon-chevron-right"></i>');		
				}
			
				function style_delete_form(form) {
					var buttons = form.next().find('.EditButton .fm-button');
					buttons.addClass('btn btn-sm').find('[class*="-icon"]').remove();//ui-icon, s-icon
					buttons.eq(0).addClass('btn-danger').prepend('<i class="icon-trash"></i>');
					buttons.eq(1).prepend('<i class="icon-remove"></i>')
				}
				
				function style_search_filters(form) {
					form.find('.delete-rule').val('X');
					form.find('.add-rule').addClass('btn btn-xs btn-primary');
					form.find('.add-group').addClass('btn btn-xs btn-success');
					form.find('.delete-group').addClass('btn btn-xs btn-danger');
				}
				function style_search_form(form) {
					var dialog = form.closest('.ui-jqdialog');
					var buttons = dialog.find('.EditTable')
					buttons.find('.EditButton a[id*="_reset"]').addClass('btn btn-sm btn-info').find('.ui-icon').attr('class', 'icon-retweet');
					buttons.find('.EditButton a[id*="_query"]').addClass('btn btn-sm btn-inverse').find('.ui-icon').attr('class', 'icon-comment-alt');
					buttons.find('.EditButton a[id*="_search"]').addClass('btn btn-sm btn-purple').find('.ui-icon').attr('class', 'icon-search');
				}
				
				function beforeDeleteCallback(e) {
					var form = $(e[0]);
					if(form.data('styled')) return false;
					
					form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
					style_delete_form(form);
					
					form.data('styled', true);
				}
				
				function beforeEditCallback(e) {
					var form = $(e[0]);
					form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
					style_edit_form(form);
				}
			
			
			
				//it causes some flicker when reloading or navigating grid
				//it may be possible to have some custom formatter to do this as the grid is being created to prevent this
				//or go back to default browser checkbox styles for the grid
				function styleCheckbox(table) {
				/**
					$(table).find('input:checkbox').addClass('ace')
					.wrap('<label />')
					.after('<span class="lbl align-top" />')
			
			
					$('.ui-jqgrid-labels th[id*="_cb"]:first-child')
					.find('input.cbox[type=checkbox]').addClass('ace')
					.wrap('<label />').after('<span class="lbl align-top" />');
				*/
				}
				
			
				//unlike navButtons icons, action icons in rows seem to be hard-coded
				//you can change them like this in here if you want
				function updateActionIcons(table) {
				}
				
				//replace icons with FontAwesome icons like above
				function updatePagerIcons(table) {
					var replacement = 
					{
						'ui-icon-seek-first' : 'icon-double-angle-left bigger-140',
						'ui-icon-seek-prev' : 'icon-angle-left bigger-140',
						'ui-icon-seek-next' : 'icon-angle-right bigger-140',
						'ui-icon-seek-end' : 'icon-double-angle-right bigger-140'
					};
					$('.ui-pg-table:not(.navtable) > tbody > tr > .ui-pg-button > .ui-icon').each(function(){
						var icon = $(this);
						var $class = $.trim(icon.attr('class').replace('ui-icon', ''));
						
						if($class in replacement) icon.attr('class', 'ui-icon '+replacement[$class]);
					})
				}
			
				function enableTooltips(table) {
					$('.navtable .ui-pg-button').tooltip({container:'body'});
					$(table).find('.ui-pg-div').tooltip({container:'body'});
				}
			
			
			});
			
			function talert(str){
			 $( "#alert-text" ).html(str);
			  $( "#dialog-alert" ).removeClass('hide').dialog({
						resizable: false,
						modal: true,
						title: "<div class='widget-header'><h4 class='smaller'><i class='icon-question-sign yellow'></i> 提示 </h4></div>",
						title_html: true,
						buttons: [
							{
								html: "<i class='icon-remove bigger-110'></i>&nbsp;确定",
								"class" : "btn btn-xs",
								click: function() {
									$( this ).dialog( "close" );
								}
							}
						]
					});
			}
			function resetform(){
			$("#userid").val('0');
			$("#username").val('');
			$("#password").val('');
			$("#re_password").val('');
			$("#nickname").val('');
			}
			
			
			function savaData(){
					var dialog = $("#dialog-message").removeClass('hide').dialog({
						modal:true,
						title:'<div class="widget-header widget-header-small"><h4 class="smaller"><i class="icon-search"></i>查询</h4></div>',
                        title_html:true,
						buttons: [ 
							{
								text: "取消",
								"class" : "btn btn-xs",
								click: function() {
								resetform();
									$( this ).dialog("close" ); 
								} 
							},
							{
								text: "确定",
								"class" : "btn btn-primary btn-xs",
								click: function() {
									
									if($("#username").val().length<1 || $("#username").val().length >20){
									  talert("用户名必须在1-20个字符之间！");
									  return;
									}
									if($("#password").val().length<1 || $("#password").val().length>20){
									  talert("密码必须在1-20个字符之间！");
									  return;
									}
									if($("#password").val() != $("#re_password").val() ){
									  talert("两次密码必须输入一致！");
									  return;
									}
									if($("#nickname").val().length>20){
									  talert("真实姓名不能超过20个字符！");
									  return;
									}
									
								var	postData =  {
                                       userid:$("#userid").val(),
                                       username:$("#username").val(),
                                       password:$("#password").val(),
                                        nickname:$("#nickname").val()
                                       };
                                        $.ajax({
                      url :"manager/addManager.do",
                      type :"post",
                       dataType :"json",
                      data:postData,
                      success :function(data){
                         if(data.success==1){
                           jQuery(grid_selector).trigger("reloadGrid");
                         $( "#dialog-message" ).dialog( "close" ); 
                          resetform();
                          talert("保存成功");
                         }else{
                         talert(data.msg);
                         }
                                }
                               });
									
								} 
							}
						]
					});
			}
		</script>

</head>

<body>
	<div class="page-content" style="height:100%;">
		<table id="grid-table"></table>
		<div id="grid-pager"></div>
	</div>
	<!-- /.page-content -->
	<div id="dialog-message" class="hide">
		<form class="form-horizontal" role="form">
			<input id="userid" type="hidden" value="0">
			<table>
				<tr>
					<td align="right"><font>用户名：</font></td>
					<td><input type="text" id="username"></td>
				</tr>
				<tr>
					<td align="right"><font>密码：</font></td>
					<td><input type="password" id="password"></td>
				</tr>
				<tr>
					<td align="right"><font>再次输入密码：</font></td>
					<td><input type="password" id="re_password"></td>
				</tr>
				<tr>
					<td align="right"><font>真实姓名：</font></td>
					<td><input type="text" id="nickname"></td>
				</tr>
			</table>

		</form>
	</div>

	<div id="dialog-confirm" class="hide">
		<div class="alert alert-info bigger-110">你要保存数据吗</div>
		<div class="space-6"></div>
		<p class="bigger-110 bolder center grey">
			<i class="icon-hand-right blue bigger-120"></i> 确定?
		</p>
	</div>

	<div id="dialog-alert" class="hide">
		<p class="bigger-110 bolder center grey">
			<i class="icon-hand-right blue bigger-120"></i> <span id="alert-text"></span>
		</p>
	</div>

</body>
</html>
