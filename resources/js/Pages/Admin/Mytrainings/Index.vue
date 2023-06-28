<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import ReportLink from "@/Components/ReportLink.vue";
import CALENDAR from "./Calendar.vue";

const form = useForm();
const props = defineProps({
    mytrainings: {
        type: Object,
        default: () => ({}),
    },
    templates: Object,
    new_templates: Object,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});

</script>
<template>
    <Head title="Training Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Training
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.mytrainings.index')" :only="['mytrainings']"> Trainings </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <ReportLink
                                :active="
                                    filters.type == 'mytraining' ||
                                    filters.type == null
                                "
                                :href="
                                    route('admin.mytrainings.index', [
                                        { type: 'mytraining' },
                                    ])
                                "
                                :only="['mytrainings', 'filters']"
                                >My Training</ReportLink
                            >
                        </li>
                        <li class="nav-item">
                            <ReportLink
                                :active="
                                    filters.type == 'calendar'
                                "
                                :href="
                                    route('admin.mytrainings.index', [
                                        { type: 'calendar' },
                                    ])
                                "
                                :only="['tcalendar', 'filters']"
                                >Calendar</ReportLink
                            >
                        </li>
                        <li class="nav-item">
                            <ReportLink
                                :active="
                                    filters.type == 'evaluation'
                                "
                                :href="
                                    route('admin.mytrainings.index', [
                                        { type: 'evaluation' },
                                    ])
                                "
                                :only="['templates', 'new_templates', 'filters']"
                                >Evaluation</ReportLink
                            >
                        </li>
                    </ul>
                    <div class="card">
                        <div class="card-body" v-if="filters.type == 'mytraining' || filters.type == null">
                            <h5 class="card-title"></h5>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Program</th>
                                        <th scope="col">Trainer</th>
                                        <th scope="col">Level</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr 
                                        v-for="(mt, index) in mytrainings.data"
                                        :key="mt.id"
                                    >
                                        <th scope="row">{{ ++index }}</th>
                                        <td scope="row">{{ mt.training ? mt.training.program.title : '' }}</td>
                                        <td scope="row">{{ mt.training ? mt.training.trainer.name : '' }}</td>
                                        <td scope="row">{{ mt.training ? mt.training.leveling : '' }}</td>
                                        <td scope="row">{{ mt.training ? (mt.training.from+' - '+mt.training.to) : '' }}</td>
                                        <td scope="row">
                                            <div class="btn-group">
                                                <Link :href="route('admin.mytrainings.show', mt.training.id)"
                                                    class="btn btn-sm btn-outline-success">
                                                    <i class="bi bi-eye"></i>
                                                </Link>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="8">
                                            <Pagination class="mt-6" :links="mytrainings.links" />
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="card-body" v-if="filters.type=='calendar'">
                            <CALENDAR />
                        </div>
                        <div class="card-body" v-if="filters.type=='evaluation'">
                            <div v-if="new_templates.length > 0" class="mt-3">
                                <h3 class="card-title">New Eveluation Form</h3>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Share With</th>
                                            <th>Schedule Date</th>
                                            <th>Action</th>
                                        </tr>   
                                    </thead>
                                    <tbody>
                                        <tr v-for="(template, tindex) in new_templates" :key="tindex">
                                            <td>{{template.title}}</td>
                                            <td>
                                                <span v-if="template.share_with == 0">Both</span>
                                                <span v-if="template.share_with == 2">Trainee</span>
                                            </td>
                                            <td>{{template.schedule_date}} - {{template.schedule_end_date}}</td>
                                            <td>
                                                <Link :href="route('admin.mytrainings.getEvaluation', template.id)"
                                                    class="btn btn-sm btn-outline-info">
                                                    <i class="bi bi-eye"></i>
                                                </Link>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div v-if="templates.data.length > 0">
                                <h3 class="card-title">Training Evaluation</h3>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Program</th>
                                            <th>Template</th>
                                            <th>Date</th>
                                            <th>Score</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(template, tindex) in templates.data" :key="tindex">
                                            <td>{{++tindex}}</td>
                                            <td>{{template.training ? template.training.program.title : ''}}</td>
                                            <td>{{template.template ? template.template.title : ''}}</td>
                                            <td>{{template.answer_date}}</td>
                                            <td>{{template.score_board.score}} / {{template.score_board.total}}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">
                                                <Pagination class="mt-6" :links="templates.links" />
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
<style scoped>
</style>
