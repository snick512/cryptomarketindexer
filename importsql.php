<?php
require_once "mdie/connect.php";
/* Recycled code
Thanks to,
https://www.webslesson.info/2017/06/how-to-import-sql-file-in-mysql-database-using-php.html

*/


$message = '';
if(isset($_POST["import"]))
{
 if($_FILES["database"]["name"] != '')
 {
  $array = explode(".", $_FILES["database"]["name"]);
  $extension = end($array);
  if($extension == 'sql')
  {
   $connect = mysqli_connect("$servername", "$username", "$password", "$dbname");
   $output = '';
   $count = 0;
   $file_data = file($_FILES["database"]["tmp_name"]);
   foreach($file_data as $row)
   {
    $start_character = substr(trim($row), 0, 2);
    if($start_character != '--' || $start_character != '/*' || $start_character != '//' || $row != '')
    {
     $output = $output . $row;
     $end_character = substr(trim($row), -1, 1);
     if($end_character == ';')
     {
      if(!mysqli_query($connect, $output))
      {
       $count++;
      }
      $output = '';
     }
    }
   }
   if($count > 0)
   {
    $message = '<label class="text-danger">There is an error in Database Import</label>';
   }
   else
   {
    $message = '<label class="text-success">Database Successfully Imported</label>';
   }
  }
  else
  {
   $message = '<label class="text-danger">Invalid File</label>';
  }
 }
 else
 {
  $message = '<label class="text-danger">Please Select Sql File</label>';
 }
}
?>

<!DOCTYPE html>
<html>
 <head>
  <script src="jquery.min.js"></script>
  <script src="bootstrap.min.js"></script>
 </head>
 <body>
   <p>Step 2</p><hr />
   <p>1) Import coinlist.sql from the sql/ directory. <br />2) Import exchanges.sql from the sql/ directory.<br /><br />After both files are imported, proceed to step 3</p>
  <br /><br />
  <div class="container" style="width:700px;">
   <br />
   <div><?php echo $message; ?></div>
   <form method="post" enctype="multipart/form-data">
    <p><label>Select SQL File</label>
    <input type="file" name="database" /></p>
    <br />
    <input type="submit" name="import" value="Import" />
   </form>
  </div>
  <p><a href="?step=3">Continue to Step 3</a></p>
 </body>
</html>
