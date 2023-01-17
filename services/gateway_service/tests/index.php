<?php
$files = scandir("./tests");
unset($files[0], $files[1], $files[array_search('index.php', $files)]);
if(isset($_GET['id_test'])){
    include "./tests/".$_GET['id_test'];
    // echo "<br><br><a href='test'>Back</a><br>";
}
else {
    foreach ($files as $file){
        echo "<a href='test?id_test=$file' >$file</a><br>";
    }
}
