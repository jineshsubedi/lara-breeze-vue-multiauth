<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import throttle from "lodash/throttle";
import CenterModal1 from "@/Components/CenterModal.vue";
import LargeModal from "@/Components/LargeModal.vue";

const form = useForm();
const props = defineProps({
    templates: {
        type: Object,
        default: () => ({}),
    },
    training: Object,
    datas: Object,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
let SuperAdmin = props.can.includes('SuperAdmin');
let TrainingHandler = props.can.includes('TrainingHandler');

let title = ref(props.filters.title);
let share = ref(props.filters.share);
let schedule = ref(props.filters.schedule);
watch(title, throttle(function (value){
    loadFilter()
}, 500
));
function loadFilter()
{
    Inertia.get(
        route('staffs.trainings.template.index', props.training.id),
        { title: title.value, share: share.value, schedule: schedule.value},
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
}

function destroy(id, template_id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("staffs.trainings.template.destroy", [id, template_id]));
    }
}
function openEvaluationList(modelId)
{
    $('#ev-'+modelId).modal('show');
}
function openDetailEvaluationList(modelId)
{
    $('#evaluation-'+modelId).modal('show');
}
</script>
<template>
    <Head title="Trainer Page" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Trainer
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.trainings.index')"> Training </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.trainings.show', training.id)" :only="['training']"> Information </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.trainings.template.index', training.id)" :only="['templates']"> Templates </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('staffs.trainings.template.create', training.id)" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New Template
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Template</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Training Program</th>
                                <th scope="col">Share With</th>
                                <th scope="col">Schedule</th>
                                <th scope="col">Action</th>
                            </tr>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">
                                    <input
                                        type="text"
                                        v-model="title"
                                        placeholder="Search Template By title"
                                        class="form-control"
                                    />
                                </th>
                                <th scope="col"></th>
                                <th scope="col">
                                    <select v-model="share" class="form-control" id="share_with" @change="loadFilter()">
                                        <option v-for="(share, sindex) in datas.share" :key="sindex" :value="share.value">{{share.title}}</option>
                                        
                                    </select>
                                </th>
                                <th scope="col">
                                    <select v-model="schedule" class="form-control" id="schedule" @change="loadFilter()">
                                        <option v-for="(req, rindex) in datas.required" :key="rindex" :value="req.value">{{req.title}}</option>
                                        
                                    </select>
                                </th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(template, index) in templates.data"
                                :key="template.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ template.title }}</td>
                                <td scope="row">{{ training.program ? training.program.title : '' }}</td>
                                <td scope="row">{{ template.shared }}</td>
                                <td scope="row">
                                    <span v-if="template.schedule == 0">Not Scheduled</span>
                                    <span v-else>{{template.schedule_date}} - {{template.schedule_end_date}}</span>
                                </td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('staffs.trainings.getEvaluation', [training.id, template.id])"
                                            class="btn btn-sm btn-outline-info" v-if="template.share_with == 1 && template.answers.length == 0">
                                            <i class="bi bi-info-lg"></i>
                                        </Link>
                                        <button type="button" class="btn btn-sm btn-outline-primary" @click="openEvaluationList(template.id)" v-if="template.answers.length > 0">
                                            Evaluations <span class="badge bg-success">{{template.answers.length}}</span>
                                        </button>
                                        <Link :href="route('staffs.trainings.template.edit', [training.id, template.id])"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(training.id, template.id)"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                                <CenterModal1
                                    :id="'ev-'+template.id"
                                    title="Evaluation By Staffs"
                                    v-if="template.answers.length > 0"
                                >
                                   <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Score</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(ans, aindex) in template.answers" :key="aindex">
                                                <td v-if="template.is_trainer == 0">{{ans.user ? ans.user.name : ''}}</td>
                                                <td v-else>Trainer</td>
                                                <td>{{ans.score_board.score}} / {{ans.score_board.total}}</td>
                                                <td>{{ans.answer_date}}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-info" @click="openDetailEvaluationList(template.id)"><i class="bi bi-eye"></i> Detail</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                   </table> 
                                </CenterModal1>
                                <LargeModal 
                                    :title="'Evaluation Detail'"
                                    :id="'evaluation-'+template.id"
                                    v-if="template.qanswers.length > 0"
                                >
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Question</th>
                                                <th>Answer</th>
                                                <th>Score</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(qans, qindex) in template.qanswers" :key="qindex">
                                                <td>{{qans.question}}</td>
                                                <td>{{qans.answer}}</td>
                                                <td>{{qans.score}}</td>
                                            </tr>
                                        </tbody>
                                   </table> 
                                </LargeModal>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">
                                    <Pagination class="mt-6" :links="templates.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </StaffLayout>
</template>
