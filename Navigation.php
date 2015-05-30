<html>
<head><link rel="stylesheet" type="text/css" href="Style.css"></head>
<body>
	<ul class="Navigation">
		<?php
			$Pages_List=array('Login','Register','Student','Profesor','Assigment','Homework','Test','Calendar');
			Create_Html($Pages_List);
		?>
	</ul>

</body>
</html>

<?php
	function Create_Html($Array)
	{
		if(isset($Array))
		{
			foreach ($Array as $Page) 
			{
				echo "<li><form class='Control' action={$Page}.php method='post' name={$Page}><input type='submit' value={$Page}></form></li>";
			}
		}
	}
?>