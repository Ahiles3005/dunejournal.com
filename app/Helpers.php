<?php

// Print json answer
if( !function_exists('jsonResponse') ){
    function jsonResponse($data, $code = 200) {
        return response()->json($data, $code,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }
}

// Concat errors
if( !function_exists('concatErrors') ){
    function concatErrors($errors) {
        $sorted = [];

        foreach($errors as $error){
            array_push($sorted, $error);
        }
        return $sorted;
    }
}

// Format date in human's view
if( !function_exists('formatHumanDate') ){
    function formatHumanDate($date, $full = false) {
        if($full) return date('d.m.Y H:i:s', strtotime($date));
        return date('d.m.Y', strtotime($date));
    }
}

// Check if file is video
if( !function_exists('isVideo') ){
    function isVideo($url){
        $videoExtensions = ['mp4', 'ogg', 'webm'];

        $isVideo = false;
        foreach($videoExtensions as $key => $value){
            if( strpos(strtolower($url), $value) !== false ) return true;
        }

        return $isVideo;
    }
}


?>
