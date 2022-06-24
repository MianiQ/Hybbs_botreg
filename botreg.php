<?php
	header("Content-Type: text/html; charset=utf-8");
	$pass = rand(99999999,99999999999).rand(99999999,99999999999);
	$user = rand(99999999,99999999999).rand(1,9999999);
	$email = rand(9999999,99999999999);
	
	$title = '我是脚本 >'.$user.'<';
	$content = "我给我自己点赞了哦我给我自己点赞了哦我给我自己点赞了哦我给我自己点赞了哦我给我自己点赞了哦我给我自己点赞了哦我给我自己点赞了哦我给我自己点赞了哦我给我自己点赞了哦我给我自己点赞了哦我给我自己点赞了哦我给我自己点赞了哦";
	
	$cookie_file = dirname(__FILE__).'/cookie.txt';
	//$cookie_file = tempnam("tmp","cookie");
	//先获取cookies并保存
	
	$url = "http://www.outiao.cn/?user/add.html"; //HYBBS注册URL，F12+注册获得提交地址，不知道可以只改前面的的URL
	
	//$data = "user=$user&email=$user%40114145as.cn&pass1=$pass&pass2=$pass";
	$post_string = array('user'=>$user,'email'=>$email.'@qq.com','pass1'=>$pass,'pass2'=>$pass);
	$ch = curl_init($url); //初始化
	curl_setopt($ch, CURLOPT_HEADER, 0); //不返回header部分
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //返回字符串，??直接输出
	curl_setopt($ch, CURLOPT_COOKIEJAR,  $cookie_file); //存储cookies
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
	curl_exec($ch);
	curl_close($ch);
	
	echo "$user Reged! Pass: $pass , Posting...\r\n";
	shell_exec("echo User: $user Pass: $pass >>users.log");

	//使?上?保存的cookies再次访问
	
	$post_string = array(
	'title' => $title,
	'content' => $content,
	'forum'=> rand(8,8),//帖子分类 自己填 F12看提交的
	'tmp_md5' => 'GGeie',
	);
	
	$url = "http://www.outiao.cn/?post.html"; //HYBBS发帖提交URL，F12+发帖可以获得，不知道可以直接只改前面的URL
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file); //使?上?获取的cookies
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
	$response = curl_exec($ch);
	curl_close($ch);
	
	$response = json_decode($response,true);
	if (!$response['error']){
		echo '(Error):'.$response['info'];
	}	else	{
		echo '(OK) type: '.$post_string['forum']."\r\n";
	}
	$t_id = $response['id'];
	$post_string = array(
	'type' => 'thread1',
	'id' => $t_id
	);
	//自动点赞
	$url = "http://www.outiao.cn/?s=post/vote"; //HYBBS点赞提交URL，F12+发帖可以获得，不知道可以直接只改前面的URL
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file); //使?上?获取的cookies
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
	$response = curl_exec($ch);
	curl_close($ch);
	$response = json_decode($response,true);
	if (!$response['error']){
		echo '(Error):'.$response['info']."\r\n";
	}	else	{
		echo '(OK) id: '.$post_string['id']."\r\n";
	}
	
	//自动回复
	$post_string = array(
	'content' => "我还能自动回复呢",
	'id' => $t_id,
	'tmp_md5' => '114514'
	);
	
	$url = "http://www.outiao.cn/?post/post.html"; //HYBBS回复提交URL，F12+发帖可以获得，不知道可以直接只改前面的URL
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file); //使?上?获取的cookies
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
	$response = curl_exec($ch);
	curl_close($ch);
	$response = json_decode($response,true);
	if (!$response['error']){
		echo '(Error):'.$response['info']."\r\n";
	}	else	{
		echo '(OK) id: '.$post_string['id']."content: ".$post_string['content']."\r\n";
	}
