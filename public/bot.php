<?php
require_once "Telegram.php";

$token = "6115266796:AAEK7-zye55ZIsByKt0SWcBWbttGW16qwD4";

// Created at Samandar Sariboyev - samandarsariboyev69@gmail.com - +998 97 567 20 09
$username = "shoisl0d_bot";
$host = "localhost";
$password = "24082003S@man";
$db = "shoisl0d_bot";

$telegram = new Telegram($token);
$data = $telegram->getData();
$message = $data['message'];
$message_id = $message['message_id'];
$text = $message['text'];
$chat_id = $message['chat']['id'];
$callback_query = $telegram->Callback_Query();
$chatID = $telegram->Callback_ChatID();
$adminlar = [499270876,848511386];

$con = mysqli_connect($host, $username, $password, $db);
if(isset($con)){
    echo "Yes DB";
}
if ($callback_query != null && $callback_query != '') {
    $callback_data = $telegram->Callback_Data();
    $r = "Select * from `bot_users` where `chat_id` = {$chatID}";
    $res = mysqli_query($con, $r);
    $p = mysqli_fetch_assoc($res);
    $page = $p['page'];
    if (7 ==2) {

    }
    else{
        switch ($page) {
            case 'region':
                $region = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM  `regions` where `id` = {$callback_data}"));
                mysqli_query($con, "UPDATE `bot_users` SET `region`='{$region["name"]}' WHERE `chat_id` = {$chatID}");
                $districts = mysqli_query($con, "SELECT * FROM  `districts` where `region_id` = {$callback_data}");
                while($raw = mysqli_fetch_assoc($districts)){
                    $option[] = array($telegram->buildInlineKeyboardButton("{$raw['name']}","","{$raw['id']}"));
                }
                $keyb = $telegram->buildInlineKeyBoard($option);
                $content = ['chat_id' => $chatID, 'reply_markup' => $keyb, "text" => "Tumaningizni tanlang:", 'parse_mode' => "HTML"];
                $telegram->sendMessage($content);
                SetPageCall('district');
                break;
            case 'district':
                $region = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM  `districts` where `id` = {$callback_data}"));
                mysqli_query($con, "UPDATE `bot_users` SET `district`='{$region["name"]}' WHERE `chat_id` = {$chatID}");
                $districts = mysqli_query($con, "SELECT * FROM  `quarters` where `district_id` = {$callback_data}");
                while($raw = mysqli_fetch_assoc($districts)){
                    $option[] = array($telegram->buildInlineKeyboardButton("{$raw['name']}","","{$raw['id']}"));
                }
                $keyb = $telegram->buildInlineKeyBoard($option);
                $content = ['chat_id' => $chatID, 'reply_markup' => $keyb, "text" => "Mahallangizni tanlang:", 'parse_mode' => "HTML"];
                $telegram->sendMessage($content);
                SetPageCall('quarter');
                break;
            case 'quarter':
                $region = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM  `quarters` where `id` = {$callback_data}"));
                mysqli_query($con, "UPDATE `bot_users` SET `quarter`='{$region["name"]}' WHERE `chat_id` = {$chatID}");
                sendMessageCall('Maktabingiz raqami yoki nomini yuboring: ');
                SetPageCall('school');
                break;
            default:
                # code...
                break;
        }
    }
}
elseif ($text == '/start') {
    Start();
    // sendMessage(4);
}
else{
    $r = mysqli_query($con, "Select * from `bot_users` where `chat_id` = {$chat_id}");
    $p = mysqli_fetch_assoc($r);
    $page = $p['page'];
    switch ($page) {
        case 'home':
            switch ($text) {
                case "Testni tekshirish📊":
                    sendTextWithKeyboard(['Orqaga↩️'],'Test ID ni yuboring: ');
                    SetPage('block_id');
                    break;
                case "Ma'lumotlarim👤":
                    $sql = "Ism: {$p['name']}\nTelefon: {$p['phone']}\nViloyat: {$p['region']}\nTuman: {$p['district']}\nMahalla: {$p['quarter']}\nMaktab: {$p['school']}";
                    sendMessage($sql);
                    Home();
                    break;
                case "Natijalarim📊":
                    sendTextWithKeyboard(['Orqaga↩️'],'Test ID sini kiriting:');
                    SetPage('result');
                    break;
                case "Biz haqimizda©":
                    $sql = "🌤 \"Ideal Study\" xususiy maktabida

⏱️ Darslar har kuni soat 08:30 dan kech soat 17:30 gacha davom etadi

⚡️ Kunda 3 mahal ovqat
⚡️ Haftasiga 12 soat chuqurlashtirilgan
    - ingliz tili
    - rus tili
    - matematika darslari

👨‍🎓 Yuqori sinflarga esa o'zlari tanlagan yo'nalishlariga ko'ra barcha fanlar chuqurlashtirilib o'tiladi.

🚪 Har bir sinfxonamizda
    - yotoqxona
    - hojatxona
    - yuvinish xonalari mavjud!

🏫 Bundan tashqari xususiy maktabimizda
    - Karate
    - Gimnastika
    - Shaxmat shashka
    - Mental arifmetika,
    - Psixologiya darslari
    - IT kurslari
    - Prezident maktabiga tayyorlov kurslari ham mavjud!

🌤 Ideal study - Yangi yulduzlarni kashf qilamiz!";
                    sendMessage($sql);
                    Home();
                    break;
                default:
                    Home();
                    break;
            }
            break;
        case 'start':
            switch ($text) {
                case "Ro'yxatdan o'tish 🗒":
                    sendMessage('Ism familyangizni yuboring: ');
                    SetPage('name');
                    break;
                default:
                    Start();
                    break;
            }
            break;
        case 'phone':
            if(isset($message['contact']['phone_number'])){
                mysqli_query($con, "UPDATE `bot_users` SET `phone`='{$message["contact"]["phone_number"]}' WHERE `chat_id` = {$chat_id}");
                $regions = mysqli_query($con, "SELECT * FROM  `regions`");
                while($raw = mysqli_fetch_assoc($regions)){
                    $option[] = array($telegram->buildInlineKeyboardButton("{$raw['name']}","","{$raw['id']}"));
                }
                $keyb = $telegram->buildInlineKeyBoard($option);
                $content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, "text" => "Yashash viloyatingizni tanlang:", 'parse_mode' => "HTML"];
                $telegram->sendMessage($content);
                SetPage('region');
            }
            else{
                sendMessage('Telefon raqam yuboring');
            }
            break;

        case 'school':
            mysqli_query($con, "UPDATE `bot_users` SET `school`='{$text}' WHERE `chat_id` = {$chat_id}");
            sendMessage('Sinfingizni yuboring:');
            SetPage('class');
            break;
        case 'name':
            mysqli_query($con, "UPDATE `bot_users` SET `name`='{$text}' WHERE `chat_id` = {$chat_id}");
            $option[] = array($telegram->buildKeyboardButton('Telefon Raqamingiz 📲', true));
            $keyboard = $telegram->buildKeyBoard($option, $onetime = false, $resize = true);
            $content = array('chat_id' => $chat_id, 'reply_markup' => $keyboard, 'text' => "Telefon Raqamingiz 📲", 'parse_mode' => "HTML");
            $telegram->sendMessage($content);
            SetPage('phone');
            break;
        case 'result':
            switch ($text) {
                case "Orqaga↩️":
                    Home();
                    break;
                default:
                    $block = mysqli_query($con, "SELECT * FROM  `blocks` where `id` = {$text};");
                    $block_arr = mysqli_fetch_assoc($block);
                    if(mysqli_num_rows($block)<1){
                        sendTextWithKeyboard(['Orqaga↩️'],'Test topilmadi. Iltimos qaytadan kiriting');
                    }
                    else{
                        $sql = "SELECT * FROM  `results` where `chat_id` = {$chat_id} and `block_id` = {$text}";
                        $res = mysqli_query($con, $sql);
                        if(mysqli_num_rows($res)>0){
                            $result = mysqli_fetch_assoc($res);

                            sendTextWithKeyboard(['Orqaga↩️'],"Sizning natijangiz:\n\n✅ To'g'ri javob: {$result['correct']} ta\n\n❌Noto'g'ri javob: {$result['incorrect']} ta\n\nUshbu testni yechish uchun imkoniyatlaringiz tugagan.");
                            Home();
                        }
                        else{
                            sendMessage('Siz ushbu testni hali ishlamagansiz. Boshqa ID kiriting');
                            Home();
                        }
                    }
                    break;
            }
            break;
        case 'class':
            mysqli_query($con, "UPDATE `bot_users` SET `class`='{$text}' WHERE `chat_id` = {$chat_id}");
            Home();
            break;
        case 'block_id':
            switch ($text) {
                case "Orqaga↩️":
                    Home();
                    break;
                default:
                    $block = mysqli_query($con, "SELECT * FROM  `blocks` where `id` = {$text};");
                    $block_arr = mysqli_fetch_assoc($block);
                    if(mysqli_num_rows($block)<1){
                        sendTextWithKeyboard(['Orqaga↩️'],'Test topilmadi. Iltimos qaytadan kiriting');
                    }
                    else{
                        $sql = "SELECT * FROM  `results` where `chat_id` = {$chat_id} and `block_id` = {$block_arr['id']}";
                        $res = mysqli_query($con, $sql);
                        if(mysqli_num_rows($res)>0){
                            $result = mysqli_fetch_assoc($res);

                            sendTextWithKeyboard(['Orqaga↩️'],"Siz ushbu testni avval ishlagansiz!\n\nSizning natijangiz:\n\n✅ To'g'ri javob: {$result['correct']} ta\n\n❌Noto'g'ri javob: {$result['incorrect']} ta\n\nUshbu testni yechish uchun imkoniyatlaringiz tugagan. Boshqa Test ID kiritishingiz mumkin");
                        }
                        else{
                            // $block = mysqli_fetch_assoc($block);
                            $str = "Test nomi: <b>{$block_arr['name']}</b>\nSavollar soni: <b>{$block_arr['length']}</b>\nJavoblarni quidagi tartibda yuboring: abcdabcdab";
                            sendTextWithKeyboard(['Orqaga↩️'],$str);
                            $sql = "UPDATE `bot_users` SET `block_id`={$block_arr['id']} WHERE chat_id={$chat_id};";
                            // sendMessage($sql);
                            mysqli_query($con, $sql);
                            SetPage('check_test');
                        }
                    }
                    break;
            }
            break;
        case 'check_test':
            switch ($text) {
                case "Orqaga↩️":
                    sendTextWithKeyboard(['Orqaga↩️'],'Test ID ni yuboring: ');
                    SetPage('block_id');
                    break;
                default:
                    $user = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM  `bot_users` where `chat_id` =  {$chat_id}"));
                    $block = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM  `blocks` where `id` = {$user['block_id']}"));
                    $answers = str_split($block['answers']);
                    $answers_user = str_split($text);
                    $correct = 0;
                    $incorrect = 0;
                    if (strlen($text) != strlen($block['answers'])) {
                        sendTextWithKeyboard(['Orqaga↩️'],"Xatolik!\nTestlar soni bilan javoblar soni to'g'ri kelmadi. Qaytadan tekshirib yuboring");
                    }
                    else{
                        $javoblar = "Test natijangiz:\n";
                        $correct = 0;
                        $incorrect = 0;
                        for ($i = 0; $i < $block['length']; $i++) {
                            $isCorrect = $answers[$i] == $answers_user[$i];
                            $status = $isCorrect ? '✅' : '❌';
                            $javoblar .= ($i + 1) . " - {$status}\n";

                            if ($isCorrect) {
                                $correct++;
                            } else {
                                $incorrect++;
                            }
                        }
                        $str = "{$javoblar}\n✅ To'g'ri javob: {$correct} ta\n\n❌Noto'g'ri javob: {$incorrect} ta\n\nUshbu testni yechish uchun imkoniyatlaringiz tugadi. Ma'lumotlar saqlandi";
                        sendMessage($str);
                        $sql = "INSERT INTO `results`(`user_id`, `block_id`, `chat_id`, `correct`, `incorrect`, `name`, `region`, `district`, `quarter`,`school`, `class`, `phone`) VALUES ({$user['id']},{$block['id']},{$chat_id},{$correct},{$incorrect},'{$user['name']}','{$user['region']}','{$user['district']}','{$user['quarter']}','{$user['school']}','{$user['class']}','{$user['phone']}')";
                        // sendMessage($sql);
                        mysqli_query($con, $sql);
                        Home();
                    }
                    break;
            }
            break;
    }
}



echo 22;

function Home() {
    global $chat_id, $message,$con, $data;
    sendTextWithKeyboard(['Testni tekshirish📊', "Ma'lumotlarim👤", "Natijalarim📊","Biz haqimizda©"], "Tanlang ⤵️");
    SetPage('home');
}

function Start(){
    global $chat_id, $message,$con, $data;
    $user = mysqli_query($con, "SELECT * FROM  `bot_users` where `chat_id` =  {$chat_id}");
    $dat = json_encode($data);
    if(mysqli_num_rows($user)<1){
        $sql = "INSERT INTO `bot_users`(`chat_id`, `name`, `page`, `data`) VALUES ($chat_id, '{$message['from']['first_name']}','start', '{$dat}')";
        $r = mysqli_query($con,$sql);
        SetPage('start');
        $b = ["Ro'yxatdan o'tish 🗒"];
        sendTextWithKeyboard($b, "<b>Assalomu aleykum!</b>\nIdeal Study NTM ning rasmiy telegram botiga xush kelibsiz!");
    }
    else{
        Home();
    }

}


function sendTextWithKeyboard($buttons, $text, $backBtn = false)
{
    global $telegram, $chat_id, $texts;
    $option = [];
    if (count($buttons) % 2 == 0) {
        for ($i = 0; $i < count($buttons); $i += 2) {
            $option[] = array($telegram->buildKeyboardButton($buttons[$i]), $telegram->buildKeyboardButton($buttons[$i + 1]));
        }
    } else {
        for ($i = 0; $i < count($buttons) - 1; $i += 2) {
            $option[] = array($telegram->buildKeyboardButton($buttons[$i]), $telegram->buildKeyboardButton($buttons[$i + 1]));
        }
        $option[] = array($telegram->buildKeyboardButton(end($buttons)));
    }
    if ($backBtn) {
        $option[] = [$telegram->buildKeyboardButton($texts->getText("back_btn"))];
    }
    $keyboard = $telegram->buildKeyBoard($option, $onetime = false, $resize = true);
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyboard, 'text' => $text, 'parse_mode' => "HTML");
    $telegram->sendMessage($content);
}

function sendTextWithKeyboardCall($buttons, $text, $backBtn = false)
{
    global $telegram, $chatID, $texts;
    $option = [];
    if (count($buttons) % 2 == 0) {
        for ($i = 0; $i < count($buttons); $i += 2) {
            $option[] = array($telegram->buildKeyboardButton($buttons[$i]), $telegram->buildKeyboardButton($buttons[$i + 1]));
        }
    } else {
        for ($i = 0; $i < count($buttons) - 1; $i += 2) {
            $option[] = array($telegram->buildKeyboardButton($buttons[$i]), $telegram->buildKeyboardButton($buttons[$i + 1]));
        }
        $option[] = array($telegram->buildKeyboardButton(end($buttons)));
    }
    if ($backBtn) {
        $option[] = [$telegram->buildKeyboardButton($texts->getText("back_btn"))];
    }
    $keyboard = $telegram->buildKeyBoard($option, $onetime = false, $resize = true);
    $content = array('chat_id' => $chatID, 'reply_markup' => $keyboard, 'text' => $text, 'parse_mode' => "HTML");
    $telegram->sendMessage($content);
}


function SetPage($name)
{
    global $chat_id, $con;
    $r = mysqli_query($con, "UPDATE `bot_users` SET `page`='{$name}' WHERE `chat_id` = {$chat_id}");
}

function SetPageCall($name)
{
    global $con, $chatID;
    $r = mysqli_query($con, "UPDATE `bot_users` SET `page`='{$name}' WHERE `chat_id` = {$chatID}");
}


function sendMessage($text)
{
    global $telegram, $chat_id;
    $telegram->sendMessage(['chat_id' => $chat_id, 'reply_markup' => json_encode(['remove_keyboard' => true], true), 'text' => $text, 'parse_mode' => "HTML"]);
}

function sendMessageCall($text)
{
    global $telegram, $chatID;
    $telegram->sendMessage(['chat_id' => $chatID, 'reply_markup' => json_encode(['remove_keyboard' => true]),'text' => $text, 'parse_mode' => "HTML"]);
}
