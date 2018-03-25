<?php
include 'mod/header.php';
session_start();
extract($_POST);

//+++++Note++++
//Import doesn't handle csv comments since that is now moving to the Student layout page


//Reads the uploaded csv file and parses the headers and row data creating a key/value relationship. Then saves that data into the database.
function importUploadedFile() {
    if (!isset($_FILES["fileUpload"]["tmp_name"]) || empty($_FILES["fileUpload"]["tmp_name"]))
    {
        throw new Exception('Please select a csv file to upload.');
    }
    $dao = new DataAccessObject(INI_FILE_PATH);
    $uploadFile = fopen($_FILES["fileUpload"]["tmp_name"], "r") or die("Unable to open file!");
    $headers = parseHeader($uploadFile);
    //While not the end of the file
    while(!feof($uploadFile)) {
        $row = parseRow($headers, $uploadFile);
        if(empty($row)){ break; }
        saveRow($dao, $row);
      }
    fclose($uploadFile);
}

//Skips the first line of the csv and then saves a list of courses and a list of headers. 
function parseHeader($file) {
    fgets($file); // Ignore initial line that contains garbage
    $firstHeaders = fgetcsv($file);
    $secondHeaders = fgetcsv($file);
    $firstHeaders[0] = $secondHeaders[0]; // Student #
    $firstHeaders[1] = trim($secondHeaders[1]); // Student Name
    $firstHeaders[2] = $secondHeaders[2]; // Level
    
    if($firstHeaders[0] != "Student #" || 
       $firstHeaders[1] != "Student Name" ||
       $firstHeaders[2] != "Level")
    {
            
        throw new Exception("csv contains invalid headers");
    }
    return $firstHeaders;
}

//Gets a row of data from the csv file and uses the header information as a key to the row values
function parseRow($headers, $file) {
    $data = fgetcsv($file);
    $row = array_combine($headers, $data);
    return array_filter($row);
}

//Matches only the coursekey format
function isCourse($str){
    return preg_match('/^\w{3}\d{4}/', $str) === 1;
}

//Takes the data from one row of the csv and saves it in the Student, Course, and StudentCourse table.
function saveRow($dao, $row){
    $dao->saveStudent($row["Student #"], $row["Student Name"]);
    $courses = array_filter($row, "isCourse", ARRAY_FILTER_USE_KEY);
    foreach ($courses as $key => $grade) {
        $dao->saveCourse($key, $row["Level"]);
        $dao->saveStudentCourse($row["Student #"], $key, $grade);
    }
}

if(isset($btnSubmit)) {
    $result='<div class="alert alert-success" style="text-align: center;"><strong>Import Successful!</strong></div>';

    try {
        importUploadedFile();
    } 
    catch (Exception $ex) {
        $result='<div class="alert alert-danger">' . $ex->getMessage() . '</div>';
    }

}

?>
<form id="form_import" method="post" action="f_import.php" enctype="multipart/form-data">
    <div class="offset-sm-2 col-sm-7">
       <h1 class="pb-5">Import a Semester CSV</h1>
    </div>
    <div class="form-group">
        <div class="offset-sm-2 col-sm-7">
            <input class="form-control" type="file" name="fileUpload" accept=".csv"> 
        </div>
    </div>
    <div class="form-group">
        <?php func_btnBuilder("Import", "btnSubmit", "btnGrey", "col-sm-2", "offset-sm-5"); ?>
    </div>
    <div class="form-group">
        <div class="offset-sm-2 col-sm-7">
        <?php echo $result; ?> 
        </div>
    </div>
</form>

<?php include_once 'mod/footer.php' ?>