<?php
include_once("Composer.php");
include_once("Navigation.php");
?>

<?php
$Array=array("Student_ID","Nume","Email","Set Nota");
$Subscriptions_id_List=array();
$Student_id_list=array();

    session_start();


    if(isset($_SESSION['Subject_id']) && isset($_SESSION['Subject_Type'])) {
        echo $_SESSION['Subject_Type'];
        echo $_SESSION['Subject_id'];
        $Course_query=new bdxe\CourseQuery();
        $Subscription_query=new \bdxe\SubscriptionQuery();
        $Student_query=new bdxe\StudentQuery();
        if ($_SESSION['Subject_Type'] == "Project") {
            $Project_query=new \bdxe\ProjectQuery();
            $Students=$Student_query->find();
            $Course_id=$Course_query->findOneById($Project_query->findOneById($_SESSION['Subject_id'])->getCourseId())->getId();
            CreateTable($Array,$Project_query->findOneById($_SESSION['Subject_id'])->getTitlu());
            foreach($Subscription_query->findByCourseId($Course_id) as $subscription) {
                foreach($Students as $student) {
                    if($student->getId()==$subscription->getStudentId())
                    {
                        $Student_id=$student->getId();
                        $Subscription_id=$subscription->getId();
                        array_push($Subscriptions_id_List,$Subscription_id);
                        array_push($Student_id_list,$Student_id);
                        echo $Subscription_id." ";
                        echo $Student_id."<br>";

                        echo "<tr>";
                        echo "<td>".$student->getId()."</td>";
                        echo "<td>".$student->getName()."</td>";
                        echo "<td>".$student->getEmail()."</td>";
                        echo "<td><input name={$Student_id} type='number' min='1' max='10''></td>";
                        //echo "<td> <a href='StudentEval.php.php?Student_id={$Student_id}&Subscription_id={$Subscription_id}'>See more</a></td>";
                        echo "</tr>";
                    }
                }
            }
            echo "<body><br><input type='submit' name='Submit' value='Submit'></body>";
            echo "</table>";
            echo "</form>";


        }

        if ($_SESSION['Subject_Type'] == "Homework") {
            $Homework_query=new \bdxe\ProjectQuery();;
            $Students=$Student_query->find();

            $Course_id=$Course_query->findOneById($Homework_query->findOneById($_SESSION['Subject_id'])->getCourseId())->getId();
            CreateTable($Array,$Homework_query->findOneById($_SESSION['Subject_id'])->getTitlu());
            foreach($Subscription_query->findByCourseId($Course_id) as $subscription) {
                foreach($Students as $student) {
                    if($student->getId()==$subscription->getStudentId())
                    {
                        $Student_id=$student->getId();
                        $Subscription_id=$subscription->getId();
                        array_push($Subscriptions_id_List,$Subscription_id);
                        array_push($Student_id_list,$Student_id);

                        echo "<tr>";
                        echo "<td>".$student->getId()."</td>";
                        echo "<td>".$student->getName()."</td>";
                        echo "<td>".$student->getEmail()."</td>";
                        echo "<td><input name={$Student_id} type='number' min='1' max='10''></td>";
                       // echo "<td> <a href='StudentEval.php.php?Student_id={$Student_id}&Subscription_id={$Subscription_id}'>See more</a></td>";
                        echo "</tr>";
                    }
                }
            }
            echo "<body><br><input type='submit' name='Submit' value='Submit'></body>";
            echo "</table>";
            echo "</form>";
        }

        if ($_SESSION['Subject_Type'] == "Test") {
            
            $Test_query=new \bdxe\ProjectQuery();
            $Students=$Student_query->find();

            $Course_id=$Course_query->findOneById($Test_query->findOneById($_SESSION['Subject_id'])->getCourseId())->getId();
            CreateTable($Array,$Test_query->findOneById($_SESSION['Subject_id'])->getTitlu());
            foreach($Subscription_query->findByCourseId($Course_id) as $subscription) {
                foreach($Students as $student) {
                    if($student->getId()==$subscription->getStudentId())
                    {

                        $Student_id=$student->getId();
                        $Subscription_id=$subscription->getId();
                        array_push($Subscriptions_id_List,$Subscription_id);
                        array_push($Student_id_list,$Student_id);
                        echo "<tr>";
                        echo "<td>".$student->getId()."</td>";
                        echo "<td>".$student->getName()."</td>";
                        echo "<td>".$student->getEmail()."</td>";
                        echo "<td><input name={$Student_id} type='number' min='1' max='10''></td>";
                        //echo "<td> <a href='StudentEval.php.php?Student_id={$Student_id}&Subscription_id={$Subscription_id}'>See more</a></td>";
                        echo "</tr>";
                    }
                }
            }
            echo "</table>";
            echo "<body><br><input type='submit' name='Submit' value='Submit'></body>";
            echo "</form>";

        }


        if(isset($_POST['Submit'])) {

            $Students=$Student_query->find();
            foreach($Students as $student){
                foreach($Student_id_list as $student_id)
                    if($student->getId()==$student_id) {
                        $Student_name=$student->getName();
                        if(isset($_POST[$student_id])) {
                            echo $_SESSION['Subject_Type'];

                            if($_SESSION['Subject_Type']=="Project") {

                                $Subscription_id=$Subscriptions_id_List[array_search($student_id, array_keys($Student_id_list))];
                                $Availabe=true;
                                $Project=new bdxe\ProjectEvalQuery();
                                $Projects=$Project->find();

                                foreach($Projects as $key)
                                {
                                        if($key->getProjectId()==$_SESSION['Subject_id'] && $key->getSubscriptionId()==$Subscription_id) {
                                            $Availabe=false;
                                        }

                                }
                                if($Availabe) {
                                    $project = new bdxe\ProjectEval();
                                    $project->setNota($_POST[$student_id]);
                                    $project->setProjectId($_SESSION['Subject_id']);
                                    $project->setSubscriptionId($Subscriptions_id_List[array_search($student_id, array_keys($Student_id_list))]);
                                    $project->save();
                                    $_SESSION['ProjectCreatedMessage'] = "Studentul " . $Student_name . " a fost notat cu succes la proiect cu nota " . $_POST[$student_id];
                                }
                                else {
                                    $_SESSION['ProjectCreatedMessage'] = "Studentul a fost deja notat la aceast proiect!";
                                }
                            }

                            if($_SESSION['Subject_Type']=="Homework") {
                                $homework = new bdxe\HomeworkEval();
                                $Homework_query=new bdxe\HomeworkEvalQuery();
                                $Homework=$Homework_query->find();
                                $Subscription_id=$Subscriptions_id_List[array_search($student_id, array_keys($Student_id_list))];

                                $Availabe=true;
                                foreach($Homework as $key)
                                {
                                    if($key->getHomeworkId()==$_SESSION['Subject_id'] && $key->getSubscriptionId()==$Subscription_id) {
                                        $Availabe=false;
                                    }
                                }
                                if($Availabe) {
                                    $homework->setNota($_POST[$student_id]);
                                    $homework->setHomeworkId($_SESSION['Subject_id']);
                                    $homework->setSubscriptionId($Subscription_id);
                                    $homework->save();
                                    $_SESSION['ProjectCreatedMessage'] = "Studentul " . $Student_name . " a fost notat cu succes la tema cu nota " . $_POST[$student_id];
                                }
                                else
                                {
                                    $_SESSION['ProjectCreatedMessage']="Studentul a fost deja notat la aceasta tema!";
                                }
                            }

                            if($_SESSION['Subject_Type']=="Test") {

                                $Subscription_id=$Subscriptions_id_List[array_search($student_id, array_keys($Student_id_list))];
                                $Test_query=new bdxe\TestEvalQuery();
                                $Tests=$Test_query->find();

                                $Availabe=true;
                                foreach($Tests as $key)
                                {
                                    if($key->getTestId()==$_SESSION['Subject_id'] && $key->getSubscriptionId()==$Subscription_id) {
                                        $Availabe=false;
                                    }
                                }
                                if($Availabe) {
                                    $test = new bdxe\TestEval();
                                    $test->setNota($_POST[$student_id]);
                                    $test->setTestId($_SESSION['Subject_id']);
                                    $test->setSubscriptionId($Subscription_id);
                                    $test->save();
                                    $_SESSION['ProjectCreatedMessage'] = "Studentul " . $Student_name . " a fost notat cu succes la test cu nota " . $_POST[$student_id];
                                }
                                else{
                                    $_SESSION['ProjectCreatedMessage']="Studentul a fost notat deja la acest test!";
                                }
                            }
                            header("Location: SubjectEval.php");
                        }

                }
            }
        }

    }

function CreateTable($Array,$Name){
    echo "<form method='post'>";
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

