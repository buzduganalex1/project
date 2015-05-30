<?php include_once "Navigation.php";
      include_once "Composer.php";
session_start();
?>
<html>
	<head>
		<title>Test</title>
	</head>
	<body>
		<pre class="Title">Test</pre>
        <form method="post">

            <?php
            $Available=true;

            if(isset($_SESSION['user']) && $_SESSION['type']=="Profesor") {
                $query = new bdxe\CourseQuery();
                $query2 = new bdxe\ProfesorQuery();
                $MateriiDisponibile = $query->find();

                $Profesor = $query2->findOneByName($_SESSION['user']);
                $IdProfesor = $Profesor->getId();

                $MateriiDisponibile = $query->find();


                echo "<pre>Subject</pre>";
                echo "<select name='Subject'>";
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

                echo "</select><br>";
            }
            ?>
             <pre>Due Time</pre>
             <input type="date" name="DueTime" placeholder="DueTime"><br><br>
             <input type="submit" name="submit">
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
		if(isset($_POST['submit']))
        {
            if(!isEmpty($_POST['Subject']) && !isEmpty($_POST['DueTime']))
            {
                InsertIntoTest($_POST['Subject'],$_POST['DueTime']);
                $_SESSION['AssigmentMessage']="<br>Test Added!<br>";
                header("Location: Profesor.php");
            }
        }

	}
		else
			header("Location: Login.php");

function InsertIntoTest($Subject,$DueTime)
{
    $test=new \bdxe\Test();
    $query=new bdxe\CourseQuery();
    $Course_id=$query->findOneBySubjectName($Subject)->getId();
    $test->setCourseId($Course_id);
    $test->setMaterie($Subject);
    $test->setDuetime($DueTime);
    $test->setPosttime(time());
    $test->save();

}
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
?>