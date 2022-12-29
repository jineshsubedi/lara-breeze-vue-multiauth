<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import axios from "axios";
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    user : Object,
    datas : Object,
    document : Object,
})

const form = useForm({
    name: props.user.name,
    branch_id: props.user.branch_id,
    supervisor_id: props.user.supervisor_id,
    employee_code: props.user.employee_code,
    email: props.user.email,
    user_password: null,
    confirm_password: null,
    staff_type: props.user.staff_type,
    department_id: props.user.department_id,
    designation_id: props.user.designation_id,
    shift_time_id: props.user.shift_time_id,
    status: props.user.status,
    join_date: props.user.join_date,
    weekend: props.user.weekend,
    primary_location: props.user.primary_location,
    status: props.user.status,
    employment_type: props.user.employment_type,

    document: []
});

let shifts = ref([]);
let staffs = ref([]);
let departments = ref([]);
let designations = ref([]);
getStaffs()
function getStaffs()
{
    axios.post(route('getStaffsByBranch'), 
        {
            branch: form.branch_id
        }
    )
    .then(res => {
        staffs.value = ref(res.data)
        getShifts()
        getDepartments()
    }).catch(err => {
        console.log(err)
    })
}
function getShifts()
{
    axios.post(route('getShiftsByBranch'), 
        {
            branch: form.branch_id
        }
    )
    .then(res => {
        shifts.value = ref(res.data)
    }).catch(err => {
        console.log(err)
    })
}
function getDepartments()
{
    axios.post(route('getDepartmentsByBranch'), 
        {
            branch: form.branch_id
        }
    )
    .then(res => {
        departments.value = ref(res.data)
    }).catch(err => {
        console.log(err)
    })
}
getDesignations()
function getDesignations()
{
    axios.post(route('getDesignationByDepartment'), 
        {
            department: form.department_id
        }
    )
    .then(res => {
        designations.value = ref(res.data)
    }).catch(err => {
        console.log(err)
    })
}
function addMoreDocument()
{
    form.document.push({
        title: '',
        document: ''
    })
}
function removeFormDocument(index)
{
    form.document.splice(index, 1)
}
function removeDocument(id)
{
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("staffs.deleteProfileDocument", id));
    }
}
function submitProfileUpdateForm()
{
    Inertia.post(route('staffs.users.update', props.user.id), {
        _method: 'put',
        title: form.title,
        description: form.description,
        department_id: form.department_id,
        branch_id: form.branch_id,
        docfile: form.docfile,

        name: form.name,
        branch_id: form.branch_id,
        supervisor_id: form.supervisor_id,
        employee_code: form.employee_code,
        email: form.email,
        user_password: form.user_password,
        confirm_password: form.confirm_password,
        staff_type: form.staff_type,
        department_id: form.department_id,
        designation_id: form.designation_id,
        shift_time_id: form.shift_time_id,
        status: form.status,
        join_date: form.join_date,
        weekend: form.weekend,
        primary_location: form.primary_location,
        status: form.status,
        employment_type: form.employment_type,

        document: form.document
    })
}
</script>
<template>
    <Head title="Edit Staff" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Staff
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.users.index')"> Staffs </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.users.edit', user.id)"> Edit </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New Staff</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    submitProfileUpdateForm
                                "
                                enctype="multipart/form-data"
                            >
                                <div class="row">
                                    <div class="col-md-6 row">
                                        <div class="form-group mb-3">
                                            <label
                                                for="branch_id"
                                                class=""
                                                >Branch</label
                                            >
                                            <select v-model="form.branch_id" id="branch_id" class="form-control" @change="getStaffs">
                                                <option v-for="(branch, index) in datas.branches" :key="index" :value="branch.id">{{branch.name}}</option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.branch_id"
                                            >
                                                {{ form.errors.branch_id }}
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label
                                                for="employee_code"
                                                class=""
                                                >Employee Code</label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="employee_code"
                                                placeholder="employee_code"
                                                v-model="form.employee_code"
                                            />
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.employee_code"
                                            >
                                                {{ form.errors.employee_code }}
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label
                                                for="name"
                                                class=""
                                                >Name</label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="name"
                                                placeholder="name"
                                                v-model="form.name"
                                            />
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.name"
                                            >
                                                {{ form.errors.name }}
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label
                                                for="email"
                                                class=""
                                                >Email</label
                                            >
                                            <input
                                                type="email"
                                                class="form-control"
                                                id="email"
                                                placeholder="email"
                                                v-model="form.email"
                                            />
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.email"
                                            >
                                                {{ form.errors.email }}
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                                <label
                                                    for="join_date"
                                                    class=""
                                                    >Join Date</label
                                                >
                                                <input type="date" v-model="form.join_date" id="join_date" class="form-control">
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.join_date"
                                                >
                                                    {{ form.errors.join_date }}
                                                </div>
                                        </div>
                                        <div class="form-group mb-3">
                                                <label
                                                    for="status"
                                                    class=""
                                                    >Status</label
                                                >
                                                <select v-model="form.status" id="status" class="form-control">
                                                    <option v-for="(status, index) in datas.status" :key="index" :value="status.value">{{status.title}}</option>
                                                </select>
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.status"
                                                >
                                                    {{ form.errors.status }}
                                                </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label
                                                for="password"
                                                class=""
                                                >Password</label
                                            >
                                            <input
                                                type="password"
                                                class="form-control"
                                                id="password"
                                                placeholder="password"
                                                v-model="form.user_password"
                                            />
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.user_password"
                                            >
                                                {{ form.errors.user_password }}
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label
                                                for="confirm_password"
                                                class=""
                                                >Confirm Password</label
                                            >
                                            <input
                                                type="password"
                                                class="form-control"
                                                id="confirm_password"
                                                placeholder="confirm_password"
                                                v-model="form.confirm_password"
                                            />
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.confirm_password"
                                            >
                                                {{ form.errors.confirm_password }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <div class="form-group mb-3">
                                                <label
                                                    for="staff_type"
                                                    class=""
                                                    >Staff Type</label
                                                >
                                                <select v-model="form.staff_type" id="staff_type" class="form-control">
                                                    <option v-for="(staff_type, index) in datas.staff_type" :key="index" :value="staff_type.value">{{staff_type.title}}</option>
                                                </select>
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.staff_type"
                                                >
                                                    {{ form.errors.staff_type }}
                                                </div>
                                        </div>
                                        <div class="form-group mb-3">
                                                <label
                                                    for="shift_time_id"
                                                    class=""
                                                    >Shift Time</label
                                                >
                                                <select v-model="form.shift_time_id" id="shift_time_id" class="form-control">
                                                    <option v-for="(shift, index) in shifts.value" :key="index" :value="shift.id">{{shift.title}} ({{shift.start_time}} - {{shift.end_time}})</option>
                                                </select>
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.shift_time_id"
                                                >
                                                    {{ form.errors.shift_time_id }}
                                                </div>
                                        </div>
                                        <div class="form-group mb-3">
                                                <label
                                                    for="supervisor_id"
                                                    class=""
                                                    >Supervisor</label
                                                >
                                                <select v-model="form.supervisor_id" id="supervisor_id" class="form-control">
                                                    <option v-for="(staff, index) in staffs.value" :key="index" :value="staff.id">{{staff.name}}</option>
                                                </select>
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.supervisor_id"
                                                >
                                                    {{ form.errors.supervisor_id }}
                                                </div>
                                        </div>
                                        <div class="form-group mb-3">
                                                <label
                                                    for="department_id"
                                                    class=""
                                                    >Department</label
                                                >
                                                <select v-model="form.department_id" id="department_id" class="form-control" @change="getDesignations()">
                                                    <option v-for="(department, index) in departments.value" :key="index" :value="department.id">{{department.title}}</option>
                                                </select>
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.department_id"
                                                >
                                                    {{ form.errors.department_id }}
                                                </div>
                                        </div>
                                        <div class="form-group mb-3">
                                                <label
                                                    for="designation_id"
                                                    class=""
                                                    >Designation</label
                                                >
                                                <select v-model="form.designation_id" id="designation_id" class="form-control">
                                                    <option v-for="(designation, index) in designations.value" :key="index" :value="designation.id">{{designation.title}}</option>
                                                </select>
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.designation_id"
                                                >
                                                    {{ form.errors.designation_id }}
                                                </div>
                                        </div>
                                        <div class="form-group mb-3">
                                                <label
                                                    for="weekend"
                                                    class=""
                                                    >Weekend</label
                                                >
                                                <select v-model="form.weekend" id="weekend" class="form-control" multiple>
                                                    <option v-for="(weekend, index) in datas.weekend" :key="index" :value="weekend">{{weekend}}</option>
                                                </select>
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.weekend"
                                                >
                                                    {{ form.errors.weekend }}
                                                </div>
                                        </div>
                                        <div class="form-group mb-3">
                                                <label
                                                    for="employment_type"
                                                    class=""
                                                    >Employment Type</label
                                                >
                                                <select v-model="form.employment_type" id="employment_type" class="form-control">
                                                    <option v-for="(type, index) in datas.types" :key="index" :value="type">{{type}} </option>
                                                </select>
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.employment_type"
                                                >
                                                    {{ form.errors.employment_type }}
                                                </div>
                                        </div>
                                        <div class="form-group mb-3">
                                                <label
                                                    for="primary_location"
                                                    class=""
                                                    >Primary Location</label
                                                >
                                                <input type="text" v-model="form.primary_location" id="primary_location" class="form-control">
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.primary_location"
                                                >
                                                    {{ form.errors.primary_location }}
                                                </div>
                                        </div>
                                    </div>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Document</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(doc, index) in document" :key="index">
                                                <td>{{doc.title}}</td>
                                                <td><Link :href="doc.document_path" target="_blank">Document</Link></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" @click="removeDocument(index)"><i class="bi bi-trash"></i></button>
                                                </td>
                                            </tr>
                                            <tr v-for="(fdoc, findex) in form.document" :key="findex">
                                                <td>
                                                    <input type="text" v-model="fdoc.title" class="form-control">
                                                    <div class="text-red-400 text-sm" v-if="form.errors.document">
                                                        {{ form.errors.document.findex.title }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" @input="fdoc.document = $event.target.files[0]" />
                                                    <div class="text-red-400 text-sm" v-if="form.errors.document">
                                                        {{ form.errors.document.findex.document }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" @click="removeFormDocument(findex)"><i class="bi bi-trash"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" class="text-right">
                                                    <button type="button" class="btn btn-sm btn-outline-info" @click="addMoreDocument"><i class="bi bi-plus"></i> Add More</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button
                                            type="submit"
                                            class="btn btn-outline-primary btn-sm"
                                        >
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </StaffLayout>
</template>
