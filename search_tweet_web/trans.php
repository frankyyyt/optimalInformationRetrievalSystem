<?php
session_start();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<?php
  
   require_once('translate.class.php');
 
//Objekt des Translators erzeugen.
//Parameter 1: Anwendungs-ID der registrierten Anwendung.
//Parameter 2: Anwendungsschluessel der registrierten Anwendung.
$BingTranslator = new BingTranslator('bernini2015', 'amj5+UpX6B7K2SO9cHT8dqeDKZfnWuPtxBjwgQQAyXg');
 
//Uebersetzen eines Worts.
//$raw_query="Syrian refugee";
$raw_query=$_SESSION['query'];
$_SESSION['query']=null;
$proc_query=str_replace(" ","%20",$raw_query);
echo $proc_query;
echo "<br/>";

$translation_de = $BingTranslator->getTranslation('en', 'de', $raw_query);
$translation_fr = $BingTranslator->getTranslation('en', 'fr', $raw_query);
$translation_ar = $BingTranslator->getTranslation('en', 'ar', $raw_query);
//Ausgeben des uebersetzten Worts (Hallo).
echo $translation_de;
//echo rawurlencode($translation);
echo "<br/>";

echo $translation_fr;
//echo rawurlencode($translation);
echo "<br/>";

echo $translation_ar;
//echo rawurlencode($translation);
echo "<br/>";


$proc_trans=str_replace(" ","+",$translation_de);

$proc_trans_de=rawurlencode($proc_trans);
echo $proc_trans;
echo "<br/>";
echo $proc_trans_de;
echo "<br/>";

$proc_trans=str_replace(" ","+",$translation_fr);

$proc_trans_fr=rawurlencode($proc_trans);
echo $proc_trans;
echo "<br/>";
echo $proc_trans_fr;
echo "<br/>";



$proc_trans=str_replace(" ","+",$translation_ar);

$proc_trans_ar=rawurlencode($proc_trans);
echo $proc_trans;
echo "<br/>";
echo $proc_trans_ar;
echo "<br/>";



    $ch = curl_init();
    $htps="http://localhost:8983/solr/proj3/select?defType=edismax&qf=text_en%20text_de%20text_fr%20text_ar%20&%20q=%22".$proc_query."%22%20OR%20%22".$proc_trans_de."%22%20OR%20%22".$proc_trans_fr."%22%20OR%20%22".$proc_trans_ar."%22&start=0&rows=500&wt=json&indent=true&facet=true&facet.field=lang";
    echo $htps;
    echo "<br/>";

curl_setopt($ch, CURLOPT_URL, $htps );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$file = curl_exec($ch);
curl_close($ch);

//echo $file;
$json_string=$file;

//echo print_r($json_string,true);            //打印文件的内容

$obj=json_decode($json_string,true);
     if (!is_array($obj)) die('no successful');
     //print_r($obj);
     echo "<br>";
     $faced=$obj['facet_counts']['facet_fields']['lang'];
     $len=count($faced);
     $count=0;
     while($len>=2)
     {
      echo $faced[$count].":".$faced[$count+1]."&nbsp;&nbsp;&nbsp;&nbsp;";
           $count=$count+2;
           $len=$len-2;

     }
     echo "<br>";
     echo "<br>";
     echo "<br>";


         
     //print_r($obj['response']['docs']);
     $respond=$obj['response']['docs'];
     //print_r ($respond['0']);

     foreach ($respond as $key ) {//循环数组
      echo '<li>' . $key['id'] . '</li>';
      echo '<li>' . $key['created_at'] . '</li>';
      echo '<li>' . $key['lang'] . '</li>';
      $lang=$key['lang'];
      if ($lang=="de")
      {
      echo '<li>' . $key['text_de'] . '</li>';
    }

      if ($lang=="en")
      {
        echo '<li>' . $key['text_en'] . '</li>';
      }

      if ($lang=="fr")
      {
      echo '<li>' . $key['text_fr'] . '</li>';
    }

      

      if ($lang=="ar")
      {
      echo '<li>' . $key['text_ar'] . '</li>';
    }

      $htlen=count($key['tweet_hashtags']);
      if ($htlen>=1){
        echo '<li>'."tweet_hashtags: ";
        while ($htlen>=1){
      echo $key['tweet_hashtags'][$htlen-1];
       echo "&nbsp;&nbsp;&nbsp;&nbsp;";
      $htlen=$htlen-1;
    }
      
    echo'</li>';
  }

      


      $htlen=count($key['tweet_urls']);
      if ($htlen>=1){
        echo '<li>'."tweet_urls: ";
        while ($htlen>=1){
      echo $key['tweet_urls'][$htlen-1];
       echo "&nbsp;&nbsp;&nbsp;&nbsp;";
      $htlen=$htlen-1;
    }
      
    echo'</li>';
  }


      echo '<br />';
    
  }
?>