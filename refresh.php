<script src="jquery.min.js"></script>

<div id="crawler"></div>

<script>
setInterval(function(){
 $('#crawler').load('mdie/crawl.php');
}, 60000)
</script>
