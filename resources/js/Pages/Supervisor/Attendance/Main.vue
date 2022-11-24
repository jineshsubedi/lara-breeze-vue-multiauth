<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import axios from "axios";
import MapModal from "@/Layouts/Common/MapModal.vue";
import CenterModal1 from "@/Components/CenterModal.vue";
import CenterModal2 from "@/Components/CenterModal.vue";

const props = defineProps({
    attendances: Object,
    staffs: Object,
    astatus: Object,
    excelFile: String,
    filters: Object,
    dateType: Number,
    can: Object,
});
const approveForm = useForm({
    selected: [],
});
const exportForm = useForm({
    staff: "all",
    year: null,
    month: null,
});
const generateForm = useForm({
    staff: null,
    year: null,
    month: null,
    start_day: null,
    end_day: null,
    in_time: null,
    out_time: null,
    remarks: null,
    manual: 1,
    type: props.dateType,
});
const form2 = useForm({
    position: { lat: 51.093048, lng: 6.84212 },
});
function showModal(path, location) {
    var data = location.split(",");
    form2.position.lat = data[0];
    form2.position.lng = data[1];

    $("#" + path).modal("show");
}
let staff = ref(props.filters.staff);
let from = ref(props.filters.from);
let to = ref(props.filters.to);
let status = ref(props.filters.status);
let download_excel = ref(false);
function loadFilter() {
    Inertia.get(
        route("supervisor.attendanceHandler.index"),
        {
            staff: staff.value,
            from: from.value,
            to: to.value,
            status: status.value,
        },
        {
            preserveState: true,
            replace: true,
        }
    );
}
function ExportAttendanceModal() {
    $("#ExportAttendanceModal").modal("show");
}
function generateAttendanceModal() {
    $("#generateAttendanceModal").modal("show");
}
function exportAttendance() {
    exportForm.post(route("supervisor.attendanceHandler.export"), {
        preserveScroll: true,
        onSuccess: () => {
            download_excel.value = true;
            $("#ExportAttendanceModal").modal("hide");
        },
    });
}
function generateAttendance() {
    generateForm.post(route("supervisor.attendanceHandler.generate"), {
        preserveScroll: true,
        onSuccess: () => {
            // generateForm.reset();
            $("#generateAttendanceModal").modal("hide");
        },
    });
}

let years = ref([]);
let months = ref([]);
let days = ref([]);
loadYear();
function loadYear() {
    axios
        .get(route("getYear"), {
            params: {
                type: props.dateType,
            },
        })
        .then((res) => {
            years.value = ref(res.data);
        })
        .catch((err) => {
            console.log(err);
        });
}
function loadMonth() {
    axios
        .get(route("getMonth"), {
            params: {
                type: props.dateType,
                year: generateForm.year,
            },
        })
        .then((res) => {
            months.value = ref(res.data);
        })
        .catch((err) => {
            console.log(err);
        });
}
function loadDays() {
    axios
        .get(route("getDays"), {
            params: {
                type: props.dateType,
                year: generateForm.year,
                month: generateForm.month,
            },
        })
        .then((res) => {
            days.value = ref(res.data);
        })
        .catch((err) => {
            console.log(err);
        });
}

function approveAttendance() {
    approveForm.post(route("supervisor.attendanceHandler.approve"), {
        preserveScroll: true,
        onSuccess: () => {
            // approveForm.reset();
        },
    });
}
let isCheckAllViewAccess = ref(false);
function selectAllAttendance() {
    isCheckAllViewAccess.value = !isCheckAllViewAccess.value;
    approveForm.selected.splice(0);
    if (isCheckAllViewAccess.value) {
        for (var key in props.attendances.data) {
            approveForm.selected.push(props.attendances.data[key].id);
        }
    }
}
</script>
<template>
    <Head title="Attendance Handler" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Attendance Handler
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('supervisor.attendanceHandler.index')">
                        Attendance Handler
                    </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Attendance Handler</h5>
                            <div class="row mb-5">
                                <div class="col-md-7 row">
                                    <div class="col-md-4">
                                        <label for="filter_from"
                                            >Date From</label
                                        >
                                        <input
                                            type="date"
                                            v-model="from"
                                            class="form-control"
                                            id="filter_from"
                                            @change="loadFilter"
                                        />
                                    </div>
                                    <div class="col-md-4">
                                        <label for="filter_to">Date To</label>
                                        <input
                                            type="date"
                                            v-model="to"
                                            class="form-control"
                                            id="filter_to"
                                            @change="loadFilter"
                                        />
                                    </div>
                                    <div class="col-md-4">
                                        <label for="filter_staff">Staffs</label>
                                        <select
                                            v-model="staff"
                                            class="form-control"
                                            id="filter_staff"
                                            @change="loadFilter"
                                        >
                                            <option value="">
                                                Select Staff
                                            </option>
                                            <option
                                                v-for="(staff, index) in staffs"
                                                :key="index"
                                                :value="staff.id"
                                            >
                                                {{ staff.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5 row">
                                    <div class="col-md-6">
                                        <label for="filter_status"
                                            >Status</label
                                        >
                                        <select
                                            v-model="status"
                                            class="form-control"
                                            id="filter_status"
                                            @change="loadFilter"
                                        >
                                            <option value="">
                                                Select Status
                                            </option>
                                            <option
                                                v-for="(
                                                    status, index
                                                ) in astatus"
                                                :key="index"
                                                :value="status.value"
                                            >
                                                {{ status.title }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Attendance</label><br />
                                        <div class="btn-group">
                                            <a 
                                                :href="excelFile" 
                                                target="_blank" 
                                                v-if="download_excel" 
                                                class="btn btn-sm btn-outline-info" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-title="Download Attendances"
                                            >
                                                <i class="bi bi-download"></i> 
                                            </a>
                                            <button
                                                class="btn btn-sm btn-outline-info"
                                                type="button"
                                                @click="ExportAttendanceModal()"
                                                data-bs-toggle="tooltip" 
                                                data-bs-title="Export Attendances"
                                            >
                                                <i class="bi bi-archive"></i>
                                            </button>
                                            
                                            <button
                                                class="btn btn-sm btn-outline-primary"
                                                type="button"
                                                @click="
                                                    generateAttendanceModal()
                                                "
                                                data-bs-toggle="tooltip" 
                                                data-bs-title="Generate Attendances"
                                            >
                                                <i class="bi bi-arrow-repeat"></i>
                                            </button>
                                            <button
                                                class="btn btn-sm btn-outline-success"
                                                type="button"
                                                @click="approveAttendance()"
                                                data-bs-toggle="tooltip" 
                                                data-bs-title="Approve Attendances"
                                            >
                                                <i class="bi bi-check2-all"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">
                                                <input
                                                    type="checkbox"
                                                    @change="
                                                        selectAllAttendance
                                                    "
                                                />
                                                Select All
                                            </th>
                                            <th scope="col">Staff</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Duty Start</th>
                                            <th scope="col">Lunch Start</th>
                                            <th scope="col">Lunch End</th>
                                            <th scope="col">Duty End</th>
                                            <th scope="col">Duration</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(
                                                attendance, index
                                            ) in attendances.data"
                                            :key="attendance.id"
                                        >
                                            <td scope="row">
                                                <input
                                                    type="checkbox"
                                                    class="myAttendanceCheckbox"
                                                    v-model="
                                                        approveForm.selected
                                                    "
                                                    :value="attendance.id"
                                                    v-if="
                                                        attendance.approve !=
                                                        '1'
                                                    "
                                                />
                                                <span v-else>{{
                                                    ++index
                                                }}</span>
                                            </td>
                                            <td scope="row">
                                                {{
                                                    attendance.user
                                                        ? attendance.user.name
                                                        : ""
                                                }}
                                            </td>
                                            <td scope="row">
                                                {{ attendance.attendance_date }}
                                            </td>
                                            <td scope="row">
                                                <div
                                                    v-if="
                                                        attendance.in_time !=
                                                        null
                                                    "
                                                >
                                                    <button
                                                        :class="
                                                            attendance.in_time_class
                                                        "
                                                        @click="
                                                            showModal(
                                                                'duty-In' +
                                                                    index,
                                                                attendance.in_location
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="bi bi-geo-alt"
                                                        ></i>
                                                        {{
                                                            attendance.in_time
                                                        }}
                                                        {{
                                                            attendance.in_time_distance
                                                        }}
                                                    </button>
                                                    <MapModal
                                                        :path="
                                                            'duty-In' + index
                                                        "
                                                        :title="
                                                            'Duty Start At: ' +
                                                            attendance.in_time
                                                        "
                                                        :location="
                                                            attendance.in_location
                                                        "
                                                        :key="'duty-In' + index"
                                                    />
                                                </div>
                                            </td>
                                            <td scope="row">
                                                <div
                                                    v-if="
                                                        attendance.lunch_start !=
                                                        null
                                                    "
                                                >
                                                    <button
                                                        :class="
                                                            attendance.lunch_start_class
                                                        "
                                                        @click="
                                                            showModal(
                                                                'lunch-In' +
                                                                    index,
                                                                attendance.lunch_start_location
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="bi bi-geo-alt"
                                                        ></i>
                                                        {{
                                                            attendance.lunch_start
                                                        }}
                                                        {{
                                                            attendance.lunch_start_distance
                                                        }}
                                                    </button>
                                                    <MapModal
                                                        :path="
                                                            'lunch-In' + index
                                                        "
                                                        :title="
                                                            'Lunch Start At: ' +
                                                            attendance.in_time
                                                        "
                                                        :location="
                                                            attendance.in_location
                                                        "
                                                        :key="
                                                            'Lunch-In' + index
                                                        "
                                                    />
                                                </div>
                                            </td>
                                            <td scope="row">
                                                <div
                                                    v-if="
                                                        attendance.lunch_end !=
                                                        null
                                                    "
                                                >
                                                    <button
                                                        :class="
                                                            attendance.lunch_end_class
                                                        "
                                                        @click="
                                                            showModal(
                                                                'lunch-Out' +
                                                                    index,
                                                                attendance.lunch_end_location
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="bi bi-geo-alt"
                                                        ></i>
                                                        {{
                                                            attendance.lunch_end
                                                        }}
                                                        {{
                                                            attendance.lunch_end_distance
                                                        }}
                                                    </button>
                                                    <MapModal
                                                        :path="
                                                            'lunch-Out' + index
                                                        "
                                                        :title="
                                                            'Lunch End At: ' +
                                                            attendance.lunch_end
                                                        "
                                                        :location="
                                                            attendance.lunch_end_location
                                                        "
                                                        :key="
                                                            'Lunch-Out' + index
                                                        "
                                                    />
                                                </div>
                                            </td>
                                            <td scope="row">
                                                <div
                                                    v-if="
                                                        attendance.out_time !=
                                                        null
                                                    "
                                                >
                                                    <button
                                                        :class="
                                                            attendance.out_time_class
                                                        "
                                                        @click="
                                                            showModal(
                                                                'Duty-Out' +
                                                                    index,
                                                                attendance.out_location
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="bi bi-geo-alt"
                                                        ></i>
                                                        {{
                                                            attendance.out_time
                                                        }}
                                                        {{
                                                            attendance.out_time_distance
                                                        }}
                                                    </button>
                                                    <MapModal
                                                        :path="
                                                            'Duty-Out' + index
                                                        "
                                                        :title="
                                                            'Duty End At: ' +
                                                            attendance.out_time
                                                        "
                                                        :location="
                                                            attendance.out_location
                                                        "
                                                        :key="'Duty-In' + index"
                                                    />
                                                </div>
                                            </td>
                                            <td scope="row">
                                                {{
                                                    attendance.attendance_duration
                                                }}
                                            </td>
                                            <td scope="row">
                                                <p
                                                    v-html="
                                                        attendance.approve_title
                                                    "
                                                ></p>
                                            </td>
                                            <td scope="row">
                                                <div class="btn-group">
                                                    <Link
                                                        :href="
                                                            route(
                                                                'supervisor.attendances.show',
                                                                attendance.id
                                                            )
                                                        "
                                                        class="btn btn-sm btn-outline-info"
                                                    >
                                                        <i
                                                            class="bi bi-eye"
                                                        ></i>
                                                    </Link>
                                                    <Link
                                                        :href="
                                                            route(
                                                                'supervisor.attendances.approve',
                                                                attendance.id
                                                            )
                                                        "
                                                        method="patch"
                                                        as="button"
                                                        type="button"
                                                        class="btn btn-sm btn-outline-success"
                                                        v-if="
                                                            attendance.approve !=
                                                            '1'
                                                        "
                                                    >
                                                        <i
                                                            class="bi bi-check"
                                                        ></i>
                                                    </Link>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="8">
                                                <Pagination
                                                    class="mt-6"
                                                    :links="attendances.links"
                                                />
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <CenterModal2
                                :id="'generateAttendanceModal'"
                                title="Generate Attendance Model"
                            >
                                <form
                                    class="form-horizontal"
                                    @submit.prevent="generateAttendance()"
                                >
                                    <div class="form-group row mb-3">
                                        <label
                                            for="staff"
                                            class="col-sm-4 col-form-label"
                                            >Staff</label
                                        >
                                        <div class="col-sm-8">
                                            <select
                                                v-model="generateForm.staff"
                                                id="staff"
                                                class="form-control"
                                            >
                                                <option value="">
                                                    Select Staff
                                                </option>
                                                <option
                                                    v-for="(
                                                        staff, index
                                                    ) in staffs"
                                                    :key="index"
                                                    :value="staff.id"
                                                >
                                                    {{ staff.name }}
                                                </option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="generateForm.errors.staff"
                                            >
                                                {{ generateForm.errors.staff }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="year"
                                            class="col-sm-4 col-form-label"
                                            >Year</label
                                        >
                                        <div class="col-sm-8">
                                            <select
                                                v-model="generateForm.year"
                                                id="year"
                                                class="form-control"
                                                @change="loadMonth"
                                            >
                                                <option value="">
                                                    Select Year
                                                </option>
                                                <option
                                                    v-for="(
                                                        year, index
                                                    ) in years.value"
                                                    :key="index"
                                                    :value="year"
                                                >
                                                    {{ year }}
                                                </option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="generateForm.errors.year"
                                            >
                                                {{ generateForm.errors.year }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="month"
                                            class="col-sm-4 col-form-label"
                                            >Month</label
                                        >
                                        <div class="col-sm-8">
                                            <select
                                                v-model="generateForm.month"
                                                id="month"
                                                class="form-control"
                                                @change="loadDays"
                                            >
                                                <option value="">
                                                    Select Month
                                                </option>
                                                <option
                                                    v-for="(
                                                        month, index
                                                    ) in months.value"
                                                    :key="index"
                                                    :value="month.value"
                                                >
                                                    {{ month.title }}
                                                </option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="generateForm.errors.month"
                                            >
                                                {{ generateForm.errors.month }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="start_day"
                                            class="col-sm-4 col-form-label"
                                            >Start Day</label
                                        >
                                        <div class="col-sm-8">
                                            <select
                                                v-model="generateForm.start_day"
                                                id="start_day"
                                                class="form-control"
                                            >
                                                <option value="">
                                                    Select Day
                                                </option>
                                                <option
                                                    v-for="(
                                                        day, index
                                                    ) in days.value"
                                                    :key="index"
                                                    :value="day"
                                                >
                                                    {{ day }}
                                                </option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="
                                                    generateForm.errors
                                                        .start_day
                                                "
                                            >
                                                {{
                                                    generateForm.errors
                                                        .start_day
                                                }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="end_day"
                                            class="col-sm-4 col-form-label"
                                            >End Day</label
                                        >
                                        <div class="col-sm-8">
                                            <select
                                                v-model="generateForm.end_day"
                                                id="end_day"
                                                class="form-control"
                                            >
                                                <option value="">
                                                    Select Day
                                                </option>
                                                <option
                                                    v-for="(
                                                        day, index
                                                    ) in days.value"
                                                    :key="index"
                                                    :value="day"
                                                >
                                                    {{ day }}
                                                </option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="
                                                    generateForm.errors.end_day
                                                "
                                            >
                                                {{
                                                    generateForm.errors.end_day
                                                }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="in_time"
                                            class="col-sm-4 col-form-label"
                                            >Clock In Time</label
                                        >
                                        <div class="col-sm-8">
                                            <input
                                                type="time"
                                                v-model="generateForm.in_time"
                                                id="in_time"
                                                class="form-control"
                                            />
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="
                                                    generateForm.errors.in_time
                                                "
                                            >
                                                {{
                                                    generateForm.errors.in_time
                                                }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="out_time"
                                            class="col-sm-4 col-form-label"
                                            >Clock Out Time</label
                                        >
                                        <div class="col-sm-8">
                                            <input
                                                type="time"
                                                v-model="generateForm.out_time"
                                                id="out_time"
                                                class="form-control"
                                            />
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="
                                                    generateForm.errors.out_time
                                                "
                                            >
                                                {{
                                                    generateForm.errors.out_time
                                                }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="remarks"
                                            class="col-sm-4 col-form-label"
                                            >Remarks</label
                                        >
                                        <div class="col-sm-8">
                                            <textarea
                                                v-model="generateForm.remarks"
                                                id="remarks"
                                                class="form-control"
                                                rows="2"
                                            ></textarea>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="
                                                    generateForm.errors.remarks
                                                "
                                            >
                                                {{
                                                    generateForm.errors.remarks
                                                }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="offset-sm-4 col-sm-8">
                                        <button
                                            type="submit"
                                            class="btn btn-outline-primary btn-sm"
                                        >
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </CenterModal2>
                            <CenterModal1
                                :id="'ExportAttendanceModal'"
                                title="Export Attendance Model"
                            >
                                <form
                                    class="form-horizontal"
                                    @submit.prevent="exportAttendance()"
                                >
                                    <div class="form-group row mb-3">
                                        <label
                                            for="staff"
                                            class="col-sm-4 col-form-label"
                                            >Staff</label
                                        >
                                        <div class="col-sm-8">
                                            <select
                                                v-model="exportForm.staff"
                                                id="staff"
                                                class="form-control"
                                            >
                                                <option value="all">ALL</option>
                                                <option
                                                    v-for="(
                                                        staff, index
                                                    ) in staffs"
                                                    :key="index"
                                                    :value="staff.id"
                                                >
                                                    {{ staff.name }}
                                                </option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="exportForm.errors.staff"
                                            >
                                                {{ exportForm.errors.staff }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="year"
                                            class="col-sm-4 col-form-label"
                                            >Year</label
                                        >
                                        <div class="col-sm-8">
                                            <select
                                                v-model="exportForm.year"
                                                id="year"
                                                class="form-control"
                                                @change="loadMonth"
                                            >
                                                <option value="">
                                                    Select Year
                                                </option>
                                                <option
                                                    v-for="(
                                                        year, index
                                                    ) in years.value"
                                                    :key="index"
                                                    :value="year"
                                                >
                                                    {{ year }}
                                                </option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="exportForm.errors.year"
                                            >
                                                {{ exportForm.errors.year }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="month"
                                            class="col-sm-4 col-form-label"
                                            >Month</label
                                        >
                                        <div class="col-sm-8">
                                            <select
                                                v-model="exportForm.month"
                                                id="month"
                                                class="form-control"
                                            >
                                                <option value="">
                                                    Select Month
                                                </option>
                                                <option
                                                    v-for="(
                                                        month, index
                                                    ) in months.value"
                                                    :key="index"
                                                    :value="month.value"
                                                >
                                                    {{ month.title }}
                                                </option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="exportForm.errors.month"
                                            >
                                                {{ exportForm.errors.month }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="offset-sm-2 col-sm-10">
                                        <button
                                            type="submit"
                                            class="btn btn-outline-primary btn-sm"
                                        >
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </CenterModal1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </SupervisorLayout>
</template>
