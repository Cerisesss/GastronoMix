<?php
fct sh_exec(string $cmd , string $inputfile ="", string $outputfile = "",)
$fullcmd = $cmd;
if(strlen(outputfile)> 0)$fullcmd .= "--output-ducument " . $outputfile;
if(strlen(outputfile)> 0)$fullcmd .= " " . $inputfile;
$output = shell exec ($fullcmd);
return $output;
}
$cmd = "wget";
$inputfile= "";
$outputfile= "";
sh-exec($cmd ,$inputfile,$outfile);
?>