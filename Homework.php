<?php include_once "Navigation.php" ?>
<?php include_once "Composer.php";
session_start();

?>
<html>
	<head>
		<title>Homework</title>
	</head>
	<body>
		<pre class="Title">Homework</pre>
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
            <nav>Description</nav><textarea rows="10" cols="50" name="Description"></textarea><br><br>
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
        if(isset($_POST['DueTime'])&& isset($_POST['Subject']))
            if(!isEmpty($_POST['Subject'])) {
                if (isEmpty($_POST['DueTime']) && !isEmpty($_POST['Description'])) {

                    InsertIntoHomework($_POST['Subject'], $_POST['DueTime'],$_POST['Description']);
                    $_SESSION['AssigmentMessage'] = "<br>Homework Added!<br>";
                    header("Location: Profesor.php");
                }
            }
        else{
            echo "Nu exista nici un Curs creat!";
        }
    }

}
else
    header("Location: Login.php");

function InsertIntoHomework($Subject,$DueTime,$Description)
{

    $test=new \bdxe\Homework();
    $query=new bdxe\CourseQuery();
    $Course_id=$query->findOneBySubjectName($Subject)->getId();
    $test->setCourseId($Course_id);
    $test->setMaterie($Subject);
    $test->setDuetime($DueTime);
    $test->setDescription($Description);
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