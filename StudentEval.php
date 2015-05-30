<?php
include_once("Composer.php");
include_once("Navigation.php");
?>
<html>

</html>
<?php
$Array=array("Student_ID","Nume","Email","Set Nota");

    session_start();
    if(isset($_SESSION['Subject_id']) && isset($_SESSION['Subject_Type'])) {

        if ($_SESSION['Subject_Type'] == "Project") {
            $Project_query=new \bdxe\ProjectQuery();
            $Course_query=new bdxe\CourseQuery();
            $Subscription_query=new \bdxe\SubscriptionQuery();
            $Student_query=new bdxe\StudentQuery();
            $Students=$Student_query->find();

            $Course_id=$Course_query->findOneById($Project_query->findOneById($_SESSION['Subject_id'])->getCourseId())->getId();
            CreateTable($Array,$Project_query->findOneById($_SESSION['Subject_id'])->getTitlu());
            foreach($Subscription_query->findByCourseId($Course_id) as $subscription) {
                foreach($Students as $student) {
                    if($student->getId()==$subscription->getStudentId())
                    {
                        echo "<tr>";
                        echo "<td>".$student->getId()."</td>";
                        echo "<td>".$student->getName()."</td>";
                        echo "<td>".$student->getEmail()."</td>";
                        echo "<td><input type='text'></td>";
                        echo "</tr>";
                    }
                }
            }
            echo "</table>";


        }

        if ($_SESSION['Subject_Type'] == "Homework") {
            $Course_query=new bdxe\CourseQuery();
            $Homework_query=new bdxe\HomeworkQuery();

            $Student_query = new \bdxe\StudentQuery();
        }

        if ($_SESSION['Subject_Type'] == "Test") {
            $Course_query=new bdxe\CourseQuery();
            $Test_query=new bdxe\TestQuery();

            $Student_query = new \bdxe\StudentQuery();
        }
    }

function CreateTable($Array,$Name){
    echo "<table class='NewsFeed'  BORDER=3 CELLSPACING=3 CELLPADDING=3>";
    echo "<tr><td COLSPAN='7' ALIGN=center><b>{$Name}</b></td></tr>";
    echo "<tr>";
    foreach($Array as $element)
    {
        echo "<td ALIGN=center>{$element}</td>";
    }
    echo "</tr>";
}
?>