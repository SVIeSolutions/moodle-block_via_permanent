<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Via Permanent activities block.
 *
 * @package   block_via_permanent
 * @copyright  SVIeSolutions <alexandra.dinan@sviesolutions.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$plugin->version = 2022060701;
$plugin->requires = 2011033003; // Requires this Moodle version.
$plugin->component = 'block_via_permanent'; // Full name of the plugin (used for diagnostics).
$plugin->maturity = MATURITY_STABLE; // This is considered as ready for production sites.
$plugin->release = 'v4.0-r1';
$plugin->dependencies = array(
	'mod_via' => 2022060701,
);
