<?php
/**
 * @author    Janek Ostendorf <ozzy@ozzyfant.de>
 * @copyright Copyright (c) 2014 Janek Ostendorf
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

class Whitelist {
	/**
	 * @var MinecraftPlayer[]
	 */
	protected $players = [];

	public function __construct() {

	}

	public function addPlayer(MinecraftPlayer $player) {
		// TODO: Add some sort of intelligence here?
		$this->players[] = $player;

		return $this;
	}

	public function getPlayers() {
		return $this->players;
	}
}