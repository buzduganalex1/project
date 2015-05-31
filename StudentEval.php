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
        $ProjectEvalQuery=new bdxe\ProjectEvalQuery();

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
                            $Available=true;
                            echo $_SESSION['Subject_Type'];
                            if($_SESSION['Subject_Type']=='Project') {
                                $Course_id = $_SESSION['Course_id'];
                                $Course_query->findOneBySubjectName($_SESSION['Subject_Type']);
                                $CurrentSubscription_id = null;
                                $CurrentCourse_id = null;
                                $CurrentProjectEval_id = null;

                                foreach ($Subscription_query->find() as $subscription) {
                                    if ($subscription->getStudentId() == $student_id && $subscription->getCourseId() == $Course_id) {
                                        $CurrentSubscription_id = $subscription->getId();
                                        $CurrentCourse_id = $subscription->getCourseId();

                                        break;
                                    }
                                }
                                if (isset($CurrentSubscription_id)) {
                                    foreach ($ProjectEvalQuery->find() as $key) {
                                        if ($key->getSubscriptionId() == $CurrentSubscription_id && $key->getProjectId() == $CurrentCourse_id) {
                                            $CurrentProjectEval_id = $key->getId();
                                            $Available = false;
                                            break;
                                        }
                                    }
                                    if ($_POST[$student_id] != null) {
                                        if ($Available) {
                                            $ProjectEval = new bdxe\ProjectEval();
                                            $ProjectEval->setNota($_POST[$student_id]);
                                            $ProjectEval->setSubscriptionId($CurrentSubscription_id);
                                            $ProjectEval->setProjectId($_SESSION['Subject_id']);
                                            $ProjectEval->save();

                                            echo "Subject Type: " . $_SESSION['Subject_Type'] . " ";
                                            echo "Student_Id: " . $student_id;
                                            echo "$Course_id: " . $_SESSION['Course_id'];
                                            echo "Subscription id: " . $CurrentSubscription_id;
                                            echo "<br>";
                                        } else {
                                            $Students = $Student_query->find();

                                            foreach ($Students as $student) {
                                                if ($student->getId() == $student_id) {
                                                    echo "Nota studentului {$Student_name} este deja setata!";
                                                    echo "<br>";
                                                    break;
                                                }
                                            }
                                            $Available = true;
                                        }
                                    } else {
                                        $Students = $Student_query->find();
                                        foreach ($Students as $student) {
                                            if ($student->getId() == $student_id) {
                                                echo "Nota studentului {$Student_name} nu este setata!";
                                                echo "<br>";
                                                break;
                                            }
                                        }
                                    }

                                }
                            }
                            if($_SESSION['Subject_Type']=='Homework') {
                                $Course_id = $_SESSION['Course_id'];
                                $Course_query->findOneBySubjectName($_SESSION['Subject_Type']);
                                $CurrentSubscription_id = null;
                                $CurrentCourse_id = null;
                                $CurrentHomeWorkEval_id = null;
                                $HomeworkEvalQuery=new bdxe\HomeworkEvalQuery();

                                foreach ($Subscription_query->find() as $subscription) {
                                    if ($subscription->getStudentId() == $student_id && $subscription->getCourseId() == $Course_id) {
                                        $CurrentSubscription_id = $subscription->getId();
                                        $CurrentCourse_id = $subscription->getCourseId();

                                        break;
                                    }
                                }
                                if (isset($CurrentSubscription_id)) {
                                    foreach ($HomeworkEvalQuery->find() as $key) {
                                        if ($key->getSubscriptionId() == $CurrentSubscription_id && $key->getHomeworkId() == $CurrentCourse_id) {
                                            $CurrentProjectEval_id = $key->getId();
                                            $Available = false;
                                            break;
                                        }
                                    }
                                    if ($_POST[$student_id] != null) {
                                        if ($Available) {
                                            $HomeworkEval = new bdxe\HomeworkEval();
                                            $HomeworkEval->setNota($_POST[$student_id]);
                                            $HomeworkEval->setSubscriptionId($CurrentSubscription_id);
                                            $HomeworkEval->setHomeworkId($_SESSION['Subject_id']);
                                            $HomeworkEval->save();

                                            echo "Subject Type: " . $_SESSION['Subject_Type'] . " ";
                                            echo "Student_Id: " . $student_id;
                                            echo "$Course_id: " . $_SESSION['Course_id'];
                                            echo "Subscription id: " . $CurrentSubscription_id;
                                            echo "<br>";
                                        } else {
                                            $Students = $Student_query->find();

                                            foreach ($Students as $student) {
                                                if ($student->getId() == $student_id) {
                                                    echo "Nota studentului {$Student_name} este deja setata!";
                                                    echo "<br>";
                                                    break;
                                                }
                                            }
                                            $Available = true;
                                        }
                                    } else {
                                        $Students = $Student_query->find();
                                        foreach ($Students as $student) {
                                            if ($student->getId() == $student_id) {
                                                echo "Nota studentului {$Student_name} nu este setata!";
                                                echo "<br>";
                                                break;
                                            }
                                        }
                                    }

                                }
                            }
                            if($_SESSION['Subject_Type']=='Test') {
                                $Course_id = $_SESSION['Course_id'];
                                $Course_query->findOneBySubjectName($_SESSION['Subject_Type']);
                                $CurrentSubscription_id = null;
                                $CurrentCourse_id = null;
                                $CurrentTestEval_id = null;
                                $TestEvalQuery=new bdxe\TestEvalQuery();

                                foreach ($Subscription_query->find() as $subscription) {
                                    if ($subscription->getStudentId() == $student_id && $subscription->getCourseId() == $Course_id) {
                                        $CurrentSubscription_id = $subscription->getId();
                                        $CurrentCourse_id = $subscription->getCourseId();

                                        break;
                                    }
                                }
                                if (isset($CurrentSubscription_id)) {
                                    foreach ($TestEvalQuery->find() as $key) {
                                        if ($key->getSubscriptionId() == $CurrentSubscription_id && $key->getTestId() == $CurrentCourse_id) {
                                            $CurrentTestEval_id = $key->getId();
                                            $Available = false;
                                            break;
                                        }
                                    }
                                    if ($_POST[$student_id] != null) {
                                        if ($Available) {
                                            $TestEval = new bdxe\TestEval();
                                            $TestEval->setNota($_POST[$student_id]);
                                            $TestEval->setSubscriptionId($CurrentSubscription_id);
                                            $TestEval->setTestId($_SESSION['Subject_id']);
                                            $TestEval->save();

                                            echo "Subject Type: " . $_SESSION['Subject_Type'] . " ";
                                            echo "Student_Id: " . $student_id;
                                            echo "$Course_id: " . $_SESSION['Course_id'];
                                            echo "Subscription id: " . $CurrentSubscription_id;
                                            echo "<br>";
                                        } else {
                                            $Students = $Student_query->find();

                                            foreach ($Students as $student) {
                                                if ($student->getId() == $student_id) {
                                                    echo "Nota studentului {$Student_name} este deja setata!";
                                                    echo "<br>";
                                                    break;
                                                }
                                            }
                                            $Available = true;
                                        }
                                    } else {
                                        $Students = $Student_query->find();
                                        foreach ($Students as $student) {
                                            if ($student->getId() == $student_id) {
                                                echo "Nota studentului {$Student_name} nu este setata!";
                                                echo "<br>";
                                                break;
                                            }
                                        }
                                    }

                                }
                            }

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

