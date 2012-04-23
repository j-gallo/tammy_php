<!-- this file displays the form for uploading a portfolio piece.-->
<form enctype="multipart/form-data" action="upload.php" method="post">
name: <br />
<input type="text" name="title"><br />
year: <br />
<select name='year'>
  <?php for ($i=2000; $i<=2020; $i++): ?>
    <?php if (date('Y') == $i) : ?>
      <option value='<?php echo $i; ?>' selected='selected'><?php echo $i; ?></option>
    <?php endif ?>
    <option value='<?php echo $i; ?>'><?php echo $i; ?></option>
  <?php endfor ?>
</select>
<br />
image: <br />
<input name ="image" type="file"><br />
url: <br />
<input type="text" name="url"><br />
<input type="submit" value="Upload">
</form>
