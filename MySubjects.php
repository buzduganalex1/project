<?php
 include_once("Navigation.php");
 include_once("Composer.php");
session_start();
?>
<html>
    <form method="post">
        <?php
        if(isset($_SESSION['user']) && $_SESSION['type']=="Profesor") {
            $query = new bdxe\CourseQuery();
            $query1 = new bdxe\ProfesorQuery();


            $Subscription = $query->find();
            $Profesors = $query1->findOneByName($_SESSION['user']);
            echo "<table class='NewsFeed' BORDER=3 CELLSPACING=3 CELLPADDING=3>";
            echo "<tr>";
            echo "<td>Subject</td>";
            echo "<td>Class Capacity</td>";
            echo "<td>Availabe Spots</td>";
            echo "<td>StartTime</td>";
            echo "<td>EndTime</td>";
            echo "<td>More</td>";
            echo "</tr>";
            foreach ($Subscription as $key) {
                echo "<tr>";
                if ($key->getProfesorId() == $Profesors->getId()) {
                    $SubjetID=$key->getID();
                    $Subject_Name=$key->getSubjectName();

                    echo "<td> <a href='MySubjects.php?SubjectEval={$SubjetID}'>{$Subject_Name}</a></td>";
                    echo "<td>" . $key->getInitialClassCapacity() . "</td>";
                    echo "<td>" . $key->getClassCapacity() . "</td>";
                    echo "<td>" . $key->getStartDate()->format('Y-m-d') . "</td>";
                    echo "<td>" . $key->getFinishDate()->format('Y-m-d') . "</td>";
                    echo "<td> <a href='MySubjects.php?Subject_id={$SubjetID}'>See more</a></td>";
                }
                echo "</tr>";
            }
            echo "</table>";

        if(isset($_GET['Subject_id'])) {
            $_SESSION['Subject_id']=$_GET['Subject_id'];

            header("Location: InfoSubject.php");
        }
        if(isset($_GET['SubjectEval'])) {
            $_SESSION['SubjectEval'] = $_GET['SubjectEval'];
            //echo $_SESSION['SubjectEval'];
            header("Location: SubjectEval.php");
        }
        }
        ?>
    </form>
</html>
