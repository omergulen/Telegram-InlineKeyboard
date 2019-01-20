

<?php 

// By Quiec
// Telegram : @Quiec

$message= file_get_contents("php://input");
	//file_put_contents("message.txt", $message);
	//$message= file_get_contents("message.txt");
	$up = json_decode($message);
	$update_id = $up->update_id;
	
	$message_id = $up->message->message_id;
	$message_date = $up->message->date;
	$message_date = date('Y-m-d H:i:s', $message_date);
	
	
	
	$uniq = $update_id."_".date('Y-m-d', $message_date);
	$ups = file_get_contents('ups');
	if(strpos($ups,$uniq) > 0 ){
	   exit(); 
	}else{
	   file_put_contents('ups',$ups."\n".$uniq); 
	}

	
	$userFile = 'users/'.$chat_id;


define('API_KEY','653534941:AAFc8j8BbdVZGp4hAV_sZK2O5ASzBKqkpIM'); //token bot
//----######------
function makereq($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($datas));
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
//##############=--API_REQ
function apiRequest($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }
  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }
  foreach ($parameters as $key => &$val) {
    // encoding to JSON array parameters, for example reply_markup
    if (!is_numeric($val) && !is_string($val)) {
      $val = json_encode($val);
    }
  }
  $url = "https://api.telegram.org/bot".API_KEY."/".$method.'?'.http_build_query($parameters);
  $handle = curl_init($url);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($handle, CURLOPT_TIMEOUT, 60);
  return exec_curl_request($handle);
}
//----######------
//---------
$update = json_decode(file_get_contents('php://input'));
var_dump($update);
//=========
$chat_id = $update->message->chat->id;
$chatname = $update->message->chat->title;
$chatuname = $update->message->chat->username;
$message_id = $update->message->message_id;
$from_id = $update->message->from->id;
$name = $update->message->from->first_name;
$type2 = $update->message->chat->type;
$username = $update->message->from->username;
$gpname = $update->message->chat->title;
$textmessage = isset($update->message->text)?$update->message->text:'';
$txtmsg = $update->message->text;
$replytext = $update->message->reply_to_message->text;
$reply = $update->message->reply_to_message->from->id;
$reply2 = $update->message->reply_to_message->chat->id;
$replyname = $update->message->reply_to_message->from->first_name;
$replyusername = $update->message->reply_to_message->from->username;
$stickerid = $update->message->reply_to_message->sticker->file_id;
$versionbot = "1.0"; //version bot
$forward = $update->message->forward_from;
$photo = $update->message->photo;
$video = $update->message->video;
$location = $update->message->location;
$joinusername = $update->message->new_chat_member->from->username;
$joinmember = $update->message->new_chat_member;
$leftmember = $update->message->left_chat_member;
$sticker = $update->message->sticker;
$document = $update->message->document;
$contact = $update->message->contact;
$game = $update->message->game;
$music = $update->message->audio;
$gif = $update->message->gif;
$voice = $update->message->voice;
$edit = $update->edited_message;
$chatsuper=str_replace("-","",$chat_id);
$step = file_get_contents("step.txt");
$type = $update->callback_query->message->chat->type;
$from_id2 = $update->callback_query->from->id;
$cblock = $update->callback_query->message->getmember->user;
$token = "".API_KEY."";
$gpname2 = $update->callback_query->message->chat->title;
$chat_id2 = $update->callback_query->message->chat->id;
$message_id2 = $update->callback_query->message->message_id;
$name2 = $update->callback_query->from->first_name;
$data = $update->callback_query->data;
$cmember = getChatMembersCount($chat_id2,$token);

//-------
function getcreator($chat_id,$token){
  $up = json_decode(file_get_contents('https://api.telegram.org/bot'.$token.'/getChatAdministrators?chat_id='.$chat_id),true);
  $result = $up['result'];
  foreach($result as $key=>$value){
    $found = array_search("creator",$result[$key]);
    if($found !== false){
      return $result[$key]['user'];
    }
  }
}
$creator = getcreator($chat_id,$token);


	$getChatMember = json_decode(file_get_contents("https://api.telegram.org/bot$token/getChatMember?chat_id=$chat_id&user_id=$idbot")); 
    $resultChat = $getChatMember->result;
	$mstatus = $getChatMember->result->status;
function  getUserProfilePhotos($token,$from_id) {
  $url = 'https://api.telegram.org/bot'.$token.'/getUserProfilePhotos?user_id='.$from_id;
  $result = file_get_contents($url);
  $result = json_decode ($result);
  $result = $result->result;
  return $result;
}
$getuserprofile = getUserProfilePhotos($token,$from_id);
$cuphoto = $getuserprofile->total_count;
$getuserphoto = $getuserprofile->photos[0][0]->file_id;

function getChatMembersCount($chat_id,$token) {
  $url = 'https://api.telegram.org/bot'.$token.'/getChatMembersCount?chat_id='.$chat_id;
  $result = file_get_contents($url);
  $result = json_decode ($result);
  $result = $result->result;
  return $result;
}
function SendMessage($ChatId, $TextMsg)
{
 makereq('sendMessage',[
'chat_id'=>$ChatId,
'text'=>$TextMsg,
'parse_mode'=>"MarkDown"
]);
}
function SendMessage2($ChatId, $TextMsg)
{
 makereq('sendMessage',[
'chat_id'=>$ChatId,
'text'=>$TextMsg,
]);
}
function SendSticker($ChatId, $sticker_ID)
{
 makereq('sendSticker',[
'chat_id'=>$ChatId,
'sticker'=>$sticker_ID
]);
}
function Forward($KojaShe,$AzKoja,$KodomMSG)
{
makereq('ForwardMessage',[
'chat_id'=>$KojaShe,
'from_chat_id'=>$AzKoja,
'message_id'=>$KodomMSG
]);
}
function save($filename,$TXTdata)
	{
	$myfile = fopen($filename, "w") or die("Unable to open file!");
	fwrite($myfile, "$TXTdata");
	fclose($myfile);
	}
	
	$dosya = fopen('kullanicilar.txt', 'r');

$icerik = fread($dosya, filesize('kullanicilar.txt'));

fclose($dosya);

if ($textmessage == '/start') {

var_dump(makereq('sendMessage',[
        	'chat_id'=>$chat_id,
        	'text'=>" example vote

select dislike or like :)
	dev : @quiec
	",
              'reply_markup' =>json_encode([
              'inline_keyboard'=>[
[
  ['text'=>'like','callback_data'=>'secenek1'],  ['text'=>'dislike','callback_data'=>'secenek2'],
],
	]
	])
    		]));
} 
    
    if($data == "secenek1" ){
var_dump(makereq('editMessageText',[
            'chat_id'=>$chat_id2,
            'message_id'=>$message_id2,
  "text" => "$name2 liked!",
'reply_markup' =>json_encode([
'inline_keyboard'=>[
[
  ['text'=>'🔁 Home','callback_data'=>'start'],
]
]
			])
		]));
			}
			
	
if($data == "secenek2" ){
var_dump(makereq('editMessageText',[
            'chat_id'=>$chat_id2,
            'message_id'=>$message_id2,
 'text'=>"
$name2 disliked!
	",
              'reply_markup' =>json_encode([
              'inline_keyboard'=>[
[
  ['text'=>'Home','callback_data'=>'start'],
],
	]
	])
    		]));
}
if($data == "start" ){
var_dump(makereq('editMessageText',[
            'chat_id'=>$chat_id2,
            'message_id'=>$message_id2,      
 	'text'=>"Merhaba $name Burdaki yazıları değiştirmek istiyorsanız alttaki butonları kullanın :)
	Geliştirici : @quiec
	",
              'reply_markup' =>json_encode([
              'inline_keyboard'=>[
[
  ['text'=>'Like','callback_data'=>'secenek1'],  ['text'=>'Dislike','callback_data'=>'secenek2'],
],
	]
	])
    		]));
}

?>