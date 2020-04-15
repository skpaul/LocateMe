<h1>Find Used Files [Multiple Mode]</h1>
<div>Find image, javascript, css or any other files which are not used in your application</div>

<p>For example, you want know if there is any unused image in your images directory, search "./images".</p>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"> 
    <?php
        if (isset($_POST["relative-path"])) {
                $searchFor= $_POST["relative-path"];
        }
        else {
            $searchFor = "";
        }
    ?>
    <input type="text" name="relative-path" value="<?php echo $searchFor ;?>" placeholder="./relative-path/any-dir">
    <input type="submit" name="submit"  value="submit">
</form>

<?php


//  $path = realpath('/localhost/zahin_enterprise_github/contractor_biz/sites');
$batchPath = realpath("./images");
$batchObjects = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($batchPath), 
    RecursiveIteratorIterator::SELF_FIRST);

$searchFiles = array();
foreach($batchObjects as $name => $object){

    if($object->getFilename() === 'findfilea.php') {
        continue;
    }

    $fileName = $object->getFilename();
    $filePath = $object->getPathname();

    if(is_dir($filePath)){
        continue;}

        $searchFiles[] = $fileName;
       // echo  $filePath;
}


//Get the path of this file
$path = dirname(__FILE__);

$objects = new RecursiveIteratorIterator(
               new RecursiveDirectoryIterator($path), 
               RecursiveIteratorIterator::SELF_FIRST);

$ignoredExt = array("png","jpg","jpeg");

$fileFound = 0;

foreach($objects as $name => $object){

     if($object->getFilename() === 'findfilea.php') {
        continue;
    }

    $filePath = $object->getPathname();

    if(is_dir($filePath)){
        continue;
    }

    $ext = pathinfo($filePath, PATHINFO_EXTENSION);

    if(in_array($ext, $ignoredExt)){
        continue;
    }

    $handle = fopen($filePath, 'r');
    $valid = false; // init as false
    $lineNumber = 1;
    while (($buffer = fgets($handle)) !== false) {
        //loop $searchFiles ---->
        foreach ($searchFiles as $fileName) {
            if (strpos($buffer, $fileName) !== false) {
                $newString = str_replace($fileName,"<b>$fileName</b>",$buffer);
                echo "<br>";
                echo  htmlspecialchars($newString) ;
                echo "<br>";
                echo "On Line: $lineNumber";
               // echo $newString;
                echo "<br>";
                echo "File: " . $filePath;
                echo "<br>";
                $valid = TRUE;
            }      
        }
        //<----- loop $searchFiles
        $lineNumber++;
    }
    fclose($handle);
    if($valid)
        $fileFound++;
}

if($fileFound == 0)
    echo "Not found anything.";



?>