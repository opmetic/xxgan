<html>
<head>
<title></title>
{literal}
<script type="text/javascript">
function outCall(tel)
{
    alert(tel);
    //setTimeout("parent.makeOutCall(" + tel + ");", 1000); 
    setTimeout("parent.makeOutCall(" + tel + ");", 1000); 
    //parent.makeOutCall(tel);
}
</script>
{/literal}
</head>

<body>

<a href="#" onclick="outCall('13595694690');">13595694690</a>
</body>
</html>