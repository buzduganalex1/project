<?php include_once "Navigation.php" ?>
<?php include_once("Composer.php");?>

<html>

<head>
	<title>Profesor</title>
</head>

	<body>
		<pre class="Title">Profesor</pre>
		<form name="Profile" method="post">
			<input type="submit" name="LogOut" value="Log out">
            <input type="submit" name="CreateNewSubject" value="New Class">
            <input type="submit" name="MySubjects" value="MySubjects">
            <input type="submit" name="Catalog" value="Catalog">
		</form>
	</body>
</html>

<?php
$Array=array("ID","Student Name","Subject","Accept","Decline");
$Message="";
session_start();


	if(isset($_SESSION['AssigmentMessage']))
	{
		echo $_SESSION['AssigmentMessage'];
		$_SESSION['AssigmentMessage']=null;
	}

    if(isset($_SESSION['AcceptanceMessage']))
    {
        echo $_SESSION['AcceptanceMessage'];
        $_SESSION['AcceptanceMessage']=null;
    }

	if(isset($_SESSION['user']) && $_SESSION['type']=="Profesor")
	{


        $Course_query=new bdxe\CourseQuery();
        $Profesors_query=new bdxe\ProfesorQuery();
        $Requests_query=new bdxe\SubjectQuery();
        $Student_query=new bdxe\StudentQuery();
        $Requests_List=$Requests_query->find();
        $Student_List=$Student_query->find();

        $Teacher_Courses=$Course_query->findByProfesorId($Profesors_query->findOneByName($_SESSION['user'])->getId());
        CreateTable($Array,"Subject Requests");

        foreach($Teacher_Courses as $course) {
            foreach($Requests_List as $request) {
                if($request->getCourseId()==$course->getId()) {
                    foreach ($Student_List as $Student) {
                        if($Student->getId()==$request->getStudentId()) {
                            $Student_id = $Student->getId();
                            $Course_id = $course->getId();

                            echo "<tr>";
                            echo "<td>" . $Student->getId() . "</td>";
                            echo "<td>" . $Student->getName() . "</td>";
                            echo "<td>" . $course->getSubjectName() . "</td>";
                            echo "<td> <a href='Profesor.php?Accept={$Student_id}&Course={$Course_id}'>Accept</a></td>";
                            echo "<td> <a href='Profesor.php?Decline={$Student_id}'>Decline</a></td>";
                            echo "</tr>";
                        }
                    }
                }
            }
        }
        echo "</table>";

        if(isset($_GET['Accept']) && isset($_GET['Course'])) {

            $Subscription_check=new bdxe\SubscriptionQuery();

            $Subscription=new \bdxe\Subscription();
            $Subscription->setCourseId($_GET['Course']);
            $Subscription->setStudentId($_GET['Accept']);
            $Subscription->save();
            $Student=$Student_query->findOneById($_GET['Accept']);
            $Course=$Course_query->findOneById($_GET['Course']);

            $Student_name=$Student->getName();
            $Course_name=$Course->getSubjectName();


            $_SESSION['AcceptanceMessage']="Student {$Student_name} has been accepted in {$Course_name}!";

            foreach($Subscription_check->find() as $key) {
                if($key->getCourseId()==$_GET['Course'] && $key->getStudentId()==$_GET['Accept']){
                    $Message=$Student->getTeachermessage()." ".$Course_query->findOneById($_GET['Course'])->getSubjectName();
                }
            }



            $Student->setTeachermessage("{$Message}");
            $Student->save();
            $RequestList=$Requests_query->find();
            foreach($RequestList as $key) {
                if($key->getCourseId()==$_GET['Course'] && $key->getStudentId()==$_GET['Accept']) {
                    $key->delete();
                    break;
                }
            }


            header("Location: Profesor.php");
        }

        if(isset($_GET['Decline'])) {

        }

             echo "<ul class='Profesor'>";
             $Assigments=array('Assigment','Homework','Test');
             Create_HTML($Assigments);
             echo "</ul>";

     if(isset($_POST['LogOut']))
     {
         $_SESSION['user']=NULL;
         $_SESSION['type']=NULL;
         header("Location: Login.php");
     }

    if(isset($_POST['Catalog'])) {
        header("Location: Catalog.php");
    }


     if(isset($_POST['CreateNewSubject']))
     {
         header("Location: CreateNewSubject.php");
     }
     if(isset($_POST['MySubjects']))
     {
         header("Location: MySubjects.php");
     }
 }
 else
 {
     header("Location: Login.php");
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

<?php
 class Assigment
 {
     public $Size=0;
     public $Materie="";
     public $Dificultate="";
     public $Title="";
     public $Due_Time="";
     public $Nota="0";

     public function __construct($Materie,$Size,$Dificultate,$Title,$Due_Time)
     {
         $this->Title=$Title;
         $this->Due_Time=$Due_Time;
         $this->Size=$Size;
         $this->Materie=$Materie;
         $this->Dificultate=$Dificultate;
     }

     public function setNota($nota)
     {
         $this->Nota=$nota;
     }
     public function Afisare()
     {
         echo "<u><b>Assigment</b></u><br>";
         echo "Materie: ".$this->Materie."<br>";
         echo "Titlu: ".$this->Title."<br>";
         echo "Dificultate: ".$this->Dificultate."<br>";
         echo "Dimensiune: ".$this->Size."<br>";
         echo "Data Predarii: ".$this->Due_Time."<br>";
         echo "Nota: ".$this->Nota."<br>";
     }

 }

 class Test
 {
     public $Materie="";
     public $info="";
     public $Due_Time="";
     public $Nota="";

     public function __construct($Materie,$Due_Time)
     {
         $this->Materie=$Materie;
         $this->Due_Time=$Due_Time;
     }

     public function setNota($nota)
     {
         $this->Nota=$nota;
     }
     public function addInfo($Info)
     {
         $this->info=$Info; //trebuie gandita
     }
     public function Afisare()
     {
         echo "<u><b>Test</b></u><br>";
         echo "Materie: ".$this->Materie."<br>";
         echo "Data: ".$this->Due_Time."<br>";
         echo "Nota: ".$this->Nota."<br>";
     }
 }

 class Tema
 {
     public $Materie="";
     public $info="";
     public $Content="";
     public $Due_Time="";
     public $Nota="";

     public function __construct($Materie,$Due_Time,$Content)
     {
         $this->Materie=$Materie;
         $this->Due_Time=$Due_Time;
         $this->Content=$Content;
     }
     public function setNota($Nota)
     {
         $this->Nota=$Nota;
     }
     public function setInfo($Info)
     {
         $this->info=$Info; //trebuie gandita
     }
     public function Afisare()
     {
         echo "<u><b>Tema</b></u><br>";
         echo "Materie: ".$this->Materie."<br>";
         echo "Data: ".$this->Due_Time."<br>";
         echo "<b>Cerinta</b>:".$this->Content."<br>";
         echo "Nota: ".$this->Nota."<br>";
     }
 }


?>