<?php
/**
 * View team details
 *
 * Part of the DOMjudge Programming Contest Jury System and licenced
 * under the GNU GPL. See README and COPYING for details.
 */

$id = @$_GET['id'];

require('init.php');

if ( ! is_numeric($id) );

$title = 'Team t'.htmlspecialchars(@$id);
$menu = false;
require(LIBWWWDIR . '/header.php');

putTeam($id);

echo "<p><a href=\"./\">return to scoreboard</a></p>\n\n";

require(LIBWWWDIR . '/footer.php');
