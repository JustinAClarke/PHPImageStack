<?php

$inDir = "/home/stagingsites/cla_justin/data/KbaseDebtors";
$outDir = "/home/stagingsites/cla_justin/data/docs_data";
$outputFile = "70.dat";
$filePattern = "KBASE-CUST";

$debug = true;

$outFile = fopen($outDir."/".$outputFile, "a");

if (!$outFile) {
	throw new Exception("Output file not open.");
	die;
}

//get list of files in dir.
$files = scandir($inDir);

if($debug)
	{print_r($files);}

//for each file, get only the files with the title "KBASE-CUST"
foreach ($files as $file) {
	if($debug)
		{print_r($file);}
	if(strpos($file, $filePattern) !== false)
	{
		if($debug)
			{print_r($file);
			print_r("<br>\n");}

		//with these files, open each, and copy them to external file.
		//unless line is blank.
		$inFile = fopen($inDir."/".$file,"r");

		if ($inFile) {
			if($debug)
				echo "file Open<br>\n";

			while (($line = fgets($inFile)) !== false) {
				// if($debug)
					// print_r($line);
				$lineOut = trim($line);
				if($debug)
					print_r(strlen($lineOut));
				if(strlen($lineOut)>0)
				{
					$out = str_replace(" ", "", $lineOut);
					if($debug)
						echo "lineOut Write: $out <br>\n: end lineOut<br>\n";
					fwrite($outFile, $out. "\n");
				}
			}
			fclose($inFile);

		}
		else
		{
			throw new Exception("Input file not open.");
			die;
		}

		unlink($inDir."/".$file);
	}
}

fclose($outFile);
