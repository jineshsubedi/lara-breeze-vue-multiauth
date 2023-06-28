<script setup>
    import { useForm } from '@inertiajs/inertia-vue3';
    import LargeModal from "@/Components/LargeModal.vue";
    import axios from "axios";
    
    const props = defineProps({
        performance_rating: Boolean,
        url: String,
        staffs: Object,
    });
    const form = useForm({
        user_id: null,
        comment: null,
        comment_rating: null,
        action: 'submit'
    });
    $(document).ready(function(){
        openPerformanceRating()
    })
    function openPerformanceRating()
    {
        $('#performance_rating').modal('show');
    }
    function closePerformanceRating()
    {
        $('#performance_rating').modal('hide');
    }
    function submitPerformanceRating()
    {
        axios
        .post(props.url, {
            user_id: form.user_id,
            comment: form.comment,
            comment_rating: form.comment_rating,
            action: form.action,
        })
        .then((res) => {
            closePerformanceRating()
            Toast.fire({
                icon: "success",
                title: "Form Submitted"
            })
        })
        .catch((err) => {
            console.log(err);
            Toast.fire({
                icon: "error",
                title: err.response.data.message
            })
        });
    }
    function cancelStaffPerfromance()
    {
        form.action = 'cancel'
        submitPerformanceRating()
    }
    function cancelAllRating()
    {
        form.action = 'cancel-all'
        submitPerformanceRating()
    }

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
</script>
<template>
    <div>
        <LargeModal id="performance_rating" title="Comment SubOrdinate Rating">
            <form
                class="form-horizontal"
                @submit.prevent="
                    submitPerformanceRating()
                "
            >
                <div class="form-group row mb-3">
                    <label
                        for="user_id"
                        class="col-sm-4 col-form-label"
                        >SubOrdinate</label
                    >
                    <div class="col-sm-8">
                        <select v-model="form.user_id" id="user_id" class="form-control">
                            <option v-for="(staff, sindex) in staffs" :key="sindex" :value="staff.id">{{staff.name}}</option>
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
                        for="comment"
                        class="col-sm-4 col-form-label"
                        >comment</label
                    >
                    <div class="col-sm-8">
                        <textarea rows="3" v-model="form.comment" class="form-control"></textarea>
                        <div
                            class="text-red-400 text-sm"
                            v-if="form.errors.comment"
                        >
                            {{ form.errors.comment }}
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label
                        for="comment_rating"
                        class="col-sm-4 col-form-label"
                        >Comment Rating (Out of 10)</label
                    >
                    <div class="col-sm-8">
                        <input
                            type="number"
                            class="form-control"
                            id="comment_rating"
                            min="1"
                            max="10"
                            v-model="form.comment_rating"
                        />
                        <div
                            class="text-red-400 text-sm"
                            v-if="form.errors.comment_rating"
                        >
                            {{ form.errors.comment_rating }}
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button
                        type="button"
                        class="btn btn-outline-warning btn-sm"
                        @click="cancelAllRating()"
                    >
                        Cancel All
                    </button>&nbsp;
                    <button
                        type="button"
                        class="btn btn-outline-danger btn-sm"
                        @click="cancelStaffPerfromance()"
                    >
                        Staff Cancel
                    </button>&nbsp;
                    <button
                        type="submit"
                        class="btn btn-outline-primary btn-sm"
                    >
                        Submit
                    </button>
                </div>
            </form>
        </LargeModal>
    </div>
</template>