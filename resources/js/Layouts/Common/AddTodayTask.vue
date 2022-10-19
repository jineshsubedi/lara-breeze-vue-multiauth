<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
const props = defineProps({
    url: String
})
const form = useForm({
    work_date: null,
    start_time: null,
    end_time: null,
    kra: null,
    description: null,
});

</script>

<template>
    <div class="modal fade" id="todayTaskModal" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daily Task Modal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="needs-validation" @submit.prevent="form.post(url)" >
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="workdate" class="form-label">Work Date</label>
                            <input type="date" class="form-control" id="workdate" max="" v-model="form.work_date" >
                            <div
                                class="text-red-400 text-sm"
                                v-if="form.errors.work_date"
                            >
                                {{ form.errors.work_date }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="startTime" class="form-label">Start Time</label>
                            <input type="time" class="form-control" id="startTime" v-model="form.start_time" >
                            <div
                                class="text-red-400 text-sm"
                                v-if="form.errors.start_time"
                            >
                                {{ form.errors.start_time }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="endTime" class="form-label">End Time</label>
                            <input type="time" class="form-control" id="endTime" v-model="form.end_time" >
                            <div
                                class="text-red-400 text-sm"
                                v-if="form.errors.end_time"
                            >
                                {{ form.errors.end_time }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="validationCustomUsername" class="form-label">KRA</label>
                            <select class="form-control" id="kra" v-model="form.kra" >
                                <option value="">Select Kra</option>
                                <option value="1">One</option>
                            </select>
                            <div
                                class="text-red-400 text-sm"
                                v-if="form.errors.kra"
                            >
                                {{ form.errors.kra }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" rows="5" v-model="form.description"></textarea>
                            <div
                                class="text-red-400 text-sm"
                                v-if="form.errors.description"
                            >
                                {{ form.errors.description }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-primary">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</template>