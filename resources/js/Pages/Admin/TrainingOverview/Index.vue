<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import ReportLink from "@/Components/ReportLink.vue";
import CALENDAR from "../Mytrainings/Calendar.vue";
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import TrainingStaffByDepartment from "@/Components/Google/BarChart.vue";
import TrainingVsProgram from "@/Components/Google/PieChart.vue";
import TrainingVsParticipant from "@/Components/Google/ComboChart.vue";
import CostItemStat from "@/Components/Google/DonutChart.vue";
import TemplateScoreChart from "@/Components/Google/TrendlinessChart.vue"
import TemaplateBothVsScore from "@/Components/Google/ComboChart.vue";
import TemaplateTrainerVsScore from "@/Components/Google/ComboChart.vue";
import TemaplateTraineeVsScore from "@/Components/Google/ComboChart.vue";

const form = useForm();
const props = defineProps({
    overtime: Object,
    expenditure: Object,
    template: Object,
    branches: Object,
    programs: Object,
    years: Object,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array,
});
let SuperAdmin = props.can.includes("SuperAdmin");
let TrainingHandler = props.can.includes("TrainingHandler");

let year = ref(props.filters.year);
let program = ref(props.filters.program);
let from = ref(props.filters.from);
let to = ref(props.filters.to);
let branch = ref(props.filters.branch);
let type = ref(props.filters.type);

function loadFilter()
{
    Inertia.get(
        route("admin.td.index"),
        {
            branch: branch.value,
            program: program.value,
            from: from.value,
            to: to.value,
            year: year.value,
            type: type.value,
        },
        {
            preserveState: false,
            preserveScroll: true,
            replace: true,
        }
    );
}

</script>
<template>
    <Head title="Training Overview Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Training Overview
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.trainings.index')">
                        Trainings
                    </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.td.index')">
                        Training Overview</Link
                    >
                </li>
            </ol>
        </template>
        <div class="">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <ReportLink
                        :active="
                            filters.type == 'overview' || filters.type == null
                        "
                        :href="route('admin.td.index', [{ type: 'overview' }])"
                        >Trainings</ReportLink
                    >
                </li>
                <li class="nav-item">
                    <ReportLink
                        :active="filters.type == 'calendar'"
                        :href="route('admin.td.index', [{ type: 'calendar' }])"
                        :only="[]"
                        >Calendar</ReportLink
                    >
                </li>
                <li class="nav-item">
                    <ReportLink
                        :active="filters.type == 'evaluation'"
                        :href="
                            route('admin.td.index', [{ type: 'evaluation' }])
                        "
                        >Evaluation</ReportLink
                    >
                </li>
                <li class="nav-item">
                    <ReportLink
                        :active="filters.type == 'cost'"
                        :href="route('admin.td.index', [{ type: 'cost' }])"
                        >Expenditure</ReportLink
                    >
                </li>
            </ul>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="">Year</label>
                            <select v-model="year" class="form-control" @change="loadFilter">
                                <option value="">Select Year</option>
                                <option v-for="(yr, yindex) in years" :key="yindex" :value="yr">{{yr}}</option>
                            </select>
                        </div>
                        <div class="col-md-3" v-if="SuperAdmin">
                            <label for="">Branch</label>
                            <select v-model="branch" class="form-control" @change="loadFilter">
                                <option value="">Select Branch</option>
                                <option v-for="(branch, bindex) in branches" :key="bindex" :value="branch.id">{{branch.name}}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">Program</label>
                            <select v-model="program" class="form-control" @change="loadFilter">
                                <option value="">Select Program</option>
                                <option v-for="(program, pindex) in programs" :key="pindex" :value="program.id">{{program.title}}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">From</label>
                            <input type="date" v-model="from" class="form-control" @change="loadFilter">
                        </div>
                        <div class="col-md-3">
                            <label for="">To</label>
                            <input type="date" v-model="to" class="form-control" @change="loadFilter">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <div class="card-body"
                        v-if="
                            filters.type == 'overview' || filters.type == null
                        "
                        >
                        <table class="mt-3 table table-bordered">
                            <thead>
                                <tr>
                                    <th>Training Conducted</th>
                                    <th>Invited Participants</th>
                                    <th>Participants</th>
                                    <th>Costs (NPR)</th>
                                    <th>Hours (Hours)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ overtime.total_training }}</td>
                                    <td>{{ overtime.total_invited }}</td>
                                    <td>{{ overtime.total_trained }}</td>
                                    <td>{{ overtime.total_cost }}</td>
                                    <td>{{ overtime.total_hour }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <hr />
                        <TrainingVsParticipant 
                            :datas="overtime.trainingVsParticipant"
                            :cdata='[
                                "Program",
                                "Total Invite",
                                "Total Participate",
                                "Total Hour",
                            ]'
                            :title="'Training Vs Participant Information'"
                            :hAxis="'Program/Course'"
                            :vAxis="'Count'"
                            :id="'TrainingVsParticipant'"
                            v-if="overtime.trainingVsParticipant.length > 0"
                        />
                        <hr />
                        <TrainingStaffByDepartment 
                            :datas="overtime.trainingStaffByDepartment" 
                            :cdata='["Department", "No. Of Staffs"]'
                            :title="'Trained Staff By Department'"
                            :hAxis="'Total Staff'"
                            :vAxis="'Training Attended by Department Staff'"
                            :id="'barChartTrainingStaffByDepartment'"
                            v-if="overtime.trainingStaffByDepartment.length > 0"
                        />
                        <hr />
                        <TrainingVsProgram 
                            :datas="overtime.programVsTraining" 
                            :cdata="['Program', 'No. Of Trainings']"
                            :title="'Program/Course Vs Trainings'"
                            :id="'TrainingVsProgram'"
                            v-if="overtime.programVsTraining.length > 0"
                        />
                    </div>
                    <div class="card-body" v-if="filters.type == 'calendar'">
                        <CALENDAR />
                    </div>
                    <div class="card-body" v-if="filters.type == 'evaluation'">
                        <table class="mt-3 table table-bordered">
                            <thead>
                                <tr>
                                    <th>Training</th>
                                    <th>Total Templates</th>
                                    <th>Full Score</th>
                                    <th>Total Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ template.total_training }}</td>
                                    <td>{{ template.total_template }}</td>
                                    <td>{{ template.full_score }}</td>
                                    <td>{{ template.total_score }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <TemplateScoreChart 
                            :datas="template.templateScoreChart" 
                            :cdata="['Full Score', 'Score']"
                            :title="'Template With highest (Full and Obtained) Score'"
                            :hAxis="'Full Score'"
                            :vAxis="'Template Score'"
                            :id="'trendlinessScoreChart'"
                            v-if="template.templateScoreChart.length > 0"
                        />
                        <hr>
                        <TemaplateBothVsScore 
                            :datas="template.share_both_chart"
                            :cdata='[
                                "Template",
                                "Full Score",
                                "Total Score",
                            ]'
                            :title="'Training Template Shared with Both Vs Score'"
                            :hAxis="'Templates'"
                            :vAxis="'Score'"
                            :id="'share_both_chart'"
                            v-if="template.share_both_chart.length > 0"
                        />
                        <hr>
                        <TemaplateTrainerVsScore 
                            :datas="template.share_trainer_chart"
                            :cdata='[
                                "Template",
                                "Full Score",
                                "Total Score",
                            ]'
                            :title="'Training Template Shared with Trainer Vs Score'"
                            :hAxis="'Templates'"
                            :vAxis="'Score'"
                            :id="'share_trainer_chart'"
                            v-if="template.share_trainer_chart.length > 0"
                        />
                        <hr>
                        <TemaplateTraineeVsScore 
                            :datas="template.share_trainee_chart"
                            :cdata='[
                                "Template",
                                "Full Score",
                                "Total Score",
                            ]'
                            :title="'Training Template Shared with Trainee Vs Score'"
                            :hAxis="'Templates'"
                            :vAxis="'Score'"
                            :id="'share_trainee_chart'"
                            v-if="template.share_trainee_chart.length > 0"
                        />
                    </div>
                    <div class="card-body" v-if="filters.type == 'cost'">
                        <table class="mt-3 table table-bordered">
                            <thead>
                                <tr>
                                    <th>Training Conducted</th>
                                    <th>Total Budget</th>
                                    <th>Trainee Cost</th>
                                    <th>Trainer Cost</th>
                                    <th>Hours (Hours)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ expenditure.total_training }}</td>
                                    <td>{{ expenditure.total_budget }}</td>
                                    <td>{{ expenditure.trainee_cost }}</td>
                                    <td>{{ expenditure.trainer_cost }}</td>
                                    <td>{{ expenditure.total_hour }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <CostItemStat 
                            :datas="expenditure.costItemStat" 
                            :cdata="['Items', 'Total Cost']"
                            :title="'Training Items Vs Items Cost'"
                            :id="'TrainingVsProgram'"
                            v-if="expenditure.costItemStat.length > 0"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
