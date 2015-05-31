<?php session_start() ?>
<form>
    <pre>Username </pre><input type='text' name='Username' value=''><br>
    <pre>Old password</pre><input type='text' name='OldPassword' value=''><br>
    <pre>New password</pre><input type='text' name='NewPassword' value=''><br>
    <pre>Repeat new password</pre><input type='text' name='RepeatNewUsername' value=''><br><br>
    <input type="submit" name="" value="Submit">
</form>

<?php
if (isset($_POST['SubmitChanges'])){
    $student = new bdxe\StudentQuery();
}

?>