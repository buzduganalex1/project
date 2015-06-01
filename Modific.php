<?php include_once "Navigation.php" ?>
<?php include_once "Composer.php" ?>

<?php session_start() ?>

<form method="post">
        <input type="submit" name="changeEmail" value="change Email">
        <input type="submit" name="changePassword" value="Change Password">
</form>

    <form method="post">
<?php


if (isset($_POST['changeEmail'])){
    header("Location: ChangeEmail.php");
}



if (isset($_POST['changePassword'])){
    header("Location: ChangePassword.php");
}


?>

</form>
