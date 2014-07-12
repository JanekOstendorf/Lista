<?php
/**
 * @author    Janek Ostendorf <ozzy@ozzyfant.de>
 * @copyright Copyright (c) 2014 Janek Ostendorf
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

use minecraftAccounts\Converter;
use minecraftAccounts\Profile;
use minecraftAccounts\UUID;

class MinecraftPlayer {

	/**
	 * @var \minecraftAccounts\Profile
	 */
	protected $profile = null;

	public function __construct(Profile $profile) {
		$this->profile = $profile;
	}

	/**
	 * Completes attributes to this player (UUID/Name)
	 * @return $this
	 */
	public function complete() {
		$this->profile = Converter::completeProfile($this->profile);
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->profile->getUserName();
	}

	/**
	 * @return \minecraftAccounts\UUID
	 */
	public function getUUID() {
		return $this->profile->getUuid();
	}

	/**
	 * Create new player using the username
	 * @param $username
	 * @return MinecraftPlayer
	 */
	static public function fromName($username) {
		$profile = new Profile();
		$profile->setUserName($username);
		return new self($profile);
	}

	/**
	 * Create new player using the uuid
	 * @param UUID $uuid
	 * @return MinecraftPlayer
	 */
	static public function fromUUID(UUID $uuid) {
		$profile = new Profile();
		$profile->setUuid($uuid);
		return new self($profile);
	}

	/**
	 * Create new player using uuid (string)
	 * @param $uuidString
	 * @return MinecraftPlayer
	 */
	static public function fromUUIDString($uuidString) {
		$uuid = UUID::fromString($uuidString);
		$profile = new Profile();
		$profile->setUuid($uuid);
		return new self($profile);
	}
} 