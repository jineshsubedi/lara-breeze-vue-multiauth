<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import axios from "axios";

const props = defineProps({
    datas: Object,
    formdata: Object,
})

let form_datas = ref(props.datas.forms);
let label_options = ref([]);
let term = ref('');
let isOpen = ref(false);
const tempForm = useForm({
    parent_id: 0,
    f_lable: null,
    f_type: null,
    list_menu: null,
    required: null,
    marks: null,
    extra: null,
})
function getSuggestionList()
{
    axios.post(route('admin.jobs.autocomplete'), 
        {
            term: term.value
        }
    )
    .then(res => {
        isOpen = true
        label_options = ref(res.data)
    }).catch(err => {
        isOpen = false
        console.log(err)
    })
}
function setResult(label)
{
    tempForm.parent_id = label.value
    term.value = label.title
    isOpen = false
} 
function submitForm()
{
    axios.post(route('admin.jobs.addJobForm'), 
        {
            parent_id: tempForm.parent_id,
            f_lable: tempForm.f_lable,
            f_type: tempForm.f_type,
            list_menu: tempForm.list_menu,
            required: tempForm.required,
            marks: tempForm.marks,
            extra: tempForm.extra,
        }
    )
    .then(res => {
        resetForm();
        form_datas.value = res.data
    }).catch(err => {
        
    })
}
function removeTempForm(id, index)
{
    axios.post(route('admin.jobs.deleteJobForm'), 
        {
            id: id
        }
    )
    .then(res => {
        form_datas.value.splice(index, 1)
    }).catch(err => {
        
    })
}
function removeForm(id, index)
{
    axios.post(route('admin.jobs.deleteForm'), 
        {
            id: id
        }
    )
    .then(res => {
        props.formdata.value.splice(index, 1)
    }).catch(err => {
        
    })
}
function resetForm()
{
    term.value = "";
    tempForm.reset();
}
</script>
<template>
    <div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Parent</th>
                    <th>Label</th>
                    <th>Input Type</th>
                    <th>Options</th>
                    <th>Required</th>
                    <th>Marks</th>
                    <th>Extra</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(fmdata, fmdindex) in formdata" :key="fmdindex">
                    <td>{{ fmdata.parent }}</td>
                    <td>{{ fmdata.f_lable }}</td>
                    <td>{{ fmdata.f_type }}</td>
                    <td>{{ fmdata.list_menu }}</td>
                    <td>{{ fmdata.require }}</td>
                    <td>{{ fmdata.marks }}</td>
                    <td>{{ fmdata.extra }}</td>
                    <td>
                        <button
                            type="button"
                            class="btn btn-sm btn-outline-danger"
                            @click="removeForm(fmdata.id, fdindex)"
                        >
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                <tr v-for="(fdata, fdindex) in form_datas" :key="fdindex">
                    <td>{{ fdata.parent }}</td>
                    <td>{{ fdata.f_lable }}</td>
                    <td>{{ fdata.f_type }}</td>
                    <td>{{ fdata.list_menu }}</td>
                    <td>{{ fdata.require }}</td>
                    <td>{{ fdata.marks }}</td>
                    <td>{{ fdata.extra }}</td>
                    <td>
                        <button
                            type="button"
                            class="btn btn-sm btn-outline-danger"
                            @click="removeTempForm(fdata.id, fdindex)"
                        >
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td>
                        <input
                            type="text"
                            v-model="term"
                            class="form-control"
                            @input="getSuggestionList"
                        />
                        <ul
                            id="autocomplete-results"
                            v-show="isOpen"
                            class="autocomplete-results"
                        >
                            <li
                                v-for="(label, i) in label_options"
                                :key="i"
                                @click="setResult(label)"
                                class="autocomplete-result"
                            >
                                {{ label.title }}
                            </li>
                        </ul>
                        <div
                            class="text-red-400 text-sm"
                            v-if="tempForm.errors.parent_id"
                        >
                            {{ tempForm.errors.parent_id }}
                        </div>
                    </td>
                    <td>
                        <input
                            type="text"
                            v-model="tempForm.f_lable"
                            class="form-control"
                        />
                        <div
                            class="text-red-400 text-sm"
                            v-if="tempForm.errors.f_lable"
                        >
                            {{ tempForm.errors.f_lable }}
                        </div>
                    </td>
                    <td>
                        <select v-model="tempForm.f_type" class="form-control">
                            <option
                                v-for="(type, tindex) in datas.form_type"
                                :key="tindex"
                                :value="type.value"
                            >
                                {{ type.title }}
                            </option>
                        </select>
                        <div
                            class="text-red-400 text-sm"
                            v-if="tempForm.errors.f_type"
                        >
                            {{ tempForm.errors.f_type }}
                        </div>
                    </td>
                    <td>
                        <input
                            type="text"
                            v-model="tempForm.list_menu"
                            class="form-control"
                        />
                        <div
                            class="text-red-400 text-sm"
                            v-if="tempForm.errors.list_menu"
                        >
                            {{ tempForm.errors.list_menu }}
                        </div>
                    </td>
                    <td>
                        <select
                            v-model="tempForm.required"
                            class="form-control"
                        >
                            <option
                                v-for="(required, rindex) in datas.required"
                                :key="rindex"
                                :value="required.value"
                            >
                                {{ required.title }}
                            </option>
                        </select>
                        <div
                            class="text-red-400 text-sm"
                            v-if="tempForm.errors.required"
                        >
                            {{ tempForm.errors.required }}
                        </div>
                    </td>
                    <td>
                        <input
                            type="text"
                            v-model="tempForm.marks"
                            class="form-control"
                        />
                        <div
                            class="text-red-400 text-sm"
                            v-if="tempForm.errors.marks"
                        >
                            {{ tempForm.errors.marks }}
                        </div>
                    </td>
                    <td>
                        <input
                            type="text"
                            v-model="tempForm.extra"
                            class="form-control"
                        />
                        <div
                            class="text-red-400 text-sm"
                            v-if="tempForm.errors.extra"
                        >
                            {{ tempForm.errors.extra }}
                        </div>
                    </td>
                    <td class="btn-group">
                        <button
                            type="button"
                            class="btn btn-sm btn-outline-danger"
                            @click="resetForm()"
                        >
                            <i class="bi bi-x-lg"></i>
                        </button>
                        <button
                            type="button"
                            class="btn btn-sm btn-outline-success"
                            @click="submitForm()"
                        >
                            <i class="bi bi-person-check"></i>
                        </button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</template>
