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
            echo "<td><a href='' name='Subject'>Subject</a></td>";
            echo "<td><a href='' name='Initial Class Capacity'>Initial Class Capacity</a></td>";
            echo "<td><a href='' name='Class Capacity'>Class Capacity</a></td>";
            echo "<td><a href='' name='StartTime'>StartTime</a></td>";
            echo "<td><a href='' name='EndTime'>EndTime</a></td>";
            echo "<td><a href='' name='Students'>More</a></td>";
            echo "</tr>";
            foreach ($Subscription as $key) {
                echo "<tr>";
                if ($key->getProfesorId() == $Profesors->getId()) {
                    $SubjetID=$key->getID();
                    echo "<td>" . $key->getSubjectName() . "</td>";
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

        }
        ?>
    </form>
</html>
