<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    training: Object,
    template: Object,
    category: Object,
    datas: Object,
})

const form = useForm({
    training_id: props.training.id,
    title: props.template.title,
    description: props.template.description,
    share_with: props.template.share_with,
    schedule: props.template.schedule,
    schedule_date: props.template.schedule_date,
    schedule_end_date: props.template.schedule_end_date,

    category: props.category,
});

function addCategory()
{
    form.category.push({'question' : '', 'type': '', 'list_menu': '', 'mandatory': 1, 'order': 1});
}
function removeCategory(index)
{
    form.category.splice(index, 1)
}
</script>
<template>
    <Head title="Training Template Edit" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Training Template Edit
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
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
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.trainings.template.edit', [training.id, template.id])"> Edit </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New Template</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.put(route('staffs.trainings.template.update', [training.id, template.id]))
                                "
                            >
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
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.title"
                                        >
                                            {{ form.errors.title }}
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
                                <div class="form-group row mt-3 mb-3">
                                    <label
                                        for="share_with"
                                        class="col-sm-2 col-form-label"
                                        >Share With</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.share_with" class="form-control" id="share_with">
                                            <option v-for="(share, sindex) in datas.share" :key="sindex" :value="share.value">{{share.title}}</option>
                                            
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.share_with"
                                        >
                                            {{ form.errors.share_with }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mt-3 mb-3">
                                    <label
                                        for="schedule"
                                        class="col-sm-2 col-form-label"
                                        >Schedule</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.schedule" class="form-control" id="schedule">
                                            <option v-for="(req, rindex) in datas.required" :key="rindex" :value="req.value">{{req.title}}</option>
                                            
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.schedule"
                                        >
                                            {{ form.errors.schedule }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3" v-if="form.schedule == 1">
                                    <label
                                        for="schedule_date"
                                        class="col-sm-2 col-form-label"
                                        >Start Date</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="schedule_date"
                                            placeholder="schedule_date"
                                            v-model="form.schedule_date"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.schedule_date"
                                        >
                                            {{ form.errors.schedule_date }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3" v-if="form.schedule == 1">
                                    <label
                                        for="schedule_end_date"
                                        class="col-sm-2 col-form-label"
                                        >End Date</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="schedule_end_date"
                                            placeholder="schedule_end_date"
                                            v-model="form.schedule_end_date"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.schedule_end_date"
                                        >
                                            {{ form.errors.schedule_end_date }}
                                        </div>
                                    </div>
                                </div>

                                <h5 class="card-title">Question Section</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Question</th>
                                            <th>Type</th>
                                            <th>List Option</th>
                                            <th>Mandatory</th>
                                            <th>Order</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(st, index) in form.category" :key="index">
                                            <td>
                                                <input type="text" v-model="form.category[index].question" class="form-control" placeholder="question" required>
                                            </td>
                                            <td>
                                                <select v-model="form.category[index].type" class="form-control" required>
                                                    <option v-for="(type, tindex) in datas.types" :key="tindex" :value="type.value">{{type.title}}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" v-model="form.category[index].list_menu" class="form-control" placeholder="Yes,No">
                                            </td>
                                            <td>
                                                <select v-model="form.category[index].mandatory" class="form-control" required>
                                                    <option v-for="(req, rindex) in datas.required" :key="rindex" :value="req.value">{{req.title}}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" min="0" v-model="form.category[index].order" class="form-control" placeholder="question" required>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-danger" @click="removeCategory(index)"><i class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5">
                                                <div class="text-danger" v-for="(form) in form.errors.category">
                                                    {{form}}
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <button type="button" class="btn btn-sm btn-outline-primary" @click="addCategory"><i class="bi bi-plus"></i>  Add More</button>
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
    </StaffLayout>
</template>
