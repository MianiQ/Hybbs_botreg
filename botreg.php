<?php
	header("Content-Type: text/html; charset=utf-8");
	$pass = rand(99999,9999999);
	$user = rand(99999,99999999);
	$email = rand(99999,99999999);
	
	
	$title = '想要同款刷帖脚本吗，点进来看哦 >'.$user.'<';
	$content = '这是内容这是内容这是内容这是内容这是内容这是内容这是内容这是内容这是内容这是内容';
	
	header('Content-Type: text/html; charset=utf-8');
	$cookie_file = dirname(__FILE__).'/cookie.txt';
	//$cookie_file = tempnam("tmp","cookie");
	//先获取cookies并保存
	
	$url = "http://114514.1919810/?user/add.html"; //HYBBS注册URL，F12+注册获得提交地址，不知道可以只改前面的的URL
	
	//$data = "user=$user&email=$user%40114145as.cn&pass1=$pass&pass2=$pass";
	$post_string = array('user'=>$user,'email'=>$email.'@qq.com','pass1'=>$pass,'pass2'=>$pass);
	$ch = curl_init($url); //初始化
	curl_setopt($ch, CURLOPT_HEADER, 0); //不返回header部分
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //返回字符串，??直接输出
	curl_setopt($ch, CURLOPT_COOKIEJAR,  $cookie_file); //存储cookies
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
	curl_exec($ch);
	curl_close($ch);
	
	echo "$user 注册成功，密码: $pass ,正在发表帖子";
	shell_exec("echo 账号: $user 密码: $pass >>users.log");

	//使?上?保存的cookies再次访问
	
	$post_string = array(
	'title' => $title,
	'content' => $content,
	'forum'=> rand(1,9),
	'tmp_md5' => 'GGeie',
	);
	
	$url = "http://114514.1919810/?post.html"; //HYBBS发帖提交URL，F12+发帖可以获得，不知道可以直接只改前面的URL
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file); //使?上?获取的cookies
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
	$response = curl_exec($ch);
	curl_close($ch);
	echo $response;
