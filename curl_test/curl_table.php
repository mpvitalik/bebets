<?php

header('Powered: test');
header('Content-Type: text/html; charset=utf-8');

include('simple_html_dom.php');
require_once "../php/Database.php";

$db = new Database();
$championats = $db->getChampionatsShowing();

foreach ($championats as $championat){

    try{
        // get DOM from URL or file
        $html = file_get_html($championat->getHrefTablica());

        $table_arr = array();

        $table_our = "<div class=\"table-responsive\"><table class=\"table table-bordered\"><thead><tr><td></td><td>И</td><td class=\"colorgreen\">В</td><td class=\"coloryellow\">Н</td><td class=\"colorred\">П</td><td>З</td><td>-</td><td>П</td><td>О</td></tr></thead><tbody>";

        foreach($html->find('div#champs-table') as $div_champs_table) {
           // echo $div_champs_table->children(0). '<br>';
            foreach ($div_champs_table->find('table') as $table) {
                $tr_increment = 0;
                foreach ($table->find('tr') as $tr) {
                    if($tr_increment==0){
                        $tr_increment++;
                        continue;
                    }
                    $table_our .="<tr>";
                    $td_incr = 0;
                    $table_arr[$tr_increment] = array();
                    foreach ($tr->find('td') as $td) {
                        if($td_incr==0){
                            $table_our .="<td>".$td->plaintext;
                        }elseif ($td_incr==1){
                            $table_our .= $td->plaintext."</td>";
                        }elseif($td_incr==2){
                            $table_our .="<td>".$td->plaintext."</td>";
                        }elseif($td_incr==3){
                            $table_our .="<td class=\"colorgreen\">".$td->plaintext."</td>";
                        }elseif($td_incr==4){
                            $table_our .="<td class=\"coloryellow\">".$td->plaintext."</td>";
                        }elseif($td_incr==5){
                            $table_our .="<td class=\"colorred\">".$td->plaintext."</td>";
                        }else{
                            $table_our .="<td>".$td->plaintext."</td>";
                        }
                        $table_arr[$tr_increment][$td_incr] = $td->plaintext;
                        //echo $td->plaintext. '<br>';
                        $td_incr++;
                    }
                    $table_our .="</tr>";
                    $tr_increment++;
                    //echo "===============================<br>";
                }

            }
        }

        $table_our .= "</tbody></table></div>";
        $count_table_arr = count($table_arr);

        if($count_table_arr!=0){
            $db->updateSyncChampTablica($championat->getId(),$table_our);
            echo "Championat, with id:".$championat->getId()." - main table updated!<br>";
        }

    }catch (Exception $e){

    }
}






