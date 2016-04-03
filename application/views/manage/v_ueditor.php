<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>static/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>static/ueditor/editor_api.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>static/ueditor/lang/zh-cn/zh-cn.js"></script>
</head>
<body>
    <script type="text/plain" id="myEditor" ></script>
    <script type="text/javascript">
    //根据容器的宽高
    //容器给定高度
    UE.getEditor('myEditor',{
        initialFrameWidth : 600,
        initialFrameHeight: 600
    });
</script>
</body>
</html>