<?php
/**
 * @package       poster
 * @copyright     Copyright 2016 杭州阿拉丁信息科技股份有限公司武汉分公司
 * @author        JAKE
 * @time          2016/3/14 13:34
 * @description
 */



if(isset($_POST['action'])){
	require_once 'config.php';
	$CFG = new Config();
	switch($_POST['action']){
		case 'addLink' :
			$time = date('Y-m-d H:i:s');
			$ip = $_SERVER['REMOTE_ADDR'];
			try{
				$dbHandler = new PDO("mysql:dbname=".$CFG::DBNAME.";host=".$CFG::HOST, $CFG::DBUSER, $CFG::DBPSWD);
				$insert_sql = "insert into p_links(link,time,ip,times) values('{$_POST['link']}','{$time}','{$ip}',1)";
				$find_sql = "select * from p_links where link = '{$_POST['link']}'";
				$has = $dbHandler->query($find_sql);
				foreach($has as $key => $item){
					if($item) {
						$increase_sql = "update p_links set times = times+1 where link = '{$_POST['link']}'";
						$dbHandler->query($increase_sql);
						echo '此记录已经+1';
						exit;
					}
				}
				$res = $dbHandler->exec($insert_sql);
				if($res){
					echo '已添加一条新的记录';
				}else{
					var_dump($dbHandler->errorInfo());
				}
			}catch (PDOException $e){
				echo $e->getMessage();
			}
		break;
		case 'getList' :
			break;
	}

}else{
	echo "bad request";
}