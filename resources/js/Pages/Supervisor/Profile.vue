<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm  } from "@inertiajs/inertia-vue3";
import moment from 'moment';
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import axios from "axios";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    'user' : Object,
    'datas' : Object,
    'districts' : Object,
    'detail' : Object,
    'address' : Object,
    'bank' : Object,
    'document' : Object,
    'notification': Object,
    'educated': Object
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: null,
    confirm_password: null,

    father_name: props.user.father_name,
    gender: props.user.gender,
    dob: props.user.dob,

    marital_status: props.detail.marital_status,
    citizenship_no: props.detail.citizenship_no,
    blood_group: props.detail.blood_group,

    phone_number: props.address.phone_number,
    pdistrict_id: props.address.pdistrict_id,
    tdistrict_id: props.address.tdistrict_id,
    p_address: props.address.p_address,
    t_address: props.address.t_address,
    emergency_number: props.address.emergency_number,
    primary_location: props.address.primary_location,
    contact_person: props.address.contact_person,
    contact_person_number: props.address.contact_person_number,
    home_location: props.address.home_location,
    location: {
        lat: 26.481724,
        lng: 87.283524
    },

    account_number: props.bank.account_number,
    bank_name: props.bank.bank_name,
    pan_number: props.bank.pan_number, 

    education_level_id: props.educated.education_level_id, 
    faculty_id: props.educated.faculty_id, 
    specialization: props.educated.specialization, 
    institution: props.educated.institution, 
    year: props.educated.year, 
    board: props.educated.board, 
    marksystem: props.educated.marksystem, 
    mark: props.educated.mark, 

    document: []

})
const avatarForm = useForm({
    avatar: ''
})

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
        form.delete(route("supervisor.deleteProfileDocument", id));
    }
}
function submitProfileUpdateForm()
{
    form.post(route('supervisor.updateProfile'));
}
$(function() {
    var x = document.getElementById("demo");
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.innerHTML = '<div class="alert alert-danger">Geolocation is not supported by this browser.</div>';
    }
});

function showPosition(position) {
    if(form.home_location)
    {
        var data = form.home_location.split(',');
        form.location = {
            lat: parseFloat(data[0]),
            lng: parseFloat(data[1])
        }
    }else{
        form.location = {
            lat: parseFloat(position.coords.latitude),
            lng: parseFloat(position.coords.longitude)
        }
    }
}

function mapLocation(location)
{
    form.home_location = location.latLng.lat()+','+location.latLng.lng()
}
function toUpperCase(value)
{
    return value.toUpperCase();
}
function humanTime(value)
{
    return moment(value).fromNow();
}
function markAsRead(id = '', url = '')
{
    axios.post(route('markNotification'), 
        {
            id: id
        }
    )
    .then(res => {
        Inertia.visit(url, {
            method: 'get'
        })
    }).catch(err => {
        console.log(err)
    })
}

let faculties = ref([]);
getFacultyByEducationId()
function getFacultyByEducationId()
{
    axios
        .post(route("getFacultyByEducationId"), {
            education: form.education_level_id
        })
        .then((res) => {
            faculties.value = res.data;
        })
        .catch((err) => {
            console.log(err);
        });
}
</script>
<template>
    <Head title="Profile" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profile
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')">
                        Home
                    </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('supervisor.profile')">
                        User Profile
                    </Link>
                </li>
            </ol>
        </template>
        
        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card">
                        <form @submit.prevent="avatarForm.post(route('supervisor.updateAvatar'))" enctype="multipart/form-data" >
                            <input type="file" @input="avatarForm.avatar = $event.target.files[0]" @change="$refs.profileUpdateForm.click()" ref="fileInput" style="display:none">
                            <button type="submit" ref="profileUpdateForm" style="display:none">Submit</button>
                        </form>
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            <div @click="$refs.fileInput.click()" class="profile-imageUploader"><i class="bi bi-camera"></i></div>
                            <img :src="user.avatarpath" alt="Profile" class="rounded-circle">

                            <h2>{{user.name}}</h2>
                            <h3>Designation</h3>
                            <p>{{user.email}}</p>
                            <!-- <div class="social-links mt-2">
                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                        </div> -->
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs nav-tabs-bordered">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Notification</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Basic Information</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#contact">Contact Information</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Documents</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#education">Qualification/Education</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#bank">Bank Information</button>
                                </li>
                                <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                                </li>
                            </ul>
                        </div>
                        <form class="form-horizontal" @submit.prevent="submitProfileUpdateForm" enctype="multipart/form-data">
                        <div class="card-body pt-3">
                            <div class="tab-content pt-2">
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <h5 class="card-title">Notification</h5>
                                    <div v-for="(notify,index) in notification.data"  @click="markAsRead(notify.id, notify.data.url)">
                                        <div class="alert border-success alert-dismissible fade show">
                                            <i :class="notify.data.icon"></i>
                                            {{notify.data.title}}
                                            <p v-html="notify.data.message"></p>   
                                            <button type="button" class="btn-close text-primary"><i class="bi bi-eye"></i></button>
                                        </div>
                                    </div>
                                    <Pagination class="mt-6" :links="notification.links" :only="['notification']" preseveState="true" />
                                </div>
                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input v-model="form.name" type="text" class="form-control" id="fullName">
                                            <div class="text-red-400 text-sm" v-if="form.errors.name">
                                                {{ form.errors.name }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input v-model="form.email" type="email" class="form-control" id="email">
                                            <div class="text-red-400 text-sm" v-if="form.errors.email">
                                                {{ form.errors.email }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="phone_number" class="col-md-4 col-lg-3 col-form-label">Phone Number</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" v-model="form.phone_number" class="form-control" id="phone_number">
                                            <div class="text-red-400 text-sm" v-if="form.errors.phone_number">
                                                {{ form.errors.phone_number }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="father_name" class="col-md-4 col-lg-3  col-form-label">Father Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input  type="father_name" v-model="form.father_name" class="form-control" id="father_name">
                                            <div class="text-red-400 text-sm" v-if="form.errors.father_name">
                                                {{ form.errors.father_name }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="gender" class="col-md-4 col-lg-3  col-form-label">Gender</label>
                                        <div class="col-md-8 col-lg-9">
                                            <select id="gender" class="form-control" v-model="form.gender">
                                                <option v-for="(gender, indexG) in datas.genders" :key="indexG" :value="gender" >{{gender}}</option>
                                            </select>
                                            <div class="text-red-400 text-sm" v-if="form.errors.gender">
                                                {{ form.errors.gender }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="marital_status" class="col-md-4 col-lg-3  col-form-label">Marital Status</label>
                                        <div class="col-md-8 col-lg-9">
                                            <select id="marital_status" class="form-control" v-model="form.marital_status">
                                                <option v-for="(mstatus, indexG) in datas.marital_status" :key="indexG" :value="mstatus" >{{mstatus}}</option>
                                            </select>
                                            <div class="text-red-400 text-sm" v-if="form.errors.marital_status">
                                                {{ form.errors.marital_status }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="dob" class="col-md-4 col-lg-3 col-form-label">Date Of Birth</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="date" class="form-control" v-model="form.dob" id="dob">
                                            <div class="text-red-400 text-sm" v-if="form.errors.dob">
                                                {{ form.errors.dob }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="citizenship_no" class="col-md-4 col-lg-3 col-form-label">Citizenship</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control" v-model="form.citizenship_no" id="citizenship_no">
                                            <div class="text-red-400 text-sm" v-if="form.errors.citizenship_no">
                                                {{ form.errors.citizenship_no }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="blood_group" class="col-md-4 col-lg-3 col-form-label">Blood Group</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control" v-model="form.blood_group" id="blood_group">
                                            <div class="text-red-400 text-sm" v-if="form.errors.blood_group">
                                                {{ form.errors.blood_group }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade pt-3" id="contact">
                                    <div class="row mb-3">
                                        <label for="pdistrict_id" class="col-md-4 col-lg-3 col-form-label">Permanent District</label>
                                        <div class="col-md-8 col-lg-9">
                                            <select v-model="form.pdistrict_id" class="form-control">
                                                <option v-for="(district, index) in districts" :key="index" :value="district.id">{{district.title}}</option>
                                            </select>
                                            <div class="text-red-400 text-sm" v-if="form.errors.pdistrict_id">
                                                {{ form.errors.pdistrict_id }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="tdistrict_id" class="col-md-4 col-lg-3 col-form-label">Permanent District</label>
                                        <div class="col-md-8 col-lg-9">
                                            <select v-model="form.tdistrict_id" class="form-control">
                                                <option v-for="(district, index) in districts" :key="index" :value="district.id">{{district.title}}</option>
                                            </select>
                                            <div class="text-red-400 text-sm" v-if="form.errors.tdistrict_id">
                                                {{ form.errors.tdistrict_id }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="p_address" class="col-md-4 col-lg-3 col-form-label">Permanent Address</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control" v-model="form.p_address" id="p_address">
                                            <div class="text-red-400 text-sm" v-if="form.errors.p_address">
                                                {{ form.errors.p_address }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="t_address" class="col-md-4 col-lg-3 col-form-label">Temporary Address</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control" v-model="form.t_address" id="t_address">
                                            <div class="text-red-400 text-sm" v-if="form.errors.t_address">
                                                {{ form.errors.t_address }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="emergency_number" class="col-md-4 col-lg-3 col-form-label">Emergency Number</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control" v-model="form.emergency_number" id="emergency_number">
                                            <div class="text-red-400 text-sm" v-if="form.errors.emergency_number">
                                                {{ form.errors.emergency_number }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="contact_person" class="col-md-4 col-lg-3 col-form-label">Contact Person</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control" v-model="form.contact_person" id="contact_person">
                                            <div class="text-red-400 text-sm" v-if="form.errors.contact_person">
                                                {{ form.errors.contact_person }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="contact_person_number" class="col-md-4 col-lg-3 col-form-label">Contact Person Number</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control" v-model="form.contact_person_number" id="contact_person_number">
                                            <div class="text-red-400 text-sm" v-if="form.errors.contact_person_number">
                                                {{ form.errors.contact_person_number }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="home_location" class="col-md-4 col-lg-3 col-form-label">Home Location</label>
                                        <div class="col-md-8 col-lg-9">
                                            <GMapMap
                                                :center="form.location"
                                                :zoom="16"
                                                style="width: 100%; height: 20rem"
                                            >
                                                <GMapMarker
                                                    :icon="'/images/user-location.png'"
                                                    :position="form.location"
                                                    :draggable="true"
                                                    @drag="mapLocation"
                                                />
                                            </GMapMap>
                                            <input type="hidden" class="form-control" v-model="form.home_location" id="home_location">
                                            <div class="text-red-400 text-sm" v-if="form.errors.home_location">
                                                {{ form.errors.home_location }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade pt-3" id="profile-settings">
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
                                <div class="tab-pane fade pt-3" id="education">
                                    <div class="row mb-3">
                                        <label for="education_level_id" class="col-md-4 col-lg-3 col-form-label">Education Level</label>
                                        <div class="col-md-8 col-lg-9">
                                            <select v-model="form.education_level_id" class="form-control" id="education_level_id" @change="getFacultyByEducationId">
                                                <option v-for="(edu, eduindex) in datas.education" :key="eduindex" :value="edu.id">{{ edu.title }}</option>
                                            </select>
                                            <div class="text-red-400 text-sm" v-if="form.errors.education_level_id">
                                                {{ form.errors.education_level_id }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="faculty_id" class="col-md-4 col-lg-3 col-form-label">Faculty</label>
                                        <div class="col-md-8 col-lg-9">
                                            <select v-model="form.faculty_id" class="form-control" id="faculty_id" @change="getFacultyByEducationId">
                                                <option v-for="(fac, facindex) in faculties" :key="facindex" :value="fac.id">{{ fac.title }}</option>
                                            </select>
                                            <div class="text-red-400 text-sm" v-if="form.errors.faculty_id">
                                                {{ form.errors.faculty_id }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="specialization" class="col-md-4 col-lg-3 col-form-label">Specialization</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input v-model="form.specialization" type="text" class="form-control" id="specialization">
                                            <div class="text-red-400 text-sm" v-if="form.errors.specialization">
                                                {{ form.errors.specialization }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="institution" class="col-md-4 col-lg-3 col-form-label">Institute</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input v-model="form.institution" type="text" class="form-control" id="institution">
                                            <div class="text-red-400 text-sm" v-if="form.errors.institution">
                                                {{ form.errors.institution }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="year" class="col-md-4 col-lg-3 col-form-label">Year</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input v-model="form.year" type="text" class="form-control" id="year">
                                            <div class="text-red-400 text-sm" v-if="form.errors.year">
                                                {{ form.errors.year }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="board" class="col-md-4 col-lg-3 col-form-label">Borad</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input v-model="form.board" type="text" class="form-control" id="board">
                                            <div class="text-red-400 text-sm" v-if="form.errors.board">
                                                {{ form.errors.board }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="marksystem" class="col-md-4 col-lg-3 col-form-label">Mark System</label>
                                        <div class="col-md-8 col-lg-9">
                                            <select v-model="form.marksystem" class="form-control" id="education_level_id" @change="getFacultyByEducationId">
                                                <option v-for="(mark, markindex) in datas.mark_system" :key="markindex" :value="mark">{{ mark }}</option>
                                            </select>
                                            <div class="text-red-400 text-sm" v-if="form.errors.marksystem">
                                                {{ form.errors.marksystem }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="mark" class="col-md-4 col-lg-3 col-form-label">Obtain Marks</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input v-model="form.mark" type="text" class="form-control" id="mark" autocomplete="off">
                                            <div class="text-red-400 text-sm" v-if="form.errors.mark">
                                                {{ form.errors.mark }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade pt-3" id="bank">
                                    <div class="row mb-3">
                                        <label for="account_number" class="col-md-4 col-lg-3 col-form-label">Account Number</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input v-model="form.account_number" type="text" class="form-control" id="account_number">
                                            <div class="text-red-400 text-sm" v-if="form.errors.account_number">
                                                {{ form.errors.account_number }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="bank_name" class="col-md-4 col-lg-3 col-form-label">Bank Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input v-model="form.bank_name" type="text" class="form-control" id="bank_name">
                                            <div class="text-red-400 text-sm" v-if="form.errors.bank_name">
                                                {{ form.errors.bank_name }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="pan_number" class="col-md-4 col-lg-3 col-form-label">Pan Number</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input v-model="form.pan_number" type="text" class="form-control" id="pan_number">
                                            <div class="text-red-400 text-sm" v-if="form.errors.pan_number">
                                                {{ form.errors.pan_number }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade pt-3" id="profile-change-password">
                                <!-- Change Password Form -->
                                    <div class="row mb-3">
                                        <label for="password" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input v-model="form.password" type="password" class="form-control" id="password">
                                            <div class="text-red-400 text-sm" v-if="form.errors.password">
                                                {{ form.errors.password }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="confirm_password" class="col-md-4 col-lg-3 col-form-label">Confirm Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input v-model="form.confirm_password" type="password" class="form-control" id="confirm_password">
                                            <div class="text-red-400 text-sm" v-if="form.errors.confirm_password">
                                                {{ form.errors.confirm_password }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End Bordered Tabs -->
                        </div>
                        <div class="card-footer">
                            <div class="text-center">
                                <button type="submit" class="btn btn-outline-primary">Submit</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </SupervisorLayout>
</template>