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
 * Via permanent block.
 *
 * Allows students to manage their user information on the via Live!
 * server from Moodle and admins/teachers to add students and other users
 * to a remote via Live! server.
 *
 * @copyright 2011 - 2016 SVIeSolutions
 */

class block_via_permanent extends block_list {

    public function init() {
        $this->title   = get_string('blockstring', 'block_via_permanent');
    }

    public function get_content() {
        global $CFG, $DB, $USER;

        if ($this->content !== null) {
            return $this->content;
        }

        $courseid = $this->page->course->id;
        $userid = $USER->id;

        $this->content = new stdClass;
        $this->content->items = array();
        $this->content->icons = array();

        $sql = "SELECT cm.id, v.name  FROM mdl_via v
            JOIN mdl_course_modules cm ON v.id = cm.instance
            JOIN mdl_modules m ON m.id = cm.module
            WHERE v.activitytype = 2 AND m.name = 'via' AND v.course = $courseid AND cm.course = $courseid AND cm.visible = 1
            ORDER BY v.name DESC";
        $result = $DB->get_records_sql($sql);

        if ($result) {
            foreach ($result as $row) {
                $this->content->items[] = '<a href="' . $CFG->wwwroot . '/mod/via/view.php?id=' . $row->id . '" >
                <img src="' . $CFG->wwwroot .
                '/mod/via/pix/icon.png" width="20" height="20" alt="" align="absmiddle"/>' . $row->name. '</a><br />';
            }
        }
        return $this->content;
    }

    public function applicable_formats() {
        return array('all' => true, 'mod' => false, 'my' => false, 'admin' => false, 'tag' => false);
    }
}