<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
?>
<!DOCTYPE html>
<html>
<head>
<base href="<?php  echo base_url();?>" />

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>H+ 后台主题UI框架 - jqGird</title>
<meta name="keywords" content="H+后台主题,后台bootstrap框架,会员中心主题,后台HTML,响应式后台">
<meta name="description"
	content="H+是一个完全响应式，基于Bootstrap3最新版本开发的扁平化主题，她采用了主流的左右两栏式布局，使用了Html5+CSS3等现代技术">

<link rel="shortcut icon" href="favicon.ico">
<link href="res/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
<link href="res/css/font-awesome.css?v=4.4.0" rel="stylesheet">

<!-- jqgrid-->
<link href="res/css/plugins/jqgrid/ui.jqgrid.css?0820" rel="stylesheet">

<link href="res/css/animate.css" rel="stylesheet">
<link href="res/css/style.css?v=4.1.0" rel="stylesheet">

<style>
/* Additional style to fix warning dialog position */
#alertmod_table_list_2 {
	top: 900px !important;
}
</style>

</head>

<body class="gray-bg">
	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row">
			<div class="col-sm-12">
				<div class="ibox ">
					<div class="ibox-title">
						<h5>jQuery Grid Plugin – jqGrid</h5>
					</div>
					<div class="ibox-content">

						<div class="jqGrid_wrapper">
							<table id="table_list_2"></table>
							<div id="pager_list_2"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- 全局js -->
	<script src="res/js/jquery.min.js?v=2.1.4"></script>
	<script src="res/js/bootstrap.min.js?v=3.3.6"></script>



	<!-- Peity -->
	<script src="res/js/plugins/peity/jquery.peity.min.js"></script>

	<!-- jqGrid -->
	<script src="res/js/plugins/jqgrid/i18n/grid.locale-cn.js?0820"></script>
	<script src="res/js/plugins/jqgrid/jquery.jqGrid.min.js?0820"></script>

	<!-- 自定义js -->
	<script src="res/js/content.js?v=1.0.0"></script>

	<!-- Page-Level Scripts -->
	<script>
        $(document).ready(function () {

            $.jgrid.defaults.styleUI = 'Bootstrap';

            $("#table_list_2").jqGrid({
            	url:"index.php/manager/managerList",
				datatype:"json",
                height: 450,
                mtype:"POST",
                autowidth: true,
                shrinkToFit: true,
                jsonReader: {
                root:"rows", 
                page:"page", 
                total:"total",          //   很重要 定义了 后台分页参数的名字。
                records:"records", 
                repeatitems:false,
                id : "id"
                             },
                rowNum: 20,
                rowList: [10, 20, 30],
             	colNames:['id','姓名','帐号','密码'],
                colModel: [
                    {
                        name: 'id',
                        index: 'id',
                        width: 60,
                        sorttype: "int"
                    },
                    {
                        name: 'nickname',
                        index: 'nickname',
                        width: 90
                    },
                    {
                        name: 'username',
                        index: 'username',
                        width: 100
                    },
                    {
                        name: 'password',
                        index: 'password',
                        editable: true
                    }
                ],
                pager: "#pager_list_2",
                pgtext:"第 {0} 页 共  {1} 页",
				recordtext: "显示 {0} - {1} 共 {2} 条",
                emptyrecords: "没有记录",
				viewrecords : true,
                loadtext: "加载中...",
                caption: "jqGrid 示例2",
                add: true,
                edit: true,
                addtext: 'Add',
                edittext: 'Edit',
                hidegrid: false
            });

            // Add selection
            $("#table_list_2").setSelection(4, true);

            // Setup buttons
            $("#table_list_2").jqGrid('navGrid', '#pager_list_2', {
                edit: true,
                add: true,
                del: true,
                search: true
            }, {
                height: 200,
                reloadAfterSubmit: true
            });

            // Add responsive to jqGrid
            $(window).bind('resize', function () {
                var width = $('.jqGrid_wrapper').width();
                $('#table_list_2').setGridWidth(width);
            });
        });
    </script>


</body>

</html>
