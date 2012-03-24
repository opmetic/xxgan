<?php /* Smarty version 2.6.20, created on 2011-01-18 09:57:48
         compiled from test.tpl */ ?>
<html>
<head>
<title></title>
<?php echo '
<script type="text/javascript">
function outCall(tel)
{
    alert(tel);
    //setTimeout("parent.makeOutCall(" + tel + ");", 1000); 
    setTimeout("parent.makeOutCall(" + tel + ");", 1000); 
    //parent.makeOutCall(tel);
}
</script>
'; ?>

</head>

<body>

<a href="#" onclick="outCall('13595694690');">13595694690</a>
</body>
</html>