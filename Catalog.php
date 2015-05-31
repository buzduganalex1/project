<?php
include_once("Navigation.php");
include_once("Composer.php");
?>
<html>
        <head></head>
        <body>
            <nav><b>Catalog</b></nav><br><br>
        </body>
</html>

<?php
$Proiects=array();
$Tests=array();
$Homeworks=array();

//$Array=array($Array2);


session_start();
if(isset($_SESSION['user']) && $_SESSION['type']=="Profesor"){
    $Profesor_query=new bdxe\ProfesorQuery();
    $Course_query=new bdxe\CourseQuery();
    $Subscription_query=new bdxe\SubscriptionQuery();
    $Student_query=new bdxe\StudentQuery();

    $ProjectEval_query=new bdxe\ProjectEvalQuery();
    $TestEval_query=new bdxe\TestEvalQuery();
    $HomeworkEval_query=new bdxe\HomeworkEvalQuery();

    $Project_query=new bdxe\ProjectQuery();
    $Test_query=new bdxe\TestQuery();
    $Homework_query=new bdxe\HomeworkQuery();

    echo "<form method='post'><select name='Subject'>";
    foreach($Course_query->findByProfesorId($Profesor_query->findOneByName($_SESSION['user'])->getId()) as $curs){
        $Course_name=$curs->getSubjectName();
        echo "<option>{$Course_name}</option>";
    }
    echo "<input type='submit' value='Submit'>";
    echo "</select></form>";

    if(isset($_POST['Subject'])) {
        $Course_name=$_POST['Subject'];
        $Subscriptions=$Subscription_query->findByCourseId($Course_query->findOneBySubjectName($Course_name)->getId());

        foreach($ProjectEval_query->find() as $project) {
            foreach($Subscriptions as $subscription) {
                    if ($project->getSubscriptionId() == $subscription->getId()) {
                        foreach($Student_query->find() as $student){
                            if($student->getId()==$subscription->getStudentId()) {
                                echo $student->getName();
                            }
                        }

                        foreach($Course_query->find() as $course){
                            if($course->getId()==$subscription->getCourseId()) {
                                echo $course->getSubjectName();
                            }
                        }

                        echo $project->getNota() . " ";
                        //echo $Student_query->findOneById($subscription->getStudentId())->getName()." ";
                        //echo $Course_query->findOneById($subscription->getCourseId())->getSubjectName()."<br>";
                    }
                    echo "<br>";
                }
            }

        /*foreach($Student_query->find() as $student) {
            foreach($Subscriptions as $subscription){
                if($student->getId()==$subscription->getStudentId()) {
                    echo $student->getName()." ";

                    foreach($ProjectEval_query->find() as $project) {
                        if($project->getSubscriptionId()==$subscription->getId()) {
                            echo $project->getNota()." ";

                        }
                    }
                    foreach($Project_query->find() as $test){
                        if($subscription->getCourseId()==$project->getId()){
                            echo $test->getMaterie();
                        }
                    }






                }
            }

        }*/
    }

}

function CreateTable($Array,$Name){
    echo "<table class='NewsFeed' BORDER=3 CELLSPACING=3 CELLPADDING=3>";
    echo "<tr><td COLSPAN='7' ALIGN=center><b>{$Name}</b></td></tr>";
    echo "<tr>";
    foreach($Array as $Element)
    {
        foreach($Element as $element)
        echo "<td ALIGN=center>{$element}</td>";
    }
    echo "</tr>";
}

?>