<?php
include_once("Navigation.php");
include_once("Composer.php");
?>

<html>
    <head></head>
    <body>

        <form method="post">
           <nav> Subject </nav> <input type="text" name="Subject"><br><br>
           <nav> Class Capacity </nav> <input type="number" min=1 name="ClassCapacity"><br><br>
           <nav> Start Date </nav><input type="date" name="StartDate"><br><br>
           <nav> Finish Date </nav><input type="date" name="FinishDate"><br><br>
            <input type="submit" name="submit">
        </form>

    </body>
</html>

<?php
session_start();
$Available=true;

if(!isset($_SESSION['AssigmentMessage'])) {
    $_SESSION['AssigmentMessage']="";
}

if(isset($_SESSION['user']) && $_SESSION['type']=="Profesor") {

    if(isset($_POST['submit'])){
            if (!isEmpty($_POST['Subject']) && !isEmpty($_POST['ClassCapacity']) && !isEmpty($_POST['StartDate']) && !isEmpty($_POST['FinishDate'])) {
                $query=new bdxe\CourseQuery();
                $ListaSubiecte=$query->find();
                $profesori=new bdxe\ProfesorQuery();
                $profesor=$profesori->findOneByName($_SESSION['user']);

                foreach($ListaSubiecte as $key)
                {
                    if($key->getSubjectName()==$_POST['Subject'] && $key->getProfesorId()==$profesor->getId())
                    {
                        $Available=false;
                        break;
                    }

                }


                if($Available){
                    $Materie = new bdxe\Course();
                    $Materie->setProfesorId($profesor->getId());
                    $Materie->setSubjectName($_POST['Subject']);
                    $Materie->setClassCapacity($_POST['ClassCapacity']);
                    $Materie->setInitialClassCapacity($_POST['ClassCapacity']);
                    $Materie->setStartDate($_POST['StartDate']);
                    $Materie->setFinishDate($_POST['FinishDate']);
                    $Materie->save();
                    $_SESSION['AssigmentMessage'] = "<br>Subject Added!<br>";
                    header("Location: Profesor.php");
                }
                else
                {
                    echo "Clasa de tipul respectiv deja exista!";
                }
            }
    }
}


function isEmpty($String)
{
    if(isset($String)) {
        if(strlen(trim($String))==0) {
            return true;
        }
        else
            return false;
    }
}

?>