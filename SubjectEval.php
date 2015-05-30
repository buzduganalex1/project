<?php
include_once("Navigation.php");
include_once("Composer.php");
?>

<html>

    <head></head>
    <body></body>

</html>
<?php
$Array=array("Type","Subject","Name","Size","Dificulty","Students");
session_start();
if(isset($_SESSION['user']) && $_SESSION['type']=="Profesor") {
    if(isset($_SESSION['SubjectEval']))
    {
        $Course_query=new bdxe\CourseQuery();
        $Project_query=new bdxe\ProjectQuery();
        $Homework_query=new bdxe\HomeworkQuery();
        $Test_query=new bdxe\TestQuery();

        $Course_id=$_SESSION['SubjectEval'];

        //Projects
        CreateTable($Array,"Teste/Teme/Proiect");

        foreach($Project_query->findByCourseId($Course_id) as $project)
        {
            $Project_ID=$project->getId();

            echo "<tr>";
            echo "<td>Proiect</td>";
            echo "<td>".$Course_query->findOneById($Course_id)->getSubjectName()."</td>";
            echo "<td>".$project->getTitlu()."</td>";
            echo "<td>".$project->getNumarParticipanti()."</td>";
            echo "<td>".$project->getDificultate()."</td>";
            echo "<td> <a href='SubjectEval.php?Project_id={$Project_ID}'>See Studens!</a></td>";
            echo "</tr>";
        }
        //Homeworks
        foreach($Homework_query->findByCourseId($Course_id) as $homework)
        {
            $Homework_ID=$homework->getId();

            echo "<tr>";
            echo "<td>Homework</td>";
            echo "<td>".$Course_query->findOneById($Course_id)->getSubjectName()."</td>";
            echo "<td>None</td>";
            echo "<td>One</td>";
            echo "<td>None</td>";
            echo "<td> <a href='SubjectEval.php?Homework_id={$Homework_ID}'>See Studens!</a></td>";
            echo "</tr>";
        }
        //Tests
        foreach($Test_query->findByCourseId($Course_id) as $test)
        {
            $Test_ID=$test->getId();

            echo "<tr>";
            echo "<td>Test</td>";
            echo "<td>".$Course_query->findOneById($Course_id)->getSubjectName()."</td>";
            echo "<td>None</td>";
            echo "<td>One</td>";
            echo "<td>None</td>";
            echo "<td> <a href='SubjectEval.php?Test_id={$Test_ID}'>See Studens!</a></td>";
            echo "</tr>";
        }
        //
        echo "</table>";
    }
}

function CreateTable($Array,$Name){
    echo "<table class='NewsFeed' BORDER=3 CELLSPACING=3 CELLPADDING=3>";
    echo "<tr><td COLSPAN='7' ALIGN=center><b>{$Name}</b></td></tr>";
    echo "<tr>";
    foreach($Array as $element)
    {
        echo "<td ALIGN=center>{$element}</td>";
    }
    echo "</tr>";
}

?>