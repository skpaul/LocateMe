<h1>Find Used Files [Single Mode]</h1>
<div>Find image, javascript, css or any other files</div>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"> 
    <?php
        if (isset($_POST["file-name"])) {
                $searchFor= $_POST["file-name"];
        }
        else {
            $searchFor = "";
        }
    ?>
    <input type="text" name="file-name" value="<?php echo $searchFor ;?>" placeholder="logo1.png">
    <input type="submit" name="submit"  value="submit">
</form>

<?php

if(isset($_POST["submit"])){
    $searchString = trim($_POST["file-name"]);
    if(!empty($searchString)){


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
                if (strpos($buffer, $searchString ) !== false) {
                    $newString = str_replace($searchString ,"<b>$searchString</b>",$buffer);
                    echo "<br>";
                    echo $newString;
                    echo "<br>";
                    echo "On Line: $lineNumber";
                    echo "<br>";
                    echo "File: " . $filePath;
                    echo "<br>";
                    $valid = TRUE;
                    // break; // Once you find the string, you should break out the loop.
                }      
                $lineNumber++;
            }
            fclose($handle);
            if($valid)
                $fileFound++;
        
            // $ff = file_get_contents($filePath);
        
            //   if(strpos($ff, "meta") !== false) {
            //     echo $object->getPathname() . "<br>";
            //                 echo "Found" . "<br>";
            //             }
        
            // if($object->getFilename() === 'work.txt') {
            //     echo $object->getPathname();
            // }
        }
        
        if($fileFound == 0)
            echo "Not found anything.";
        
        //Get the path of this file
        $basePath = dirname(__FILE__);
        // search($basePath);


    }
}


?>