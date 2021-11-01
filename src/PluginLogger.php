<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

declare(strict_types=1);

namespace pocketmine\plugin;

use function spl_object_id;

class PluginLogger extends \PrefixedLogger implements \AttachableLogger{

	/** @var \LoggerAttachment[] */
	private $attachments = [];

	public function addAttachment(\LoggerAttachment $attachment){
		$this->attachments[spl_object_id($attachment)] = $attachment;
	}

	public function removeAttachment(\LoggerAttachment $attachment){
		unset($this->attachments[spl_object_id($attachment)]);
	}

	public function removeAttachments(){
		$this->attachments = [];
	}

	public function getAttachments(){
		return $this->attachments;
	}

	public function log($level, $message){
		parent::log($level, $message);
		foreach($this->attachments as $attachment){
			$attachment->log($level, $message);
		}
	}
}
