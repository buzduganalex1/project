<?php
include_once("Composer.php");
include_once("Navigation.php");
?>


<html>
	<title>Register</title>
	<body>
			<pre class="Title">Registration</pre>

	</body>
</html>

<?php //form


echo "<form method='post'>";
echo"<pre>Username </pre><input type='text' name='Username' value=''><br>";
echo"<pre>Password </pre><input type='password' name='Password'><br><br>";
echo"<pre>Repeat Password </pre><input type='password' name='Password_check'><br><br>";
echo"<pre>Email Adress </pre><input type='email'name='Email' value=''><br><br>";
echo"<select name='type'>";
echo"<option value='Profesor' name='Profesor'>Profesor</option>";
echo"<option value='Student' name='Student'>Student</option>";
echo"</select>";
echo"<input type='submit' name='submit'>";
echo"</form>";

?>

<?php //validare


$Available=true;
	

		if(isset($_POST['submit']))		{
			if( isEmpty($_POST['Username'])){
				echo "<style>.error {color:red;}</style> <p class='error'>Username requiered</p>";	
			}
			if( isEmpty($_POST['Password'])){
				echo "<style>.error {color:red;}</style> <p class='error'>Password requiered</p>";	
			}
			if( isEmpty($_POST['Password_check'])){
				echo "<style>.error {color:red;}</style> <p class='error'>Repeat Password requiered</p>";
			}
			if( isEmpty($_POST['Email'])){
				echo "<style>.error {color:red;}</style> <p class='error'>Email Adress requiered</p>";
			}
			if(!isEmpty($_POST['Username']) && !isEmpty($_POST['Password']) && !isEmpty($_POST['type']) && !isEmpty($_POST['Email']))
			{
				if($_POST['Password']==$_POST['Password_check'])
                {
                    $query=new \bdxe\UsersQuery();

						 if($_POST['type']=='Student')
                         {

                             if(empty($query->findByName($_POST['Username'])->getData()) && empty($query->findByName($_POST['Email'])->getData())){
                                 $Student = new \bdxe\Users();
                                 $Student->setName($_POST['Username']);
                                 $Student->setEmail($_POST['Email']);
                                 $Student->setPassword(md5($_POST['Password']));
                                 $Student->setType("Student");
                                 $Student->save();

                                 $Student = new \bdxe\Student();
                                 $Student->setName($_POST['Username']);
                                 $Student->setEmail($_POST['Email']);
                                 $Student->setPassword(md5($_POST['Password']));
                                 $Student->save();

                                 header("Location: Login.php");
                             }
                             else
                             {
                                 echo "Username sau Email Existent!";
                             }

                         }

                         if($_POST['type']=='Profesor')
                         {

                             if(empty($query->findByName($_POST['Username'])->getData()) && empty($query->findByName($_POST['Email'])->getData())){
                                 $Profesor=new \bdxe\Users();
                                 $Profesor->setName($_POST['Username']);
                                 $Profesor->setEmail($_POST['Email']);
                                 $Profesor->setPassword(md5($_POST['Password']));
                                 $Profesor->setType("Profesor");
                                 $Profesor->save();

                                 $Profesor=new \bdxe\Profesor();
                                 $Profesor->setName($_POST['Username']);
                                 $Profesor->setEmail($_POST['Email']);
                                 $Profesor->setPassword(md5($_POST['Password']));
                                 $Profesor->save();

                                 header("Location: Login.php");
                             }
                             else
                             {
                                 echo "Username sau Email Existent!";
                             }
                         }


				}	
				else
				{
						echo "Passwords do not match";
				}
				
			}
		}
?>
<?php
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