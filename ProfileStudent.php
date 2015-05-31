<?php include_once "Navigation.php" ?>
<?php include_once "Composer.php" ?>
<?php session_start() ?>
<html>
<title>Student</title>
<body>
<pre class="Title">Student Profile</pre>
<form name="Profile" method="post">
    <input type="submit" name="LogOut" value="Log out">
    <input type="submit" name="Materii" value="Materii Disponibile">
    <input type="submit" name="Groups" value="Grupe">
    <input type="submit" name="ChangeProfileInfo" value="Change Profile Info">
    <input type="submit" name="Groups" value="Grupe">
    <input type="submit" name="ChangeProfileInfo" value="Change Profile Info">
</form>

</body>
</html>

<?php
if(isset($_SESSION['user']) && $_SESSION['type']=="Student")
{
    if(isset($_POST['Groups'])){
        header('Location: Groups.php');
    }

    if(isset($_POST['ChangeProfileInfo'])){
        header('Location: Modific.php');
    }



}


?>