<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <title></title>
    <script type="text/javascript" charset="utf-8" src="ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="editor_api.js"></script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <script type="text/javascript" charset="utf-8" src="lang/zh-cn/zh-cn.js"></script>

</head>
<body>
<script type="text/plain" id="myEditor1" ></script>
<script type="text/javascript">
    //根据容器的宽高
    //容器给定高度
    UE.getEditor('myEditor1',{
        initialFrameWidth : 600,
        initialFrameHeight: 600
    });
</script>
</body>
</html>
