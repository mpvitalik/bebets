<?php

header('Powered: test');
header('Content-Type: text/html; charset=utf-8');

include('simple_html_dom.php');
require_once "../php/Database.php";

$db = new Database();
$championats = $db->getChampionatsShowing();


foreach ($championats as $championat){

    try{
        $html = file_get_html($championat->getHrefMatchi());
        $table_arr = array();

        $table_our = "<div class=\"table-responsive\"><table class=\"table table-bordered\"><tbody>";
        $count_cildren = 0;
        foreach($html->find('div.tab') as $e){
            $count_cildren = count($e->children());

            for($i=0;$i<$count_cildren;$i++){
                if($i%2==0){
                    //echo $e->children($i)->plaintext."<br>========WAS NAZVA==========<br><br>";
                    $table_arr[$i] = "<tr><td colspan=\"4\"><p class=\"name-turintable\">".$e->children($i)->plaintext."</p></td></tr>";
                    $table_our .= "<tr><td colspan=\"4\"><p class=\"name-turintable\">".$e->children($i)->plaintext."</p></td></tr>";
                }else{
                    $table_arr[$i] = "";
                    foreach ($e->children($i)->find('tr') as $tr) {
                        $td_incr = 0;
                        $td_this0 = "";
                        $td_this1 = "";
                        $td_this2 = "";
                        $td_this3 = "";
                        $table_our .= "<tr>";
                        foreach ($tr->find('td') as $td) {
                            //echo $td->plaintext."<br>";
                            if($td_incr==0){
                                $td_this0 = "<td>".$td->plaintext."</td>";
                            }elseif ($td_incr==1){
                                if($td->plaintext=="" && !isset($first_notfullgamed)){
                                    $first_notfullgamed = $i;
                                }
                                $td_this1 = "<td>".$td->plaintext."</td>";
                            }elseif ($td_incr==2){
                                $td_this2 = "<td>".$td->plaintext."</td>";
                            }elseif ($td_incr==3){
                                $td_this3 = "<td>".$td->plaintext."</td>";
                            }
                            $td_incr++;
                        }
                        $table_our .= $td_this3.$td_this0.$td_this1.$td_this2;
                        $table_our .= "</tr>";
                        $table_arr[$i] .= "<tr>".$td_this3.$td_this0.$td_this1.$td_this2."</tr>";
                    }
                    //echo "========WAS TABLE===============<br><br>";
                }

            }

        }

        $table_our .= "</tbody></table></div>";

        $table_little = "<div class=\"table-responsive\"><table class=\"table table-bordered\"><tbody>";

        $count_table_arr = count($table_arr);

        if(!isset($first_notfullgamed) && $count_table_arr>=4 ){ // Тобишь нету несигранных матчей
            if(isset($table_arr[$count_table_arr-4]) && isset($table_arr[$count_table_arr-3])){
                $table_little .= $table_arr[$count_table_arr-4].$table_arr[$count_table_arr-3];
            }
            if(isset($table_arr[$count_table_arr-2]) && isset($table_arr[$count_table_arr-1])){
                $table_little .= $table_arr[$count_table_arr-2].$table_arr[$count_table_arr-1];
            }
        }elseif(isset($first_notfullgamed) && $count_table_arr>=4 && $first_notfullgamed==$count_table_arr-1){// Тобишь первый несигранный в последнем туре
            if(isset($table_arr[$count_table_arr-4]) && isset($table_arr[$count_table_arr-3])){
                $table_little .= $table_arr[$count_table_arr-4].$table_arr[$count_table_arr-3];
            }
            if(isset($table_arr[$count_table_arr-2]) && isset($table_arr[$count_table_arr-1])){
                $table_little .= $table_arr[$count_table_arr-2].$table_arr[$count_table_arr-1];
            }
        }elseif(isset($first_notfullgamed) && $count_table_arr>=4 && $first_notfullgamed==0){// Тобишь первый несигранный в первом туре
            if(isset($table_arr[0]) && isset($table_arr[1])){
                $table_little .= $table_arr[0].$table_arr[1];
            }
            if(isset($table_arr[2]) && isset($table_arr[3])){
                $table_little .= $table_arr[2].$table_arr[3];
            }
        }elseif(isset($first_notfullgamed) && $count_table_arr>=4){
            if(isset($table_arr[$first_notfullgamed-3]) && isset($table_arr[$first_notfullgamed-2])){
                $table_little .= $table_arr[$first_notfullgamed-3].$table_arr[$first_notfullgamed-2];
            }
            if(isset($table_arr[$first_notfullgamed-1]) && isset($table_arr[$first_notfullgamed])){
                $table_little .= $table_arr[$first_notfullgamed-1].$table_arr[$first_notfullgamed];
            }

        }

        if(isset($first_notfullgamed)){
        	unset($first_notfullgamed);
        }
        

        $table_little .= "</tbody></table></div>";

        if($count_table_arr!=0){
            $db->updateSyncChampMatchi($championat->getId(),$table_our,$table_little);
            echo "Championat, with id:".$championat->getId()." - matches updated!<br>";
        }

    }catch (Exception $e){

    }


}










    






























