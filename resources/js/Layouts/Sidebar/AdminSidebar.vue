<script setup>
    import NavLink from "@/Components/AdminLteNavLink.vue"
    import {SidebarIcon} from "@/Layouts/Common/Icons.vue"

    let DocumentMenu = Ziggy.routes['admin.documents.index'] ? true : false;
    let TaskMenu = Ziggy.routes['admin.tasks.index'] ? true : false;
    let AttendanceMenu = Ziggy.routes['admin.attendances.index'] ? true : false;
    let AttendanceHandlerMenu = Ziggy.routes['admin.attendanceHandler.index'] ? true : false;
    let HolidayMenu = Ziggy.routes['admin.holidays.index'] ? true : false;
    let SuggestionForMenu = Ziggy.routes['admin.suggestionfor.index'] ? true : false;
    let SuggestionMenu = Ziggy.routes['admin.suggestions.index'] ? true : false;
    let SurveyMenu = Ziggy.routes['admin.surveys.index'] ? true : false;
    let AdjustmentMenu = Ziggy.routes['admin.adjustments.index'] ? true : false;
    let OvertimeMenu = Ziggy.routes['admin.overtimes.index'] ? true : false;
    let ExitInterviewMenu = Ziggy.routes['admin.exitinterviews.index'] ? true : false;
    let EventMenu = Ziggy.routes['admin.events.index'] ? true : false;
    let BookingPlaceMenu = Ziggy.routes['admin.bookingplaces.index'] ? true : false;
    let BookingHallMenu = Ziggy.routes['admin.bookinghalls.index'] ? true : false;
    let BookingPurposeMenu = Ziggy.routes['admin.bookingpurposes.index'] ? true : false;
    let BookingMenu = Ziggy.routes['admin.bookings.index'] ? true : false;
    let RevenueMenu = Ziggy.routes['admin.revenues.index'] ? true : false;
    let SubordinateMenu = Ziggy.routes['admin.subordinates.index'] ? true : false;
    let TrainingMenu = Ziggy.routes['admin.trainings.index'] ? true : false;
    let LetterMenu = Ziggy.routes['admin.letters.index'] ? true : false;
    let TravelMenu = Ziggy.routes['admin.travels.index'] ? true : false;
    let OutSourceMenu = Ziggy.routes['admin.outsources.index'] ? true : false;
    let OnboardingMenu = Ziggy.routes['admin.onboardings.index'] ? true : false;
    let OffboardingMenu = Ziggy.routes['admin.offboardsettings.index'] ? true : false;
    let NewsfeedMenu = Ziggy.routes['admin.newsfeeds.index'] ? true : false;

</script>
<template>
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <NavLink
                    :href="route('admin.dashboard')"
                    :active="$page.component.startsWith('Admin/Dashboard')"
                >
                    <i :class="SidebarIcon.DASHBOARD"></i>
                    Dashboard
                </NavLink>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#setting-nav" data-bs-toggle="collapse" href="#">
                    <i :class="SidebarIcon.CONFIGURATION"></i><span>Configuration</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="setting-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li v-if="$page.props.can.includes('SuperAdmin')">
                        <NavLink 
                            :href="route('admin.setting.index')" 
                            :active="$page.component.startsWith('Admin/Setting')"
                        >
                            <i :class="SidebarIcon.SETTING"></i><span>Setting</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.branches.index')" 
                            :active="$page.component.startsWith('Admin/Branch')"
                        >
                            <i :class="SidebarIcon.BRANCH"></i><span>Branch</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.departments.index')" 
                            :active="$page.component.startsWith('Admin/Department')"
                        >
                            <i :class="SidebarIcon.DEPARTMENT"></i><span>Department</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.designations.index')" 
                            :active="$page.component.startsWith('Admin/Designation')"
                        >
                            <i :class="SidebarIcon.DESIGNATION"></i><span>Designation</span>
                        </NavLink>
                    </li>
                    <li v-if="DocumentMenu">
                        <NavLink 
                            :href="route('admin.documents.index')" 
                            :active="$page.component.startsWith('Admin/Document')"
                        >
                            <i :class="SidebarIcon.DOCUMENT"></i><span>Document</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.shift_times.index')" 
                            :active="$page.component.startsWith('Admin/Shifttime')"
                        >
                            <i :class="SidebarIcon.SHIFT"></i><span>Shift Time</span>
                        </NavLink>
                    </li>
                    <li v-if="HolidayMenu">
                        <NavLink 
                            :href="route('admin.holidays.index')" 
                            :active="$page.component.startsWith('Admin/Holiday')"
                        >
                            <i :class="SidebarIcon.HOLIDAY"></i><span>Holiday</span>
                        </NavLink>
                    </li>
                    <li v-if="$page.props.can.includes('SuperAdmin')">
                        <NavLink 
                            :href="route('admin.fiscalyears.index')" 
                            :active="$page.component.startsWith('Admin/Fiscal')"
                        >
                            <i :class="SidebarIcon.FISCAL_YEAR"></i><span>Fiscal Year</span>
                        </NavLink>
                    </li>
                    <li class="nav-heading">Leave Configuration</li>
                    <li>
                        <NavLink 
                            :href="route('admin.leave_types.index')" 
                            :active="$page.component.startsWith('Admin/Leavetype')"
                        >
                            <i :class="SidebarIcon.LEAVE_TYPE"></i><span>Leave Type</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.leave_setting.index')" 
                            :active="$page.component.startsWith('Admin/Leavesetting')"
                        >
                            <i :class="SidebarIcon.LEAVE_SETTING"></i><span>Leave Setting</span>
                        </NavLink>
                    </li>
                    <li class="nav-heading">Suggestion</li>
                    <li v-if="SuggestionForMenu">
                        <NavLink 
                            :href="route('admin.suggestionfor.index')" 
                            :active="$page.component.startsWith('Admin/Suggestionfor')"
                        >
                            <i :class="SidebarIcon.SUGGESTION_FOR"></i><span>Suggestion Category</span>
                        </NavLink>
                    </li>
                    <li class="nav-heading">Adjustment Configuration</li>
                    <li v-if="AdjustmentMenu">
                        <NavLink 
                            :href="route('admin.adjustmentreasons.index')" 
                            :active="$page.component.startsWith('Admin/adjustmentreasons')"
                        >
                            <i :class="SidebarIcon.ADJUSTMENT_FOR"></i><span>Adjustment Category</span>
                        </NavLink>
                    </li>
                    <li class="nav-heading">Overtime Configuration</li>
                    <li v-if="OvertimeMenu">
                        <NavLink 
                            :href="route('admin.overtimereasons.index')" 
                            :active="$page.component.startsWith('Admin/overtimereasons')"
                        >
                            <i :class="SidebarIcon.OVERTIME_FOR"></i><span>Overtime Category</span>
                        </NavLink>
                    </li>
                    <li class="nav-heading">Booking Configuration</li>
                    <li v-if="BookingPurposeMenu">
                        <NavLink 
                            :href="route('admin.bookingpurposes.index')" 
                            :active="$page.component.startsWith('Admin/BookingPurposes')"
                        >
                            <i :class="SidebarIcon.BOOKING_PURPOSE"></i><span>Purpose</span>
                        </NavLink>
                    </li>
                    <li v-if="BookingPlaceMenu">
                        <NavLink 
                            :href="route('admin.bookingplaces.index')" 
                            :active="$page.component.startsWith('Admin/BookingPlaces')"
                        >
                            <i :class="SidebarIcon.BOOKING_PLACE"></i><span>Place</span>
                        </NavLink>
                    </li>
                    <li v-if="BookingHallMenu">
                        <NavLink 
                            :href="route('admin.bookinghalls.index')" 
                            :active="$page.component.startsWith('Admin/BookingHalls')"
                        >
                            <i :class="SidebarIcon.BOOKING_HALL"></i><span>Halls</span>
                        </NavLink>
                    </li>
                    <li class="nav-heading">Travel Configuration</li>
                    <li class="nav-heading">Division Configuration</li>
                    <li v-if="RevenueMenu">
                        <NavLink 
                            :href="route('admin.divisions.index')" 
                            :active="$page.component.startsWith('Admin/Divisions')"
                        >
                            <i :class="SidebarIcon.DIVISION"></i><span>Divisions</span>
                        </NavLink>
                    </li>
                    <li class="nav-heading">Survey Configuration</li>
                    <li v-if="SurveyMenu && $page.props.can.includes('SuperAdmin')">
                        <NavLink 
                            :href="route('admin.surveys.index')" 
                            :active="$page.component.startsWith('Admin/Surveys')"
                        >
                            <i :class="SidebarIcon.SURVEY"></i><span>Custom Survey</span>
                        </NavLink>
                    </li>
                    <li class="nav-heading">Qualification Configuration</li>
                    <li>
                        <NavLink 
                            :href="route('admin.education.index')" 
                            :active="$page.component.startsWith('Admin/Education')"
                        >
                            <i :class="SidebarIcon.EDUCATION"></i><span>Education</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.faculties.index')" 
                            :active="$page.component.startsWith('Admin/Faculties')"
                        >
                            <i :class="SidebarIcon.FACULTY"></i><span>Faculty</span>
                        </NavLink>
                    </li>
                    <li class="nav-heading" v-if="$page.props.can.includes('SuperAdmin')">HR Letter</li>
                    <li v-if="LetterMenu && $page.props.can.includes('SuperAdmin')">
                        <NavLink 
                            :href="route('admin.lettertypes.index')" 
                            :active="$page.component.startsWith('Admin/LetterTypes')"
                        >
                            <i :class="SidebarIcon.LETTER"></i><span>Letter Type</span>
                        </NavLink>
                    </li>
                    <li v-if="LetterMenu && $page.props.can.includes('SuperAdmin')">
                        <NavLink 
                            :href="route('admin.letters.index')" 
                            :active="$page.component.startsWith('Admin/Letters')"
                        >
                            <i :class="SidebarIcon.LETTER"></i><span>Letters</span>
                        </NavLink>
                    </li>
                    <li class="nav-heading" v-if="$page.props.can.includes('SuperAdmin')">Travel Management</li>
                    <li v-if="TravelMenu && $page.props.can.includes('SuperAdmin')">
                        <NavLink 
                            :href="route('admin.assignmentcategories.index')" 
                            :active="$page.component.startsWith('Admin/Travel/AssignmentCategories')"
                        >
                            <i :class="SidebarIcon.TRAVEL_ASSIGNMENT_CATEGORY"></i><span>Assignment Category</span>
                        </NavLink>
                    </li>
                    <li v-if="TravelMenu && $page.props.can.includes('SuperAdmin')">
                        <NavLink 
                            :href="route('admin.assignmenttypes.index')" 
                            :active="$page.component.startsWith('Admin/Travel/AssignmentTypes')"
                        >
                            <i :class="SidebarIcon.TRAVEL_ASSIGNMENT_TYPE"></i><span>Assignment Types</span>
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
                            :href="route('admin.travels.index')" 
                            :active="$page.component.startsWith('Admin/Travel/Main')"
                        >
                            <i :class="SidebarIcon.TRAVEL_MAIN"></i><span>Request</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.travelplanners.index')" 
                            :active="$page.component.startsWith('Admin/Travel/Planner')"
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
                            :href="route('admin.tasks.index')" 
                            :active="$page.component.startsWith('Admin/Tasks')"
                        >
                            <i :class="SidebarIcon.TASK_HOME"></i><span>Home</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.helpdesks.index')" 
                            :active="$page.component.startsWith('Admin/Helpdesk')"
                        >
                            <i :class="SidebarIcon.HELP_DESK"></i><span>Help Desk</span>
                        </NavLink>
                    </li>
                </ul>
            </li>
            <li class="nav-item" v-if="OutSourceMenu && $page.props.can.includes('OutSourceHandler')">
                <NavLink 
                    :href="route('admin.outsources.index')" 
                    :active="$page.component.startsWith('Admin/Outsources')"
                >
                    <i :class="SidebarIcon.OUTSOURCE"></i><span>Outsourcing</span>
                </NavLink>
            </li>
            <!-- requests  -->
            <li class="nav-item"> 
                <a class="nav-link collapsed" data-bs-target="#requests-nav" data-bs-toggle="collapse" href="#">
                    <i :class="SidebarIcon.REQUESTS"></i><span>Requests</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="requests-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <NavLink 
                            :href="route('admin.leaves.index')" 
                            :active="$page.component.startsWith('Admin/Leave')"
                        >
                            <i :class="SidebarIcon.LEAVE_REQUEST"></i><span>Leave Requests</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.compensatory.index')" 
                            :active="$page.component.startsWith('Admin/Compensatory')"
                        >
                            <i :class="SidebarIcon.COMPENSATORY"></i><span>Compensatory Off</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.handovers.index')" 
                            :active="$page.component.startsWith('Admin/Handover')"
                        >
                            <i :class="SidebarIcon.HANDOVER"></i><span>Handover</span>
                        </NavLink>
                    </li>
                    <li v-if="AdjustmentMenu">
                        <NavLink 
                            :href="route('admin.adjustments.index')" 
                            :active="$page.component.startsWith('Admin/adjustments')"
                        >
                            <i :class="SidebarIcon.ADJUSTMENT"></i><span>Adjustment</span>
                        </NavLink>
                    </li>
                    <li v-if="OvertimeMenu">
                        <NavLink 
                            :href="route('admin.overtimes.index')" 
                            :active="$page.component.startsWith('Admin/overtimes')"
                        >
                            <i :class="SidebarIcon.OVERTIME"></i><span>Overtime</span>
                        </NavLink>
                    </li>
                </ul>
            </li>
            <!-- jobs  -->
            <li class="nav-item" v-if="$page.props.can.includes('HrHandler') || $page.props.can.includes('SuperAdmin')">
                <a class="nav-link collapsed" data-bs-target="#recruitment-nav" data-bs-toggle="collapse" href="#">
                    <i :class="SidebarIcon.JOB"></i><span>Recruitment</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="recruitment-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <NavLink 
                            :href="route('admin.joblevels.index')" 
                            :active="$page.component.startsWith('Admin/JobLevels')"
                        >
                            <i :class="SidebarIcon.JOBLEVEL"></i><span>Job Levels</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.joblocations.index')" 
                            :active="$page.component.startsWith('Admin/JobLocations')"
                        >
                            <i :class="SidebarIcon.JOBLOCATION"></i><span>Job Location</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.recruitmentprocesses.index')" 
                            :active="$page.component.startsWith('Admin/RecruitmentProcesses')"
                        >
                            <i :class="SidebarIcon.JOBPROCESS"></i><span>Recruitment Process</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.jobs.index')" 
                            :active="$page.component.startsWith('Admin/Jobs')"
                        >
                            <i :class="SidebarIcon.JOBPOST"></i><span>Job Post</span>
                        </NavLink>
                    </li>
                </ul>
            </li>
            <li v-if="BookingMenu">
                <NavLink 
                    :href="route('admin.bookings.index')" 
                    :active="$page.component.startsWith('Admin/Bookings')"
                >
                    <i :class="SidebarIcon.BOOKING"></i><span>Hall Booking</span>
                </NavLink>
            </li>
            <li class="nav-item" v-if="AttendanceHandlerMenu && $page.props.can.includes('AttendanceHandler') && !$page.props.can.includes('HrHandler')">
                <NavLink
                    :href="route('admin.attendanceHandler.index')"
                    :active="$page.component.startsWith('Admin/Attendance/Main')"
                >
                    <i :class="SidebarIcon.ATTENDANCE_HANDLER"></i>
                    Attendance Handler
                </NavLink>
            </li>
            <li class="nav-item" v-if="TrainingMenu">
                <a class="nav-link collapsed" data-bs-target="#training-nav" data-bs-toggle="collapse" href="#">
                    <i :class="SidebarIcon.TRAINING"></i><span>Training</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="training-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <NavLink 
                            :href="route('admin.trainingprograms.index')" 
                            :active="$page.component.startsWith('Admin/TrainingPrograms')"
                        >
                            <i :class="SidebarIcon.TRAINING_PROGRAM"></i><span>Programs/Course</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.trainers.index')" 
                            :active="$page.component.startsWith('Admin/Trainers')"
                        >
                            <i :class="SidebarIcon.TRAINER"></i><span>Trainer</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.trainings.index')" 
                            :active="$page.component.startsWith('Admin/Trainings')"
                        >
                            <i :class="SidebarIcon.TRAINING"></i><span>Trainings</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.td.index')" 
                            :active="$page.component.startsWith('Admin/TrainingOverview')"
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
                            :href="route('admin.attendanceHandler.index')"
                            :active="$page.component.startsWith('Admin/Attendance/Main')"
                        >
                            <i :class="SidebarIcon.ATTENDANCE_HANDLER"></i>
                            Attendance Handler
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.fiscalyears.index')" 
                            :active="$page.component.startsWith('Admin/Fiscal')"
                        >
                            <i :class="SidebarIcon.FISCAL_YEAR"></i><span>Fiscal Year</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.notices.index')" 
                            :active="$page.component.startsWith('Admin/Notices')"
                        >
                            <i :class="SidebarIcon.NOTICE"></i><span>Notice</span>
                        </NavLink>
                    </li>
                    <li v-if="OnboardingMenu">
                        <NavLink 
                            :href="route('admin.onboardings.index')" 
                            :active="$page.component.startsWith('Admin/OnBoardStaffs')"
                        >
                            <i :class="SidebarIcon.ONBOARDING"></i><span>Onboarding</span>
                        </NavLink>
                    </li>
                    <li v-if="EventMenu">
                        <NavLink 
                            :href="route('admin.events.index')" 
                            :active="$page.component.startsWith('Admin/Events')"
                        >
                            <i :class="SidebarIcon.EVENT"></i><span>Events</span>
                        </NavLink>
                    </li>
                    <li v-if="SurveyMenu">
                        <NavLink 
                            :href="route('admin.surveys.index')" 
                            :active="$page.component.startsWith('Admin/Surveys')"
                        >
                            <i :class="SidebarIcon.SURVEY"></i><span>Custom Survey</span>
                        </NavLink>
                    </li>
                    <li v-if="ExitInterviewMenu">
                        <NavLink 
                            :href="route('admin.exitinterviews.index')" 
                            :active="$page.component.startsWith('Admin/ExitInterviews')"
                        >
                            <i :class="SidebarIcon.EXIT_INTERVIEW"></i><span>Exit Interview</span>
                        </NavLink>
                    </li>
                    <li class="nav-heading">Qualification Configuration</li>
                    <li>
                        <NavLink 
                            :href="route('admin.education.index')" 
                            :active="$page.component.startsWith('Admin/Education')"
                        >
                            <i :class="SidebarIcon.EDUCATION"></i><span>Education</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.faculties.index')" 
                            :active="$page.component.startsWith('Admin/Faculties')"
                        >
                            <i :class="SidebarIcon.FACULTY"></i><span>Faculty</span>
                        </NavLink>
                    </li>
                    <li class="nav-heading">Travel Management</li>
                    <li v-if="TravelMenu">
                        <NavLink 
                            :href="route('admin.assignmentcategories.index')" 
                            :active="$page.component.startsWith('Admin/Travel/AssignmentCategories')"
                        >
                            <i :class="SidebarIcon.TRAVEL_ASSIGNMENT_CATEGORY"></i><span>Assignment Category</span>
                        </NavLink>
                    </li>
                    <li v-if="TravelMenu">
                        <NavLink 
                            :href="route('admin.assignmenttypes.index')" 
                            :active="$page.component.startsWith('Admin/Travel/AssignmentTypes')"
                        >
                            <i :class="SidebarIcon.TRAVEL_ASSIGNMENT_TYPE"></i><span>Assignment Types</span>
                        </NavLink>
                    </li>
                    <li class="nav-heading">HR Letter</li>
                    <li v-if="LetterMenu">
                        <NavLink 
                            :href="route('admin.lettertypes.index')" 
                            :active="$page.component.startsWith('Admin/LetterTypes')"
                        >
                            <i :class="SidebarIcon.LETTER"></i><span>Letter Type</span>
                        </NavLink>
                    </li>
                    <li v-if="LetterMenu">
                        <NavLink 
                            :href="route('admin.letters.index')" 
                            :active="$page.component.startsWith('Admin/Letters')"
                        >
                            <i :class="SidebarIcon.LETTER"></i><span>Letters</span>
                        </NavLink>
                    </li>
                </ul>
            </li>
            <li class="nav-item" v-if="OffboardingMenu">
                <a class="nav-link collapsed" data-bs-target="#offboarding-nav" data-bs-toggle="collapse" href="#">
                    <i :class="SidebarIcon.OFFBOARDING"></i><span>Offboarding</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="offboarding-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <NavLink 
                            :href="route('admin.offboardsettings.index')" 
                            :active="$page.component.startsWith('Admin/Offboard/Setting')"
                        >
                            <i :class="SidebarIcon.OFFBOARDING_ITEM"></i><span>OffBoard Setting</span>
                        </NavLink>
                    </li>
                    <!-- <li>
                        <NavLink 
                            :href="route('admin.offboardprocesses.index')" 
                            :active="$page.component.startsWith('Admin/Offboard/Process')"
                        >
                            <i :class="SidebarIcon.OFFBOARDING_ITEM"></i><span>OffBoard Process</span>
                        </NavLink>
                    </li> -->
                    <li>
                        <NavLink 
                            :href="route('admin.resignationreasons.index')" 
                            :active="$page.component.startsWith('Admin/Offboard/ResignationReasons')"
                        >
                            <i :class="SidebarIcon.OFFBOARDING_ITEM"></i><span>Resignation Reason</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.resignationtypes.index')" 
                            :active="$page.component.startsWith('Admin/Offboard/ResignationTypes')"
                        >
                            <i :class="SidebarIcon.OFFBOARDING_ITEM"></i><span>Resignation Types</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.terminationtypes.index')" 
                            :active="$page.component.startsWith('Admin/Offboard/TerminationTypes')"
                        >
                            <i :class="SidebarIcon.OFFBOARDING_ITEM"></i><span>Termination Type</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.disciplinarygrounds.index')" 
                            :active="$page.component.startsWith('Admin/Offboard/DisciplinaryGrounds')"
                        >
                            <i :class="SidebarIcon.OFFBOARDING_ITEM"></i><span>Disciplinary Grounds</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.disciplinaryactions.index')" 
                            :active="$page.component.startsWith('Admin/Offboard/DisciplinaryActions')"
                        >
                            <i :class="SidebarIcon.OFFBOARDING"></i><span>Disciplinary Actions</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.abscondings.index')" 
                            :active="$page.component.startsWith('Admin/Offboard/Abscondings')"
                        >
                            <i :class="SidebarIcon.OFFBOARDING"></i><span>Absconding</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.resignationstaffs.index')" 
                            :active="$page.component.startsWith('Admin/Offboard/ResignationStaffs')"
                        >
                            <i :class="SidebarIcon.OFFBOARDING"></i><span>Resignation</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.terminatestaffs.index')" 
                            :active="$page.component.startsWith('Admin/Offboard/TerminationStaffs')"
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
                            :href="route('admin.users.index')" 
                            :active="$page.component.startsWith('Admin/Users')"
                        >
                            <i :class="SidebarIcon.STAFFS"></i><span>Staffs</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.reports.index', $page.props.auth.user.id)" 
                            :active="$page.component.startsWith('Admin/Reports')"
                        >
                            <i :class="SidebarIcon.REPORT"></i><span>Report</span>
                        </NavLink>
                    </li>
                    <li v-if="AttendanceMenu">
                        <NavLink 
                            :href="route('admin.attendances.index')" 
                            :active="$page.component.startsWith('Admin/Attendance')"
                        >
                            <i :class="SidebarIcon.ATTENDANCE"></i><span>Attendance</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.dailytasks.index')" 
                            :active="$page.component.startsWith('Admin/DailyTasks')"
                        >
                            <i :class="SidebarIcon.DAILY_TASK"></i><span>Daily Tasks</span>
                        </NavLink>
                    </li>
                    <li v-if="TrainingMenu">
                        <NavLink 
                            :href="route('admin.mytrainings.index')" 
                            :active="$page.component.startsWith('Admin/Mytrainings')"
                        >
                            <i :class="SidebarIcon.TRAINING"></i><span>My Trainings</span>
                        </NavLink>
                    </li>
                    <li v-if="SuggestionMenu">
                        <NavLink 
                            :href="route('admin.suggestions.index')" 
                            :active="$page.component.startsWith('Admin/Suggestion/Index')"
                        >
                            <i :class="SidebarIcon.SUGGESTION"></i><span>Suggestion</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.notices.index')" 
                            :active="$page.component.startsWith('Admin/Notices')"
                        >
                            <i :class="SidebarIcon.NOTICE"></i><span>Notice</span>
                        </NavLink>
                    </li>
                    <li v-if="OffboardingMenu">
                        <NavLink 
                            :href="route('admin.disciplinary.index')" 
                            :active="$page.component.startsWith('Admin/Offboard/Disciplinary')"
                        >
                            <i :class="SidebarIcon.OFFBOARDING"></i><span>Disciplinary</span>
                        </NavLink>
                    </li>
                    <li v-if="OffboardingMenu">
                        <NavLink 
                            :href="route('admin.resignations.index')" 
                            :active="$page.component.startsWith('Admin/Offboard/Resignation')"
                        >
                            <i :class="SidebarIcon.OFFBOARDING"></i><span>Resignations</span>
                        </NavLink>
                    </li>
                    <li v-if="SurveyMenu">
                        <NavLink 
                            :href="route('admin.mysurveys.index')" 
                            :active="$page.component.startsWith('Admin/Mysurveys')"
                        >
                            <i :class="SidebarIcon.SURVEY"></i><span>Survey</span>
                        </NavLink>
                    </li>
                    <li v-if="OnboardingMenu">
                        <NavLink 
                            :href="route('admin.onboardings.index')" 
                            :active="$page.component.startsWith('Admin/OnBoardStaffs')"
                        >
                            <i :class="SidebarIcon.ONBOARDING"></i><span>Onboarding</span>
                        </NavLink>
                    </li>
                    <li v-if="EventMenu">
                        <NavLink 
                            :href="route('admin.events.index')" 
                            :active="$page.component.startsWith('Admin/Events')"
                        >
                            <i :class="SidebarIcon.EVENT"></i><span>Events</span>
                        </NavLink>
                    </li>
                    <li v-if="SubordinateMenu">
                        <NavLink 
                            :href="route('admin.subordinates.index')" 
                            :active="$page.component.startsWith('Admin/Subordinates/Index')"
                        >
                            <i :class="SidebarIcon.SUBORDINATE"></i><span>Subordinate Note</span>
                        </NavLink>
                    </li>
                    <li>
                        <NavLink 
                            :href="route('admin.organization_chart')" 
                            :active="$page.component.startsWith('Admin/Orgchart')"
                        >
                            <i :class="SidebarIcon.ORG_CHART"></i><span>Organization Chart</span>
                        </NavLink>
                    </li>
                </ul>
            </li>
            <li v-if="RevenueMenu && $page.props.can.includes('RevenueHandler') || $page.props.can.includes('SuperAdmin')">
                <NavLink 
                    :href="route('admin.revenues.index')" 
                    :active="$page.component.startsWith('Admin/Revenues')"
                >
                    <i :class="SidebarIcon.REVENUE"></i><span>Revenue</span>
                </NavLink>
            </li>
            <li class="nav-item">
                <NavLink
                    :href="route('admin.calendar')"
                    :active="$page.component.startsWith('Admin/Calendar')"
                >
                    <i :class="SidebarIcon.CALENDAR"></i>
                    Calendar
                </NavLink>
            </li>
            <li class="nav-item" v-if="NewsfeedMenu">
                <NavLink
                    :href="route('admin.newsfeeds.index')"
                    :active="$page.component.startsWith('Admin/Newsfeeds')"
                >
                    <i :class="SidebarIcon.NEWSFEED"></i>
                    NewsFeed
                </NavLink>
            </li>


            <!-- <li class="nav-heading">Pages</li> -->

            <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>Profile</span>
                </a>
            </li> -->


        </ul>
    </aside>
</template>