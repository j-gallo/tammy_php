<!--if user is logged in, display form to create a new admin.
    else, display login form.-->
<?php if(isset($_SESSION['logged_in'])) :?>
  <br />
  <form method='POST' action='index.php'>
    <input type="hidden" name="action" value="new" />
    <label for='name'>Name</label>
    <input type='input' name='name'>
    <br />
    <label for='password'>Password</label>
    <input type='password' name='password' />
    <input type='submit' value='New Admin' />
  </form>
<?php else : ?>
  <form method='POST' action='index.php'>
    <input type="hidden" name="action" value="login" />
    <label for='name'>Name</label>
    <input type='input' name='name'>
    <br />
    <label for='password'>Password</label>
    <input type='password' name='password' />
    <input type='submit' value='Login' />
  </form>
<?php endif ?>
