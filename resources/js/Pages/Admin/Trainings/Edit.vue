<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    training: Object,
    datas: Object

})

const form = useForm({
    training_program_id: props.training.training_program_id,
    trainer_id: props.training.trainer_id,
    status: props.training.status,
    from: props.training.from,
    to: props.training.to,
    level: props.training.level,
    budget: props.training.budget,
    venue: props.training.venue,
    total_participant: props.training.total_participant,

    category: props.training.category,

    notice_date: props.training.notice.notice_date,
    submit_date: props.training.notice.submit_date,
    description: props.training.notice.description,
    documentFile: null,
});
function addCategory()
{
    form.category.push({'idate' : '', 'topic': '', 'start_time': '', 'end_time': '', 'duration': ''});
}
function removeCategory(index)
{
    form.category.splice(index, 1)
}
function submitForm()
{
    Inertia.post(route('admin.trainings.update', props.training.id), {
        _method: 'put',
        training_program_id: form.training_program_id,
        trainer_id: form.trainer_id,
        status: form.status,
        from: form.from,
        to: form.to,
        level: form.level,
        budget: form.budget,
        venue: form.venue,
        total_participant: form.total_participant,

        category: form.category,

        notice_date: form.notice_date,
        submit_date: form.submit_date,
        description: form.description,
        documentFile: form.documentFile,
    })
}
</script>
<template>
    <Head title="Training Create" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Training Create
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.trainings.index')"> Training </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.trainings.edit', training.id)"> Edit </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Edit Training</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    submitForm
                                "
                            >
                                <hr>
                                <h5 class="card-title">Basic Information</h5>
                                <div class="form-group row mb-3">
                                    <label
                                        for="training_program_id"
                                        class="col-sm-2 col-form-label"
                                        >Program</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.training_program_id" class="form-control" id="program">
                                            <option v-for="(program, pindex) in datas.programs" 
                                            :key="pindex" :value="program.id">{{program.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.training_program_id"
                                        >
                                            {{ form.errors.training_program_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="trainer_id"
                                        class="col-sm-2 col-form-label"
                                        >Trainer</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.trainer_id" class="form-control" id="program">
                                            <option v-for="(trainer, pindex) in datas.trainers" 
                                            :key="pindex" :value="trainer.id">{{trainer.name}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.trainer_id"
                                        >
                                            {{ form.errors.trainer_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="from"
                                        class="col-sm-2 col-form-label"
                                        >From</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="from"
                                            placeholder="from"
                                            v-model="form.from"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.from"
                                        >
                                            {{ form.errors.from }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="to"
                                        class="col-sm-2 col-form-label"
                                        >To</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="to"
                                            placeholder="to"
                                            v-model="form.to"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.to"
                                        >
                                            {{ form.errors.to }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="budget"
                                        class="col-sm-2 col-form-label"
                                        >Badget</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="number"
                                            step="any"
                                            class="form-control"
                                            id="budget"
                                            placeholder="budget"
                                            v-model="form.budget"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.budget"
                                        >
                                            {{ form.errors.budget }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="venue"
                                        class="col-sm-2 col-form-label"
                                        >Venue</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="venue"
                                            placeholder="venue"
                                            v-model="form.venue"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.venue"
                                        >
                                            {{ form.errors.venue }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="level"
                                        class="col-sm-2 col-form-label"
                                        >Participant Level</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.level" class="form-control" id="program">
                                            <option v-for="(level, pindex) in datas.level" 
                                            :key="pindex" :value="level.value">{{level.title}}</option>
                                        </select>
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
                                        for="total_participant"
                                        class="col-sm-2 col-form-label"
                                        >Total Participant</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="number"
                                            min="0"
                                            class="form-control"
                                            id="total_participant"
                                            placeholder="total participant"
                                            v-model="form.total_participant"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.total_participant"
                                        >
                                            {{ form.errors.total_participant }}
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
                                        <select v-model="form.status" class="form-control" id="program">
                                            <option v-for="(status, pindex) in datas.status" 
                                            :key="pindex" :value="status.value">{{status.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.status"
                                        >
                                            {{ form.errors.status }}
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h5 class="card-title">Itinery Information</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Topic</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Duration</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(st, index) in form.category" :key="index">
                                            <td>
                                                <input type="date" v-model="form.category[index].idate" class="form-control" placeholder="Date" required>
                                            </td>
                                            <td>
                                                <input type="text" v-model="form.category[index].topic" class="form-control" placeholder="Topic" required>
                                            </td>
                                            <td>
                                                <input type="time" v-model="form.category[index].start_time" class="form-control" placeholder="Date" required>
                                            </td>
                                            <td>
                                                <input type="time" v-model="form.category[index].end_time" class="form-control" placeholder="Date" required>
                                            </td>
                                            <td>
                                                <input type="number" min="0" v-model="form.category[index].duration" class="form-control" placeholder="" required>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-danger" @click="removeCategory(index)"><i class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6" class="text-right">
                                                <button type="button" class="btn btn-sm btn-outline-primary" @click="addCategory"><i class="bi bi-plus"></i>  Add More</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <hr>
                                <h5 class="card-title">Publish Notice</h5>
                                <div class="row">
                                    <div class="col-md-6 form-group row mb-3">
                                        <label
                                            for="notice_date"
                                            class="col-sm-4 col-form-label"
                                            >Notice Date</label
                                        >
                                        <div class="col-sm-8">
                                            <input type="date" v-model="form.notice_date" class="form-control">
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.notice_date"
                                            >
                                                {{ form.errors.notice_date }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group row mb-3">
                                        <label
                                            for="submit_date"
                                            class="col-sm-4 col-form-label"
                                            >Submit Date</label
                                        >
                                        <div class="col-sm-8">
                                            <input type="date" v-model="form.submit_date" class="form-control">
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.submit_date"
                                            >
                                                {{ form.errors.submit_date }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="documentFile"
                                        class="col-sm-2 col-form-label"
                                        >Document</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="file"
                                            class="form-control"
                                            id="documentFile"
                                            @input="form.documentFile = $event.target.files[0]"
                                            accept="application/pdf,application/docx,application/doc"
                                        />
                                        <p v-if="training.notice.document != ''">
                                            <a :href="training.notice.document" target="_blank">Download</a>
                                        </p>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.documentFile"
                                        >
                                            {{ form.errors.documentFile }}
                                        </div>
                                    </div>
                                </div>
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
