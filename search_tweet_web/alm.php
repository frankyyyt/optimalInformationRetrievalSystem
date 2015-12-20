<?php
header('Content-type:text/json'); 
require_once 'alchemyapi.php';
$alchemyapi = new AlchemyAPI();
$myText = "I can't wait to integrate AlchemyAPI's awesome PHP SDK into my app!";
$urladd="http://52.32.49.169:8983/solr/proj3/select?defType=edismax&qf=text_en%20text_de%20text_fr%20text_ar%20&%20q=%22Syrian%20refugee%22%20OR%20%22Syrische%2BFl%C3%BCchtlinge%22%20OR%20%22R%C3%A9fugi%C3%A9s%2Bsyriens%22%20OR%20%22%D8%A7%D9%84%D9%84%D8%A7%D8%AC%D8%A6%D9%8A%D9%86%2B%D8%A7%D9%84%D8%B3%D9%88%D8%B1%D9%8A%D9%8A%D9%86%22&start=0&rows=500&wt=json&indent=true&facet=true&facet.field=lang";

$options["sentiment"]=1;
$response = $alchemyapi->entities("url", $urladd, $options);
//echo "Sentiment: ", $response["docSentiment"]["type"], PHP_EOL;
//echo $response;
echo print_r($response,true); 

//$obj=json_decode($response,true);
$person;
$country;
$p_num=0;
$c_num=0;
echo $response["entities"][0]["type"];
$len=count($response["entities"]);
echo $len;

while ($len>=1){
   $en_type=$response["entities"][$len-1]["type"];
   if ($en_type=="Person")
   {
   	 $person[$p_num]["name"]=$response["entities"][$len-1]["text"];
   	 $person[$p_num]["sen"]=$response["entities"][$len-1]["sentiment"]["type"];
   	 $person[$p_num]["sen_sco"]=$response["entities"][$len-1]["sentiment"]["score"];
   	 $person[$p_num]["ref"]=$response["entities"][$len-1]["relevance"];

      $p_num=$p_num+1;
   }

   if ($en_type=="Country")
   {
       $country[$c_num]["name"]=$response["entities"][$len-1]["text"];
       $country[$c_num]["sen"]=$response["entities"][$len-1]["sentiment"]["type"];
       $country[$c_num]["sen_sco"]=$response["entities"][$len-1]["sentiment"]["score"];
       $country[$c_num]["ref"]=$response["entities"][$len-1]["relevance"];

      $c_num=$c_num+1;
   }


   
   $len=$len-1;

}


$p_num=0;

$p_len=count($person);





echo '<br />';
echo '<br />';

 for( $i=$p_len-1; $i>=0;$i--) {
 	echo "name: ".$person[$i]["name"];
 	echo '<br />';
 	echo "sentiment: ".$person[$i]["sen"];
 	echo '<br />';
 	echo "relevance: ".$person[$i]["ref"];
 	echo '<br />';
 	echo '<br />';

 }





 $c_num=0;

$c_len=count($country);



echo '<br />';
echo '<br />';

 for( $i=$c_len-1; $i>=0;$i--) {
   echo "name: ".$country[$i]["name"];
   echo '<br />';
   echo "sentiment: ".$country[$i]["sen"];
   echo '<br />';
   echo "relevance: ".$country[$i]["ref"];
   echo '<br />';
   echo '<br />';

 }


?>
