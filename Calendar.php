<?php include_once "Navigation.php" ?>
<html>
<head><link rel="stylesheet" type="text/css" href="Style.css"></head>
<form method="post">
<ul>
	<li><input type="submit" name="Back" value="Back"></li>
	<li><input type="submit" name="Next" value="Next"></li>
	<li><input type="submit" name="Present" value="Present"></li>
</ul>

</form>
</html>


<?php
session_start();

	$Unavailable=true;  //variabila pentru verificarea zilelor disponibile din luna curenta

	if(!isset($_SESSION['Month']))     //verificam daca luna este setata in Sesiune daca nu setam cu luna curenta
	{
		$_SESSION['Month']=date('n');
	}
	if(!isset($_SESSION['Year']))      //verificam daca anul este setat in Sesiune daca nu setam cu anul curent
	{
		$_SESSION['Year']=date('o');
	}


	$Month=$_SESSION['Month'];      //Salvam acele valori in variabile pentru a le accesa in codul html
	$Year=$_SESSION['Year'];


	if(isset($_POST['Back']))      //Daca se apasa butonul back verificam daca este setata luna si daca este mai mare ca 1 
	{
		if(isset($_SESSION['Month']) && $_SESSION['Month']>1)    //Daca da se trece la luna precedenta si se salveaza in variabila
		{
			$_SESSION['Month']=$_SESSION['Month']-1;
			$Month=$_SESSION['Month'];
		}
		else
		{
			$_SESSION['Year']=$_SESSION['Year']-1;               //Daca nu se trece la anul precedent luna devine 12(Decembrie) si se salveaza in variabile
			$_SESSION['Month']=12;
			$Month=$_SESSION['Month'];
			$Year=$_SESSION['Year'];
		}

	}

	if(isset($_POST['Next']))                                    //opusul celor de mai sus 
	{
		if(isset($_SESSION['Month']) && $_SESSION['Month']<12)
		{
			$_SESSION['Month']=$_SESSION['Month']+1;
			$Month=$_SESSION['Month'];
		}
		else
		{
			$_SESSION['Year']=$_SESSION['Year']+1;
			$_SESSION['Month']=1;
			$Month=$_SESSION['Month'];
			$Year=$_SESSION['Year'];
		}

	}
	if(isset($_POST['Present']))						//Daca se apasa Present se duce la luna si anul curent si se salveaza in variabile
	{
		$_SESSION['Year']=date('o');//luna curenta
		$_SESSION['Month']=date('n');//anul curent
		$Month=$_SESSION['Month'];
		$Year=$_SESSION['Year'];
	}



	if($Month>1)
		$BeforeMonth=$Month-1;
	else
		$BeforeMonth=12;

	$DaysInMonthBefore=cal_days_in_month ( CAL_GREGORIAN, $BeforeMonth , $Year);
	$DaysInMonth=cal_days_in_month ( CAL_GREGORIAN, $Month , $Year);
	






	$date=$Year."/".$BeforeMonth."/".$DaysInMonthBefore;
	$DayPosition=date('N',strtotime($date));
	$contor=$DaysInMonthBefore-($DayPosition%7);

	echo "Data: ".$date."<br>";
	echo "Position of day: ".$DayPosition."<br>";

	
	

	echo $Month."<br>";
	echo $Year."<br>";
	echo "Number of days of Month Before this: ".$DaysInMonth."<br>";
	echo "Starting Date: ".$contor."<br>";


	$day_name=array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
    $Months=array('January','February','March','April','May','June','July','August','September','October','November','December');
    echo "<form method='post'>";
    echo "<table class='Calendar' BORDER=3 CELLSPACING=1 CELLPADDING=1>";
	echo "<tr><td COLSPAN='7' ALIGN=center><B>{$Months[$Month-1]} {$Year} </B></td></tr>";
	echo "<tr><td COLSPAN='7' ALIGN=center><I>Another year comes to an end</I></td></tr>";
	echo "<tr>";

	foreach ($day_name as $day) 
	{
		echo "<td align=center>{$day}</td>";	
	}
	echo "</tr>";

    $ContorLimit=$DaysInMonthBefore;
    $MonthDisplay=$BeforeMonth;



    for ($i=0; $i <6 ; $i++) { 
    	echo "<tr>";
    	for ($j=0; $j <7 ; $j++) { 
    		if($Unavailable)
    			if($MonthDisplay==12)
    			{
    				$LastYear=$Year-1;
    				Display($contor,$MonthDisplay,$LastYear,false);
    			}
    			else
    			{
    				if($MonthDisplay==13)
    				{
    					$NewYear=$Year+1;
    					Display($contor,$MonthDisplay,$NewYear,false);
    				}
    				else
    					Display($contor,$MonthDisplay,$Year,false);
    			}
    		else
    			Display($contor,$Month,$Year,true);

    		if($contor<$ContorLimit)
    		{
    			$contor=$contor+1;
    		}	
    		else
    		{
    			
    			if($Unavailable==false)
    				{
    					$Unavailable=true;
    					$MonthDisplay=$Month+1;
    				}
    			else
    				$Unavailable=false;

    			$contor=1;
    			$ContorLimit=$DaysInMonth;
    		}
    	
    	}
    	
    	
    }
    echo "</tr>";
    echo "</form>";
?>
<?php
	function Display($Day,$Month,$Year,$available)
	{
		if($available==true)
			echo "<td class='Available' ><pre>{$Day}</pre></td>";
		else
			echo "<td class='Unavailable' ><pre>{$Day}</pre></td>";
	}
?>