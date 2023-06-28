<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";

const form = useForm();
const props = defineProps({
    documents: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("admin.documents.destroy", id));
    }
}
</script>
<template>
    <Head title="Document Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Document
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.documents.index')" :only="['documents']"> Document </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('admin.documents.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> Add New Document
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Document</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Document</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(doc, index) in documents.data"
                                :key="doc.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ doc.title }}</td>
                                <td scope="row">
                                    <a :href="doc.document" v-if="doc.document != ''">
                                        <img src="/images/pdf_icon.png" style="width: 50px">
                                    </a>
                                </td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('admin.documents.edit', doc.id)"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(doc.id)"
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
                                    <Pagination class="mt-6" :links="documents.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
