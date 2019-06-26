<?php
if($_FILES){
        $upload_path = "upload_file/";
        $code = $_FILES['file']['error'];
        $file_name = $_FILES["file"]["name"];
		
        if($code != 0){
                switch($code){
                        case 1:
                                $msg = "文件过大,文件大小超出 php.ini 中 upload_max_filesize 指定值!";
                                break;
                        case 2:
                                $msg = "文件过大,文件大小超出表单 MAX_FILE_SIZE 指定值!";
                                break;
                        case 3:
                                $msg = "文件只有部分被上传!";
                                break;
                        case 4:
                                $msg = "没有文件被上传!";
                                break;
                        case 6:
                                $msg = "找不到临时文件夹!";
                                break;
                        case 7:
                                $msg = "文件写入失败!";
                                break;
                        default:
                                $msg = "未知错误,错误代码:" . $code;
                }
                
        } else if(!is_dir($upload_path)) {
			$code = 8;
			$msg = "文件上传路径出错,请联系网站管理员检查!";
		} else if(file_exists($upload_path . $file_name)) {
			$code = 9;
			$msg = $file_name." 文件已存在!";
		} else {
                move_uploaded_file($_FILES["file"]["tmp_name"], $upload_path . $file_name);
				$msg = $file_name . " 已上传成功";
        }
}

function out_error($msg){
        echo "<span style='color:red'>" . $msg . "</span>";
}
function out_success($msg){
        echo "<span style='color:green'>" . $msg . "</span>";
}
?>
<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <title>File Uplaod System</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="renderer" content="webkit" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="//cdnjs.loli.net/ajax/libs/mdui/0.4.2/css/mdui.min.css" />
    <script src="//cdnjs.loli.net/ajax/libs/mdui/0.4.2/js/mdui.min.js"></script>
  </head>
  <body class="mdui-appbar-with-toolbar mdui-theme-primary-grey mdui-theme-accent-pink mdui-center">
  <div class="mdui-container-fluid">
    <!-- 应用栏 -->
    <header class="mdui-appbar mdui-appbar-fixed">
      <div class="mdui-toolbar mdui-color-grey-800">
      <span class="mdui-btn mdui-btn-icon mdui-ripple mdui-ripple-white"
      mdui-drawer="{target: &#39;#main-drawer&#39;, swipe: true}">
        <i class="mdui-icon material-icons">menu</i>
      </span> 
      <a href="./" class="mdui-typo-title">文件上传系统</a>
      <div class="mdui-toolbar-spacer"></div>
      <span class="mdui-btn mdui-btn-icon mdui-ripple mdui-ripple-white" mdui-tooltip="{content: &#39;文件系统&#39;}">
        <i class="mdui-icon material-icons">folder</i>
      </span></div>
    </header>
	
	<br />
	<div class="mdui-row">
	<div class="mdui-col-lg-6 mdui-col-offset-lg-3">	
    <!-- 卡片 -->
     <div class="mdui-card">
        <!-- 卡片的标题和副标题 -->
        <div class="mdui-card-primary">
          <div class="mdui-card-primary-title"><?php if(!isset($code))echo "请选择文件"; ?></div>
		  <div class="mdui-card-primary-title"><?php if(isset($code) && $code==0) out_success("上传成功");if(isset($code) && $code!=0) out_error("上传失败"); ?></div>
          <div class="mdui-card-primary-subtitle"><?php echo isset($code)? $msg:"文件大小限制最大为6M"; ?></div>
        </div>
		<div class="mdui-divider"></div>
        <!-- 卡片的内容 -->
        <div class="mdui-card-content">
			<form action="" method="post" enctype="multipart/form-data">
			<label class="mdui-textfield-label">请点击下面的按钮选择你要上传的文件</label>
			<input class="mdui-btn mdui-btn-raised mdui-ripple" type="file" name="file" /><br /><br />
			<input class="mdui-btn mdui-btn-block mdui-ripple mdui-color-theme" type="submit" value="立即上传" mdui-dialog="{target: '#uploadDialog'}" />
			</form>
        </div>
      </div>
	</div>
	</div>


    <!-- 抽屉式导航-->
    <div class="mdui-drawer mdui-drawer-close" id="main-drawer">
      <div class="mdui-list" mdui-collapse="{accordion: true}" style="margin-bottom: 76px;">
	  
        <div class="mdui-collapse-item">
          <div class="mdui-collapse-item-header mdui-list-item mdui-ripple"> 
			<i class="mdui-list-item-icon mdui-icon material-icons mdui-text-color-blue">home</i>
            <div class="mdui-list-item-content"><i class="mdui-icon"></i>开始使用</div>
            <i class="mdui-collapse-item-arrow mdui-icon material-icons">keyboard_arrow_down</i>
          </div>
          <div class="mdui-collapse-item-body mdui-list">
          <a href="./" class="mdui-list-item mdui-ripple">上传文件</a> 
        </div>       		
      </div>	  
	  <div class="mdui-collapse-item">
          <div class="mdui-collapse-item-header mdui-list-item mdui-ripple" mdui-dialog="{target: '#aboutDialog'}">
		  <i class="mdui-list-item-icon mdui-icon material-icons mdui-text-color-primary">info</i>
            <div class="mdui-list-item-content">关于</div>       
          </div>      		
      </div>	  
     </div>
	</div>


	<!-- 关于-->
	<div class="mdui-dialog" id="aboutDialog">
		<div class="mdui-tab mdui-tab-full-width" id="tabs">
			<h3 class="mdui-ripple mdui-center">关于本站</h3>
		</div>
		<div class="mdui-divider"></div>
		 <div id="example4-tab1" class="mdui-p-a-2" align="center">
		 <p>商丘学院8#101</p>
		 <p>&copy;2019 InSQU Inc. All Rights Reserved.</p>
		</div>
	</div>

	<!-- 上传提示-->
	<div class="mdui-dialog" id="uploadDialog">
	  <div class="mdui-dialog-title">请稍候</div>
	  <div class="mdui-progress">
  <div class="mdui-progress-indeterminate"></div>
</div>
	  <div class="mdui-dialog-content">
	  <span>当你看到这个界面时,就说明你的上传网速较慢或文件较大,请稍候文件的上传。</span><br />
	  <span>文件上传过程中请<b>不要</b>尝试其他操作！！！</span><br /><br />
	  <span>如果本页面超过1分钟未响应,请尝试手动刷新并重试。</span><br />	  
	  <h3>文件上传成功后 本对话框将自动关闭</h3>
	  </div>
	</div>

	
	</div>
  </body>
</html>
