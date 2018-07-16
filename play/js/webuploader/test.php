<?php 
require 'public.php';
require 'head.php';
?>

<div id="uploader" class="wu-example">
    <!--用来存放文件信息-->
    <div id="thelist" class="uploader-list"></div>
    <div class="btns">
        <div id="picker">选择文件</div>
        <div id="dndArea" class="placeholder" style="width:200px;height:100px;background:grey;">
            <div id="filePicker"></div>
            <p>或将照片拖到这里，单次最多可选300张</p>
        </div>
        <button id="ctlBtn" class="btn btn-default">开始上传</button>
    </div>
</div>

<link rel="stylesheet" type="text/css" href="<?php echo TEST_URL.'/public/js/webuploader/webuploader.css';?>">
<script src="<?php echo TEST_URL.'/public/js/webuploader/webuploader.js';?>"></script>
<script>
var uploader = WebUploader.create({
    // swf文件路径
	swf: TEST_URL + '/public/js/webuploader/Uploader.swf',
    // 文件接收服务端。
    server: URL,
    // 选择文件的按钮。可选。
    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
    pick: {
        id: '#picker',
        label: '请选择文件',
        multiple: false
    },
    dnd: '#dndArea',
    disableGlobalDnd: true,
    accept: {
        title: 'Images',
        extensions: 'gif,jpg,jpeg,bmp,png',
        mimeTypes: 'image/*'
    },
    // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
    resize: false
});
</script>