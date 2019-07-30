
<?php
ob_start();
 $bot_url = "https://api.telegram.org/bot959057540:AAFafcZKY2wRr0Tx2l8zagRibl2rmgJMqho";

$admin = "638611275";

 $update = file_get_contents("php://input");
    
    $update_array = json_decode($update, true);
    if( isset($update_array["callback_query"]) ) {
        
        $data              = $update_array["callback_query"]["data"];
        $callback_query_id = $update_array["callback_query"]["id"];
        $chat_id           = $update_array["callback_query"]["message"]["chat"]["id"];
        
        
    }
    else if( isset($update_array["message"]) ) {
        
        $text    = $update_array["message"]["text"];
        $chat_id = $update_array["message"]["chat"]["id"];
    }
	
    //-------------------------------------
  $inline_keyboard = [
                            [
                                [ 'text' => "Dostlarga ulashish" , 'switch_inline_query' => "https://t.me/UzApks/"]
                            ] ,
                       ];
    
    $inline_kb_options = [
                            'inline_keyboard' => $inline_keyboard
                         ];
    


if($text == "/start"){

   $reply = "salom";
    $url = $GLOBALS['bot_url'] . "/sendMessage";
    $post_params = [ 'chat_id' => $GLOBALS['chat_id'] , 'text' => $reply ];
    
    $result = send_reply($url, $post_params);
    $result_array = json_decode($result, true);
    $msg_id  = $result_array["result"]["message_id"];
    
    sleep(3);
    
    $reply = "this is updated message";
    $url = $GLOBALS['bot_url'] . "/editMessageText";
    $post_params = [ 'chat_id' => $GLOBALS['chat_id'] , 'text' => $reply , 'message_id' => $msg_id ];
    send_reply($url, $post_params);
    
    sleep(3);
    
    $url = $GLOBALS['bot_url'] . "/deleteMessage";
    $post_params = [ 'chat_id' => $GLOBALS['chat_id'] , 'message_id' => $msg_id ];
    send_reply($url, $post_params);
  

} 

$chpost  = $update_array["channel_post"];
$mid = $update_array["channel_post"]["message_id"];
$cpost = $update_array["channel_post"]["document"];
$fname = $update_array["channel_post"]["document"]["file_name"];
$size = $update_array["channel_post"]["document"]["file_size"];
$hajmi = hajm($size);
$faylnomi = str_replace("_"," ", $fname);
$nomi = str_replace("@UzApks.apk","", $faylnomi);
$cid = $update_array["channel_post"]["chat"]["id"];
$file_id = $update_array["channel_post"]["document"]["file_id"];
$rasm = "BQADAgADaAQAAsIR2Un7Vr3Q3opNyAI";
  
if($cpost){

$caption = $update_array["channel_post"]["caption"];


   $new_media = [ 
                    'type'    => 'document' ,  // audio, video, ...
                    'media'   => $file_id ,  // must be string
                    'caption' => "📱:<b> $nomi.</b>

💾: $hajmi.
🗜: <b>APK.</b>
Ⓜ️: @UzApks
📎 <i>Doʻstlarga ulashing</i>⤵️
https://t.me/joinchat/AAAAAFAnytp8WnfiaI9HWA" ,
                 'thumb' => 'BQADAgADaAQAAsIR2Un7Vr3Q3opNyAI'  ,
'parse_mode' =>html,
                 ];
$json_kb = json_encode($GLOBALS['inline_kb_options']);

    $url = $GLOBALS['bot_url'] . "/editMessageMedia";
    $post_params = [ 
                        'chat_id'    => $cid , 
                        'message_id' => $mid ,
                        'media'      => json_encode($new_media),
        'reply_markup' => $json_kb,

                   ];
    send_reply($url, $post_params);
}


function hajm($size){
  $base = log($size) / log(1024);
  $suffix = array("", "KB", "MB", "GB", "TB");
  $f_base = floor($base);
  return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
}
function send_reply($url, $post_params) {
        
        $cu = curl_init();
        curl_setopt($cu, CURLOPT_URL, $url);
        curl_setopt($cu, CURLOPT_POSTFIELDS, $post_params);
        curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);  // get result
        $result = curl_exec($cu);
        curl_close($cu);
        return $result;
}
