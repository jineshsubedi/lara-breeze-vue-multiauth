<script setup>
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Browser from "@/Components/Browser.vue";
import { Inertia } from "@inertiajs/inertia";
import ExtraForm from "./ExtraForm.vue";
import { ref } from "vue";

const props = defineProps({
    job: Object,
    locations: Object,
    datas: Object,
    default_image: String,
})

const form = useForm({
    title: props.job.title,
    seo_url: props.job.seo_url,
    branch_id: props.job.branch_id,
    job_level: props.job.job_level,
    job_availability: props.job.job_availability,
    job_location: props.locations,
    min_experience: props.job.min_experience,
    position: props.job.position,
    vacancy_code: props.job.vacancy_code,
    deadline: props.job.deadline,
    external_link: props.job.external_link,
    salary_unit: props.job.salary_unit,
    negotiable: props.job.negotiable,
    minimum_salary: props.job.minimum_salary,
    gender: props.job.gender,
    min_age: props.job.min_age,
    max_age: props.job.max_age,
    apply_type: props.job.apply_type,
    setting: props.job.setting,
    process_status: props.job.process_status,
    emails: props.job.emails,
    status: props.job.status,
    publish_date: props.job.publish_date,
    line_manager: props.job.line_manager,
    assignment_handeler: props.job.assignment_handeler,
    jobFile: null,
    advertise_detail: props.job.advertise_detail,
    advertise_link: props.job.advertise_link,
    sort_order: props.job.sort_order,
    image: props.job.image,

    description: props.job.requirement.description,
    specification: props.job.requirement.specification,
    education_description: props.job.requirement.education_description,
    specific_requirement: props.job.requirement.specific_requirement,
    specific_instruction: props.job.requirement.specific_instruction,

    formfields: props.job.formfields,
    location_title: props.job.location_title,
    manual_education: props.job.manual_education,
    education_levels: props.job.education_levels,
    edu_marks: props.job.edu_marks,
    exp_marks: props.job.exp_marks,

    educations: props.job.educations,

});
function generateSlug() {
    form.seo_url = form.title.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
    vacancyCode()
}
function vacancyCode()
{
    var today = props.datas.today;
    var fleter = form.title.match(/\b\w/g).join('');
    form.vacancy_code = fleter+'-'+props.datas.vcode+'-'+today;
}
let logo_path = ref(props.default_image ?  props.default_image : props.datas.default_image)
function changeImage(data) {
    logo_path.value = data.placeholder_img;
    form.image = data.placeholder_img_path;
    $("#job_post_browser").modal('hide');
}
function openModel(path) {
    $("#"+path).modal('show');
}

function addEducation()
{
    form.educations.push({'education_level_id' : '', 'faculty_id' : '', 'experience' : '', 'exp_format': '', 'percent': '', 'cgpa': '', 'others': ''});
}
function removeEducation(index)
{
    form.educations.splice(index, 1)
}
function submitForm()
{
    Inertia.post(route('admin.jobs.update', props.job.id), {
        _method: 'put',
        title: form.title,
        title: form.title,
        seo_url: form.seo_url,
        branch_id: form.branch_id,
        job_level: form.job_level,
        job_availability: form.job_availability,
        job_location: props.locations,
        min_experience: form.min_experience,
        position: form.position,
        vacancy_code: form.vacancy_code,
        deadline: form.deadline,
        external_link: form.external_link,
        salary_unit: form.salary_unit,
        negotiable: form.negotiable,
        minimum_salary: form.minimum_salary,
        gender: form.gender,
        min_age: form.min_age,
        max_age: form.max_age,
        apply_type: form.apply_type,
        setting: form.setting,
        process_status: form.process_status,
        emails: form.emails,
        status: form.status,
        publish_date: form.publish_date,
        line_manager: form.line_manager,
        assignment_handeler: form.assignment_handeler,
        jobFile: form.jobFile,
        advertise_detail: form.advertise_detail,
        advertise_link: form.advertise_link,
        sort_order: form.sort_order,
        image: form.image,

        description: form.description,
        specification: form.specification,
        education_description: form.education_description,
        specific_requirement: form.specific_requirement,
        specific_instruction: form.specific_instruction,

        formfields: form.formfields,
        location_title: form.location_title,
        manual_education: form.manual_education,
        education_levels: form.education_levels,
        edu_marks: form.edu_marks,
        exp_marks: form.exp_marks,

        educations: form.educations,
    })
}
</script>
<template>
    <Head title="Jobs Edit" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Jobs Edit
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
                    <Link :href="route('admin.jobs.edit', job.id)"> Edit </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <form
                            class="form-horizontal"
                            @submit.prevent="
                                submitForm()
                            "
                        >
                        <div class="card-header">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Details</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="education-tab" data-bs-toggle="tab" data-bs-target="#education" type="button" role="tab" aria-controls="education" aria-selected="true">Education</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Requirements</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Form</button>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">        
                                    <div class="form-group row mb-3">
                                        <label
                                            for="title"
                                            class="col-sm-2 col-form-label"
                                            >Title</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="title"
                                                placeholder="Title"
                                                v-model="form.title"
                                                @blur="generateSlug"
                                            />
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.title"
                                            >
                                                {{ form.errors.title }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="seo_url"
                                            class="col-sm-2 col-form-label"
                                            >Seo Url</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="seo_url"
                                                placeholder="seo url"
                                                v-model="form.seo_url"
                                                @blur="vacancyCode()"
                                            />
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.seo_url"
                                            >
                                                {{ form.errors.seo_url }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="branch_id"
                                            class="col-sm-2 col-form-label"
                                            >Branch</label
                                        >
                                        <div class="col-sm-10">
                                            <select v-model="form.branch_id" id="branch_id" class="form-control">
                                                <option v-for="(branch, bindex) in datas.branch" :key="bindex" :value="branch.id">{{branch.name}}</option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.branch_id"
                                            >
                                                {{ form.errors.branch_id }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="job_level"
                                            class="col-sm-2 col-form-label"
                                            >Job Level</label
                                        >
                                        <div class="col-sm-10">
                                            <select v-model="form.job_level" id="job_level" class="form-control">
                                                <option v-for="(jlevel, jindex) in datas.joblevels" :key="jindex" :value="jlevel.id">{{jlevel.name}}</option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.job_level"
                                            >
                                                {{ form.errors.job_level }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="job_availability"
                                            class="col-sm-2 col-form-label"
                                            >Job Availiability</label
                                        >
                                        <div class="col-sm-10">
                                            <select v-model="form.job_availability" id="job_availability" class="form-control">
                                                <option v-for="(jalevel, jaindex) in datas.jobavailabilty" :key="jaindex" :value="jalevel">{{jalevel}}</option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.job_availability"
                                            >
                                                {{ form.errors.job_availability }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="job_location"
                                            class="col-sm-2 col-form-label"
                                            >Job Location</label
                                        >
                                        <div class="col-sm-10">
                                            <select v-model="form.job_location" id="job_location" class="form-control" multiple>
                                                <option v-for="(jlocation, lindex) in datas.joblocations" :key="lindex" :value="jlocation.id">{{jlocation.name}}</option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.job_location"
                                            >
                                                {{ form.errors.job_location }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="min_experience"
                                            class="col-sm-2 col-form-label"
                                            >Minimum Experience</label
                                        >
                                        <div class="col-sm-10">
                                            <select v-model="form.min_experience" id="min_experience" class="form-control">
                                                <option v-for="(minexp, mexpindex) in datas.minexperiences" :key="mexpindex" :value="minexp.value">{{minexp.title}}</option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.min_experience"
                                            >
                                                {{ form.errors.min_experience }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="position"
                                            class="col-sm-2 col-form-label"
                                            >Number of Position</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="number"
                                                min="1"
                                                class="form-control"
                                                id="position"
                                                placeholder="1"
                                                v-model="form.position"
                                            />
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.position"
                                            >
                                                {{ form.errors.position }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="vacancy_code"
                                            class="col-sm-2 col-form-label"
                                            >Vacancy Code</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="vacancy_code"
                                                placeholder="1"
                                                v-model="form.vacancy_code"
                                            />
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.vacancy_code"
                                            >
                                                {{ form.errors.vacancy_code }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="deadline"
                                            class="col-sm-2 col-form-label"
                                            >Deadline</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="date"
                                                class="form-control"
                                                id="deadline"
                                                v-model="form.deadline"
                                            />
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.deadline"
                                            >
                                                {{ form.errors.deadline }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="external_link"
                                            class="col-sm-2 col-form-label"
                                            >External Link</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="external_link"
                                                v-model="form.external_link"
                                            />
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.external_link"
                                            >
                                                {{ form.errors.external_link }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="salary_unit"
                                            class="col-sm-2 col-form-label"
                                            >Salary Unit</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="salary_unit"
                                                placeholder="NPR"
                                                v-model="form.salary_unit"
                                            />
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.salary_unit"
                                            >
                                                {{ form.errors.salary_unit }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="negotiable"
                                            class="col-sm-2 col-form-label"
                                            >Salary Negotiable</label
                                        >
                                        <div class="col-sm-10">
                                            <select v-model="form.negotiable" id="negotiable" class="form-control">
                                                <option v-for="(nego, negoindex) in datas.negotiable" :key="negoindex" :value="nego.value">{{nego.title}}</option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.negotiable"
                                            >
                                                {{ form.errors.negotiable }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3" v-if="form.negotiable == 0">
                                        <label
                                            for="minimum_salary"
                                            class="col-sm-2 col-form-label"
                                            >Salary</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="number"
                                                any="2"
                                                class="form-control"
                                                id="minimum_salary"
                                                v-model="form.minimum_salary"
                                            />
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.minimum_salary"
                                            >
                                                {{ form.errors.minimum_salary }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="gender"
                                            class="col-sm-2 col-form-label"
                                            >Prefered Gender</label
                                        >
                                        <div class="col-sm-10">
                                            <select v-model="form.gender" id="gender" class="form-control">
                                                <option v-for="(gender, genindex) in datas.gender" :key="genindex" :value="gender">{{gender}}</option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.gender"
                                            >
                                                {{ form.errors.gender }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="min_age"
                                            class="col-sm-2 col-form-label"
                                            >Minimum Age</label
                                        >
                                        <div class="col-sm-10">
                                            <select v-model="form.min_age" id="min_age" class="form-control">
                                                <option v-for="(work, windex) in datas.works" :key="windex" :value="work.value">{{work.title}}</option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.min_age"
                                            >
                                                {{ form.errors.min_age }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="max_age"
                                            class="col-sm-2 col-form-label"
                                            >Maximum Age</label
                                        >
                                        <div class="col-sm-10">
                                            <select v-model="form.max_age" id="max_age" class="form-control">
                                                <option v-for="(work, windex) in datas.works" :key="windex" :value="work.value">{{work.title}}</option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.max_age"
                                            >
                                                {{ form.errors.max_age }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="apply_type"
                                            class="col-sm-2 col-form-label"
                                            >Email Validation</label
                                        >
                                        <div class="col-sm-10">
                                            <select v-model="form.apply_type" id="apply_type" class="form-control">
                                                <option v-for="(required, reqindex) in datas.required" :key="reqindex" :value="required.value">{{required.title}}</option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.apply_type"
                                            >
                                                {{ form.errors.apply_type }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="setting"
                                            class="col-sm-2 col-form-label"
                                            >Job Setting</label
                                        >
                                        <div class="col-sm-10">
                                            <select v-model="form.setting" id="setting" class="form-control">
                                                <option v-for="(setting, sindex) in datas.setting" :key="sindex" :value="setting.value">{{setting.title}}</option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.setting"
                                            >
                                                {{ form.errors.setting }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="emails"
                                            class="col-sm-2 col-form-label"
                                            >Emails</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="emails"
                                                placeholder="abc@mail.com,xyz@gmail.com"
                                                v-model="form.emails"
                                            />
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.emails"
                                            >
                                                {{ form.errors.emails }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="status"
                                            class="col-sm-2 col-form-label"
                                            >Status</label
                                        >
                                        <div class="col-sm-10">
                                            <select v-model="form.status" id="status" class="form-control">
                                                <option v-for="(status, sindex) in datas.status" :key="sindex" :value="status.value">{{status.title}}</option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.status"
                                            >
                                                {{ form.errors.status }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="process_status"
                                            class="col-sm-2 col-form-label"
                                            >Process Status</label
                                        >
                                        <div class="col-sm-10">
                                            <select v-model="form.process_status" id="process_status" class="form-control">
                                                <option v-for="(pstatus, psindex) in datas.process_status" :key="psindex" :value="pstatus.id">{{pstatus.title}}</option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.status"
                                            >
                                                {{ form.errors.status }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="publish_date"
                                            class="col-sm-2 col-form-label"
                                            >Publish Date</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="date"
                                                class="form-control"
                                                id="publish_date"
                                                v-model="form.publish_date"
                                            />
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.publish_date"
                                            >
                                                {{ form.errors.publish_date }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="line_manager"
                                            class="col-sm-2 col-form-label"
                                            >Line Manager/Reports To</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="line_manager"
                                                v-model="form.line_manager"
                                            />
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.line_manager"
                                            >
                                                {{ form.errors.line_manager }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="assignment_handeler"
                                            class="col-sm-2 col-form-label"
                                            >Assignment Handled By</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="assignment_handeler"
                                                v-model="form.assignment_handeler"
                                            />
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.assignment_handeler"
                                            >
                                                {{ form.errors.assignment_handeler }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="jobFile"
                                            class="col-sm-2 col-form-label"
                                            >File</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="file"
                                                class="form-control"
                                                id="jobFile"
                                                @input="form.jobFile = $event.target.files[0]"
                                                accept="image/*,.pdf,.docx,.doc"
                                            />
                                            <a :href="job.job_file" v-if="job.job_file != null" target="_blank">Open File</a>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.jobFile"
                                            >
                                                {{ form.errors.jobFile }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="advertise_detail"
                                            class="col-sm-2 col-form-label"
                                            >Advertise Detail</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="advertise_detail"
                                                v-model="form.advertise_detail"
                                            />
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.advertise_detail"
                                            >
                                                {{ form.errors.advertise_detail }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="advertise_link"
                                            class="col-sm-2 col-form-label"
                                            >Advertise Link</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="advertise_link"
                                                v-model="form.advertise_link"
                                            />
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.advertise_link"
                                            >
                                                {{ form.errors.advertise_link }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="image"
                                            class="col-sm-2 col-form-label"
                                            >Advertise Image</label
                                        >
                                        <div class="col-sm-10">
                                            <img :src="logo_path" style="border:1px solid #dcdcff; width:100px;" @click="openModel('job_post_browser')">
                                            <div>
                                                <Browser 
                                                    v-model="logo_path"
                                                    v-on:changeImage="changeImage"
                                                    :browserId="'job_post_browser'"
                                                    :deleteFolder=false
                                                    :createFolder=true
                                                    :deleteFiles=false
                                                    :createFiles=true
                                                />
                                            </div>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.image"
                                            >
                                                {{ form.errors.image }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="sort_order"
                                            class="col-sm-2 col-form-label"
                                            >Sort Order</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="number"
                                                class="form-control"
                                                id="sort_order"
                                                v-model="form.sort_order"
                                            />
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.sort_order"
                                            >
                                                {{ form.errors.sort_order }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="education" role="tabpanel" aria-labelledby="education-tab">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Education Level</th>
                                                <th>Faculty</th>
                                                <th>Experience</th>
                                                <th>Format</th>
                                                <th>Percent</th>                         
                                                <th>CGPA</th>
                                                <th>Others</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(edu, eduindex) in form.educations" :key="eduindex">
                                                <td>
                                                    <select class="form-control" v-model="form.educations[eduindex].education_level_id" required>
                                                        <option v-for="(elevel, elindex) in datas.education_level" :key="elindex" :value="elevel.id">{{elevel.title}}</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control" v-model="form.educations[eduindex].faculty_id" required>
                                                        <option v-for="(faculty, faindex) in datas.faculty" :key="faindex" :value="faculty.id">{{faculty.title}}</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" v-model="form.educations[eduindex].experience" class="form-control" required>
                                                </td>
                                                <td>
                                                    <select class="form-control" v-model="form.educations[eduindex].exp_format" required>
                                                        <option v-for="(expf, efaindex) in datas.exp_format" :key="efaindex" :value="expf">{{expf}}</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" v-model="form.educations[eduindex].percent" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" v-model="form.educations[eduindex].cgpa" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" v-model="form.educations[eduindex].others" class="form-control">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" @click="removeEducation(eduindex)"><i class="bi bi-x-lg"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="8" class="text-right">
                                                    <button type="button" class="btn btn-sm btn-outline-primary" @click="addEducation()"><i class="bi bi-plus"></i> Add More</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="form-group row mb-5">
                                        <label
                                            for="description"
                                            class="col-sm-2 col-form-label"
                                            >Description</label
                                        >
                                        <div class="col-sm-10">
                                            <QuillEditor v-model:content="form.description" id="description" class="form-control" contentType="html" theme="snow" toolbar="" ref="quill"/>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.description"
                                            >
                                                {{ form.errors.description }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-5">
                                        <label
                                            for="specification"
                                            class="col-sm-2 col-form-label"
                                            >Specification</label
                                        >
                                        <div class="col-sm-10">
                                            <QuillEditor v-model:content="form.specification" id="specification" class="form-control" contentType="html" theme="snow" toolbar="" ref="quill"/>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.specification"
                                            >
                                                {{ form.errors.specification }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-5">
                                        <label
                                            for="education_description"
                                            class="col-sm-2 col-form-label"
                                            >Education Description
                                        </label>
                                        <div class="col-sm-10">
                                            <QuillEditor v-model:content="form.education_description" id="education_description" class="form-control" contentType="html" theme="snow" toolbar="" ref="quill"/>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.education_description"
                                            >
                                                {{ form.errors.education_description }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-5">
                                        <label
                                            for="specific_requirement"
                                            class="col-sm-2 col-form-label"
                                            >Job Processing Status
                                        </label>
                                        <div class="col-sm-10">
                                            <QuillEditor v-model:content="form.specific_requirement" id="specific_requirement" class="form-control" contentType="html" theme="snow" toolbar="" ref="quill"/>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.specific_requirement"
                                            >
                                                {{ form.errors.specific_requirement }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-5">
                                        <label
                                            for="specific_instruction"
                                            class="col-sm-2 col-form-label"
                                            >CONFIDENTIAL
                                        </label>
                                        <div class="col-sm-10">
                                            <QuillEditor v-model:content="form.specific_instruction" id="specific_instruction" class="form-control" contentType="html" theme="snow" toolbar="" ref="quill"></QuillEditor>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.specific_instruction"
                                            >
                                                {{ form.errors.specific_instruction }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                    <div class="form-group mb-3">
                                        <label
                                            for="form_fields"
                                            class="form-label"
                                            >Defalt Form Fields</label
                                        > 
                                        <div class="row">
                                            <div class="col-md-3" v-for="(fields, findex) in datas.form_fields" :key="findex">
                                                <input
                                                    type="checkbox"
                                                    class="form-control"
                                                    id="form_fields"
                                                    placeholder="seo url"
                                                    :checked="true"
                                                    v-model="form.formfields"
                                                    :value="fields.value"
                                                /> &nbsp; {{fields.title}}
                                            </div>
                                        </div>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.form_fields"
                                        >
                                            {{ form.errors.form_fields }}
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="location_title"
                                            class="col-sm-2 col-form-label"
                                            >Location Title</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="location_title"
                                                v-model="form.location_title"
                                            />
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.location_title"
                                            >
                                                {{ form.errors.location_title }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label
                                            for="education_levels"
                                            class="form-label"
                                            >Education Levels</label
                                        > 
                                        <div class="row">
                                            <div class="col-md-3" v-for="(edu, findex) in datas.education_level" :key="findex">
                                                <input
                                                    type="checkbox"
                                                    class="form-control"
                                                    id="education_levels"
                                                    placeholder="seo url"
                                                    checked=true
                                                    v-model="form.education_levels"
                                                    :value="edu.id"
                                                /> &nbsp; {{edu.title}}
                                            </div>
                                            <div class="col-md-3">
                                                <input
                                                    type="checkbox"
                                                    class="form-control"
                                                    id="manual_education"
                                                    checked=true
                                                    v-model="form.manual_education"
                                                    value="1"
                                                /> &nbsp; Manual Entry
                                            </div>

                                        </div>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.education_levels"
                                        >
                                            {{ form.errors.education_levels }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row mb-3">
                                                <label
                                                    for="edu_marks"
                                                    class="col-sm-4 col-form-label"
                                                    >Education Marks</label
                                                >
                                                <div class="col-sm-8">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="edu_marks"
                                                        v-model="form.edu_marks"
                                                    />
                                                    <div
                                                        class="text-red-400 text-sm"
                                                        v-if="form.errors.edu_marks"
                                                    >
                                                        {{ form.errors.edu_marks }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row mb-3">
                                                <label
                                                    for="exp_marks"
                                                    class="col-sm-4 col-form-label"
                                                    >Experience Marks</label
                                                >
                                                <div class="col-sm-8">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="exp_marks"
                                                        v-model="form.exp_marks"
                                                    />
                                                    <div
                                                        class="text-red-400 text-sm"
                                                        v-if="form.errors.exp_marks"
                                                    >
                                                        {{ form.errors.exp_marks }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <ExtraForm  :datas="datas" :formdata="job.jobforms"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
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
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
