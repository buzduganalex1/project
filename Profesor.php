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
		</form>
	</body>
</html>

<?php
session_start();


	if(isset($_SESSION['AssigmentMessage']))
	{
		echo $_SESSION['AssigmentMessage'];
		$_SESSION['AssigmentMessage']="";
	}

	if(isset($_SESSION['user']) && $_SESSION['type']=="Profesor")
	{

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



 /*$info="Tema asta este pentru baietii din cartier<br>Scrieti un eseu sub forma de rap in care sa descrieti viata pe strada.<br>";
 $TW_Assigment=new Assigment("TW",3,"Easy","SMTP","1/2/2012");
 $TW_Test=new Test("TW","1/2/2013");
 $TW_Tema=new Tema("TW",'1/2/2022',$info);

 $TW_Assigment->setNota(5);
 $TW_Test->setNota(10);
 $TW_Tema->setNota(6);

 $TW_Assigment->Afisare();
 $TW_Test->Afisare();
 $TW_Tema->Afisare();*/
?>