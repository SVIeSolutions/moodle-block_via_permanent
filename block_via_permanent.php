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
 * Via block.
 *
 * @package   block_via_permanent
 * @copyright  SVIeSolutions <alexandra.dinan@sviesolutions.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_via_permanent extends block_list {

    public function init() {
        $this->title   = get_string('blockstring', 'block_via_permanent');
    }

    public function get_content() {
        global $CFG, $DB, $USER, $COURSE;
        if ($this->content !== null) {
            return $this->content;
        }

        $courseid = $this->page->course->id;
        $userid = $USER->id;

        $this->content = new stdClass;
        $this->content->items = array();
        $this->content->icons = array();

        $context = context_course::instance($COURSE->id);

        if (!has_capability('mod/via:manage', $context)) {
            $groupings = groups_get_user_groups($COURSE->id, $USER->id);
        }

        $sql = "SELECT cm.id, v.name, v.groupingid FROM {via} v
                JOIN {course_modules} cm ON v.id = cm.instance
                JOIN {modules} m ON m.id = cm.module
                LEFT JOIN {via_participants} vp ON vp.activityid = v.id
                WHERE v.activitytype = 2 AND m.name = 'via' AND v.course = ? AND cm.course = ? AND cm.visible = 1 AND vp.userid = ?
                ORDER BY v.name DESC";
        $vias = $DB->get_records_sql($sql, array($courseid, $courseid, $userid));

        if ($vias) {
            foreach ($vias as $via) {

                if (isset($groupings) && $via->groupingid != 0) {
                    if (!array_key_exists($via->groupingid, $groupings)) {
                        continue;
                    }
                }
                $this->content->items[] = '<a href="' . $CFG->wwwroot . '/mod/via/view.php?id=' . $via->id . '" >
                    <img src="' . $CFG->wwwroot . '/mod/via/pix/icon.png" width="20" height="20"
                    alt="" align="absmiddle"/>' . $via->name. '</a>'. '<br />';
            }
        }
        return $this->content;
    }

    public function applicable_formats() {
        return array('all' => true, 'mod' => false, 'my' => false, 'admin' => false, 'tag' => false);
    }

}
