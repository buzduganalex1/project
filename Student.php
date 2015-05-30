<?php include_once "Navigation.php" ?>
<?php include_once "Composer.php" ?>
<?php session_start() ?>
<html>
	<title>Student</title>
	<body>
		<pre class="Title">Student</pre>
		<form name="Profile" method="post">
			<input type="submit" name="LogOut" value="Log out">
            <input type="submit" name="Materii" value="Materii Disponibile">

		</form>

	</body>
</html>
<?php

if(isset($_SESSION['user']) && $_SESSION['type']=="Student")
{
    $query=new bdxe\StudentQuery();
    $Student=$query->findOneByName($_SESSION['user']);
    if($Student->getTeachermessage()!=null) {
        echo $Student->getTeachermessage();
        $Student->setTeachermessage("");
        $Student->save();
    }



	if(isset($_POST['LogOut']))
		{
			$_SESSION['user']=NULL;
			header("Location: Login.php");
		}
    if(isset($_REQUEST['Materii']))
    {
        header("Location: Materii.php");

    }

    NewsFeed();

}
else
		header("Location: Login.php");


class Feed
{
    public $Name="";
    public $PostTime="";
    public $DueTime="";
    public $Type="";


    public function __construct($Name,$PostTime,$Type,$DueTime)
    {
        $this->Name=$Name;
        $this->DueTime=$DueTime;
        $this->PostTime=$PostTime;
        $this->Type=$Type;
    }

    public function getName()
    {
        return $this->Name;
    }

    public function getPostTime()
    {
        return $this->PostTime;
    }

    public function getType()
    {
        return $this->Type;
    }
    public function getDueTime()
    {
        return $this->DueTime;
    }
}

function NewsFeed()
{


    $NewsFeed = array();
    $query2 = new bdxe\SubscriptionQuery();
    $query3 = new bdxe\StudentQuery();
    $Courses = $query2->find();
    $Students = $query3->findOneByName($_SESSION['user']);

    $query = new bdxe\HomeworkQuery();
    $Homeworks = $query->find();

    $query = new bdxe\ProjectQuery();
    $Projects = $query->orderByPosttime();

    $query = new bdxe\TestQuery();
    $Tests = $query->orderByPosttime();

    foreach ($Courses as $key) {
        foreach ($Homeworks as $homework) {
            if ($key->getStudentId() == $Students->getId()) {

                if ($homework->getCourseId() == $key->getCourseId()) {
                    $Object = new Feed($homework->getMaterie(), $homework->getPosttime()->format('Y-m-d H:i:s'), "Homework", $homework->getDuetime()->format('Y-m-d'));
                    array_push($NewsFeed, $Object);
                }
            }

        }
    }
    foreach ($Courses as $key) {
        foreach ($Tests as $homework) {
            if ($key->getStudentId() == $Students->getId()) {

                if ($homework->getCourseId() == $key->getCourseId()) {
                    $Object = new Feed($homework->getMaterie(), $homework->getPosttime()->format('Y-m-d H:i:s'), "Test", $homework->getDuetime()->format('Y-m-d'));
                    array_push($NewsFeed, $Object);
                }
            }

        }
    }

    foreach ($Courses as $key) {
        foreach ($Projects as $homework) {
            if ($key->getStudentId() == $Students->getId()) {

                if ($homework->getCourseId() == $key->getCourseId()) {
                    $Object = new Feed($homework->getMaterie(), $homework->getPosttime()->format('Y-m-d H:i:s'), "Project", $homework->getDuetime()->format('Y-m-d'));
                    array_push($NewsFeed, $Object);
                }
            }

        }
    }


    echo "<br>";
    for($i=0;$i<sizeof($NewsFeed);$i++)
    {
        for($j=0;$j<sizeof($NewsFeed);$j++)
        {
                if($NewsFeed[$i]->PostTime>$NewsFeed[$j]->PostTime) {
                    $aux=$NewsFeed[$j];
                    $NewsFeed[$j]=$NewsFeed[$i];
                    $NewsFeed[$i]=$aux;
                }

        }

    }


    echo "<table class='NewsFeed' BORDER=3 CELLSPACING=3 CELLPADDING=3>";
    echo "<tr>";
    echo "<td><a href='' name='Type'>Type</a></td>";
    echo "<td><a href='' name='Titlu'>Titlu</a></td>";
    echo "<td><a href='' name='DueTime'>Due Time</a></td>";
    echo "<td><a href='' name='PostTime'>Post Time</a></td>";
    echo "</tr>";
        foreach($NewsFeed as $key){
            echo "<tr>";
            echo "<td>$key->Type</td>";
            echo "<td>$key->Name</td>";
            echo "<td>$key->DueTime</td>";
            echo "<td>$key->PostTime</td>";
            echo "</tr>";
        }
    echo "</table>";

}



?>