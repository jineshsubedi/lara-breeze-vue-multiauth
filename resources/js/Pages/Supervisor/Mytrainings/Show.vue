<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import CenterModal from "@/Components/CenterModal.vue";

const props = defineProps({
    training: Object,
    participants: Object
})

const form = useForm({
    description: null
});

function submitApplyFormModel()
{
    $('#applyFormModel').modal('show');
}
function handleApplyFormModel()
{
    form.reset();
    $('#applyFormModel').modal('hide');
}
</script>
<template>
    <Head title="Training Information" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Training Information
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.mytrainings.index')"> Training </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('supervisor.mytrainings.show', training.id)"> Information </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="card-title">Training Information</h5>
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>Program</th>
                                                <td>{{training.program ? training.program.title : ''}}</td>
                                            </tr>
                                            <tr>
                                                <th>Trainer</th>
                                                <td>{{training.trainer ? training.trainer.name : ''}}</td>
                                            </tr>
                                            <tr>
                                                <th>Training Date</th>
                                                <td>{{training.from}} - {{training.to}}</td>
                                            </tr>
                                            <tr>
                                                <th>Venue</th>
                                                <td>{{training.venue}}</td>
                                            </tr>
                                            <tr>
                                                <th>Target Level</th>
                                                <td>{{training.leveling}}</td>
                                            </tr>
                                            <tr>
                                                <th>Capacity / Filled</th>
                                                <td>
                                                <i class="bi bi-person"></i> {{training.total_participant}} / <i class="bi bi-person"></i> {{training.active_participant}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td><span v-html="training.status_label"></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="card-title">Notice</h5>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th>Training Deadline</th>
                                                <td>{{training.notice.notice_date}} - {{training.notice.submit_date}}</td>
                                            </tr>
                                            <tr v-if="training.notice.document != ''">
                                                <th>Document</th>
                                                <td>
                                                    <a :href="training.notice.document" target="_blank_">Download</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Detail</th>
                                                <td><p v-html="training.notice.description"></p></td>
                                            </tr>
                                        </tbody>
                                        <tfoot v-if="training.total_participant >= training.active_participant">
                                            <tr>
                                                <td colspan="2">
                                                    <button type="button" class="btn btn-sm btn-outline-primary" @click="submitApplyFormModel"><i class="bi bi-person-workspace"></i> Submit Participation</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <h5 class="card-title">Participant's</h5>
                                    <span v-for="(part, pindex) in participants" :key="pindex">
                                        <span v-if="part.status == 0"><button type="button" class="btn btn-sm btn-outline-secondary">{{part.user ? part.user.name : ''}}</button> &nbsp;</span>
                                        <span v-if="part.status == 1"><button type="button" class="btn btn-sm btn-outline-success">{{part.user ? part.user.name : ''}}</button> &nbsp;</span>
                                        <span v-if="part.status == 2"><button type="button" class="btn btn-sm btn-outline-danger">{{part.user ? part.user.name : ''}}</button> &nbsp;</span>
                                    </span>
                                </div>
                                <div class="col-md-8" v-if="training.category">
                                    <h5 class="card-title">Itinery</h5>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Topic</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(category, cindex) in training.category" :key="cindex">
                                                <td>{{category.idate}}</td>
                                                <td>{{category.topic}}</td>
                                                <td>{{category.start_time}}</td>
                                                <td>{{category.end_time}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-4" v-if="training.materials">
                                    <h5 class="card-title">Attachments</h5>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Attachment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(material, mindex) in training.materials" :key="mindex">
                                                <td>{{material.title}}</td>
                                                <td>
                                                    <span v-if="(material.extension == 'png' || material.extension == 'jpg' || material.extension == 'jpeg' || material.extension == 'webp') && material.attachment != ''">
                                                        <a :href="material.attachment" target="_blank_"><img :src="material.attachment" style="width:50px;" :alt="material.title"></a>
                                                    </span>
                                                    <span v-if="(material.extension == 'pdf' || material.extension == 'docx' || material.extension == 'doc' || material.extension == 'xlsx'|| material.extension == 'xls') && material.attachment != ''">
                                                        <a :href="material.attachment" target="_blank_"><img src="/images/pdf_icon.png" style="width:50px;" :alt="material.title"></a>
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <CenterModal
                    :id="'applyFormModel'"
                    title="Training Apply Form"
                >
                    <form
                        class="form-horizontal"
                        @submit.prevent="
                            form.post(route('supervisor.mytrainings.apply', training.id),{
                                preserveScroll: true,
                                onSuccess: () => handleApplyFormModel()
                            })
                        "
                    >
                        <div class="form-group mb-3">
                            <label
                                for="Remarks"
                                class="col-form-label"
                                >Why, in your opinion, is this training crucial for you?</label
                            >
                            <textarea v-model="form.description" rows="3" class="form-control"></textarea> 
                            <div
                                class="text-red-400 text-sm"
                                v-if="form.errors.description"
                            >
                                {{ form.errors.description }}
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <button
                                type="submit"
                                class="btn btn-outline-primary btn-sm"
                            >
                                Submit
                            </button>
                        </div>
                    </form>
            </CenterModal>
        </div>
    </SupervisorLayout>
</template>
