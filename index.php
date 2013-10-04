<?php
function read_ip($file, $db){
    if($file)
        return fgets($file);
    else 
        return $db->fetchArray()["name"];
}
function parse_arguments(&$file, &$result,&$ip, $argv)
{
    if($argv[1]=="--database")
    {
        $database=$argv[2];
        $ip=$argv[3];
        $db = new SQLite3($database);
        $statement=$db->prepare('SELECT *  FROM networks');
        $result = $statement->execute();
    }
    else{
        $file_name=$argv[1];
        $ip=$argv[2];
        $file = fopen($file_name, "r") or exit("Unable to open file!");
    }
}

$result=null;
$file=null;
parse_arguments($file, $result, $ip, $argv);

$ip_parts=explode(".", $ip);



while($network=read_ip($file,$result))
{
    
    if (strlen($network)<6)
	continue;
    $network_ip_length=strpos($network,"/")+1;
    $subnet_mask=(int)substr($network,$network_ip_length);
    $network_ip_parts=explode(".", substr($network,0,$network_ip_length-1));

    $i=0;
    $is_same=true;
    while ($subnet_mask>=8)
    {
        $subnet_mask-=8;
        if($ip_parts[$i]!=$network_ip_parts[$i])
        {
            $is_same=false;
            break;
        }
        $i++;
    }

    $mask=0b11111111;
    $mask<<=8-$subnet_mask;

    if($is_same && (($ip_parts[$i]& $mask) != ($network_ip_parts[$i]&$mask)))
    {
        $is_same=false;
    }

    if($is_same)
    {
        echo $network;
        if($result)
            echo "\n";
    }    
        
}
if($file)
    fclose($file);
?>