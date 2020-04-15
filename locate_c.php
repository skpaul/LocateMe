<h1>Find Unused Files [Multiple Mode]</h1>
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
    <input type="text" name="relative-path" value="<?php echo $searchFor; ?>" placeholder="./relative-path/any-dir">
    <input type="submit" name="submit"  value="submit">
</form>
<?php

/*
This script shows the unused files
*/

if(isset($_POST["submit"])){
    //  $path = realpath('/localhost/zahin_enterprise_github/contractor_biz/sites');

    $relativePath =trim($_POST["relative-path"]);
    $batchPath = realpath($relativePath); //"./images"
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

        $searchFiles[] = array("name"=> $fileName, "path"=>$filePath);
    }


    //Get the path of this file
    $path = dirname(__FILE__);

    $objects = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($path), 
                RecursiveIteratorIterator::SELF_FIRST);

    $ignoredExt = array("png","jpg","jpeg");

    $unusedFileCount = 0;

    $count = count($searchFiles);

    foreach ($searchFiles as $file) {
        $fileNameToSearch =  $file["name"];
        $filePathToSearch =  $file["path"];

        $found = false; // init as false
        foreach($objects as $name => $object){

            $filePath = $object->getPathname();
        
            if(is_dir($filePath)){
                continue;
            }
        
            $ext = pathinfo($filePath, PATHINFO_EXTENSION);
        
            if(in_array($ext, $ignoredExt)){
                continue;
            }
        
            $handle = fopen($filePath, 'r');
        
            $lineNumber = 1;
            while (($buffer = fgets($handle)) !== false) {
            
                if (strpos($buffer, $fileNameToSearch) !== false) {
                    $found = TRUE;
                }      

                $lineNumber++;
            }
            fclose($handle);
        
        }

        if(!$found){
            echo $filePathToSearch . "<br>";
        }
        else {
            $count--;
        }
        
    }

    if($count==0){
        echo "No unused file found";
    }

}


?>