<?php
/**
 * @copyright Copyright (c) 2016, ownCloud, Inc.
 *
 * @author Georg Ehrke <georg@owncloud.com>
 * @author Lukas Reschke <lukas@statuscode.ch>
 * @author Robin Appelman <robin@icewind.nl>
 *
 * @license AGPL-3.0
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License, version 3,
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 */
OCP\JSON::checkAdminUser();
OCP\JSON::callCheck();

if (!array_key_exists('appid', $_POST)) {
	OC_JSON::error();
	exit;
}

$app = new OC_App();
$appId = (string)$_POST['appid'];
$appId = OC_App::cleanAppId($appId);
$result = $app->installApp(
	$appId,
	\OC::$server->getConfig(),
	\OC::$server->getL10N('core')
);
if($result !== false) {
	OC_JSON::success(array('data' => array('appid' => $appId)));
} else {
	$l = \OC::$server->getL10N('settings');
	OC_JSON::error(array("data" => array( "message" => $l->t("Couldn't remove app.") )));
}
