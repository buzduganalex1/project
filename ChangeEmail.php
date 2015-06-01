<?php include_once "Navigation.php" ?>
<?php include_once "Composer.php" ?>

<?php session_start() ?>
<form method="post">
    <pre>Email Nou</pre><input type="text" name="NewEmail" ><br>
    <input type="submit" name="btnNewEmail" value="Submit">

</form>

<?php
if (isset($_POST['btnNewEmail'])){

    if (   isset($_POST['NewEmail'])
        && !isEmpty($_POST['NewEmail'])
    ){
        $verEmail = new bdxe\UsersQuery();
        $verEmail = $verEmail->findByEmail($_POST['NewEmail'])->count();
        if($verEmail == 0){
            $user = new bdxe\UsersQuery();
            $user = $user->findOneByName($_SESSION['user'])
                ->setEmail($_POST['NewEmail']);
            $user->save();
            if ($_SESSION['type'] == 'Student'){
                $stud = new bdxe\StudentQuery();
                $stud = $stud->findOneByName($_SESSION['user'])
                    ->setEmail($_POST['NewEmail']);
                $stud->save();
            }else {
                $prof = new bdxe\ProfesorQuery();
                $prof = $prof->findOneByName($_SESSION['user'])
                    ->setEmail($_POST['NewEmail']);
                $prof->save();
            }
            echo 'Ati schimbat emailul cu succes';
        }else{
            echo 'Aces email deja este folosit';
        }
    }else {
        echo 'Nu ati completat datele';
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