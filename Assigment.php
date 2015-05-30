<?php include_once "Navigation.php" ?>
<?php include_once "Composer.php" ?>
<?php session_start()?>

<html>
	<head>
		<title>Assigment</title>
	</head>
	<body>
		<pre class="Title">Assigment</pre>
		
		<form method='post'>
            <?php
            $Available=true;

            if(isset($_SESSION['user']) && $_SESSION['type']=="Profesor") {
                $query = new bdxe\CourseQuery();
                $query2 = new bdxe\ProfesorQuery();
                $Profesor=$query2->findOneByName($_SESSION['user']);
                $IdProfesor=$Profesor->getId();

                $MateriiDisponibile = $query->find();
                echo "<pre>Subject</pre>";
                echo "<select name='Materie'>";
                foreach ($MateriiDisponibile as $materie) {
                    if($materie->getProfesorId()==$IdProfesor) {
                        $Materie = $materie->getSubjectName();
                        $Available=false;
                        echo "<option value='{$Materie}' name='{$Materie}'>{$Materie}</option>";
                    }
                }
                if($Available)
                {
                    echo "<option value='None' name='Profesor'>None</option>";
                }

                echo "</select><br><br>";
            }
            ?>
			<nav>Size</nav><input type="number"  min=1 name="Size" placeholder="Person Allowed on project" value=3><br><br>
            <!--<nav>Dificultate</nav><input type="text" name="Dificultate" placeholder="Dificulty" value="Easy"><br><br> -->
            <nav>Dificultate</nav>
            <select name="Dificultate">
                <option>Easy</option>
                <option>Medium</option>
                <option>Hard</option>
            </select><br><br>
            <nav>Title</nav><input type="text" name="Title" placeholder="Title" value="SMTP"><br><br>
            <nav>Due Time</nav><input type="date" name="DueTime" placeholder="Due Time"><br><br>
            <nav>Description</nav><textarea rows="10" cols="50" name="Description"></textarea><br><br>
			<input type="submit" value="Submit" name="Submit"><br>

		</form>
	</body>
</html>
<?php


	if(!isset($_SESSION['AssigmentMessage']))
{
    $_SESSION['AssigmentMessage']="";
}
			
	if(isset($_SESSION['user']) && $_SESSION['type']=="Profesor")
	{
			if(isset($_POST['Submit']))
			{
                if($_POST['Materie']!="None") {
                    if (!isEmpty($_POST['Size']) && !isEmpty($_POST['Dificultate']) && !isEmpty($_POST['Title']) && !isEmpty($_POST['DueTime']) && !isEmpty($_POST['Description'])) {
                        InsertIntoAssigments($_POST['Materie'], $_POST['Size'], $_POST['Dificultate'], $_POST['Title'], $_POST['DueTime'],$_POST['Description']);
                        $_SESSION['AssigmentMessage'] = "<br>Assigment Added!<br>";
                        header("Location: Profesor.php");
                    } else
                        echo "Nu au fost completate toate Campurile";
                }
                else{
                    echo  "Nu exista nici un Curs creat!";
                }
			}
	}
		else
			header("Location: Login.php");

		function isEmpty($String)
			{
				if(isset($String))
				{
					if(strlen(trim($String))==0)
					{
						return true;
					}
					else
						return false;
				}	

			}
function InsertIntoAssigments($Subject,$Size,$Dificulty,$Title,$DueTime,$Description)
{
    $proiect=new \bdxe\Project();
    $query=new bdxe\CourseQuery();
    $Course_id=$query->findOneBySubjectName($Subject)->getId();
    $proiect->setCourseId($Course_id);
    $proiect->setMaterie($Subject);
    $proiect->setDificultate($Dificulty);
    $proiect->setDuetime($DueTime);
    $proiect->setPosttime(time());
    $proiect->setNumarParticipanti($Size);
    $proiect->setTitlu($Title);
    $proiect->setDescription($Description);
    $proiect->save();

}
	
?>