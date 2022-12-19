<script setup>
    import NavLink from "@/Components/AdminLteNavLink.vue"
    import {SidebarIcon} from "@/Layouts/Common/Icons.vue"

    let TaskMenu = Ziggy.routes['staffs.tasks.index'] ? true : false;
    let AttendanceHandlerMenu = Ziggy.routes['staffs.attendanceHandler.index'] ? true : false;
    let HolidayMenu = Ziggy.routes['staffs.holidays.index'] ? true : false;
    let SuggestionForMenu = Ziggy.routes['staffs.suggestionfor.index'] ? true : false;
    let SuggestionMenu = Ziggy.routes['staffs.suggestions.index'] ? true : false;
    let SurveyMenu = Ziggy.routes['staffs.surveys.index'] ? true : false;

</script>
<template>
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <NavLink
                    :href="route('staffs.dashboard')"
                    :active="$page.component.startsWith('Staff/Dashboard')"
                >
                    <i :class="SidebarIcon.DASHBOARD"></i>
                    Dashboard
                </NavLink>
            </li>
            <li class="nav-item" v-if="AttendanceHandlerMenu && $page.props.can.includes('AttendanceHandler') && !$page.props.can.includes('HrHandler')">
                <NavLink
                    :href="route('staffs.attendanceHandler.index')"
                    :active="$page.component.startsWith('Staff/Attendance/Main')"
                >
                    <i :class="SidebarIcon.ATTENDANCE_HANDLER"></i>
                    Attendance Handler
                </NavLink>
            </li>
            <li class="nav-item" v-if="$page.props.can.includes('StaffHandler') && !$page.props.can.includes('HrHandler')">
                <NavLink 
                    :href="route('staffs.users.index')" 
                    :active="$page.component.startsWith('Staff/Users')"
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
                            :href="route('staffs.attendanceHandler.index')"
                            :active="$page.component.startsWith('Staff/Attendance/Main')"
                        >
                            <i :class="SidebarIcon.ATTENDANCE_HANDLER"></i>
                            Attendance Handler
                        </NavLink>
                    </li>
                    <li v-if="HolidayMenu">
                        <NavLink 
                            :href="route('staffs.holidays.index')" 
                            :active="$page.component.startsWith('Staff/Holiday')"
                        >
                            <i :class="SidebarIcon.HOLIDAY"></i><span>Holiday</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('staffs.fiscalyears.index')" 
                            :active="$page.component.startsWith('Staff/Fiscal')"
                        >
                            <i :class="SidebarIcon.FISCAL_YEAR"></i><span>Fiscal Year</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('staffs.users.index')" 
                            :active="$page.component.startsWith('Staff/Users')"
                        >
                            <i :class="SidebarIcon.STAFFS"></i><span>Staffs</span>
                        </NavLink>
                    </li>
                    <li v-if="SuggestionForMenu">
                        <NavLink 
                            :href="route('staffs.suggestionfor.index')" 
                            :active="$page.component.startsWith('Staff/Suggestionfor')"
                        >
                            <i :class="SidebarIcon.SUGGESTION_FOR"></i><span>Suggestion Category</span>
                        </NavLink>
                    </li>
                    <li v-if="SuggestionMenu">
                        <NavLink 
                            :href="route('staffs.suggestions.index')" 
                            :active="$page.component.startsWith('Staff/Suggestion/Index')"
                        >
                            <i :class="SidebarIcon.SUGGESTION"></i><span>Suggestion</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('staffs.notices.index')" 
                            :active="$page.component.startsWith('Staff/Notices')"
                        >
                            <i :class="SidebarIcon.NOTICE"></i><span>Notice</span>
                        </NavLink>
                    </li>
                    <li v-if="SurveyMenu">
                        <NavLink 
                            :href="route('staffs.surveys.index')" 
                            :active="$page.component.startsWith('Staff/Surveys')"
                        >
                            <i :class="SidebarIcon.SURVEY"></i><span>Custom Survey</span>
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
                            :href="route('staffs.tasks.index')" 
                            :active="$page.component.startsWith('Staff/Tasks')"
                        >
                            <i :class="SidebarIcon.TASK_HOME"></i><span>Home</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('staffs.helpdesks.index')" 
                            :active="$page.component.startsWith('Staff/Helpdesk')"
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
                            :href="route('staffs.leaves.index')" 
                            :active="$page.component.startsWith('Staff/Leave')"
                        >
                            <i :class="SidebarIcon.LEAVE_REQUEST"></i><span>Leave Requests</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('staffs.compensatory.index')" 
                            :active="$page.component.startsWith('Staff/Compensatory')"
                        >
                            <i :class="SidebarIcon.COMPENSATORY"></i><span>Compensatory Off</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('staffs.handovers.index')" 
                            :active="$page.component.startsWith('Staff/Handover')"
                        >
                            <i :class="SidebarIcon.HANDOVER"></i><span>Handover</span>
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
                            :href="route('staffs.attendances.index')" 
                            :active="route().current('staffs.attendances.index')"
                        >
                            <i :class="SidebarIcon.ATTENDANCE"></i><span>Attendance</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('staffs.dailytasks.index')" 
                            :active="route().current('staffs.dailytasks.index')"
                        >
                            <i :class="SidebarIcon.DAILY_TASK"></i><span>Daily Tasks</span>
                        </NavLink>
                    </li>
                    <li v-if="SuggestionMenu">
                        <NavLink 
                            :href="route('staffs.suggestions.index')" 
                            :active="$page.component.startsWith('Staff/Suggestion/Index')"
                        >
                            <i :class="SidebarIcon.SUGGESTION"></i><span>Suggestion</span>
                        </NavLink>
                    </li>
                    <li v-if="SurveyMenu">
                        <NavLink 
                            :href="route('staffs.mysurveys.index')" 
                            :active="$page.component.startsWith('Staff/Mysurveys')"
                        >
                            <i :class="SidebarIcon.SURVEY"></i><span>Survey</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('staffs.organization_chart')" 
                            :active="$page.component.startsWith('Staff/Orgchart')"
                        >
                            <i :class="SidebarIcon.ORG_CHART"></i><span>Organization Chart</span>
                        </NavLink>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <NavLink
                    :href="route('staffs.calendar')"
                    :active="$page.component.startsWith('Staff/Calendar')"
                >
                    <i :class="SidebarIcon.CALENDAR"></i>
                    Calendar
                </NavLink>
            </li>
        </ul>
    </aside>
</template>