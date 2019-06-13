<?php
if(!isset($argv[1])|| empty($argv[1])){
    exit('Must Provide Keyword');
} 
if(empty($argv[2])){
    exit('No Depth Specified');
}else{
    //functions declarartions
    //get all similar keys 
    function similar_keys($keyword){
        echo "Processing : $keyword \n";
        $base_url='https://www.google.com/complete/search?';
        $query= http_build_query([
            'q'=>$keyword,
            'client'=>'psy-ab' //add more elements in the array based on url this is specific to goole auto suggest
        ]);
        $curl=curl_init($base_url.$query);// init with url
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true); //this ensures curl_exec returns html of url as string
        $json_data=curl_exec($curl); //downloads the curl url .
        curl_close($curl);
        // Get array from JSON
        $data= json_decode($json_data,TRUE);
        //read the data 
        foreach ($data[1]as $similar_key){
            if(!empty($similar_key)){
            $similar_keys[]=strip_tags($similar_key[0]);
            return($similar_keys);
            }else{ 
                return NULL;
            }
        }     
    }
    //get combination of letters 
    function sampling($chars, $size, $combinations = array()) {
        # if it's the first iteration, the first set 
        # of combinations is the same as the set of characters
        if (empty($combinations)) {
            $combinations = $chars;
        }
        # we're done if we're at size 1
        if ($size == 1) {
            return $combinations;
        }
        # initialise array to put new values in
        $new_combinations = array();
        # loop through existing combinations and character set to create strings
        foreach ($combinations as $combination) {
            foreach ($chars as $char) {
                $new_combinations[] = $combination . $char;
            }
        }
        # call same function again for the next iteration
        return sampling($chars, $size - 1, $new_combinations);
    }
    
    //Start Code 
    $similar_keys[]=similar_keys('$argv[1]');
    $chars = array('a', 'b', 'c','d' , 'e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','x','y','z' );
    for($i=1;$i<=$argv[2];$i++){
        $combination_array = sampling($chars, $i);
        foreach($combination_array as $combination_array){
            $similar_keys_result=similar_keys($argv[1].''.$combination_array);
            if($similar_keys_result){
                $similar_keys[]=$similar_keys_result;
            }
        }
    }
    var_dump($similar_keys);
    $fp=fopen('keywords.txt','a+');
    fwrite($fp, $argv[1]."\r\n");
    for($i=1;$i<count($similar_keys);$i++){
        fwrite($fp, $similar_keys[$i][0]."\r\n");
    }
    fwrite($fp,'-------------'."\r\n");
}

    

