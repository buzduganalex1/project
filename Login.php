<?php include_once "Navigation.php" ;?>
<?php include_once("Composer.php"); ?>

<html>
	<head>
		<title>Login</title>
		
	</head>
	
	<body>
		<pre class="Title">Login</pre>

		<form method="post" class="">
			<input type="text" name="username"><br>
			<input type="password" name="password"><br>
			<input type="submit" class="Control" name="submit">
		</form>

	</body>
</html>

<?php
session_start();


$Available=false;
$Tip="";

        if(isset($_POST['submit']))
        {
            if(!isEmpty($_POST['username']) && !isEmpty($_POST['password']))
			{

                $query=new bdxe\UsersQuery();
                $Users=$query->find();

                foreach ($Users as $key) {
                    if((!strcmp($_POST['username'], $key->getName()) || !strcmp($_POST['username'], $key->getEmail()) ) && !strcmp(md5($_POST['password']), $key->getPassword())) {
                        $Available=true;
                        $Tip=$key->getType();
                        break;
                    }
                }

                if($Available){
                    $_SESSION['user'] = $_POST['username'];
                    $_SESSION['type'] = $Tip;

                    if($Tip=="Profesor")
                        header("Location: Profesor.php");
                    else
                        header("Location: Student.php");
                }
                else{
                    echo "Password and Username do not match!";
                }

            }
        }




function isEmpty($String)
{
    if(isset($String))
    {
        if(strlen(trim($String))==0)
        {
            return true;
        }
        else
            return false;
    }
}
?>
