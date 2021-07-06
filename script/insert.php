<?php

$root = dirname(dirname(__DIR__))."/nako3storage";
// include
require_once $root.'/app/n3s_config.def.php';
require_once $root."/n3s_config.ini.php";
require_once $root.'/app/n3s_lib.inc.php';

n3s_db_init();

$wiki = "■ 書籍のサンプルプログラム\n\n";
$log = [];
for ($ch = 1; $ch <= 5; $ch++) {
  echo "* {$ch} 章\n";
  $wiki .= "● {$ch} 章\n";
  $files = glob("../src/ch{$ch}/*.nako3");
  foreach ($files as $f) {
    $ff = str_replace('../src', 'src', $f);
    echo "- $ff\n";
    $body2 = file_get_contents($f);
    $body = 
      "### なでしこ3本 ${ch}章 のサンプル ###\n".
      "# [file] {$f}\n".
      "# [説明URL] https://nadesi.com/top/go.php?46\n".
      "\n".
      $body2;
    $name = basename($f);
    $a = [
      "author"=>"クジラ飛行机",
      "email"=>"web@kujirahand.com",
      "tag"=>"なでしこ3本",
      "memo"=>"「なでしこ3本」{$ch}章のサンプル「{$name}」です。",
      "is_private"=>0,
      "user_id"=>1,
      "title" => "ch{$ch}/$name",
      "url" => "https://nadesi.com/top/go.php?46",
      "canvas_w" => 400,
      "canvas_h" => 300,
      "access_key" => "",
      "version" => "3.2.23",
      "custom_head" => "",
      "copyright" => "MIT",
      "editkey" => "",
      "nakotype"=>"wnako",
      "ref_id"=>0,
      "ip"=>"",
      "body"=>$body,
    ];
    $id = n3s_saveNewProgram($a);
    $log[] = ['app_id'=>$id, 'file'=>$ff];
    $wiki .= "- [[$ff:https://n3s.nadesi.com/id.php?{$id}\n";
  }
}
// save
file_put_contents("save.txt", json_encode($log));
file_put_contents("wiki.txt", $wiki);



