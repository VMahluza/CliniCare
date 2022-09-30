<?php namespace Views;?>
<?php

  //$acton = VIEWS_PATH . 'DiagnosisForm.php';

  if (isset($_POST) && $_POST != null) {

      
    
  }else {
  
  }

?>

<h1>Patient Diagnosis</h1>
<form action= "DiagnosisForm.php" method="POST">
  <label for="Diagnosis_id">ID</label><br>
  <input type="number" name="Diagnosis_id" id="Diagnosis_id"><br>
  <label for="title">Title</label><br>
  <input type="text" name="title" id="title" required><br>
  <label for="description">Discription</label><br>
  <input type="text" name="description" id="description" required><br>
  <label for="addNotes">Add notes right away?</label><br>
  Yes<input type="radio" name="AddNotes" id="yes" required><br>
  No<input type="radio" name="AddNotes" id="no" value="Yes" required>  
  <br>
  <input type="submit" value="Add Diagnosis">
</form>

