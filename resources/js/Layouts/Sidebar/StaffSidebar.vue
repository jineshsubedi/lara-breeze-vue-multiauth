<script setup>
    import NavLink from "@/Components/AdminLteNavLink.vue"
    import {SidebarIcon} from "@/Layouts/Common/Icons.vue"

    let TaskMenu = Ziggy.routes['staffs.tasks.index'] ? true : false;
    let AttendanceHandlerMenu = Ziggy.routes['staffs.attendanceHandler.index'] ? true : false;
    let HolidayMenu = Ziggy.routes['staffs.holidays.index'] ? true : false;
    let SuggestionForMenu = Ziggy.routes['staffs.suggestionfor.index'] ? true : false;
    let SuggestionMenu = Ziggy.routes['staffs.suggestions.index'] ? true : false;
    let SurveyMenu = Ziggy.routes['staffs.surveys.index'] ? true : false;
    let AdjustmentMenu = Ziggy.routes['staffs.adjustments.index'] ? true : false;
    let OvertimeMenu = Ziggy.routes['staffs.overtimes.index'] ? true : false;
    let ExitInterviewMenu = Ziggy.routes['staffs.exitinterviews.index'] ? true : false;
    let EventMenu = Ziggy.routes['staffs.events.index'] ? true : false;
    let BookingPlaceMenu = Ziggy.routes['staffs.bookingplaces.index'] ? true : false;
    let BookingHallMenu = Ziggy.routes['staffs.bookinghalls.index'] ? true : false;
    let BookingPurposeMenu = Ziggy.routes['staffs.bookingpurposes.index'] ? true : false;
    let BookingMenu = Ziggy.routes['staffs.bookings.index'] ? true : false;
    let RevenueMenu = Ziggy.routes['admin.revenues.index'] ? true : false;

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
                    <li class="nav-heading">Booking Configuration</li>
                    <li v-if="BookingPurposeMenu">
                        <NavLink 
                            :href="route('staffs.bookingpurposes.index')" 
                            :active="$page.component.startsWith('Staff/BookingPurposes')"
                        >
                            <i :class="SidebarIcon.BOOKING_PURPOSE"></i><span>Purpose</span>
                        </NavLink>
                    </li>
                    <li v-if="BookingPlaceMenu">
                        <NavLink 
                            :href="route('staffs.bookingplaces.index')" 
                            :active="$page.component.startsWith('Staff/BookingPlaces')"
                        >
                            <i :class="SidebarIcon.BOOKING_PLACE"></i><span>Place</span>
                        </NavLink>
                    </li>
                    <li v-if="BookingHallMenu">
                        <NavLink 
                            :href="route('staffs.bookinghalls.index')" 
                            :active="$page.component.startsWith('Staff/BookingHalls')"
                        >
                            <i :class="SidebarIcon.BOOKING_HALL"></i><span>Halls</span>
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
                    <li v-if="EventMenu">
                        <NavLink 
                            :href="route('staffs.events.index')" 
                            :active="$page.component.startsWith('Staff/Events')"
                        >
                            <i :class="SidebarIcon.EVENT"></i><span>Events</span>
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
                    <li v-if="ExitInterviewMenu">
                        <NavLink 
                            :href="route('staffs.exitinterviews.index')" 
                            :active="$page.component.startsWith('Staff/ExitInterviews')"
                        >
                            <i :class="SidebarIcon.EXIT_INTERVIEW"></i><span>Exit Interview</span>
                        </NavLink>
                    </li>
                    <li class="nav-heading">Adjustment Configuration</li>
                    <li v-if="AdjustmentMenu">
                        <NavLink 
                            :href="route('staffs.adjustmentreasons.index')" 
                            :active="$page.component.startsWith('Staff/Adjustmentreasons')"
                        >
                            <i :class="SidebarIcon.ADJUSTMENT_FOR"></i><span>Adjustment Category</span>
                        </NavLink>
                    </li>
                    <li class="nav-heading">Overtime Configuration</li>
                    <li v-if="OvertimeMenu">
                        <NavLink 
                            :href="route('staffs.overtimereasons.index')" 
                            :active="$page.component.startsWith('Staff/Overtimereasons')"
                        >
                            <i :class="SidebarIcon.OVERTIME_FOR"></i><span>Overtime Category</span>
                        </NavLink>
                    </li>
                    <li class="nav-heading">Qualification Configuration</li>
                    <li>
                        <NavLink 
                            :href="route('staffs.education.index')" 
                            :active="$page.component.startsWith('Staff/Education')"
                        >
                            <i :class="SidebarIcon.EDUCATION"></i><span>Education</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('staffs.faculties.index')" 
                            :active="$page.component.startsWith('Staff/Faculties')"
                        >
                            <i :class="SidebarIcon.FACULTY"></i><span>Faculty</span>
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
                    <li v-if="AdjustmentMenu">
                        <NavLink 
                            :href="route('staffs.adjustments.index')" 
                            :active="$page.component.startsWith('Staff/Adjustments')"
                        >
                            <i :class="SidebarIcon.ADJUSTMENT"></i><span>Adjustment</span>
                        </NavLink>
                    </li>
                    <li v-if="OvertimeMenu">
                        <NavLink 
                            :href="route('staffs.overtimes.index')" 
                            :active="$page.component.startsWith('Staff/Overtimes')"
                        >
                            <i :class="SidebarIcon.OVERTIME"></i><span>Overtime</span>
                        </NavLink>
                    </li>
                </ul>
            </li>
            <li v-if="BookingMenu">
                <NavLink 
                    :href="route('staffs.bookings.index')" 
                    :active="$page.component.startsWith('Staff/Bookings')"
                >
                    <i :class="SidebarIcon.BOOKING"></i><span>Hall Booking</span>
                </NavLink>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#hrm-nav" data-bs-toggle="collapse" href="#">
                    <i :class="SidebarIcon.HRM"></i><span>HRM</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="hrm-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <NavLink 
                            :href="route('staffs.reports.index', $page.props.auth.user.id)" 
                            :active="$page.component.startsWith('Staff/Reports')"
                        >
                            <i :class="SidebarIcon.REPORT"></i><span>Report</span>
                        </NavLink>
                    </li>
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
                    <li v-if="EventMenu">
                        <NavLink 
                            :href="route('staffs.events.index')" 
                            :active="$page.component.startsWith('Staff/Events')"
                        >
                            <i :class="SidebarIcon.EVENT"></i><span>Events</span>
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
            <li class="nav-item" v-if="RevenueMenu && $page.props.can.includes('RevenueHandler')">
                <a class="nav-link collapsed" data-bs-target="#revenue-nav" data-bs-toggle="collapse" href="#">
                    <i :class="SidebarIcon.REVENUE"></i><span>Revenue</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="revenue-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <NavLink 
                            :href="route('staffs.divisions.index')" 
                            :active="$page.component.startsWith('Staff/Divisions')"
                        >
                            <i :class="SidebarIcon.DIVISION"></i><span>Divisions</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('staffs.revenues.index')" 
                            :active="$page.component.startsWith('Staff/Revenues')"
                        >
                            <i :class="SidebarIcon.REVENUE"></i><span>Revenue Upload</span>
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