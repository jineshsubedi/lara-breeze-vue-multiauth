<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import axios from "axios";
import PDFGenerator from "@/Components/PdfGenerator.vue"

const props = defineProps({
    staffs: Object,
    letters: Object,
})

const form = useForm({
    letter_id: null,
    staff_id: null,
    description: null,
    pdfFile: null,
});

const pdfForm = useForm({
    staff_id: null,
    pdfFile: null,
})

let descriptionEditor = ref(false);
let pdfBool = ref(false);
let quill = ref(null)
function loadEditor()
{
    if(form.letter_id != null && form.staff_id != null)
    {
        axios.post(route('admin.letters.generation'), 
            {
                letter_id: form.letter_id,
                staff_id: form.staff_id,
            }
        )
        .then(res => {
            pdfForm.staff_id = form.staff_id
            form.description = res.data
            quill.value.setHTML(form.description)
            pdfBool.value = true;
        }).catch(err => {
            console.log(err)
        })
    }
}
function changeFile(data) {
    pdfForm.pdfFile = data.pdf_file;
    descriptionEditor.value = true;
}

</script>
<template>
    <Head title="Generate Staff Letters" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Generate Staff Letters
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.letters.index')"> Letter </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.letters.generate')"> Generate Staff Letters </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New Letter</h5>
                            <!-- <form
                                class="form-horizontal"
                                @submit.prevent="
                                    pdfForm.post(route('admin.letters.saveGenerate'))
                                "
                            > -->
                                <div class="form-group row mb-3">
                                    <label
                                        for="letter_id"
                                        class="col-sm-2 col-form-label"
                                        >Letter</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.letter_id" class="form-control" id="letter_id" @change="loadEditor()">
                                            <option v-for="(letter, bindex) in letters" :key="bindex" :value="letter.id">{{letter.type ? letter.type.title : ''}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.letter_id"
                                        >
                                            {{ form.errors.letter_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="staff_id"
                                        class="col-sm-2 col-form-label"
                                        >Staff</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.staff_id" class="form-control" id="staff_id" @change="loadEditor()">
                                            <option v-for="(staff, bindex) in staffs" :key="bindex" :value="staff.id">{{staff.name}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.staff_id"
                                        >
                                            {{ form.errors.staff_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-10">
                                    <label
                                        for="staff_id"
                                        class="col-sm-2 col-form-label"
                                        >Detail Information</label
                                    >
                                    <div class="col-sm-10">
                                        <QuillEditor v-model:content="form.description" id="description" class="form-control" contentType="html" theme="snow" toolbar="full" ref="quill"/>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.descirption"
                                        >
                                            {{ form.errors.descirption }}
                                        </div>
                                    </div>
                                </div>
                                <div v-if="pdfBool">
                                    <PDFGenerator :description="form.description" v-on:changeFile="changeFile"/>
                                </div>
                                <div class="form-group row mt-10 mb-3" v-if="descriptionEditor">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button
                                            type="submit"
                                            class="btn btn-outline-primary btn-sm"
                                        >
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            <!-- </form> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
<style scoped>
.mt-10{margin-top: 80px;}
.mb-10{margin-bottom: 80px;}
</style>