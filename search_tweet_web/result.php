<?php
session_start();
 if(isset($_POST['search']))
            {
            $_SESSION['query']=$_POST['query'];
            $_SESSION["facedquery"]=$_SESSION["queryhttp"];
            $_SESSION["rawsearch"]=1;
            $_SESSION['translation']=0;
            $_SESSION['lang_type']=null;
            header("Location: result.php");
            //header("Location: result.php");
            
             }
  if(isset($_POST['face']))
            {
            $_SESSION["facedquery"]=$_SESSION["facedquery"]."&fq=".rawurlencode($_POST["person"]);
            $_SESSION["rawsearch"]=0;
            //echo $_SESSION["facedquery"];
            header("Location: result.php");
            
            
             }

  if(isset($_POST['trans']))
            {
            $_SESSION['translation']=1;
            header("Location: result.php");
             }


  if(isset($_POST['lang_en']))
            {
            $_SESSION["lang_type"]="&fq=lang%3Aen";
            header("Location: result.php");
             }
  if(isset($_POST['lang_ar']))
            {
            $_SESSION["lang_type"]="&fq=lang%3Aar";
            header("Location: result.php");
             }
  if(isset($_POST['lang_de']))
            {
            $_SESSION["lang_type"]="&fq=lang%3Ade";
            header("Location: result.php");
             } 

  if(isset($_POST['lang_fr']))
            {
            $_SESSION["lang_type"]="&fq=lang%3Afr";
            header("Location: result.php");
             }          
  
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Optimal Information Retrieval System</title>
  <link href='http://fonts.useso.com/css?family=Roboto+Slab:400,100,300,700|Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" type="text/css" href="css/owl.carousel.css">
    <script src="jquery.quovolver.min.js"></script>
  <!--[if lt IE 9]-->
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <!--[endif]-->
</head>
  <body>
    <!--header starts-->
    <header class="main-header">
      <div class="backbg-color">
        <div class="navigation-bar">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <!--navigation starts-->
                <nav class="navbar navbar-default">
                  

                  <div class="collapse navbar-collapse navbar-left" id="myNavbar1">
                        <form method="post">

             
                    <input type="text" name="query"  placeholder="syrian refugee">
                  
                
                    <button type="submit" name="search">Search</button>

                    
                     
                          <button type="submit" name="trans">translation tweets</button>
                          
                  
                            
                        </form>
                  </div>


                </nav>
                <!--navigation ends-->
              </div>
            </div>
          </div>
        </div>
        <p><br /></p>;
        <!--banner starts-->

        <center>
        <table border="0" cellspacing="20" width="1140" bgcolor="white">
          <tr>
            <td bgcolor="white" width="10">
            </td>
            <td bgcolor="white" style="vertical-align:top">
              
                   <table border="0" cellspacing="20" width="200">
                      <tr>
                      

                      <td width="180" >
                      <form method="post">

                      <p>Person:</p>

                       <?php require_once 'alchemyapi.php';
                        $alchemyapi = new AlchemyAPI();
                        //$myText = "I can't wait to integrate AlchemyAPI's awesome PHP SDK into my app!";
                        if ($_SESSION["rawsearch"]==0)
                        {
                        $urladd=$_SESSION["facedquery"];
                      }
                        else {
                        $urladd="http://52.32.49.169:8983/solr/proj3/select?q=".$_SESSION['query']."&start=0&rows=100&wt=json&indent=true";
                      }
                        //echo ($_SESSION["rawsearch"]);


                        $options["sentiment"]=1;
                        $response = $alchemyapi->entities("url", $urladd, $options);
                        //echo "Sentiment: ", $response["docSentiment"]["type"], PHP_EOL;
                        //echo $response;
                        //echo print_r($response,true); 

                        //$obj=json_decode($response,true);
                        $person;
                        $p_num=0;
                        $country;
                        $c_num=0;
                        $city;
                        $city_num=0;
                        $hashtag;
                        $hash_num=0;
                        //echo $response["entities"][0]["type"];
                        $len=count($response["entities"]);
                        //echo $len;

                        while ($len>=1){
                           $en_type=$response["entities"][$len-1]["type"];
                           if ($en_type=="Person")
                           { 
                            if ($response["entities"][$len-1]["text"]!="lang") {
                              # code...
                            
                             $person[$p_num]["name"]=$response["entities"][$len-1]["text"];
                             $person[$p_num]["sen"]=$response["entities"][$len-1]["sentiment"]["type"];
                             $person[$p_num]["sen_sco"]=$response["entities"][$len-1]["sentiment"]["score"];
                             $person[$p_num]["ref"]=$response["entities"][$len-1]["relevance"];
                             $person[$p_num]["count"]=$response["entities"][$len-1]["count"];
                              
                              $p_num=$p_num+1;
                            }
                           }


                           if ($en_type=="Country")
                              {
                               $country[$c_num]["name"]=$response["entities"][$len-1]["text"];
                               $country[$c_num]["sen"]=$response["entities"][$len-1]["sentiment"]["type"];
                               $country[$c_num]["sen_sco"]=$response["entities"][$len-1]["sentiment"]["score"];
                               $country[$c_num]["ref"]=$response["entities"][$len-1]["relevance"];
                               $country[$c_num]["count"]=$response["entities"][$len-1]["count"];

                              $c_num=$c_num+1;
                           }

                           if ($en_type=="City")
                              {
                               $city[$city_num]["name"]=$response["entities"][$len-1]["text"];
                               $city[$city_num]["sen"]=$response["entities"][$len-1]["sentiment"]["type"];
                               $city[$city_num]["sen_sco"]=$response["entities"][$len-1]["sentiment"]["score"];
                               $city[$city_num]["ref"]=$response["entities"][$len-1]["relevance"];
                               $city[$city_num]["count"]=$response["entities"][$len-1]["count"];

                              $city_num=$city_num+1;
                           }

                           if ($en_type=="Hashtag")
                              {
                               $hashtag[$hash_num]["name"]=$response["entities"][$len-1]["text"];
                               $hashtag[$hash_num]["sen"]=$response["entities"][$len-1]["sentiment"]["type"];
                               $hashtag[$hash_num]["sen_sco"]=$response["entities"][$len-1]["sentiment"]["score"];
                               $hashtag[$hash_num]["ref"]=$response["entities"][$len-1]["relevance"];
                               $hashtag[$hash_num]["count"]=$response["entities"][$len-1]["count"];

                              $hash_num=$hash_num+1;
                           }
                           //echo $hash_num;


                           
                           $len=$len-1;

                        }


                        $p_num=0;

                        $p_len=count($person);

                         for( $i=$p_len-1; ($i>=$p_len-4)&($i>=0);$i--) {
                          echo "<input type=\"radio\" name=\"person\"  value=\"".$person[$i]["name"]."\" checked=\"checked\">";
                          echo " ".$person[$i]["name"]."(".$person[$i]["count"].")";
                          echo "<br />";
                          //echo '<br />';
                          //echo "sentiment: ".$person[$i]["sen"];
                          //echo '<br />';
                          //echo "relevance: ".$person[$i]["ref"];
                          //echo '<br />';
                          //echo '<br />';

                         }


                        echo "<br />";
                        echo "<p>Country:</p>";
                         
                         $c_num=0;

                         $c_len=count($country);
                         //echo $c_len;

                         for( $i=$c_len-1; ($i>=$c_len-4)&($i>=0);$i--) {
                          echo "<input type=\"radio\" name=\"person\"  value=\"".$country[$i]["name"]."\" checked=\"checked\">";
                          echo " ".$country[$i]["name"]."(".$country[$i]["count"].")";
                          echo "<br />";
                          


                        }
                          
                        echo "<br />";
                        echo "<p>City:</p>";


                          $city_num=0;

                         $city_len=count($city);
                         //echo $city_len;

                         for( $i=$city_len-1; ($i>=$city_len-4)&($i>=0);$i--) {
                          echo "<input type=\"radio\" name=\"person\"  value=\"".$city[$i]["name"]."\" checked=\"checked\">";
                          echo " ".$city[$i]["name"]."(".$city[$i]["count"].")";
                          echo "<br />";
                         
                        }



                        echo "<br />";
                        echo "<p>Hashtag:</p>";


                          $hash_num=0;

                         $hash_len=count($hashtag);
                         //echo $city_len;

                         for( $i=$hash_len-1; ($i>=$hash_len-4)&($i>=0);$i--) {
                          echo "<input type=\"radio\" name=\"person\"  value=\""."tweet_hashtags:".$hashtag[$i]["name"]."\" checked=\"checked\">";
                          echo " ".$hashtag[$i]["name"]."(".$hashtag[$i]["count"].")";
                          echo "<br />";
                        }








                        ?>






                     
                      <br />

                      <br />
                       <button type="submit" width="50" name="face">Faceted Search</button>
                      
              
                     
                          
                          
                  
                            
                        </form>


                      </td>
                      </tr> 
        </table> 
                     
            </td>
          

        <td bgcolor="white" style="vertical-align:top">      
        <div style="overflow-x: auto; overflow-y: auto; height: 750px; width:589px;">
        <table border="0" cellspacing="20"  bgcolor="white" width="590">
      <tr>
                      

                      <td width="590" >
                        <center>
                          <p>Langer fliter:</p>
                        <form method="post">
                               <button type="submit" width="50" name="lang_en">English</button>
                               
                               <button type="submit" width="50" name="lang_de">German</button>
                               <button type="submit" width="50" name="lang_fr">French</button>
                               <button type="submit" width="50" name="lang_ar">Arabic</button>

                        </form>



                        <?php
                                                        require_once('translate.class.php');
                                                         
                                                        $BingTranslator = new BingTranslator('bernini2015', 'amj5+UpX6B7K2SO9cHT8dqeDKZfnWuPtxBjwgQQAyXg');
                                                         
                                                        
                                                        $raw_query=$_SESSION['query'];

                                                        $proc_query=str_replace(" ","%20",$raw_query);
                                                        $proc_query=rawurlencode($proc_query);



                                                        $translation_de = $BingTranslator->getTranslation('en', 'de', $raw_query);
                                                        $translation_fr = $BingTranslator->getTranslation('en', 'fr', $raw_query);
                                                        $translation_ar = $BingTranslator->getTranslation('en', 'ar', $raw_query);
                                                        

                                                        $proc_trans=str_replace(" ","+",$translation_de);

                                                        

                                                        $proc_trans_de=rawurlencode($proc_trans);
                                                        

                                                        $proc_trans=str_replace(" ","+",$translation_fr);

                                                        $proc_trans_fr=rawurlencode($proc_trans);
                                                        


                                                        $proc_trans=str_replace(" ","+",$translation_ar);

                                                        $proc_trans_ar=rawurlencode($proc_trans);
                                                        



                                                            $ch = curl_init();
                                                            $htps="http://52.32.49.169:8983/solr/proj3/select?defType=edismax&qf=text_en%20text_de%20text_fr%20text_ar%20&%20q=".$proc_query."%20OR%20".$proc_trans_de."%20OR%20".$proc_trans_fr."%20OR%20".$proc_trans_ar."&start=0&rows=50&wt=json&indent=true&facet=true&facet.field=lang&facet.field=tweet_hashtags";
                                                            //echo $htps;
                                                            //echo "<br/>";
                                                        $_SESSION["queryhttp"]=$htps;

                                                        if ($_SESSION["rawsearch"]==1)
                                                        {
                                                            $_SESSION["facedquery"]=$_SESSION["queryhttp"];
                                                        }
                                                        //echo $_SESSION["facedquery"];
                                                        $http_lang=$_SESSION["facedquery"].$_SESSION['lang_type'];
                                                        //echo $http_lang;


                                                        curl_setopt($ch, CURLOPT_URL,$http_lang);


                                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                                        $file = curl_exec($ch);
                                                        curl_close($ch);

                                                        //echo $file;
                                                        $json_string=$file;

                                                        //echo print_r($json_string,true);            //打印文件的内容

                                                        $obj=json_decode($json_string,true);
                                                             if (!is_array($obj)) die('no successful');
                                                             //print_r($obj);
                                                             //echo "<br>";
                                                             $faced=$obj['facet_counts']['facet_fields']['lang'];
                                                             $len=count($faced);
                                                             $count=0;
                                                             echo "\r\n";
                                                             while($len>=2)
                                                             {
                                                              //echo $faced[$count].":".$faced[$count+1]."&nbsp;&nbsp;&nbsp;&nbsp;";
                                                                   if ($faced[$count]=="en") { $en_num=$faced[$count+1];};
                                                                   if ($faced[$count]=="de") { $de_num=$faced[$count+1];};
                                                                   if ($faced[$count]=="fr") { $fr_num=$faced[$count+1];};
                                                                   if ($faced[$count]=="ar") { $ar_num=$faced[$count+1];};
                                                                   $count=$count+2;
                                                                   $len=$len-2;
                                                                   
                                                              

                                                             }

                                                             $hastag_obj=$obj['facet_counts']['facet_fields']['tweet_hashtags'];


                                                             $htg1=$hastag_obj[0];
                                                             $htg2=$hastag_obj[2];
                                                             $htg3=$hastag_obj[4];
                                                             $htg4=$hastag_obj[6];
                                                             $htg5=$hastag_obj[8];
                                                             $htg6=$hastag_obj[10];
                                                             $htg7=$hastag_obj[12];
                                                             $htg8=$hastag_obj[14];


                                                             $hvol1=$hastag_obj[1];
                                                             $hvol2=$hastag_obj[3];
                                                             $hvol3=$hastag_obj[5];
                                                             $hvol4=$hastag_obj[7];
                                                             $hvol5=$hastag_obj[9];
                                                             $hvol6=$hastag_obj[11];
                                                             $hvol7=$hastag_obj[13];
                                                             $hvol8=$hastag_obj[15];

                                                             

                                                        

                                                    ?>
                                                          <script src="Chart.js"></script>
                                                          <div style="width: 85%">
                                                            <canvas id="canvas" height="300" width="590"></canvas>
                                                          </div>


                                                          <script>
                                                          var en_count = "<?php echo $en_num;?>";
                                                          var de_count = "<?php echo $de_num;?>";
                                                          var fr_count = "<?php echo $fr_num;?>";
                                                          var ar_count = "<?php echo $ar_num;?>";
                                                          //alert(en_count);

  
                                                            var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

                                                            var barChartData = {
                                                              labels : ["English","German","French","Arabic"],
                                                              datasets : [
                                                                {
                                                                  fillColor : "rgba(151,187,205,0.5)",
                                                                  strokeColor : "rgba(151,187,205,0.8)",
                                                                  highlightFill : "rgba(151,187,205,0.75)",
                                                                  highlightStroke : "rgba(151,187,205,1)",
                                                                  data : [en_count,de_count,fr_count,ar_count]
                                                                }
                                                              ]

                                                            }
                                                            function onload1(){
                                                              var ctx = document.getElementById("canvas").getContext("2d");
                                                              window.myBar = new Chart(ctx).Bar(barChartData, {
                                                                responsive : true
                                                              });
                                                            }

                                                            </script>












                
                                                
                                           </center>
                                              







                        <?php

                                                     
                                                      echo '<br />';  
                                                       //print_r($obj['response']['docs']);
                                                       $respond=$obj['response']['docs'];
                                                       //$_SESSION['translation']=1;
                                                       //print_r ($respond['0']);

                                                       foreach ($respond as $key ) {//循环数组
                                                        
                                                        $lang=$key['lang'];
                                                        if ($lang=="de")
                                                        {
                                                        echo "<li><p>Tweet_text: </p></li>";
                                                          echo "<p style=\"color:#0000ff\">" . $key['text_de'] . "</p></li>";
                                                           if ($_SESSION['translation']==1){
                                                          //$translation_res = $BingTranslator->getTranslation('de', 'en', $key['text_de']);
                                                          echo "<li><p>Translation: </p></li>";
                                                          echo "<p style=\"color:red\">" .$translation_de." ——> ".$raw_query. "</p></li>"; }
                                                          else
                                                          {
                                                            //echo $_SESSION['translation'];
                                                          }
                                                          

                                                      }

                                                        if ($lang=="en")
                                                        { echo "<li><p>Tweet_text: </p></li>";
                                                          echo "<p style=\"color:#0000ff\">" . $key['text_en'] . "</p></li>";
                                                        }

                                                        if ($lang=="fr")
                                                        {
                                                        echo "<li><p>Tweet_text: </p></li>";
                                                          echo "<p style=\"color:#0000ff\">" . $key['text_fr'] . "</p></li>";
                                                          if ($_SESSION['translation']==1){
                                                          //$translation_res = $BingTranslator->getTranslation('fr', 'en', $key['text_fr']);
                                                          echo "<li><p>Translation: </p></li>";
                                                          echo "<p style=\"color:red\">" .$translation_fr." ——> ".$raw_query. "</p></li>";}
                                                      }

                                                        

                                                        if ($lang=="ar")
                                                        {
                                                        echo "<li><p>Tweet_text: </p></li>";
                                                          echo "<p style=\"color:#0000ff\">" . $key['text_ar'] . "</p></li>";
                                                          if ($_SESSION['translation']==1){
                                                          //$translation_res = $BingTranslator->getTranslation('ar', 'en', $key['text_ar']);
                                                          echo "<li><p>Translation: </p></li>";
                                                          echo "<p style=\"color:red\">" .$translation_ar." ——> ".$raw_query. "</p></li>";}
                                                      }

                                                        //$_SESSION['translation']=0;


                                                        //echo '<li>' . $key['id'] . '</li>';
                                                        echo '<li>Created_at: ' . $key['created_at'] . '</li>';
                                                        echo '<li>Language: ' . $key['lang'] . '</li>';
                                                        

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
                                                        echo '<br />';
                                                      
                                                    }
                                                    //$_SESSION['translation']=0;
                                      ?>

                       

                      </td>
                      

           </tr>
        </table>
        </td>

        <td style="vertical-align:top">
                  <div style="overflow-x: auto; overflow-y: auto; height: 750px; width:349px;">


                   <table border="0" cellspacing="20" width="350" bgcolor="white">
                      <tr>
                      

                      <td width="400"  bgcolor="white">
                      
                    <center>
                    <?php

                              $raw_query_c=$_SESSION['query'];
              // $raw_query = $_GET['query'];//  $raw_query=$_SESSION['query'];// //$_SESSION['query']=null;
                              $proc_query_c=str_replace(" ","%20",$raw_query_c); // //echo $proc_query; // //echo "<br/>";
                              //echo "<br>";
                              $ch_c = curl_init();
                              //  "http://localhost:8983/solr/booksdemo/clustering?defType=edismax&wt=json&indent=true&fl=name&q=paris+attack&rows=100&clustering.engine=kmeans"   stc;
                              $htps_c="http://52.32.49.169:9090/solr/booksdemo/clustering?defType=edismax&%20q=".$proc_query."&start=0&rows=100&wt=json&indent=true&clustering.engine=stc";
                              // echo $htps;
                              //echo "<br/>";
                              curl_setopt($ch_c, CURLOPT_URL, $htps_c );
                              curl_setopt($ch_c, CURLOPT_RETURNTRANSFER, 1);
                              $file_c = curl_exec($ch_c);
                              curl_close($ch_c);  //echo $file;
                              $json_string_c=$file_c;  // echo print_r($json_string,true);            //打印文件的内容
                              $obj_c=json_decode($json_string_c,true);
                              if (!is_array($obj_c)) die('no successful');     
                              //echo "<br>";
                              //echo "<br/>";
                              $clusters=$obj_c['clusters'];

                               //number of clustering
                              $nlen=count($clusters);  
                               //arraylist for clustering title
                               $array=array();
                              //arraylist for number of clustering doc
                               $ndon=array();
                              //arraylist for score of clustering
                               $nscore=array();

                              if($nlen>0){      
                               //output number of clustering 
                              //echo "<li><p style=\"color:red\">" ."Number of Clustering ",$nlen ; 
                              //echo '</p></li>';
                              }     
                              foreach ($clusters as $key ) {    //循环数组 
                                //echo "<br>"; 
                                //echo "Score of clustering: ",$key['score'] ; 
                                $nscore[]=$key['score'];

                                //echo "<br>"; 

                                // the length of every clustering arrray 
                              $htlen_c=count($key['labels']);
                             //output clustering title
                              //echo "<li><p style=\"color:red\">"."Clustering title: ";
                              if ($htlen_c>=1){                              
                               //数组输出
                                $x=0;
                                $test=null;
                                while ($x<$htlen_c){
                                   // echo $key['labels'][$x];
                                   // echo "&nbsp;&nbsp;&nbsp;&nbsp;";
                                  // // //字符串输出
                                  $test=$test."   ".$key['labels'][$x];
                                  $x=$x+1;
                                }
                                //echo $test;
                                $array[] = $test;
                                //echo "<br>"; 
                                //echo'</p></li>';
                              }

                              //Output number of doc per clustering and doc title
                              $dlen=count($key['docs']);
                              $ndon[]=$dlen;

                              $toplab1=$array[0];
                              $docnum1=$ndon[0];
                              $toplab2=$array[1];
                              $docnum2=$ndon[1];
                              $toplab3=$array[2];
                              $docnum3=$ndon[2];
                              $toplab4=$array[3];
                              $docnum4=$ndon[3];
                              $toplab5=$array[4];
                              $docnum5=$ndon[4];


                              //echo "<li><p style=\"color:#0000ff\">" ."Number of Docs: ",$dlen,  "</p></li>";
                            }




                      ?>





                      <p>Topic circle</p>











                     


                     <script src="Chart.js"></script>
                      <style>
                        body{
                          padding: 0;
                          margin: 0;
                        }
                        #canvas-holder{
                          width:85%;
                        }
                      </style>
                       <div id="canvas-holder">
                        <canvas id="chart-area" width="300" height="300"/>
                      </div>


                                <script>

                                 



                                  var toplab1="<?php echo $toplab1 ?>";
                                  var docnum1="<?php echo $docnum1 ?>";
                                  var toplab2="<?php echo $toplab2 ?>";
                                  var docnum2="<?php echo $docnum2 ?>";
                                  var toplab3="<?php echo $toplab3 ?>";
                                  var docnum3="<?php echo $docnum3 ?>";
                                  var toplab4="<?php echo $toplab4 ?>";
                                  var docnum4="<?php echo $docnum4 ?>";
                                  var toplab5="<?php echo $toplab5 ?>";
                                  var docnum5="<?php echo $docnum5 ?>";
                                

                                  var doughnutData = [
                                      {
                                        value: docnum1,
                                        color:"#F7464A",
                                        highlight: "#FF5A5E",
                                        label: toplab1
                                      },
                                      {
                                        value: docnum2,
                                        color: "#46BFBD",
                                        highlight: "#5AD3D1",
                                        label: toplab2
                                      },
                                      {
                                        value: docnum3,
                                        color: "#FDB45C",
                                        highlight: "#FFC870",
                                        label: toplab3
                                      },
                                      {
                                        value: docnum4,
                                        color: "#949FB1",
                                        highlight: "#A8B3C5",
                                        label: toplab4
                                      },
                                      {
                                        value: docnum5,
                                        color: "#4D5360",
                                        highlight: "#616774",
                                        label: toplab5
                                      }

                                    ];

                                function onload2(){
                                    var ctx = document.getElementById("chart-area").getContext("2d");
                                    window.myDoughnut = new Chart(ctx).Doughnut(doughnutData, {responsive : true});

                                   }

                                  </script>


                                  </center> 

                                  <?php
                                  echo '<br />';

                                  echo "<font  color=#F7464A>"."1. ".$toplab1."</font>";
                                  echo '<br />';
                                  echo "<font  color=#46BFBD>"."2. ".$toplab2."</font>";
                                  echo '<br />';
                                  echo "<font  color=#FDB45C>"."3. ".$toplab3."</font>";
                                  echo '<br />';
                                  echo "<font  color=#949FB1>"."4. ".$toplab4."</font>";
                                  echo '<br />';
                                  echo "<font  color=#4D5360>"."5. ".$toplab5."</font>";








                                  ?>









                    <script type="text/javascript">

                      window.onload=function(){ 
                       onload1();
                       onload2();
                       onload3();
                       onload4();


                      }
                      </script>
                                

                       


                      
                                                  

                                        </td>
                                  </tr> 

                                  <tr>
                                      <td width="350"  bgcolor="white">
                                        <center>
                                          
                                        <p><br /></p>
                                          <?php 

                                           require_once 'alchemyapi.php';
                                            $alchemyapi2 = new AlchemyAPI();
                                            
                                            
                                            
                                            //$urladd="http://52.32.49.169:8983/solr/proj3/select?q=".$_SESSION['query']."&fq=lang%3Aen&start=0&rows=100&wt=json&indent=true";
                                            

                                            require_once 'alchemyapi.php';
                                            $alchemyapi = new AlchemyAPI();

                                            
                                            if ($_SESSION["rawsearch"]==0)
                                            {
                                              $myurl=$_SESSION["facedquery"];
                                            }
                                              else {
                                              $myurl="http://52.32.49.169:8983/solr/proj3/select?q=".$_SESSION['query']."&start=0&rows=100&wt=json&indent=true";
                                            }
                                            $response2 = $alchemyapi2->sentiment("url", $myurl, null);

                                            $sen=$response2["docSentiment"]["type"];
                                            $sen_socore=$response2["docSentiment"]["score"];
                                            echo " The query results generally are";
                                            echo '<br />';
                                            echo '<br />';
                                            if ($sen=="negative")
                                            {echo "<p style=\"color:blue;font-size:26px;\">".$sen."(".$sen_socore.")"."</p>";}
                                            else {
                                              if ($sen=="positive")
                                              {
                                                echo "<p style=\"color:red;font-size:26px;\">".$sen."(".$sen_socore.")"."</p>";
                                              }
                                               else{
                                                echo "<p style=\"font-size:26px;\">".$sen."(".$sen_socore.")"."</p>";
                                               }

                                             }
                                            

                                            


                                            



                        ?>



                                        </center>
                                      </td>

                                  </tr>

                                  <tr>

                                    <td  height="400" bgcolor="white">


                                                      <?php 

                                                         
                                                          
                                                          
                                                          
                                                          //$urladd="http://52.32.49.169:8983/solr/proj3/select?q=".$_SESSION['query']."&fq=lang%3Aen&start=0&rows=100&wt=json&indent=true";
                                                          

                                                          require_once 'alchemyapi.php';
                                                          $alchemyapi3 = new AlchemyAPI();

                                                          //en
                                                          if ($_SESSION["rawsearch"]==0)
                                                          {
                                                            $myurl=$_SESSION["facedquery"]."&fq=lang%3Aen";
                                                          }
                                                            else {
                                                            $myurl="http://52.32.49.169:8983/solr/proj3/select?q=".$_SESSION['query']."&fq=lang%3Aen"."&start=0&rows=10&wt=json&indent=true";
                                                          }
                                                          $response3 = $alchemyapi3->sentiment("url", $myurl, null);

                                          
                                                          $s_en_socore=$response3["docSentiment"]["score"];
                                                          //echo $s_en_socore;





                                                        //de
                                                          $alchemyapi3 = new AlchemyAPI();

                                                          
                                                          if ($_SESSION["rawsearch"]==0)
                                                          {
                                                            $myurl=$_SESSION["facedquery"]."&fq=lang%3Ade";
                                                          }
                                                            else {
                                                            $myurl="http://52.32.49.169:8983/solr/proj3/select?q=".$translation_de."&fq=lang%3Ade"."&start=0&rows=10&wt=json&indent=true";
                                                          }
                                                          $response3 = $alchemyapi3->sentiment("url", $myurl, null);

                                          
                                                          $s_de_socore=$response3["docSentiment"]["score"];
                                                          //echo $s_de_socore;




                                                          //fr
                                                          $alchemyapi3 = new AlchemyAPI();

                                                          
                                                          if ($_SESSION["rawsearch"]==0)
                                                          {
                                                            $myurl=$_SESSION["facedquery"]."&fq=lang%3Afr";
                                                          }
                                                            else {
                                                            $myurl="http://52.32.49.169:8983/solr/proj3/select?q=".$translation_fr."&fq=lang%3Afr"."&start=0&rows=10&wt=json&indent=true";
                                                          }
                                                          $response3 = $alchemyapi3->sentiment("url", $myurl, null);

                                          
                                                          $s_fr_socore=$response3["docSentiment"]["score"];
                                                          //echo $s_fr_socore;


                                                         //ar

                                                          $alchemyapi3 = new AlchemyAPI();

                                                          
                                                          if ($_SESSION["rawsearch"]==0)
                                                          {
                                                            $myurl=$_SESSION["facedquery"]."&fq=lang%3Aar";
                                                          }
                                                            else {
                                                            $myurl="http://52.32.49.169:8983/solr/proj3/select?q=".$translation_ar."&fq=lang%3Aar"."&start=0&rows=10&wt=json&indent=true";
                                                          }
                                                          $response3 = $alchemyapi3->sentiment("url", $myurl, null);

                                          
                                                          $s_ar_socore=$response3["docSentiment"]["score"];
                                                          //echo $s_ar_socore;















                                                          

                                                    ?>

                                                        <center>
                                                          <P>cultural differences of sentiment</P>
                                                        <script src="Chart.js"></script>
                                                      <style>
                                                        body{
                                                          padding: 0;
                                                          margin: 0;
                                                        }
                                                        #canvas-holder{
                                                          width:85%;
                                                        }
                                                      </style>
                                                       <div id="canvas-holder">
                                                        <canvas id="chart-area2" width="300" height="300"/>
                                                      </div>


                                                                <script>
                                                                var en_color="#EA0000";
                                                                var de_color="#EA0000";
                                                                var fr_color="#EA0000";
                                                                var ar_color="#EA0000";


                                                                var en_sen = "<?php echo $s_en_socore;?>";
                                                                if (en_sen<0)
                                                                  en_color="#0000c6";
                                                               var de_sen = "<?php echo $s_de_socore;?>";
                                                               if (de_sen<0)
                                                                  de_color="#0000c6";
                                                               var fr_sen = "<?php echo $s_fr_socore;?>";
                                                               if (fr_sen<0)
                                                                  fr_color="#0000c6";
                                                               var ar_sen = "<?php echo $s_ar_socore;?>";
                                                               if (ar_sen<0)
                                                                  ar_color="#0000c6";



                                                                  var doughnutData2 = [
                                                                      {
                                                                        value: en_sen,
                                                                        color: en_color,
                                                                        highlight: "#FFC870",
                                                                        label: "English"
                                                                      },
                                                                      {
                                                                        value: de_sen,
                                                                        color: de_color,
                                                                        highlight: "#FFC870",
                                                                        label: "Deutsch"
                                                                      },
                                                                      {
                                                                        value: fr_sen,
                                                                        color: fr_color,
                                                                        highlight: "#FFC870",
                                                                        label: "French"
                                                                      },
                                                                      {
                                                                        value: ar_sen,
                                                                        color: ar_color,
                                                                        highlight: "#FFC870",
                                                                        label: "Arabic"
                                                                      }


                                                                    ];

                                                                function onload3(){
                                                                    var ctx = document.getElementById("chart-area2").getContext("2d");
                                                                    window.myDoughnut = new Chart(ctx).Doughnut(doughnutData2, {responsive : true});

                                                                   }

                                                                  </script>

                                                            </center>
                                    </td>
                                  </tr>



                            </table>
                          </div>



                        </td>
                    </tr>
              </table>

              <font></br></font>

            </center>
            <center>
              <table border="0" cellspacing="20" width="1140" height="330" bgcolor="white">
                <tr>
                  <td bgcolor="white">
                    <center>
                    <p>Hash_tage volume</p>

                    <script src="Chart.js"></script>
                    <div style="width: 95%">
                        <canvas id="canvas5" height="300" width="1140"></canvas>
                      </div>
                            <script>
                                          //var randomScalingFactor = function(){ return Math.round(Math.random()*100)};


                                          var htg1= "<?php echo $htg1;?>";
                                          var htg2 = "<?php echo $htg2;?>";
                                          var htg3 = "<?php echo $htg3;?>";
                                          var htg4 = "<?php echo $htg4;?>";
                                          var htg5 = "<?php echo $htg5;?>";
                                          var htg6 = "<?php echo $htg6;?>";
                                          var htg7 = "<?php echo $htg7;?>";
                                          var htg8 = "<?php echo $htg8;?>";


                                          var hvol1 = "<?php echo $hvol1;?>";
                                          var hvol2 = "<?php echo $hvol2;?>";
                                          var hvol3 = "<?php echo $hvol3;?>";
                                          var hvol4 = "<?php echo $hvol4;?>";
                                          var hvol5 = "<?php echo $hvol5;?>";
                                          var hvol6 = "<?php echo $hvol6;?>";
                                          var hvol7 = "<?php echo $hvol7;?>";
                                          var hvol8 = "<?php echo $hvol8;?>";





                                          var barChartData5 = {
                                            labels : [ htg1, htg2, htg3, htg4, htg5,htg6, htg7,htg8 ],
                                            datasets : [
                                              {
                                                fillColor : "rgba(151,187,205,0.9)",
                                                strokeColor : "rgba(220,220,220,0.8)",
                                                highlightFill: "rgba(220,220,220,0.75)",
                                                highlightStroke: "rgba(220,220,220,1)",
                                                data : [hvol1, hvol2, hvol3, hvol4,hvol5,hvol6,hvol7, hvol8]
                                              }
                                            ]

                                          }
                                          function onload4(){
                                            var ctx = document.getElementById("canvas5").getContext("2d");
                                            window.myBar = new Chart(ctx).Bar(barChartData5, {
                                              responsive : true
                                            });
                                          }

                                          </script>




                            </center>




                  </td>
                </tr>
              </table>
            </center>
        
      <!--banner ends-->
    </header>


<body>

     <canvas id="chartContainer" width="300" height="400">
             browser doesn't support html5
        </canvas>



</body>





    <!--header ends-->
    
    

  </body>
</html>


