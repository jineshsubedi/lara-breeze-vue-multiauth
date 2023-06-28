<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    job : Object,
    applicant : Object,
})

const form = useForm();

</script>
<template>
    <Head title="Job Applicant Detail" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{job.title}} Applicant Detail
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.jobs.index')"> Jobs </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.jobs.applicants.show', [job.id, applicant.id])"> Information </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{job.title}} - Applicant Information</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Name</th>
                                            <td>{{applicant.name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{applicant.email}}</td>
                                        </tr>
                                        <tr>
                                            <th>Mobile Phone</th>
                                            <td>{{applicant.mobile}}</td>
                                        </tr>
                                        <tr v-if="job.formfields.includes('gender')">
                                            <th>Gender</th>
                                            <td>{{applicant.gender}}</td>
                                        </tr>
                                        <tr v-if="job.formfields.includes('marital_status')">
                                            <th>Marital Status</th>
                                            <td>{{applicant.marital_status}}</td>
                                        </tr>
                                        <tr v-if="job.formfields.includes('permanent_address')">
                                            <th>Permenent Address</th>
                                            <td>{{applicant.permanent_address}}</td>
                                        </tr>
                                        <tr v-if="job.formfields.includes('temporary_address')">
                                            <th>Temporary Address</th>
                                            <td>{{applicant.temporary_address}}</td>
                                        </tr>
                                        <tr v-if="job.formfields.includes('home_phone')">
                                            <th>Home Number</th>
                                            <td>{{applicant.home_phone}}</td>
                                        </tr>
                                        <tr v-if="job.formfields.includes('citizenship')">
                                            <th>Citizenship</th>
                                            <td>{{applicant.citizenship}}</td>
                                        </tr>
                                        <tr v-if="job.formfields.includes('dob')">
                                            <th>Date Of Birth</th>
                                            <td>{{applicant.dob}} - {{applicant.age}}</td>
                                        </tr>
                                        <tr v-if="job.formfields.includes('fax')">
                                            <th>Fax</th>
                                            <td>{{applicant.fax}}</td>
                                        </tr>
                                        <tr v-if="job.formfields.includes('website')">
                                            <th>Website</th>
                                            <td>{{applicant.website}}</td>
                                        </tr>
                                        <tr v-if="job.formfields.includes('vehicle')">
                                            <th>Vehicle</th>
                                            <td>{{applicant.vehicle}}</td>
                                        </tr>
                                        <tr v-if="job.formfields.includes('license_of')">
                                            <th>License Of</th>
                                            <td>{{applicant.license_of}}</td>
                                        </tr>
                                        <tr v-if="job.formfields.includes('pp_photo')">
                                            <th>Passport Size Photo</th>
                                            <td>{{applicant.image}}</td>
                                        </tr>
                                        <tr v-if="job.formfields.includes('resume')">
                                            <th>Resume</th>
                                            <td>{{applicant.resume}}</td>
                                        </tr>
                                        <tr v-if="job.formfields.includes('cover_letter')">
                                            <th>Cover Letter</th>
                                            <td><span v-html="applicant.cover_letter"></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive" v-if="job.formfields.includes('education')">
                                <h5 class="card-title">Applicant Education</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Education Level</th>
                                            <th>Faculty</th>
                                            <th>Specialization</th>
                                            <th>Institution</th>
                                            <th>Board</th>
                                            <th>Percentage</th>
                                            <th>Marksystem</th>
                                            <th>Year</th>
                                            <th>Document</th>
                                            <th>Status</th>
                                            <th>Country</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(education, eindex) in applicant.education" :key="eindex">
                                            <th>{{education.educationlevel_id}}</th>
                                            <th>{{education.faculty_id}}</th>
                                            <th>{{education.specialization}}</th>
                                            <th>{{education.institution}}</th>
                                            <th>{{education.board}}</th>
                                            <th>{{education.percentage}}</th>
                                            <th>{{education.marksystem}}</th>
                                            <th>{{education.year}}</th>
                                            <th>{{education.document}}</th>
                                            <th>{{education.status}}</th>
                                            <th>{{education.country}}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive" v-if="job.formfields.includes('experience')">
                                <h5 class="card-title">Applicant Experience</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Organization</th>
                                            <th>Type</th>
                                            <th>Designation</th>
                                            <th>Level</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Currently Working</th>
                                            <th>Duties</th>
                                            <th>Document</th>
                                            <th>Country</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(exp, exindex) in applicant.experience" :key="exindex">
                                            <th>{{exp.organization}}</th>
                                            <th>{{exp.type}}</th>
                                            <th>{{exp.designation}}</th>
                                            <th>{{exp.level}}</th>
                                            <th>{{exp.from}}</th>
                                            <th>{{exp.to}}</th>
                                            <th>{{exp.currently_working}}</th>
                                            <th><span v-html="exp.duties"></span></th>
                                            <th>{{exp.document}}</th>
                                            <th>{{exp.country}}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive" v-if="job.formfields.includes('address')">
                                <h5 class="card-title">Applicant Address</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Permanent</th>
                                            <th>Temporary</th>
                                            <th>Home Phone</th>
                                            <th>Mobile</th>
                                            <th>Website</th>
                                            <th>fax</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(address, adindex) in applicant.address" :key="adindex">
                                            <th>{{address.permanent}}</th>
                                            <th>{{address.temporary}}</th>
                                            <th>{{address.home_phone}}</th>
                                            <th>{{address.mobile}}</th>
                                            <th>{{address.website}}</th>
                                            <th>{{address.fax}}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive" v-if="job.formfields.includes('training')">
                                <h5 class="card-title">Applicant Training</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Institution</th>
                                            <th>Duration</th>
                                            <th>Document</th>
                                            <th>Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(training, tindex) in applicant.training" :key="tindex">
                                            <th>{{training.title}}</th>
                                            <th>{{training.institution}}</th>
                                            <th>{{training.duration}}</th>
                                            <th>{{training.document}}</th>
                                            <th><span v-html="training.details"></span></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive" v-if="job.formfields.includes('language')">
                                <h5 class="card-title">Applicant Language</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Language</th>
                                            <th>Understand</th>
                                            <th>Speak</th>
                                            <th>Reading</th>
                                            <th>Writing</th>
                                            <th>Native Language</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(lang, lindex) in applicant.language" :key="lindex">
                                            <th>{{lang.language}}</th>
                                            <th>{{lang.understand}}</th>
                                            <th>{{lang.speak}}</th>
                                            <th>{{lang.reading}}</th>
                                            <th>{{lang.writing}}</th>
                                            <th>{{lang.mother_t}}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive" v-if="job.formfields.includes('reference')">
                                <h5 class="card-title">Applicant Reference</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Designation</th>
                                            <th>Address</th>
                                            <th>Office Phone</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Company</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(ref, rindex) in applicant.reference" :key="rindex">
                                            <th>{{ref.name}}</th>
                                            <th>{{ref.designation}}</th>
                                            <th>{{ref.address}}</th>
                                            <th>{{ref.office_phone}}</th>
                                            <th>{{ref.mobile}}</th>
                                            <th>{{ref.email}}</th>
                                            <th>{{ref.company}}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
