<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import ReportLink from "@/Components/ReportLink.vue";
import KPI from "./Kpi.vue"
import KRA from "./Kra.vue"

import TASK from "./Task.vue"
import HELPDESK from "./Helpdesk.vue"
let TaskMenu = Ziggy.routes['staffs.tasks.index'] ? true : false;
import LEAVE from "./Leave.vue"
let LeaveMenu = Ziggy.routes['staffs.leaves.index'] ? true : false;
import ATTENDANCE from "./Attendance.vue"
let AttendanceMenu = Ziggy.routes['staffs.attendances.index'] ? true : false;
import CALENDAR from "./Calendar.vue"
let SurveyMenu = Ziggy.routes['staffs.surveys.index'] ? true : false;
import SURVEY from "./Survey.vue"

const form = useForm();

const props = defineProps({
    user: Object,
    owner: Boolean,
    kpis: Object,
    kras: Object,
    tasks: Object,
    helpdesks: Object,
    leaves: Object,
    attendances: Object,
    surveys: Object,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array,
});
let SuperAdmin = props.can.includes("SuperAdmin");

</script>
<template>
    <Head title="Report Page" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Report
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link
                        :href="route('staffs.reports.index', user.id)"
                        :only="['user']"
                    >
                        Staff Report
                    </Link>
                </li>
            </ol>
        </template>
        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card">
                        <div
                            class="card-body profile-card pt-4 d-flex flex-column align-items-center"
                        >
                            <img
                                :src="user.avatarpath"
                                alt="Profile"
                                class="rounded-circle"
                            />
                            <h2>{{ user.name }} <span v-if="user.employee_code">({{ user.employee_code }})</span></h2>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <i class="bi bi-envelope"></i>
                                    {{ user.email }}
                                </li>
                                <li class="list-group-item">
                                    <i class="bi bi-building"></i>
                                    {{
                                        user.department
                                            ? user.department.title
                                            : ""
                                    }}
                                    {{
                                        user.designation
                                            ? "(" + user.designation.title + ")"
                                            : ""
                                    }}
                                </li>
                                <li class="list-group-item">
                                    <i class="bi bi-calendar-event"></i>
                                    {{ user.join_date }}
                                    <span
                                        v-html="user.nature_of_employment"
                                    ></span>
                                </li>
                                <li class="list-group-item">
                                    <i class="bi bi-clock"></i>
                                    {{
                                        user.shift_time
                                            ? user.shift_time.start_time +
                                              " - " +
                                              user.shift_time.end_time
                                            : ""
                                    }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table class="mt-3 table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Task Management</th>
                                        <th>KPIs</th>
                                        <th>Disciplinary Action</th>
                                        <th>Punctuality & Attendance</th>
                                        <th>Subordinate & Supervisor Rating</th>
                                        <th>Achievement</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Weightage (%)</td>
                                        <td>50%</td>
                                        <td>50%</td>
                                        <td>50%</td>
                                        <td>50%</td>
                                        <td>50%</td>
                                        <td>50%</td>
                                    </tr>
                                    <tr>
                                        <td>Weightage (point)</td>
                                        <td>
                                            <span class="badge bg-info"
                                                >10.5</span
                                            >
                                        </td>
                                        <td>
                                            <span class="badge bg-info">0</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">9</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info"
                                                >11</span
                                            >
                                        </td>
                                        <td>
                                            <span class="badge bg-info">0</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">0</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Average (point)</td>
                                        <td>
                                            <span class="badge bg-primary"
                                                >10.5</span
                                            >
                                        </td>
                                        <td>
                                            <span class="badge bg-primary"
                                                >0</span
                                            >
                                        </td>
                                        <td>
                                            <span class="badge bg-primary"
                                                >9</span
                                            >
                                        </td>
                                        <td>
                                            <span class="badge bg-primary"
                                                >11</span
                                            >
                                        </td>
                                        <td>
                                            <span class="badge bg-primary"
                                                >0</span
                                            >
                                        </td>
                                        <td>
                                            <span class="badge bg-primary"
                                                >0</span
                                            >
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <ReportLink
                                        :active="
                                            filters.type == 'profile' ||
                                            filters.type == null
                                        "
                                        :href="
                                            route('staffs.reports.index', [
                                                user.id,
                                                { type: 'profile' },
                                            ])
                                        "
                                        :only="['user', 'filters']"
                                        >Profile</ReportLink
                                    >
                                </li>
                                <li class="nav-item">
                                    <ReportLink
                                        :active="
                                            filters.type == 'kpis'
                                        "
                                        :href="
                                            route('staffs.reports.index', [
                                                user.id,
                                                { type: 'kpis' },
                                            ])
                                        "
                                        :only="['kpis', 'filters']"
                                        >KPI</ReportLink
                                    >
                                </li>
                                <li class="nav-item">
                                    <ReportLink
                                        :active="
                                            filters.type == 'kras'
                                        "
                                        :href="
                                            route('staffs.reports.index', [
                                                user.id,
                                                { type: 'kras' },
                                            ])
                                        "
                                        :only="['kras', 'filters']"
                                        >KRA/KPA</ReportLink
                                    >
                                </li>
                                <li class="nav-item" v-if="TaskMenu">
                                    <ReportLink
                                        :active="
                                            filters.type == 'tasks'
                                        "
                                        :href="
                                            route('staffs.reports.index', [
                                                user.id,
                                                { type: 'tasks' },
                                            ])
                                        "
                                        :only="['tasks', 'filters']"
                                        >Task</ReportLink
                                    >
                                </li>
                                <li class="nav-item" v-if="TaskMenu">
                                    <ReportLink
                                        :active="
                                            filters.type == 'helpdesks'
                                        "
                                        :href="
                                            route('staffs.reports.index', [
                                                user.id,
                                                { type: 'helpdesks' },
                                            ])
                                        "
                                        :only="['helpdesks', 'filters']"
                                        >Help Desk</ReportLink
                                    >
                                </li>
                                <li class="nav-item" v-if="LeaveMenu">
                                    <ReportLink
                                        :active="
                                            filters.type == 'leaves'
                                        "
                                        :href="
                                            route('staffs.reports.index', [
                                                user.id,
                                                { type: 'leaves' },
                                            ])
                                        "
                                        :only="['leaves', 'filters']"
                                        >Leave Request</ReportLink
                                    >
                                </li>
                                <li class="nav-item" v-if="owner || SuperAdmin && AttendanceMenu">
                                    <ReportLink
                                        :active="
                                            filters.type == 'attendances'
                                        "
                                        :href="
                                            route('staffs.reports.index', [
                                                user.id,
                                                { type: 'attendances' },
                                            ])
                                        "
                                        :only="['attendances', 'filters']"
                                        >Attendance</ReportLink
                                    >
                                </li>
                                <li class="nav-item" v-if="owner || SuperAdmin">
                                    <ReportLink
                                        :active="
                                            filters.type == 'calendar'
                                        "
                                        :href="
                                            route('staffs.reports.index', [
                                                user.id,
                                                { type: 'calendar' },
                                            ])
                                        "
                                        :only="['filters']"
                                        >Calendar</ReportLink
                                    >
                                </li>
                                <li class="nav-item" v-if="owner || SuperAdmin && SurveyMenu">
                                    <ReportLink
                                        :active="
                                            filters.type == 'surveys'
                                        "
                                        :href="
                                            route('staffs.reports.index', [
                                                user.id,
                                                { type: 'surveys' },
                                            ])
                                        "
                                        :only="['surveys', 'filters']"
                                        >Survey</ReportLink
                                    >
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div
                                class="profile"
                                v-if="
                                    filters.type == 'profile' ||
                                    filters.type == null
                                "
                            >
                                <div class="mt-3 row">
                                    <div class="col-xl-3">
                                        <div class="box">
                                            <div class="box-header">Official Information</div>
                                            <div class="box-body">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <th>Staff Type</th>
                                                            <th>{{ user.staff_type }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Supervisor</th>
                                                            <th>{{ user.supervisor ? user.supervisor.name : '' }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Weekend</th>
                                                            <th><span v-for="(wknd, windex) in user.weekend" :key="windex" class="badge bg-info">{{ wknd }}</span></th>
                                                        </tr>
                                                        <tr>
                                                            <th>Shift</th>
                                                            <th>{{ user.shift_time ? user.shift_time.title : '' }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Employment Type</th>
                                                            <th>{{ user.employment_type }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Join Date</th>
                                                            <th>{{ user.join_date }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Provision Date</th>
                                                            <th>{{ user.provision_end_date }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Status</th>
                                                            <th><span v-html="user.status_label"></span></th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="box">
                                            <div class="box-header">Personal Information</div>
                                            <div class="box-body">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <th>Citizenship</th>
                                                            <th>{{ user.detail ? user.detail.citizenship_no : '' }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Marital Status</th>
                                                            <th>{{ user.detail ? user.detail.marital_status : '' }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Blood Group</th>
                                                            <th>{{ user.detail ? user.detail.blood_group : '' }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Gender</th>
                                                            <th>{{ user.gender}}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Birthday</th>
                                                            <th>{{ user.dob}}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Phone Number</th>
                                                            <th>{{ user.address ? user.address.phone_number : ''}}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Permanent Address</th>
                                                            <th>{{ user.address ? (user.address.pdistrict ? user.address.pdistrict.title : '') : '' }} {{ user.address ? user.address.p_address : '' }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Temporary Address</th>
                                                            <th>{{ user.address ? (user.address.pdistrict ? user.address.tdistrict.title : '') : '' }} {{ user.address ? user.address.t_address : '' }}</th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="box">
                                            <div class="box-header">Document</div>
                                            <div class="box-body">
                                                <table class="table">
                                                    <tbody>
                                                        <tr v-for="(doc, dindex) in user.documents" :key="dindex">
                                                            <th>{{ doc.title }}</th>
                                                            <th><a :href="doc.document_path" target="_blank">Download</a></th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="box">
                                            <div class="box-header">Education</div>
                                            <div class="box-body">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <th>Education Level</th>
                                                            <th>{{ user.leducation ? (user.leducation.education ? user.leducation.education.title : '') : '' }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Faculty</th>
                                                            <th>{{ user.leducation ? (user.leducation.faculty ? user.leducation.faculty.title : '') : '' }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Specialization</th>
                                                            <th>{{user.leducation ? (user.leducation ? user.leducation.specialization : '') : ''}}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Institute</th>
                                                            <th>{{user.leducation ? (user.leducation ? user.leducation.institution : '') : ''}}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Year</th>
                                                            <th>{{user.leducation ? (user.leducation ? user.leducation.year : '') : ''}}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Board</th>
                                                            <th>{{user.leducation ? (user.leducation ? user.leducation.board : '') : ''}}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Marksystem</th>
                                                            <th>{{user.leducation ? (user.leducation ? user.leducation.marksystem : '') : ''}}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Mark</th>
                                                            <th>{{user.leducation ? (user.leducation ? user.leducation.mark : '') : ''}}</th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="box">
                                            <div class="box-header">Bank Information</div>
                                            <div class="box-body">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <th>Bank</th>
                                                            <th>{{ user.bank ? user.bank.bank_name :'' }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Account</th>
                                                            <th>{{ user.bank ? user.bank.account_number :'' }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>PAN number</th>
                                                            <th>{{ user.bank ? user.bank.pan_number :'' }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th>PF</th>
                                                            <th>{{ user.bank ? user.bank.pf :'' }}</th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="kpis"
                                v-if="
                                    filters.type == 'kpis'
                                "
                            >
                                <KPI :userId="user.id" :kpis="kpis" :auth="owner || SuperAdmin" />
                            </div>
                            <div
                                class="kras"
                                v-if="
                                    filters.type == 'kras'
                                "
                            >
                                <KRA :userId="user.id" :kras="kras" :auth="owner || SuperAdmin" />
                            </div>
                            <div
                                class="tasks"
                                v-if="
                                    filters.type == 'tasks' && TaskMenu
                                "
                            >
                                <TASK :userId="user.id" :tasks="tasks" :auth="owner || SuperAdmin" />
                            </div>
                            <div
                                class="helpdesks"
                                v-if="
                                    filters.type == 'helpdesks' && TaskMenu
                                "
                            >
                                <HELPDESK :userId="user.id" :helpdesks="helpdesks" :auth="owner || SuperAdmin" />
                            </div>
                            <div
                                class="leaves"
                                v-if="
                                    filters.type == 'leaves' && LeaveMenu
                                "
                            >
                                <LEAVE :userId="user.id" :leaves="leaves" :auth="owner || SuperAdmin" />
                            </div>
                            <div
                                class="attendances"
                                v-if="
                                    filters.type == 'attendances' && AttendanceMenu
                                "
                            >
                                <ATTENDANCE :userId="user.id" :attendances="attendances" :auth="owner || SuperAdmin" />
                            </div>
                            <div
                                class="calendar"
                                v-if="
                                    filters.type == 'calendar' && AttendanceMenu
                                "
                            >
                                <CALENDAR :userId="user.id" :auth="owner || SuperAdmin" />
                            </div>
                            <div
                                class="surveys"
                                v-if="
                                    filters.type == 'surveys' && SurveyMenu
                                "
                            >
                                <SURVEY :userId="user.id" :surveys="surveys" :auth="owner || SuperAdmin" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </StaffLayout>
</template>
<style scoped>
thead,
tbody {
    font-size: 13px;
}
.profile .profile-card img {
    max-width: 60px;
}
.box{border: 1px solid #ededed; margin:0px; padding:0px;}
.box-header{
    background-color: #8484b3;
    color: #fff;
    padding: 4px 5px;
}
</style>
