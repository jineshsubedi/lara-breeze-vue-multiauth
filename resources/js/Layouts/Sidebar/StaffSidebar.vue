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
    let RevenueMenu = Ziggy.routes['staffs.revenues.index'] ? true : false;
    let SubordinateMenu = Ziggy.routes['staffs.subordinates.index'] ? true : false;
    let TrainingMenu = Ziggy.routes['staffs.trainings.index'] ? true : false;
    let LetterMenu = Ziggy.routes['staffs.letters.index'] ? true : false;
    let TravelMenu = Ziggy.routes['staffs.travels.index'] ? true : false;
    let OutSourceMenu = Ziggy.routes['staffs.outsources.index'] ? true : false;
    let OffboardingMenu = Ziggy.routes['staffs.offboardsettings.index'] ? true : false;
    let NewsfeedMenu = Ziggy.routes['staffs.newsfeeds.index'] ? true : false;

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
            <li class="nav-item" v-if="TrainingMenu">
                <a class="nav-link collapsed" data-bs-target="#training-nav" data-bs-toggle="collapse" href="#">
                    <i :class="SidebarIcon.TRAINING"></i><span>Training</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="training-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <NavLink 
                            :href="route('staffs.trainingprograms.index')" 
                            :active="$page.component.startsWith('Staff/TrainingPrograms')"
                        >
                            <i :class="SidebarIcon.TRAINING_PROGRAM"></i><span>Programs/Course</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('staffs.trainers.index')" 
                            :active="$page.component.startsWith('Staff/Trainers')"
                        >
                            <i :class="SidebarIcon.TRAINER"></i><span>Trainer</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('staffs.trainings.index')" 
                            :active="$page.component.startsWith('Staff/Trainings')"
                        >
                            <i :class="SidebarIcon.TRAINING"></i><span>Trainings</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('staffs.td.index')" 
                            :active="$page.component.startsWith('Staff/TrainingOverview')"
                        >
                            <i :class="SidebarIcon.OVERVIEW"></i><span>Overview</span>
                        </NavLink>
                    </li>
                </ul>
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
                    <li class="nav-heading">Travel Management</li>
                    <li v-if="TravelMenu">
                        <NavLink 
                            :href="route('staffs.assignmentcategories.index')" 
                            :active="$page.component.startsWith('Staff/Travel/AssignmentCategories')"
                        >
                            <i :class="SidebarIcon.TRAVEL_ASSIGNMENT_CATEGORY"></i><span>Assignment Category</span>
                        </NavLink>
                    </li>
                    <li v-if="TravelMenu">
                        <NavLink 
                            :href="route('staffs.assignmenttypes.index')" 
                            :active="$page.component.startsWith('Staff/Travel/AssignmentTypes')"
                        >
                            <i :class="SidebarIcon.TRAVEL_ASSIGNMENT_TYPE"></i><span>Assignment Types</span>
                        </NavLink>
                    </li>
                    <li class="nav-heading">HR Letter</li>
                    <li v-if="LetterMenu">
                        <NavLink 
                            :href="route('staffs.lettertypes.index')" 
                            :active="$page.component.startsWith('Staff/LetterTypes')"
                        >
                            <i :class="SidebarIcon.LETTER"></i><span>Letter Type</span>
                        </NavLink>
                    </li>
                    <li v-if="LetterMenu">
                        <NavLink 
                            :href="route('staffs.letters.index')" 
                            :active="$page.component.startsWith('Staff/Letters')"
                        >
                            <i :class="SidebarIcon.LETTER"></i><span>Letters</span>
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
            <li class="nav-item" v-if="TravelMenu">
                <a class="nav-link collapsed" data-bs-target="#travels-nav" data-bs-toggle="collapse" href="#">
                    <i :class="SidebarIcon.TRAVEL"></i><span>Travel</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="travels-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <NavLink 
                            :href="route('staffs.travels.index')" 
                            :active="$page.component.startsWith('Staff/Travel/Main')"
                        >
                            <i :class="SidebarIcon.TRAVEL_MAIN"></i><span>Request</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('staffs.travelplanners.index')" 
                            :active="$page.component.startsWith('Staff/Travel/Planner')"
                        >
                            <i :class="SidebarIcon.TRAVEL_PLANNER"></i><span>Planner</span>
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
            <li class="nav-item" v-if="OutSourceMenu && $page.props.can.includes('OutSourceHandler')">
                <NavLink 
                    :href="route('staffs.outsources.index')" 
                    :active="$page.component.startsWith('Staff/Outsources')"
                >
                    <i :class="SidebarIcon.OUTSOURCE"></i><span>Outsourcing</span>
                </NavLink>
            </li>
            <li v-if="BookingMenu">
                <NavLink 
                    :href="route('staffs.bookings.index')" 
                    :active="$page.component.startsWith('Staff/Bookings')"
                >
                    <i :class="SidebarIcon.BOOKING"></i><span>Hall Booking</span>
                </NavLink>
            </li>
            <li class="nav-item" v-if="OffboardingMenu && $page.props.can.includes('HrHandler')">
                <a class="nav-link collapsed" data-bs-target="#offboarding-nav" data-bs-toggle="collapse" href="#">
                    <i :class="SidebarIcon.OFFBOARDING"></i><span>Offboarding</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="offboarding-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <NavLink 
                            :href="route('staffs.offboardsettings.index')" 
                            :active="$page.component.startsWith('Staff/Offboard/Setting')"
                        >
                            <i :class="SidebarIcon.OFFBOARDING_ITEM"></i><span>OffBoard Setting</span>
                        </NavLink>
                    </li>
                    <!-- <li>
                        <NavLink 
                            :href="route('staffs.offboardprocesses.index')" 
                            :active="$page.component.startsWith('Staff/Offboard/Process')"
                        >
                            <i :class="SidebarIcon.OFFBOARDING_ITEM"></i><span>OffBoard Process</span>
                        </NavLink>
                    </li> -->
                    <li>
                        <NavLink 
                            :href="route('staffs.resignationreasons.index')" 
                            :active="$page.component.startsWith('Staff/Offboard/ResignationReasons')"
                        >
                            <i :class="SidebarIcon.OFFBOARDING_ITEM"></i><span>Resignation Reason</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('staffs.resignationtypes.index')" 
                            :active="$page.component.startsWith('Staff/Offboard/ResignationTypes')"
                        >
                            <i :class="SidebarIcon.OFFBOARDING_ITEM"></i><span>Resignation Types</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('staffs.terminationtypes.index')" 
                            :active="$page.component.startsWith('Staff/Offboard/TerminationTypes')"
                        >
                            <i :class="SidebarIcon.OFFBOARDING_ITEM"></i><span>Termination Type</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('staffs.disciplinarygrounds.index')" 
                            :active="$page.component.startsWith('Staff/Offboard/DisciplinaryGrounds')"
                        >
                            <i :class="SidebarIcon.OFFBOARDING_ITEM"></i><span>Disciplinary Grounds</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('staffs.disciplinaryactions.index')" 
                            :active="$page.component.startsWith('Staff/Offboard/DisciplinaryActions')"
                        >
                            <i :class="SidebarIcon.OFFBOARDING"></i><span>Disciplinary Actions</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('staffs.abscondings.index')" 
                            :active="$page.component.startsWith('Staff/Offboard/Abscondings')"
                        >
                            <i :class="SidebarIcon.OFFBOARDING"></i><span>Absconding</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('staffs.resignationstaffs.index')" 
                            :active="$page.component.startsWith('Staff/Offboard/ResignationStaffs')"
                        >
                            <i :class="SidebarIcon.OFFBOARDING"></i><span>Resignation</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('staffs.terminatestaffs.index')" 
                            :active="$page.component.startsWith('Staff/Offboard/TerminationStaffs')"
                        >
                            <i :class="SidebarIcon.OFFBOARDING"></i><span>Termination</span>
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
                    <li v-if="TrainingMenu">
                        <NavLink 
                            :href="route('staffs.mytrainings.index')" 
                            :active="$page.component.startsWith('Staff/Mytrainings')"
                        >
                            <i :class="SidebarIcon.TRAINING"></i><span>My Trainings</span>
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
                    <li v-if="OffboardingMenu">
                        <NavLink 
                            :href="route('staffs.disciplinary.index')" 
                            :active="$page.component.startsWith('Staff/Offboard/Disciplinary')"
                        >
                            <i :class="SidebarIcon.OFFBOARDING"></i><span>Disciplinary</span>
                        </NavLink>
                    </li>
                    <li v-if="OffboardingMenu">
                        <NavLink 
                            :href="route('staffs.resignations.index')" 
                            :active="$page.component.startsWith('Staff/Offboard/Resignation')"
                        >
                            <i :class="SidebarIcon.OFFBOARDING"></i><span>Resignations</span>
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
                    <li v-if="SubordinateMenu">
                        <NavLink 
                            :href="route('staffs.subordinates.index')" 
                            :active="$page.component.startsWith('Staff/Subordinates/Index')"
                        >
                            <i :class="SidebarIcon.SUBORDINATE"></i><span>Subordinate Note</span>
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
            <li class="nav-item" v-if="NewsfeedMenu">
                <NavLink
                    :href="route('staffs.newsfeeds.index')"
                    :active="$page.component.startsWith('Staff/Newsfeeds')"
                >
                    <i :class="SidebarIcon.NEWSFEED"></i>
                    NewsFeed
                </NavLink>
            </li>
        </ul>
    </aside>
</template>