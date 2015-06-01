<?php include_once "Navigation.php" ?>
<?php include_once "Composer.php" ?>

<?php session_start() ?>
<form method="post">
    <pre>Old Password</pre><input type="text" name="OldPassword" ><br>
    <pre>New Password</pre><input type="text" name="NewPassword" ><br>
    <pre>Repeat New password</pre><input type="text" name="RepeatNewPassword" ><br>
    <input type="submit" name="btnChangePassword" value="Submit">

</form>
<?php
if (isset($_POST['btnChangePassword'])){
    if (   isset($_POST['OldPassword'])
        && isset($_POST['NewPassword'])
        && isset($_POST['RepeatNewPassword'])
        && !isEmpty($_POST['OldPassword'])
        && !isEmpty($_POST['NewPassword'])
        && !isEmpty($_POST['RepeatNewPassword'])
    ){
        $oldPassword = new bdxe\UsersQuery();
        $oldPassword = $oldPassword->findOneByName($_SESSION['user'])->getPassword();
        if(md5($_POST['OldPassword']) == $oldPassword ){

            if($_POST['NewPassword'] == $_POST['RepeatNewPassword']){
                $user = new bdxe\UsersQuery();
                $user = $user->findOneByName($_SESSION['user'])
                    ->setPassword(md5($_POST['NewPassword']));
                $user->save();

                if ($_SESSION['type'] == 'Student'){
                    $stud = new bdxe\StudentQuery();
                    $stud = $stud->findOneByName($_SESSION['user'])
                        ->setPassword(md5($_POST['NewPassword']));
                    $stud->save();
                }else {
                    $prof = new bdxe\ProfesorQuery();
                    $prof = $prof->findOneByName($_SESSION['user'])
                        ->setPassword(md5($_POST['NewPassword']));
                    $prof->save();
                }
                echo 'Ati schimbat parola cu succes';
            }else{
                echo 'Parolele introduse nu corespund';
            }

        } else {
            echo 'Ati introdus parola veche gresit!';
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