
<?php
ini_set('max_execution_time', 0);
class CommonUtil {

	public static function IsNullOrEmptyString($question){
		return (!isset($question) || trim($question)==='');
	}

	public static function getHouseType($houseType)
	{
		$msg = "";
		if($houseType == 'F')
		{
			$msg = "FeMale Housing";
		}else if($houseType == 'F')
		{
			$msg = "Male Housing";
		}else
		{
			$msg = "";
		}
		return $msg;
	}

	public static function deleteDirectory($dirPath) {
		if (! is_dir($dirPath)) {
			throw new InvalidArgumentException("$dirPath must be a directory");
		}
		if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
			$dirPath .= '/';
		}
		$files = glob($dirPath . '*', GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file)) {
				self::deleteDirectory($file);
			} else {
				unlink($file);
			}
		}
		rmdir($dirPath);
	}

	// 	public function  getChild($messages,$app_id,$parent_id)
	// 	{
	// 		$return_messages = array();

	// 		$index =0;
	// 		foreach ($messages AS $id => $data)
	// 		{
	// 			echo count($messages).'==='.$id.'<br>';
	// // 			if( $data['id'] = $parent_id )
	// // 			{
	// // 				$return_messages[$index] = $data;
	// // 				$index++;
	// // 			}
	// 		}
	// 		return $return_messages;


	// 		mysql_connect(ConfigUtil::getHostName(), ConfigUtil::getUsername(), ConfigUtil::getPassword());
	// 		mysql_select_db(ConfigUtil::getDbName());

	// 		$sql = "select id,menu_icon,menu_item,menu_item_src,menu_type from tb_menu where app_id=".$app_id." and parent=".$parent_id." order by menu_order asc";
	// 		echo $sql.'<br>';
	// 		$res = mysql_query($sql);
	// 		$messages = array();

	// 		if (mysql_num_rows($res))
	// 		{
	// 			while ($result = mysql_fetch_assoc($res))
	// 			{
	// 				$messages["$result[id]"] = $result;
	// 			}
	// 		}

	// 		mysql_free_result($res);

	// 		return $messages;
	// 	}
	function clean($string) {
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
	
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}
	function cleanString($text) {
		// 1) convert á ô => a o
		$text = preg_replace("/[áàâãªä]/u","a",$text);
		$text = preg_replace("/[ÁÀÂÃÄ]/u","A",$text);
		$text = preg_replace("/[ÍÌÎÏ]/u","I",$text);
		$text = preg_replace("/[íìîï]/u","i",$text);
		$text = preg_replace("/[éèêë]/u","e",$text);
		$text = preg_replace("/[ÉÈÊË]/u","E",$text);
		$text = preg_replace("/[óòôõºö]/u","o",$text);
		$text = preg_replace("/[ÓÒÔÕÖ]/u","O",$text);
		$text = preg_replace("/[úùûü]/u","u",$text);
		$text = preg_replace("/[ÚÙÛÜ]/u","U",$text);
		$text = preg_replace("/[’‘‹›‚]/u","'",$text);
		$text = preg_replace("/[“”«»„]/u",'"',$text);
		$text = str_replace("–","-",$text);
		$text = str_replace(" "," ",$text);
		$text = str_replace("ç","c",$text);
		$text = str_replace("Ç","C",$text);
		$text = str_replace("ñ","n",$text);
		$text = str_replace("Ñ","N",$text);

		//2) Translation CP1252. &ndash; => -
		$trans = get_html_translation_table(HTML_ENTITIES);
		$trans[chr(130)] = '&sbquo;';    // Single Low-9 Quotation Mark
		$trans[chr(131)] = '&fnof;';    // Latin Small Letter F With Hook
		$trans[chr(132)] = '&bdquo;';    // Double Low-9 Quotation Mark
		$trans[chr(133)] = '&hellip;';    // Horizontal Ellipsis
		$trans[chr(134)] = '&dagger;';    // Dagger
		$trans[chr(135)] = '&Dagger;';    // Double Dagger
		$trans[chr(136)] = '&circ;';    // Modifier Letter Circumflex Accent
		$trans[chr(137)] = '&permil;';    // Per Mille Sign
		$trans[chr(138)] = '&Scaron;';    // Latin Capital Letter S With Caron
		$trans[chr(139)] = '&lsaquo;';    // Single Left-Pointing Angle Quotation Mark
		$trans[chr(140)] = '&OElig;';    // Latin Capital Ligature OE
		$trans[chr(145)] = '&lsquo;';    // Left Single Quotation Mark
		$trans[chr(146)] = '&rsquo;';    // Right Single Quotation Mark
		$trans[chr(147)] = '&ldquo;';    // Left Double Quotation Mark
		$trans[chr(148)] = '&rdquo;';    // Right Double Quotation Mark
		$trans[chr(149)] = '&bull;';    // Bullet
		$trans[chr(150)] = '&ndash;';    // En Dash
		$trans[chr(151)] = '&mdash;';    // Em Dash
		$trans[chr(152)] = '&tilde;';    // Small Tilde
		$trans[chr(153)] = '&trade;';    // Trade Mark Sign
		$trans[chr(154)] = '&scaron;';    // Latin Small Letter S With Caron
		$trans[chr(155)] = '&rsaquo;';    // Single Right-Pointing Angle Quotation Mark
		$trans[chr(156)] = '&oelig;';    // Latin Small Ligature OE
		$trans[chr(159)] = '&Yuml;';    // Latin Capital Letter Y With Diaeresis
		$trans['euro'] = '&euro;';    // euro currency symbol
		ksort($trans);
			
		foreach ($trans as $k => $v) {
			$text = str_replace($v, $k, $text);
		}

		// 3) remove <p>, <br/> ...
		$text = strip_tags($text);
			
		// 4) &amp; => & &quot; => '
		$text = html_entity_decode($text);
			
		// 5) remove Windows-1252 symbols like "TradeMark", "Euro"...
		$text = preg_replace('/[^(\x20-\x7F)]*/','', $text);
			
		$targets=array('\r\n','\n','\r','\t');
		$results=array(" "," "," ","");
		$text = str_replace($targets,$results,$text);

		//XML compatible
		/*
		 $text = str_replace("&", "and", $text);
		$text = str_replace("<", ".", $text);
		$text = str_replace(">", ".", $text);
		$text = str_replace("\\", "-", $text);
		$text = str_replace("/", "-", $text);
		*/
			
		return ($text);
	}



	public function  checkHaveNewMessage()
	{			
		mysql_connect(ConfigUtil::getHostName(), ConfigUtil::getUsername(), ConfigUtil::getPassword());
		mysql_select_db(ConfigUtil::getDbName());
		mysql_query("SET NAMES UTF8");
		$sql = "select id from tb_question where isRead='1'";
		// 		echo $dql;
		$res = mysql_query($sql);
		$messages = array();

		if (mysql_num_rows($res))
		{
			while ($result = mysql_fetch_assoc($res))
			{
				$messages["$result[id]"] = $result;
			}
		}
		mysql_free_result($res);
		if (count($messages)){
			return true;
		}else {
			return false;
		}		
	}

	public function  updateAlreadyRead()
	{
		mysql_connect(ConfigUtil::getHostName(), ConfigUtil::getUsername(), ConfigUtil::getPassword());
		mysql_select_db(ConfigUtil::getDbName());
		mysql_query("SET NAMES UTF8");
		$sql = "update tb_question set isRead='0' where isRead='1'";
		$res = mysql_query($sql);
		if($res) {
			return true;
		} else {
			return false;
		}			
	}
	
	public function  isAlreadyReadQuestion($qid)
	{
		mysql_connect(ConfigUtil::getHostName(), ConfigUtil::getUsername(), ConfigUtil::getPassword());
		mysql_select_db(ConfigUtil::getDbName());
		mysql_query("SET NAMES UTF8");
		$sql = "SELECT * FROM tb_question_answer where question_id='".$qid."'";
		// 		echo $dql;
		$res = mysql_query($sql);
		$messages = array();
	
		if (mysql_num_rows($res))
		{
			while ($result = mysql_fetch_assoc($res))
			{
				$messages["$result[id]"] = $result;
			}
		}
		mysql_free_result($res);
		if (count($messages)){
			return true;
		}else {
			return false;
		}
	}	
}
?>