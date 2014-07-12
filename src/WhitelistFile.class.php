<?php
use minecraftAccounts\Profile;
use minecraftAccounts\UUID;

/**
 * @author    Janek Ostendorf <ozzy@ozzyfant.de>
 * @copyright Copyright (c) 2014 Janek Ostendorf
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class WhitelistFile {
	/**
	 * @var string
	 */
	protected $path = '';

	/**
	 * [['uuid' => %UUID%, 'name' => %NAME%], [...]]
	 * @var array
	 */
	protected $players = [];

	/**
	 * Whitelist object cache
	 * @var Whitelist
	 */
	protected $whitelist = null;

	public function __construct($path) {
		$this->path = $path;
		$this->read();
	}

	/**
	 * Write current
	 */
	public function write() {
		// TODO: Add error handling
		$fh = fopen($this->path, 'w+'); // Writable, beginning of file, erase file, create if not exist
		fwrite($fh, json_encode($this->players));
		return $this;
	}

	/**
	 * Read from specified file
	 * @return $this
	 */
	public function read() {
		// Erase cached whitelist
		$this->whitelist = null;

		// Open file and read
		$json = json_decode(file_get_contents($this->path), true);
		// Just decoding does a great job for now
		$this->players = $json;

		return $this;
	}

	/**
	 * Gets whitelist object
	 * @return Whitelist
	 */
	public function getWhitelist() {
		if(!is_null($this->whitelist))
			return $this->whitelist;

		$whitelist = new Whitelist();
		foreach($this->players as $playerArray) {
			$profile = new Profile();
			$profile->setUuid(UUID::fromString($playerArray['uuid']));
			$profile->setUserName($playerArray['name']);
			$whitelist->addPlayer(new MinecraftPlayer($profile));
		}

		$this->whitelist = $whitelist;
		return $whitelist;
	}

	/**
	 * Updates whitelist object according to input
	 * @param Whitelist $whitelist
	 * @return $this
	 */
	public function updateWhitelist(Whitelist $whitelist) {
		$this->whitelist = $whitelist;
		$this->players = [];

		$i = 0;
		foreach($whitelist->getPlayers() as $player) {
			$player->complete();
			$this->players[$i]['name'] = $player->getName();
			$this->players[$i++]['uuid'] = $player->getUuid()->getFormatted();
		}
		return $this;
	}
} 