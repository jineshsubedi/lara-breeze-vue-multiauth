<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import axios from "axios";
import { ref } from "vue";

const props = defineProps({
    onboardstaff: Object,
    datas: Object
})


const form = useForm({
    name: props.onboardstaff.name,
    email: props.onboardstaff.email,
    department_id: props.onboardstaff.department_id,
    designation_id: props.onboardstaff.designation_id,
    supervisor_id: props.onboardstaff.supervisor_id,
    staff_type: props.onboardstaff.staff_type,
    nature_of_job: props.onboardstaff.nature_of_job,
    nature_of_employment: props.onboardstaff.nature_of_employment,
    trail_period: props.onboardstaff.trail_period,
    trail_start_date: props.onboardstaff.trail_start_date,
    no_of_days: props.onboardstaff.no_of_days,
    joining_date: props.onboardstaff.joining_date,
    cvFile: null,
    offer_letter: props.onboardstaff.offer_letter,
    letter_accept_date: props.onboardstaff.letter_accept_date,
    level: props.onboardstaff.level,
    salary: props.onboardstaff.salary,
});
let designations = ref([]);
getDesignations();
function getDesignations()
{
    axios.post(route('getDesignationByDepartment'), 
        {
            department: form.department_id
        }
    )
    .then(res => {
        designations.value = res.data
    }).catch(err => {
        console.log(err)
    })
}
function submitUpdateForm()
{
    Inertia.post(route('admin.onboardings.update', props.onboardstaff.id), {
        _method: 'put',
        name: form.name,
        email: form.email,
        department_id: form.department_id,
        designation_id: form.designation_id,
        supervisor_id: form.supervisor_id,
        staff_type: form.staff_type,
        nature_of_job: form.nature_of_job,
        nature_of_employment: form.nature_of_employment,
        trail_period: form.trail_period,
        trail_start_date: form.trail_start_date,
        no_of_days: form.no_of_days,
        joining_date: form.joining_date,
        cvFile: form.cvFile,
        offer_letter: form.offer_letter,
        letter_accept_date: form.letter_accept_date,
        level: form.level,
        salary: form.salary,
    })
}

</script>
<template>
    <Head title="OnBoardStaff Create" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                OnBoardStaff Create
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.onboardings.index')"> OnBoardStaff </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.onboardings.edit', onboardstaff.id)"> Edit </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Edit OnBoardStaff</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    submitUpdateForm()
                                "
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="name"
                                        class="col-sm-2 col-form-label"
                                        >Name</label
                                    >
                                    <div class="col-sm-10">
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
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="email"
                                        class="col-sm-2 col-form-label"
                                        >Email</label
                                    >
                                    <div class="col-sm-10">
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
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="department_id"
                                        class="col-sm-2 col-form-label"
                                        >Department</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.department_id" class="form-control" id="department_id" @change="getDesignations()">
                                           <option v-for="(department, dindex) in datas.departments" :key="dindex" :value="department.id">{{department.title}}</option> 
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.department_id"
                                        >
                                            {{ form.errors.department_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="designation_id"
                                        class="col-sm-2 col-form-label"
                                        >Designation</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.designation_id" class="form-control" id="designation_id">
                                           <option v-for="(designation, deindex) in designations" :key="deindex" :value="designation.id">{{designation.title}}</option> 
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.designation_id"
                                        >
                                            {{ form.errors.designation_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="supervisor_id"
                                        class="col-sm-2 col-form-label"
                                        >Supervisor</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.supervisor_id" class="form-control" id="supervisor_id">
                                           <option v-for="(user, dindex) in datas.users" :key="dindex" :value="user.id">{{user.name}}</option> 
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.supervisor_id"
                                        >
                                            {{ form.errors.supervisor_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="staff_type"
                                        class="col-sm-2 col-form-label"
                                        >Staff Type</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.staff_type" class="form-control" id="staff_type">
                                           <option v-for="(stype, stindex) in datas.staff_type" :key="stindex" :value="stype.value">{{stype.title}}</option> 
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.staff_type"
                                        >
                                            {{ form.errors.staff_type }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="nature_of_job"
                                        class="col-sm-2 col-form-label"
                                        >Nature of Job</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.nature_of_job" class="form-control" id="nature_of_job">
                                           <option v-for="(nature, nindex) in datas.nature" :key="nindex" :value="nature">{{nature}}</option> 
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.nature_of_job"
                                        >
                                            {{ form.errors.nature_of_job }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="nature_of_employment"
                                        class="col-sm-2 col-form-label"
                                        >Nature of Employment</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.nature_of_employment" class="form-control" id="nature_of_employment">
                                           <option v-for="(employment, eindex) in datas.employment" :key="eindex" :value="employment">{{employment}}</option> 
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.nature_of_employment"
                                        >
                                            {{ form.errors.nature_of_employment }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="trail_period"
                                        class="col-sm-2 col-form-label"
                                        >Trail Period</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.trail_period" class="form-control" id="trail_period">
                                           <option v-for="(trail, tindex) in datas.trail" :key="tindex" :value="trail.value">{{trail.title}}</option> 
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.trail_period"
                                        >
                                            {{ form.errors.trail_period }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3" v-if="form.trail_period == 1">
                                    <label
                                        for="no_of_days"
                                        class="col-sm-2 col-form-label"
                                        >No Of Days</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="no_of_days"
                                            placeholder="no_of_days"
                                            v-model="form.no_of_days"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.no_of_days"
                                        >
                                            {{ form.errors.no_of_days }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3" v-if="form.trail_period == 1">
                                    <label
                                        for="trail_start_date"
                                        class="col-sm-2 col-form-label"
                                        >Trail Start Date</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="trail_start_date"
                                            placeholder="trail_start_date"
                                            v-model="form.trail_start_date"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.trail_start_date"
                                        >
                                            {{ form.errors.trail_start_date }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3" v-if="form.trail_period == 0">
                                    <label
                                        for="joining_date"
                                        class="col-sm-2 col-form-label"
                                        >Joining Date</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="joining_date"
                                            placeholder="joining_date"
                                            v-model="form.joining_date"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.joining_date"
                                        >
                                            {{ form.errors.joining_date }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="cvFile"
                                        class="col-sm-2 col-form-label"
                                        >Upload CV</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="file"
                                            class="form-control"
                                            id="cvFile"
                                            placeholder="cvFile"
                                            @input="form.cvFile = $event.target.files[0]"
                                            accept=".pdf,.docx,.doc"
                                        />
                                        <a v-if="onboardstaff.cv != ''" :href="onboardstaff.cv" target="_blank">OPEN</a>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.cvFile"
                                        >
                                            {{ form.errors.cvFile }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="offer_letter"
                                        class="col-sm-2 col-form-label"
                                        >Letter Type</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.offer_letter" class="form-control" id="offer_letter">
                                           <option v-for="(letter, lindex) in datas.letters" :key="lindex" :value="letter.id">{{letter.title}}</option> 
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.offer_letter"
                                        >
                                            {{ form.errors.offer_letter }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="letter_accept_date"
                                        class="col-sm-2 col-form-label"
                                        >Offer Letter Accept Date</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="letter_accept_date"
                                            placeholder="letter_accept_date"
                                            v-model="form.letter_accept_date"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.letter_accept_date"
                                        >
                                            {{ form.errors.letter_accept_date }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="level"
                                        class="col-sm-2 col-form-label"
                                        >Level</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="level"
                                            placeholder="level"
                                            v-model="form.level"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.level"
                                        >
                                            {{ form.errors.level }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="salary"
                                        class="col-sm-2 col-form-label"
                                        >Gross Salary</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="number"
                                            any="2"
                                            class="form-control"
                                            id="salary"
                                            placeholder="salary"
                                            v-model="form.salary"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.salary"
                                        >
                                            {{ form.errors.salary }}
                                        </div>
                                    </div>
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
    </AdminLayout>
</template>
