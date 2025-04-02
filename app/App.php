<?php

declare(strict_types = 1);

// Your Code

function getTransactionFiles(string $dirPath)
{
    $files = []; 

    foreach(scandir($dirPath) as $file){
        if (is_dir($file)) {
            continue;
        } 
        
        $files[] = $dirPath . $file;
        return $files;
    }
}

function getTransactions($fileName) 
{   
    if (($handle = fopen($fileName, "r")) !== FALSE) {
        fgetcsv($handle, 1000, ",", '"', '\\'); 
        while (($data = fgetcsv($handle, 1000, ",", '"', '\\')) !== FALSE) {
            $transactions[] = $data;
        }
        fclose($handle);
    }
    return $transactions;
}