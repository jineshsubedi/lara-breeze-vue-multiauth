<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import CenterModal from "@/Components/CenterModal.vue";

const form = useForm();
const aForm = useForm({
    attach : []
});

const props = defineProps({
    materials: {
        type: Object,
        default: () => ({}),
    },
    training: Object,
    can: Array
});
let SuperAdmin = props.can.includes('SuperAdmin');
let TrainingHandler = props.can.includes('TrainingHandler');

function  destroy(id, training_id) {
    if (confirm("Are you sure?")) {
        form.delete(route("admin.trainings.deleteMaterials", [training_id, id]));
    }
}
function addCategory()
{
    aForm.attach.push({'attachmentFile' : '', 'title': ''});
}
function removeCategory(index)
{
    aForm.attach.splice(index, 1)
}
function addMoreAttachmentModal()
{
    $('#addMoreAttachmentModal').modal('show');
}
function handleAddMoreAttachmentModal()
{
    aForm.reset();
    $('#addMoreAttachmentModal').modal('hide');
}
</script>
<template>
    <Head title="Training Attachment Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Training Attachment
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.trainings.index')" :only="['trainings']"> Training </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.trainings.getMaterials', training.id)" :only="['materials']"> Training Attachment </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <button type="button" class="btn btn-sm btn-outline-primary" @click="addMoreAttachmentModal">Add More Attachment</button>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Training Attachment</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Attachment</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(material, index) in materials.data"
                                :key="material.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ material.title }}</td>
                                <td scope="row">
                                    <span v-if="(material.extension == 'png' || material.extension == 'jpg' || material.extension == 'jpeg' || material.extension == 'webp') && material.attachment != ''">
                                        <a :href="material.attachment" target="_blank_"><img :src="material.attachment" style="width:100px;"></a>
                                    </span>
                                    <span v-if="(material.extension == 'pdf' || material.extension == 'docx' || material.extension == 'doc' || material.extension == 'xlsx'|| material.extension == 'xls') && material.attachment != ''">
                                        <a :href="material.attachment" target="_blank_"><img src="/images/pdf_icon.png" style="width:100px;"></a>
                                    </span>
                                </td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(material.id, material.training_id)"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">
                                    <Pagination class="mt-6" :links="materials.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <CenterModal
                    :id="'addMoreAttachmentModal'"
                    title="Training Attachment Form"
                >
                    <form
                        class="form-horizontal"
                        @submit.prevent="
                            aForm.post(route('admin.trainings.saveMaterials', training.id),{
                                preserveScroll: true,
                                onSuccess: () => handleAddMoreAttachmentModal()
                            })
                        "
                        enctype="multipart/form-data"
                    >
                        <div class="form-group mb-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Attachment</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(st, index) in aForm.attach" :key="index">
                                        <td>
                                            <input type="text" v-model="aForm.attach[index].title" class="form-control" required>
                                        </td>
                                        <td>
                                            <input type="file" @input="aForm.attach[index].attachmentFile = $event.target.files[0]" class="form-control" accept="image/png, image/gif, image/jpeg, application/pdf, application/docx, application/xlsx, application/xls, application/doc" required>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-danger" @click="removeCategory(index)"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-right">
                                            <button type="button" class="btn btn-sm btn-outline-primary" @click="addCategory"><i class="bi bi-plus"></i>  Add More</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
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
    </AdminLayout>
</template>
