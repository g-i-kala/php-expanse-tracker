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

function getTransactions($fileName, ?callable $transactionHandler = null) 
{   
    if (($handle = fopen($fileName, "r")) !== FALSE) {
        fgetcsv($handle, 1000, ",", '"', '\\'); 
        while (($data = fgetcsv($handle, 1000, ",", '"', '\\')) !== FALSE) {
            if($transactionHandler !== null) {
                $transactions[] = $transactionHandler($data);    
            } else {
                $transactions[] = $data;
            }
            
        }
        fclose($handle);
    }
    return $transactions; 
}


function extractAmount($transactionRow) {

        [$date, $checkNumber, $description, $amount] = $transactionRow;

        $amountSanitized = (float)(str_replace(",","",(str_replace("$","",$amount))));
    
    return [
        'date'          => $date,
        'checkNumber'   => $checkNumber,
        'description'   => $description,
        'amount'        => $amountSanitized
    ];
}


function calculateBalance($transactions) {

    $income = 0;
    $expences = 0;

    foreach($transactions as $transaction):

        $amount = $transaction['amount'];
        if ($amount > 0) {
            $income += $amount;
        } else {
            $expences += $amount;
        };

    endforeach;

    return [
        'income' => $income,
        'expences' => $expences,
        'netTotal' => $income + $expences
    ];
}
