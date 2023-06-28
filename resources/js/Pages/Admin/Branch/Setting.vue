<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import Browser from "@/Components/Browser.vue";

const props = defineProps({
    branch: Object,
    duration: Object,
    rating_times: Object,
    lang_dates: Object,
    client_ratings: Object,
    staffs: Object,
    departments: Object,
    yn: Object,
    titles: Object,
    setting: Object,
    performance: Object,
    defaultImage: String,
    can: Object
});

const form = useForm({
    revenue: props.setting.revenue,
    client: props.setting.client,
    canteen: props.setting.canteen,
    performance_rater: props.setting.performance_rater,
    attendance_handler: props.setting.attendance_handler,
    hr_handler: props.setting.hr_handler,
    staff_handler: props.setting.staff_handler,
    training_handler: props.setting.training_handler,
    survey_handler: props.setting.survey_handler,
    out_source_handler: props.setting.out_source_handler,
    account_handler_signature: props.setting.account_handler_signature,
    account_handler: props.setting.account_handler,
    salary_calculate: props.setting.salary_calculate,
    client_comment: props.setting.client_comment,
    comment_type: props.setting.comment_type,
    performance_rating_type: props.setting.performance_rating_type,
    performance : props.performance
    
});
let placeholder_image = ref(props.defaultImage)

function changeImage1(data) {
    placeholder_image = data.placeholder_img;
    form.account_handler_signature = data.placeholder_img_path;
    $("#signature_uploader").modal('hide');
}

function openModel(path) {
    $("#"+path).modal('show');
}

function addPerformance()
{
    form.performance.push({'title' : '', 'duration' : '', 'parameter' : ''});
}
function removePerformance(index)
{
    form.performance.splice(index, 1)
}
</script>
<template>
    <Head title="Branch Setting" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Branch Setting
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.branches.index')"> Branch </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.branch.getSetting', branch.id)"> Setting </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Branch Setting</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.post(route('admin.branch.storeSetting', branch.id))
                                "
                            >
                            <div class="row">
                                <div class="form-group col-md-6 row mb-3">
                                    <label
                                        for="revenue"
                                        class="col-sm-4 col-form-label"
                                        >Revenue Uploader</label
                                    >
                                    <div class="col-sm-8">
                                        <select v-model="form.revenue" class="form-control">
                                            <option v-for="(staff, index) in staffs" :key="index" :value="staff.id">{{staff.name}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.revenue"
                                        >
                                            {{ form.errors.revenue }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 row mb-3">
                                    <label
                                        for="client"
                                        class="col-sm-4 col-form-label"
                                        >Client Handler</label
                                    >
                                    <div class="col-sm-8">
                                        <select v-model="form.client" class="form-control">
                                            <option v-for="(department, index) in departments" :key="index" :value="department.id">{{department.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.client"
                                        >
                                            {{ form.errors.client }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 row mb-3">
                                    <label
                                        for="canteen"
                                        class="col-sm-4 col-form-label"
                                        >Canteen Handler</label
                                    >
                                    <div class="col-sm-8">
                                        <select v-model="form.canteen" class="form-control">
                                            <option v-for="(department, index) in departments" :key="index" :value="department.id">{{department.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.canteen"
                                        >
                                            {{ form.errors.canteen }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 row mb-3">
                                    <label
                                        for="attendance_handler"
                                        class="col-sm-4 col-form-label"
                                        >Attendance Handler</label
                                    >
                                    <div class="col-sm-8">
                                        <select v-model="form.attendance_handler" class="form-control">
                                            <option v-for="(staff, index) in staffs" :key="index" :value="staff.id">{{staff.name}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.attendance_handler"
                                        >
                                            {{ form.errors.attendance_handler }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 row mb-3">
                                    <label
                                        for="hr_handler"
                                        class="col-sm-4 col-form-label"
                                        >HR Handler</label
                                    >
                                    <div class="col-sm-8">
                                        <select v-model="form.hr_handler" class="form-control">
                                            <option v-for="(staff, index) in staffs" :key="index" :value="staff.id">{{staff.name}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.hr_handler"
                                        >
                                            {{ form.errors.hr_handler }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 row mb-3">
                                    <label
                                        for="staff_handler"
                                        class="col-sm-4 col-form-label"
                                        >Staff Handler</label
                                    >
                                    <div class="col-sm-8">
                                        <select v-model="form.staff_handler" class="form-control">
                                            <option v-for="(staff, index) in staffs" :key="index" :value="staff.id">{{staff.name}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.staff_handler"
                                        >
                                            {{ form.errors.staff_handler }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 row mb-3">
                                    <label
                                        for="survey_handler"
                                        class="col-sm-4 col-form-label"
                                        >Survey Handler</label
                                    >
                                    <div class="col-sm-8">
                                        <select v-model="form.survey_handler" class="form-control">
                                            <option v-for="(staff, index) in staffs" :key="index" :value="staff.id">{{staff.name}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.survey_handler"
                                        >
                                            {{ form.errors.survey_handler }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 row mb-3">
                                    <label
                                        for="training_handler"
                                        class="col-sm-4 col-form-label"
                                        >Training Handler</label
                                    >
                                    <div class="col-sm-8">
                                        <select v-model="form.training_handler" class="form-control">
                                            <option v-for="(staff, index) in staffs" :key="index" :value="staff.id">{{staff.name}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.training_handler"
                                        >
                                            {{ form.errors.training_handler }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 row mb-3">
                                    <label
                                        for="out_source_handler"
                                        class="col-sm-4 col-form-label"
                                        >OutSource Handler</label
                                    >
                                    <div class="col-sm-8">
                                        <select v-model="form.out_source_handler" class="form-control select2" multiple="multiple">
                                            <option v-for="(staff, index) in staffs" :key="index" :value="staff.id">{{staff.name}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.out_source_handler"
                                        >
                                            {{ form.errors.out_source_handler }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 row mb-3">
                                    <label
                                        for="salary_calculate"
                                        class="col-sm-4 col-form-label"
                                        >Salary Calculate</label
                                    >
                                    <div class="col-sm-8">
                                        <select v-model="form.salary_calculate" class="form-control">
                                            <option v-for="(ldate, index) in lang_dates" :key="index" :value="ldate.value">{{ldate.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.salary_calculate"
                                        >
                                            {{ form.errors.salary_calculate }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 row mb-3">
                                    <label
                                        for="account_handler"
                                        class="col-sm-4 col-form-label"
                                        >Account Handler</label
                                    >
                                    <div class="col-sm-8">
                                        <select v-model="form.account_handler" class="form-control">
                                            <option v-for="(staff, index) in staffs" :key="index" :value="staff.id">{{staff.name}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.account_handler"
                                        >
                                            {{ form.errors.account_handler }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 row mb-3">
                                    <label
                                        for="account_handler_signature"
                                        class="col-sm-4 col-form-label"
                                        >Account Handler Signature</label
                                    >
                                    <div class="col-sm-8">
                                        <input
                                            type="input"
                                            class="form-control"
                                            id="inputLogo"
                                            v-model="form.account_handler_signature"
                                            style="display:none;"
                                        />
                                        <img :src="placeholder_image" alt="" style="border:1px solid #dcdcff" @click="openModel('signature_uploader')">
                                        <div>
                                            <Browser 
                                                v-model="placeholder_image"
                                                v-on:changeImage="changeImage1"
                                                browserId="signature_uploader"
                                                :deleteFolder=true
                                                :createFolder=true
                                                :deleteFiles=true
                                                :createFiles=true
                                            />
                                        </div>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.account_handler_signature"
                                        >
                                            {{ form.errors.account_handler_signature }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 row mb-3">
                                    <label
                                        for="client_comment"
                                        class="col-sm-4 col-form-label"
                                        >Client Rating Required</label
                                    >
                                    <div class="col-sm-8">
                                        <select v-model="form.client_comment" class="form-control" @change="clientRating">
                                            <option v-for="(ynop, index) in yn" :key="index" :value="ynop.value">{{ynop.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.client_comment"
                                        >
                                            {{ form.errors.client_comment }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 row mb-3" v-if="form.client_comment == 1">
                                    <label
                                        for="comment_type"
                                        class="col-sm-4 col-form-label"
                                        >Client Rating Time</label
                                    >
                                    <div class="col-sm-8">
                                        <select v-model="form.comment_type" class="form-control">
                                            <option v-for="(clientrating, index) in client_ratings" :key="index" :value="clientrating.value">{{clientrating.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.comment_type"
                                        >
                                            {{ form.errors.comment_type }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 row mb-3">
                                    <label
                                        for="performance_rater"
                                        class="col-sm-4 col-form-label"
                                        >Performance Rater</label
                                    >
                                    <div class="col-sm-8">
                                        <select v-model="form.performance_rater" class="form-control">
                                            <option v-for="(staff, index) in staffs" :key="index" :value="staff.id">{{staff.name}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.performance_rater"
                                        >
                                            {{ form.errors.performance_rater }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 row mb-3">
                                    <label
                                        for="performance_rating_type"
                                        class="col-sm-4 col-form-label"
                                        >Performance Rating Time</label
                                    >
                                    <div class="col-sm-8">
                                        <select v-model="form.performance_rating_type" class="form-control">
                                            <option v-for="(rtimes, index) in rating_times" :key="index" :value="rtimes.value">{{rtimes.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.performance_rating_type"
                                        >
                                            {{ form.errors.performance_rating_type }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="4">Performance Valuation Parameters</th>
                                        </tr>
                                        <tr>
                                            <th>Title</th>
                                            <th>Duration</th>
                                            <th>Parameter</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(per, inp) in form.performance" :key="inp">
                                            <td>
                                                <!-- <select v-model="form.performance[inp].title" class="form-control" required>
                                                <option v-for="(ptitle ,pind) in titles" :value="ptitle" :key="pind">{{ptitle}}</option></select> -->
                                                <input type="text" v-model="form.performance[inp].title" class="form-control" placeholder="Perfomance title" required>
                                            </td>
                                            <td>
                                                <select v-model="form.performance[inp].duration" class="form-control" required>
                                                <option v-for="(pduration ,pdur) in duration" :value="pduration.value" :key="pdur">{{pduration.title}}</option></select>
                                            </td>
                                            <td>
                                                <input type="text" v-model="form.performance[inp].parameter" class="form-control" placeholder="Perfomance parameter" required>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-danger" @click="removePerformance(inp)"><i class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-right">
                                                <button type="button" class="btn btn-sm btn-outline-primary" @click="addPerformance"><i class="bi bi-plus"></i>  Add More</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
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
