<?php

    $city="saopaulo";

    $url = "https://www.hebcal.com/hebcal?v=1&cfg=json&maj=on&min=on&mod=on&nx=on&year=now&month=now&ss=on&mf=on&c=on&geo=geoname&city=BR-saopaulo&M=on&s=on";

    $ch=curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    $data = json_decode(curl_exec($ch));

    $sextaesabado = array_filter($data->items, function ($item){

        $proximosabado = strtotime("next saturday");
        $itemdate = strtotime($item->date);
        $diadasemana = date("w",$itemdate);
        return $diadasemana == 6 && $itemdate == $proximosabado;
    });


foreach ($sextaesabado as $item){
    if (isset($item->leyning)){
        $ciclo = "";
        foreach ($item->leyning->triennial as $trecho){
            $ciclo .="<li>".$trecho."</li>";
        }
        echo "<div> 
        <h3> ".$item->title."</h3>
        <small> ".$item->leyning->torah."</small>
        <small> ".$item->leyning->haftarah."</small>
        <small> ".$item->leyning->maftir."</small>
        <ul>".$ciclo."</ul>
        </div>";
    }else if($item->category == "mevarchim"){
        echo "<div> 
        <h3> ".$item->hebrew."</h3>
        <h3> ".$item->title."</h3>
        <h3> ".$item->memo."</h3>
        </div>";
    }
    echo "<hr/>";

}  

?>