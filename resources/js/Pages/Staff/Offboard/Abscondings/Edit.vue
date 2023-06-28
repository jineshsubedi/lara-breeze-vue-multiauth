<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    absconding: Object,
    datas: Object
})

const form = useForm({
    user_id: props.absconding.user_id,
    follow_up_medium: props.absconding.follow_up_medium,
    follow_up_description: props.absconding.follow_up_description,
    follow_up_attachmentFile: null,
    issued_date: props.absconding.issued_date,
    previous_action: props.absconding.previous_action,
    action: props.absconding.action,
    action_type: props.absconding.action_type,
    suspension_days: props.absconding.suspension_days,
    penalty_charge: props.absconding.penalty_charge,
    description: props.absconding.description,
});
function submitForm()
{
    Inertia.post(route('staffs.abscondings.update', props.absconding.id), {
        _method: 'put',
        user_id: form.user_id,
        follow_up_medium: form.follow_up_medium,
        follow_up_description: form.follow_up_description,
        follow_up_attachmentFile: form.follow_up_attachmentFile,
        issued_date: form.issued_date,
        previous_action: form.previous_action,
        action: form.action,
        action_type: form.action_type,
        suspension_days: form.suspension_days,
        penalty_charge: form.penalty_charge,
        description: form.description,
    })
}
</script>
<template>
    <Head title="Absconding Edit" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Absconding Edit
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.abscondings.index')"> Absconding </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.abscondings.edit', absconding.id)"> Edit </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Edit Absconding</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    submitForm
                                "
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="user_id"
                                        class="col-sm-2 col-form-label"
                                        >Staff</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.user_id" id="user_id" class="form-control">
                                        <option v-for="(staff, sindex) in datas.staffs" :key="sindex" :value="staff.id">{{staff.name}}</option>
                                            
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.user_id"
                                        >
                                            {{ form.errors.user_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="issued_date"
                                        class="col-sm-2 col-form-label"
                                        >Issued Date</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="issued_date"
                                            placeholder="issued_date"
                                            v-model="form.issued_date"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.issued_date"
                                        >
                                            {{ form.errors.issued_date }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="previous_action"
                                        class="col-sm-2 col-form-label"
                                        >Previous Action (If Anny)</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.previous_action" id="previous_action" class="form-control">
                                        <option v-for="(act, aindex) in datas.actions" :key="aindex" :value="act.value">{{act.title}}</option>
                                            
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.previous_action"
                                        >
                                            {{ form.errors.previous_action }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="action"
                                        class="col-sm-2 col-form-label"
                                        >Action</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.action" id="action" class="form-control">
                                        <option v-for="(act, aindex) in datas.actions" :key="aindex" :value="act.value">{{act.title}}</option>
                                            
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.action"
                                        >
                                            {{ form.errors.action }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="action_type"
                                        class="col-sm-2 col-form-label"
                                        >Action</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.action_type" id="action_type" class="form-control">
                                        <option v-for="(act, aindex) in datas.action_types" :key="aindex" :value="act.value">{{act.title}}</option>
                                            
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.action_type"
                                        >
                                            {{ form.errors.action_type }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3" v-if="form.action_type == 1">
                                    <label
                                        for="suspension_days"
                                        class="col-sm-2 col-form-label"
                                        >Suspension Days</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="suspension_days"
                                            placeholder="suspension_days"
                                            v-model="form.suspension_days"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.suspension_days"
                                        >
                                            {{ form.errors.suspension_days }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3" v-if="form.action_type == 2">
                                    <label
                                        for="penalty_charge"
                                        class="col-sm-2 col-form-label"
                                        >Penalty Charge</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="number"
                                            any="2"
                                            class="form-control"
                                            id="penalty_charge"
                                            placeholder="penalty_charge"
                                            v-model="form.penalty_charge"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.penalty_charge"
                                        >
                                            {{ form.errors.penalty_charge }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="description"
                                        class="col-sm-2 col-form-label"
                                        >Description</label
                                    >
                                    <div class="col-sm-10">
                                        <textarea rows="5" v-model="form.description" class="form-control" id="description"></textarea>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.description"
                                        >
                                            {{ form.errors.description }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="follow_up_medium"
                                        class="col-sm-2 col-form-label"
                                        >Communication</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.follow_up_medium" id="follow_up_medium" class="form-control">
                                        <option v-for="(media, mindex) in datas.communication" :key="mindex" :value="media.value">{{media.title}}</option>
                                            
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.follow_up_medium"
                                        >
                                            {{ form.errors.follow_up_medium }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="follow_up_description"
                                        class="col-sm-2 col-form-label"
                                        >Follow Up Detail</label
                                    >
                                    <div class="col-sm-10">
                                        <textarea rows="5" v-model="form.follow_up_description" class="form-control" id="follow_up_description"></textarea>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.follow_up_description"
                                        >
                                            {{ form.errors.follow_up_description }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="follow_up_attachmentFile"
                                        class="col-sm-2 col-form-label"
                                        >Attachment</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="file"
                                            class="form-control"
                                            id="follow_up_attachmentFile"
                                            @input="form.follow_up_attachmentFile = $event.target.files[0]"
                                        />
                                        <a :href="absconding.follow_up_attachment" v-if="absconding.follow_up_attachment != null" target="_blank">View</a>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.follow_up_attachmentFile"
                                        >
                                            {{ form.errors.follow_up_attachmentFile }}
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
    </StaffLayout>
</template>
