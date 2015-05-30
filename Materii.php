
<?php
include_once("Composer.php");
include_once("Navigation.php");

?>

<html>

    <head></head>
    <body>

    </body>

</html>

<?php
session_start();

$Student_id="";
$Course_id="";
$Assigned=true;

if(isset($_SESSION['user']) && $_SESSION['type']=="Student") {

    if(isset($_SESSION['SuccesfullRegistrationSubject'])) {
        echo $_SESSION['SuccesfullRegistrationSubject'];
        $_SESSION['SuccesfullRegistrationSubject']=NULL;
    }
    $query = new bdxe\CourseQuery();
    $query1 = new bdxe\ProfesorQuery();
    $query2 = new bdxe\StudentQuery();

    $Courses = $query->find();
    $Profesori = $query1->find();
    $Studenti = $query2->find();

    foreach ($Studenti as $student) {
        if ($student->getName() == $_SESSION['user']) {
            $Student_id = $student->getId();
            break;
        }

    }


    echo "<form method='post'>";
    echo "<table class='Materii' BORDER=3 CELLSPACING=3 CELLPADDING=3>";
    echo "<tr>";
    echo "<td><a href='' name='Subject'>Subject</a></td>";
    echo "<td><a href='' name='Free Spots'>Free Spots</a></td>";
    echo "<td><a href='' name='Start Date'>Start Date</a></td>";
    echo "<td><a href='' name='End Time'>End Time</a></td>";
    echo "<td><a href='' name='Teacher'>Teacher</a></td>";
    echo "<td><a href='' name='Apply'>Apply</a></td>";
    echo "</tr>";
    foreach ($Courses as $course) {

        foreach ($Profesori as $profesor) {
            if ($profesor->getId() == $course->getProfesorId()) {
                $ProfesorName = $profesor->getName();
                break;
            }

        }
        $Course_id = $course->getId();

        echo "<tr>";
        echo "<td>" . $course->getSubjectName() . "</td>";
        if($course->getClassCapacity()==0)
            echo "<td>None</td>";
        else
            echo "<td>" . $course->getClassCapacity() . "</td>";
        echo "<td>" . $course->getStartDate()->format('Y-m-d') . "</td>";
        echo "<td>" . $course->getFinishDate()->format('Y-m-d') . "</td>";
        echo "<td>" . $ProfesorName . "</td>";
        echo "<td> <a href='Materii.php?Course_id={$Course_id}'>Apply</a></td>";
        echo "</tr>";


    }
    echo "</table>";
    echo "</form>";




    if(isset($_GET['Course_id'])) {
        $Course_id= $_GET['Course_id'];
        $Request_query=new bdxe\SubjectQuery();
        $Requests=$Request_query->find();

        $Subscription_query=new bdxe\SubscriptionQuery();
        $Subscription=$Subscription_query->find();

        foreach($Requests as $request) {
            if($request->getCourseId()==$Course_id && $request->getStudentId()==$Student_id)
            {
                $Assigned=false;
            }

        }
        foreach($Subscription as $subscription) {
            if($subscription->getCourseId()==$Course_id && $subscription->getStudentId()==$Student_id)
            {
                $Assigned=false;
            }

        }

        if($Assigned){
            $query=new bdxe\CourseQuery();
            $Course=$query->findOneById($Course_id);

            if($Course->getClassCapacity()>=1) {
                $CourseName=$Course->getSubjectName();
                $request=new \bdxe\Subject();
                $request->setStudentId($Student_id);
                $request->setCourseId($Course->getId());
                $request->save();

                $_SESSION['SuccesfullRegistrationSubject']="You have successfully submited a request for {$CourseName}";
                header("Location: Materii.php");
            }
            else
                echo "Nu mai sunt locuri disponibile!";
        }
        else {
            foreach($Courses as $course) {
                if($course->getId()==$Course_id) {
                    $Course_Name=$course->getSubjectName();

                }

            }

            echo "You are already registered at the {$Course_Name}!";
        }

    }

}
else
    header("Location: Login.php");

?>
<script type="text/javascript">
    function foo(value) {
        alert(value);
        return value;
    }
</script>