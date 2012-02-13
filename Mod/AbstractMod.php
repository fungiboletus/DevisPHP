<?php

class AbstractMod {

	public static function validerID($id) {
		return ($id < 0 ? 0 : ($id >= count(static::$liste) ? 0 : intval($id)));	
	}
}

?>
