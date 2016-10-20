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
 * @subpackage block_via_permanent
 * @copyright 2011 - 2016 SVIeSolutions
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Via permanent block.
 * Extends moodle class block_list.
 */
class block_via_permanent extends block_list {

    /**
     * This is method init
     *
     * @return string This is the bloc title
     *
     */
    public function init() {
        $this->title   = get_string('blockstring', 'block_via_permanent');
    }

    /**
     * Creates the blocks main content
     *
     * @return string
     */
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

        $sql = "SELECT cm.id, v.name  FROM {via} v
            JOIN {course_modules} cm ON v.id = cm.instance AND cm.course = v.course
            JOIN {modules} m ON m.id = cm.module
            JOIN {via_participants} vp ON vp.activityid = v.id
            WHERE v.activitytype = 2 AND m.name = 'via' AND v.course = ? AND cm.visible = 1 AND vp.userid = ?
            ORDER BY v.name DESC";
        $result = $DB->get_records_sql($sql, array($courseid, $USER->id));

        if ($result) {
            foreach ($result as $row) {
                $this->content->items[] = '<a href="' . $CFG->wwwroot . '/mod/via/view.php?id=' . $row->id . '" >
                <img src="' . $CFG->wwwroot .
                '/mod/via/pix/icon.png" class="via icon" alt="via" align="absmiddle"/>' . $row->name. '</a><br />';
            }
        }
        return $this->content;
    }

    /**
     * Set the applicable formats for this block to all
     * @return array
     */
    public function applicable_formats() {
        return array('all' => true, 'mod' => false, 'my' => false, 'admin' => false, 'tag' => false);
    }
}
