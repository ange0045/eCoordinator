<?php
include 'mod/header.php';
session_start();
extract($_POST);


function importUploadedFile() {
    $dao = new DataAccessObject(INI_FILE_PATH);
    $uploadFile = fopen($_FILES["fileUpload"]["tmp_name"], "r") or die("Unable to open file!");
    $headers = parseHeader($uploadFile);
    while(!feof($uploadFile)) {
        $row = parseRow($headers, $uploadFile);
        if(empty($row)){ break; }
        saveRow($dao, $row);
      }
    fclose($uploadFile);
}

function parseHeader($file) {
    fgets($file);
    $courses = fgetcsv($file);
    $headers = fgetcsv($file);
    $courses[0] = $headers[0];
    $courses[1] = trim($headers[1]);
    $courses[2] = $headers[2];
    return $courses;
}

function parseRow($headers, $file) {
    $data = fgetcsv($file);
    $row = array_combine($headers, $data);
    return array_filter($row);
}

function isCourse($str){
    return preg_match('/^\w{3}\d{4}/', $str) === 1;
}

function saveRow($dao, $row){
    $dao->saveStudent($row["Student #"], $row["Student Name"]);
    $courses = array_filter($row, "isCourse", ARRAY_FILTER_USE_KEY);
    foreach ($courses as $key => $grade) {
        $dao->saveCourse($key, $row["Level"]);
        $dao->saveStudentCourse($row["Student #"], $key, $grade);
    }
}

if(isset($btnSubmit)){
    unset($_SESSION['result']);
    
    importUploadedFile();
    
    //Output result message
    if ($error == false) {
        $result='<div class="alert alert-success" style="text-align: center;"><strong>Import Successful!</strong></div>';
    }else {
        $result='<div class="alert alert-danger">Sorry there was an error importing your file. Please check file and try again.</div>';
    }
}

?>
<form id="form_import" method="post" action="f_import.php" enctype="multipart/form-data">
    <div class="offset-sm-2 col-sm-6">
       <h1 class="pb-5">Import a Semester CSV</h1>
    </div>
    <div class="form-group">
        <div class="offset-sm-4 col-sm-6 pb-4">
            <input type="file" name="fileUpload"> 
        </div>
        <div class="offset-sm-6 col sm-4 pb-2">
            <input type="submit" name="btnSubmit" text="Import"></input>
        </div>
    </div>
    <div class="form-group">
        <div class="offset-sm-3 col-sm-6">
        <?php echo $result; ?> 
        </div>
    </div>
</form>

<?php include_once 'mod/footer.php' ?>