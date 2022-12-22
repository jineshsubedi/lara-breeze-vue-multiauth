<script setup>
    import NavLink from "@/Components/AdminLteNavLink.vue"
    import {SidebarIcon} from "@/Layouts/Common/Icons.vue"

    let TaskMenu = Ziggy.routes['supervisor.tasks.index'] ? true : false;
    let AttendanceHandlerMenu = Ziggy.routes['supervisor.attendanceHandler.index'] ? true : false;
    let HolidayMenu = Ziggy.routes['supervisor.holidays.index'] ? true : false;
    let SuggestionForMenu = Ziggy.routes['supervisor.suggestionfor.index'] ? true : false;
    let SuggestionMenu = Ziggy.routes['supervisor.suggestions.index'] ? true : false;
    let SurveyMenu = Ziggy.routes['supervisor.surveys.index'] ? true : false;
    let AdjustmentMenu = Ziggy.routes['supervisor.adjustments.index'] ? true : false;
    let OvertimeMenu = Ziggy.routes['supervisor.overtimes.index'] ? true : false;
    let ExitInterviewMenu = Ziggy.routes['supervisor.exitinterviews.index'] ? true : false;
    let EventMenu = Ziggy.routes['supervisor.events.index'] ? true : false;

</script>
<template>
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <NavLink
                    :href="route('supervisor.dashboard')"
                    :active="$page.component.startsWith('Supervisor/Dashboard')"
                >
                    <i :class="SidebarIcon.DASHBOARD"></i>
                    Dashboard
                </NavLink>
            </li>
            <li class="nav-item" v-if="AttendanceHandlerMenu && $page.props.can.includes('AttendanceHandler') && !$page.props.can.includes('HrHandler')">
                <NavLink
                    :href="route('supervisor.attendanceHandler.index')"
                    :active="$page.component.startsWith('Supervisor/Attendance/Main')"
                >
                    <i :class="SidebarIcon.ATTENDANCE_HANDLER"></i>
                    Attendance Handler
                </NavLink>
            </li>
            <li class="nav-item" v-if="$page.props.can.includes('StaffHandler') && !$page.props.can.includes('HrHandler')">
                <NavLink 
                    :href="route('supervisor.users.index')" 
                    :active="$page.component.startsWith('Supervisor/Users')"
                >
                    <i :class="SidebarIcon.STAFFS"></i><span>Staffs</span>
                </NavLink>
            </li>
            <li class="nav-item" v-if="$page.props.can.includes('HrHandler')">
                <a class="nav-link collapsed" data-bs-target="#hr-handler-nav" data-bs-toggle="collapse" href="#">
                    <i :class="SidebarIcon.HR_HANDLER"></i><span>Hr Handler</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="hr-handler-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li v-if="AttendanceHandlerMenu">
                        <NavLink
                            :href="route('supervisor.attendanceHandler.index')"
                            :active="$page.component.startsWith('Supervisor/Attendance/Main')"
                        >
                            <i :class="SidebarIcon.ATTENDANCE_HANDLER"></i>
                            Attendance Handler
                        </NavLink>
                    </li>
                    <li v-if="HolidayMenu">
                        <NavLink 
                            :href="route('supervisor.holidays.index')" 
                            :active="$page.component.startsWith('Supervisor/Holiday')"
                        >
                            <i :class="SidebarIcon.HOLIDAY"></i><span>Holiday</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('supervisor.fiscalyears.index')" 
                            :active="$page.component.startsWith('Supervisor/Fiscal')"
                        >
                            <i :class="SidebarIcon.FISCAL_YEAR"></i><span>Fiscal Year</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('supervisor.users.index')" 
                            :active="$page.component.startsWith('Supervisor/Users')"
                        >
                            <i :class="SidebarIcon.STAFFS"></i><span>Staffs</span>
                        </NavLink>
                    </li>
                    <li v-if="SuggestionForMenu">
                        <NavLink 
                            :href="route('supervisor.suggestionfor.index')" 
                            :active="$page.component.startsWith('Supervisor/Suggestionfor')"
                        >
                            <i :class="SidebarIcon.SUGGESTION_FOR"></i><span>Suggestion Category</span>
                        </NavLink>
                    </li>
                    <li v-if="SuggestionMenu">
                        <NavLink 
                            :href="route('supervisor.suggestions.index')" 
                            :active="$page.component.startsWith('Supervisor/Suggestion/Index')"
                        >
                            <i :class="SidebarIcon.SUGGESTION"></i><span>Suggestion</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('supervisor.notices.index')" 
                            :active="$page.component.startsWith('Supervisor/Notices')"
                        >
                            <i :class="SidebarIcon.NOTICE"></i><span>Notice</span>
                        </NavLink>
                    </li>
                    <li v-if="EventMenu">
                        <NavLink 
                            :href="route('supervisor.events.index')" 
                            :active="$page.component.startsWith('Supervisor/Events')"
                        >
                            <i :class="SidebarIcon.EVENT"></i><span>Events</span>
                        </NavLink>
                    </li>
                    <li v-if="SurveyMenu">
                        <NavLink 
                            :href="route('supervisor.surveys.index')" 
                            :active="$page.component.startsWith('Supervisor/Surveys')"
                        >
                            <i :class="SidebarIcon.SURVEY"></i><span>Custom Survey</span>
                        </NavLink>
                    </li>
                    <li v-if="ExitInterviewMenu">
                        <NavLink 
                            :href="route('supervisor.exitinterviews.index')" 
                            :active="$page.component.startsWith('Supervisor/ExitInterviews')"
                        >
                            <i :class="SidebarIcon.EXIT_INTERVIEW"></i><span>Exit Interview</span>
                        </NavLink>
                    </li>
                    <li class="nav-heading">Adjustment Configuration</li>
                    <li v-if="AdjustmentMenu">
                        <NavLink 
                            :href="route('supervisor.adjustmentreasons.index')" 
                            :active="$page.component.startsWith('Supervisor/adjustmentreasons')"
                        >
                            <i :class="SidebarIcon.ADJUSTMENT_FOR"></i><span>Adjustment Category</span>
                        </NavLink>
                    </li>
                    <li class="nav-heading">Overtime Configuration</li>
                    <li v-if="OvertimeMenu">
                        <NavLink 
                            :href="route('supervisor.overtimereasons.index')" 
                            :active="$page.component.startsWith('Supervisor/Overtimereasons')"
                        >
                            <i :class="SidebarIcon.OVERTIME_FOR"></i><span>Overtime Category</span>
                        </NavLink>
                    </li>
                </ul>
            </li>
            <li class="nav-item" v-if="TaskMenu">
                <a class="nav-link collapsed" data-bs-target="#tasks-nav" data-bs-toggle="collapse" href="#">
                    <i :class="SidebarIcon.TASK"></i><span>Tasks</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tasks-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <NavLink 
                            :href="route('supervisor.tasks.index')" 
                            :active="$page.component.startsWith('Supervisor/Tasks')"
                        >
                            <i :class="SidebarIcon.TASK_HOME"></i><span>Home</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('supervisor.helpdesks.index')" 
                            :active="$page.component.startsWith('Supervisor/Helpdesk')"
                        >
                            <i :class="SidebarIcon.HELP_DESK"></i><span>Help Desk</span>
                        </NavLink>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#requests-nav" data-bs-toggle="collapse" href="#">
                    <i :class="SidebarIcon.REQUESTS"></i><span>Requests</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="requests-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <NavLink 
                            :href="route('supervisor.leaves.index')" 
                            :active="$page.component.startsWith('Supervisor/Leave')"
                        >
                            <i :class="SidebarIcon.LEAVE_REQUEST"></i><span>Leave Requests</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('supervisor.compensatory.index')" 
                            :active="$page.component.startsWith('Supervisor/Compensatory')"
                        >
                            <i :class="SidebarIcon.COMPENSATORY"></i><span>Compensatory Off</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('supervisor.handovers.index')" 
                            :active="$page.component.startsWith('Supervisor/Handover')"
                        >
                            <i :class="SidebarIcon.HANDOVER"></i><span>Handover</span>
                        </NavLink>
                    </li>
                    <li v-if="AdjustmentMenu">
                        <NavLink 
                            :href="route('supervisor.adjustments.index')" 
                            :active="$page.component.startsWith('Supervisor/adjustments')"
                        >
                            <i :class="SidebarIcon.ADJUSTMENT"></i><span>Adjustment</span>
                        </NavLink>
                    </li>
                    <li v-if="OvertimeMenu">
                        <NavLink 
                            :href="route('supervisor.overtimes.index')" 
                            :active="$page.component.startsWith('Supervisor/Overtimes')"
                        >
                            <i :class="SidebarIcon.OVERTIME"></i><span>Overtime</span>
                        </NavLink>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#hrm-nav" data-bs-toggle="collapse" href="#">
                    <i :class="SidebarIcon.HRM"></i><span>HRM</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="hrm-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <NavLink 
                            :href="route('supervisor.attendances.index')" 
                            :active="route().current('supervisor.attendances.index')"
                        >
                            <i :class="SidebarIcon.ATTENDANCE"></i><span>Attendance</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('supervisor.dailytasks.index')" 
                            :active="route().current('supervisor.dailytasks.index')"
                        >
                            <i :class="SidebarIcon.DAILY_TASK"></i><span>Daily Tasks</span>
                        </NavLink>
                    </li>
                    <li v-if="SuggestionMenu">
                        <NavLink 
                            :href="route('supervisor.suggestions.index')" 
                            :active="$page.component.startsWith('Supervisor/Suggestion/Index')"
                        >
                            <i :class="SidebarIcon.SUGGESTION"></i><span>Suggestion</span>
                        </NavLink>
                    </li>
                    <li v-if="EventMenu">
                        <NavLink 
                            :href="route('supervisor.events.index')" 
                            :active="$page.component.startsWith('Supervisor/Events')"
                        >
                            <i :class="SidebarIcon.EVENT"></i><span>Events</span>
                        </NavLink>
                    </li>
                    <li v-if="SurveyMenu">
                        <NavLink 
                            :href="route('supervisor.mysurveys.index')" 
                            :active="$page.component.startsWith('Supervisor/Mysurveys')"
                        >
                            <i :class="SidebarIcon.SURVEY"></i><span>Survey</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('supervisor.organization_chart')" 
                            :active="$page.component.startsWith('Supervisor/Orgchart')"
                        >
                            <i :class="SidebarIcon.ORG_CHART"></i><span>Organization Chart</span>
                        </NavLink>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <NavLink
                    :href="route('supervisor.calendar')"
                    :active="$page.component.startsWith('Supervisor/Calendar')"
                >
                    <i :class="SidebarIcon.CALENDAR"></i>
                    Calendar
                </NavLink>
            </li>
        </ul>
    </aside>
</template>