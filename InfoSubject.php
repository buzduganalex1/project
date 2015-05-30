<?php include_once("Composer.php");?>
<?php include_once("Navigation.php");?>

<html>
    <head>
    </head>

    <body>
    </body>
</html>

<?php
    session_start();
    if(isset($_SESSION['StudentDeletedMessage'])) {
        echo $_SESSION['StudentDeletedMessage'];
        $_SESSION['StudentDeletedMessage']=NULL;
    }

    $Array=array("Id","Name","Email","Remove");

    if(isset($_SESSION['user']) && $_SESSION['type']=="Profesor") {
        if (isset($_SESSION['Subject_id'])) {

            $query_Subscriptions = new bdxe\SubscriptionQuery();
            $query_Students = new bdxe\StudentQuery();
            $query_Course=new bdxe\CourseQuery();

            $Subscriptions = $query_Subscriptions->findByCourseId($_SESSION['Subject_id']);
            $SubjectName=$query_Course->findOneById($_SESSION['Subject_id']);
            $Students=$query_Students->find();


            CreateTable($Array,$SubjectName->getSubjectName());
            foreach ($Subscriptions as $subscription) {
                foreach($Students as $student){
                    if($student->getId()==$subscription->getStudentId()) {
                        $Student_id=$student->getId();

                        echo "<tr>";
                        echo "<td>" . $student->getID() . "</td>";
                        echo "<td>" . $student->getName() . "</td>";
                        echo "<td>" . $student->getEmail() . "</td>";
                        echo "<td> <a href='InfoSubject.php?Studentd_id={$Student_id}'>Remove</a></td>";
                        echo "</tr>";
                    }
                }

            }
            echo "</table>";

            if(isset($_GET['Studentd_id'])) {
                $Student=$query_Students->findOneById($_GET['Studentd_id']);

                foreach($Subscriptions as $subscription){
                    if($subscription->getStudentId()==$_GET['Studentd_id'])
                    {
                        $subscription->delete();
                        $Course=$query_Course->findOneById($subscription->getCourseId())->getSubjectName();

                        $Student->setTeachermessage("You have been removed from {$Course}!");
                        $Student->save();
                        $_SESSION['StudentDeletedMessage']="Student Deleted!";

                    }
                }
                $Courses=$query_Course->find();
                echo $SubjectName->getSubjectName();
                foreach($Courses as $course){
                    if($course->getSubjectName()==$SubjectName->getSubjectName())
                    {

                        $course->setClassCapacity($course->getClassCapacity()+1);
                        $course->save();
                    }
                }
                header("Location: InfoSubject.php");
            }
        }
    }
    else {
        header("Location: Profesor.php");
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
