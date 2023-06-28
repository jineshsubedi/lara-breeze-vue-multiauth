<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";
import CenterModal from "@/Components/CenterModal.vue";
import LargeModal from "@/Components/LargeModal.vue";
import { ref, watch } from "vue";
import axios from "axios";
import moment from 'moment';

const props = defineProps({
    auth: Boolean,
    category: Object,
    staffs: Object
});

const createForm = useForm({
    description: '',
    imageFile: '',
    video: '',
    event: '',
    event_category: '',
});

const commentForm = useForm({
    description: ''
});

const form = useForm();

const previewUrl = ref(null);
const videoUrl = ref(null);
const fileInput = ref(null);
let feeds = ref([]);
let page = ref(1);
let nextpage = ref(false)

function uploadPictureBtn()
{
    $('#imageUpload').trigger('click');
}
function uploadVideoBtn()
{
    $('#YoutubeVideoUploader').modal('show');
}
function closeUploadVideoBtn()
{
    $('#YoutubeVideoUploader').modal('hide');
    filterVideoId();
}
function filterVideoId()
{
    let ID = '';
    var url = createForm.video;
    url = url.replace(/(>|<)/gi,'').split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
    if(url[2] !== undefined) {
        ID = url[2].split(/[^0-9a-z_\-]/i);
        ID = ID[0];
        videoUrl.value = '//www.youtube.com/embed/'+ID;
    }
    else {
        alert('error url')
    }
}
function previewImage()
{
    const file = fileInput.value.files[0];
    const reader = new FileReader();

    reader.onload = () => {
        previewUrl.value = reader.result;
    };

    reader.readAsDataURL(file);
}
function resetForm()
{
    page.value = 1;
    createForm.reset();
    previewUrl.value = null;
    videoUrl.value = null;
    loadFilter()
}

function humanTime(value)
{
    return moment(value).fromNow();
}

loadFilter()
function loadFilter() {
    axios
        .get(route("admin.newsfeeds.getall"), {
            params: {
                page: page.value,
            },
        })
        .then((res) => {
            feeds.value = res.data.data
            if(res.data.next_page_url != null)
                nextpage.value = true;
            else
                nextpage.value = false;
        })
        .catch((err) => {
            console.log(err);
        });
}
function loadMoreFeed()
{
    page.value++;
    axios
        .get(route("admin.newsfeeds.getall"), {
            params: {
                page: page.value,
            },
        })
        .then((res) => {
            feeds.value.push(...res.data.data)
            if(res.data.next_page_url != null)
                nextpage.value = true;
            else
                nextpage.value = false;
        })
        .catch((err) => {
            console.log(err);
        });
}
function destroy(id, index)
{
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("admin.newsfeeds.destroy", id), {
            preserveScroll: true,
            onSuccess: () => removeContent(index)
        });
    }
}
function destroyComment(id, cindex, fid)
{
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("admin.newsfeeds.deleteComment", id), {
            preserveScroll: true,
            onSuccess: () => removeCommentContent(cindex, fid)
        });
    }
}
function removeContent(index)
{
    feeds.value.splice(index, 1)
}
function removeCommentContent(cindex, fid)
{
    loadFilter()
}
function resetCommentForm()
{
    commentForm.reset();
    loadFilter()
}
function toggleUserLike(id)
{
    axios
        .get(route("admin.newsfeeds.hitlike", id), {
            params: {
                page: page.value,
            },
        })
        .then((res) => {
            loadFilter()
        })
        .catch((err) => {
            console.log(err);
        });
}
function toggleCommentBox(id)
{
    $('#commentSection-'+id).toggle();
    $('.commentSection').not('#commentSection-'+id).hide();
}
const eventForm = useForm({
    description: null,
    to_staff: null,
    event_category: null,
});
function lifeEventBtn()
{
    $('#lifeEventModel').modal('show');
}
function closeLifeEventBtn()
{
    page.value = 1;
    loadFilter()
    $('#lifeEventModel').modal('hide');
    eventForm.reset();
}
function resetEventForm()
{
    eventForm.reset();
}
</script>
<template>
    <div>
        <div class="card">
            <form 
                class="form-horizontal"
                @submit.prevent="
                    createForm.post(route('admin.newsfeeds.store'), {
                        preserveScroll: true,
                        onSuccess: () => resetForm()
                    })
                "
            >
                <div class="card-header">
                    <div class="d-flex justify-content-evenly">
                        <p>
                            <a
                                href="#"
                                id="uploadPictureBtn"
                                @click="uploadPictureBtn"
                            >
                                <i class="bi bi-image"></i>
                                Photo
                            </a>
                        </p>
                        |
                        <p>
                            <a 
                                href="#" 
                                id="uploadVideoBtn"
                                @click="uploadVideoBtn"
                            >
                                <i class="bi bi-youtube"></i>
                                Video
                            </a>
                        </p>
                        |
                        <p>
                            <a
                                href="#"
                                id="lifeEventBtn"
                                v-if="auth"
                                @click="lifeEventBtn"
                            >
                                <i class="bi bi-flag"></i>
                                Event
                            </a>
                        </p>
                    </div>
                </div>
                <div class="card-body row">
                    <div class="col-md-12 mt-3">
                        <textarea
                            rows="3"
                            class="form-control"
                            v-model="createForm.description"
                            placeholder="What's on your mind?"
                        ></textarea>
                    </div>
                    <div class="mt-3 col-md-12">
                        <input
                            type="file"
                            @input="createForm.imageFile = $event.target.files[0]"
                            ref="fileInput"
                            id="imageUpload"
                            accept="image/*"
                            @change="previewImage"
                            style="display: none"
                        />
                        <input
                            type="text"
                            name="video"
                            id="videoUrl"
                            style="display: none"
                        />
                        <div v-if="previewUrl" >
                            <img
                                style="width: 50%"
                                id="blah"
                                :src="previewUrl"
                            />
                            <div
                                class="text-red-400 text-sm"
                                v-if="createForm.errors.imageFile"
                            >
                                {{ createForm.errors.imageFile }}
                            </div>
                        </div>
                        <div v-if="videoUrl != null" id="videoblah">
                            <iframe width="100%" height="350" :src="videoUrl" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="button" class="btn btn-sm btn-outline-danger" @click="resetForm">
                        <i class="bi bi-x-lg"></i> Reset
                    </button>&nbsp;
                    <button type="submit" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-send"></i> Submit
                    </button>
                </div>
            </form>
            <CenterModal
                :id="'YoutubeVideoUploader'"
                title="Youtube Video Uploader"
            >
                <div class="form-group row">
                    <div class="col-md-10">
                        <input type="text" v-model="createForm.video" class="form-control"  placeholder="https://www.youtube.com/watch?v=yfp6DwGvDrc">
                    </div>
                    <div class="col-md-2">
                        <button type="button" @click="closeUploadVideoBtn" class="btn btn-info">Done</button>
                    </div>
                </div>
            </CenterModal>
            <LargeModal
                :id="'lifeEventModel'"
                title="Events"
            >
            <form 
                class="form-horizontal"
                @submit.prevent="
                    eventForm.post(route('admin.newsfeeds.event'), {
                        preserveScroll: true,
                        onSuccess: () => closeLifeEventBtn()
                    })
                "
            >
                <img src="/images/life_event.jpg" style="width:100%">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mt-3 form-group row mb-3">
                            <label
                                for="event_category"
                                class="col-sm-4 col-form-label"
                                >Event</label
                            >
                            <div class="col-sm-8">
                                <select v-model="eventForm.event_category" id="event_category" class="form-control">
                                    <option v-for="(cat, cindex) in category" :key="cindex" :value="cat.value">{{cat.title}}</option>
                                </select>
                                <div
                                    class="text-red-400 text-sm"
                                    v-if="eventForm.errors.event_category"
                                >
                                    {{ eventForm.errors.event_category }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-3 form-group row mb-3">
                            <label
                                for="to_staff"
                                class="col-sm-4 col-form-label"
                                >Staff</label
                            >
                            <div class="col-sm-8">
                                <select v-model="eventForm.to_staff" id="to_staff" class="form-control">
                                    <option v-for="(staff, cindex) in staffs" :key="cindex" :value="staff.id">{{staff.name}}</option>
                                </select>
                                <div
                                    class="text-red-400 text-sm"
                                    v-if="eventForm.errors.to_staff"
                                >
                                    {{ eventForm.errors.to_staff }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3 form-group row mb-3">
                    <label
                        for="description"
                        class="col-sm-2 col-form-label"
                        >Description</label
                    >
                    <div class="col-sm-10">
                        <textarea rows="3" v-model="eventForm.description" class="form-control"></textarea>
                        <div
                            class="text-red-400 text-sm"
                            v-if="eventForm.errors.description"
                        >
                            {{ eventForm.errors.description }}
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger" @click="resetEventForm">
                        <i class="bi bi-x-lg"></i> Reset
                    </button>&nbsp;
                    <button type="submit" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-send"></i> Submit
                    </button>
                </div>
            </form>
            </LargeModal>
        </div>


        <div class="mt-3 mb-3" v-if="feeds.length > 0" v-for="(feed, findex) in feeds" :key="findex">
            <div class="post" >
                <div class="post-header">
                    <div class="post-tool" v-if="feed.user.id == $page.props.auth.user.id" @click="destroy(feed.id, findex)">
                        <i class="bi bi-x-lg"></i>
                    </div>
                    <div class="d-flex">
                        <img :src="feed.user.avatar_path" :alt="feed.user.name" />
                        <div class="post-header-info">
                            <h3>{{feed.user.name}}</h3>
                            <p>
                                <span class="post-date">{{humanTime(feed.created_at)}}</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mb-3 post-body" v-if="feed.event == null">
                    <p class="text-justify" v-if="feed.description" v-html="feed.description"></p>
                    <img v-if="feed.image" :src="feed.image" :alt="feed.user.name" style="width:100%" />
                    <div class="mt-3" v-if="feed.video">
                        <iframe width="100%" height="300px" :src="feed.video" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="mb-3 post-body" v-else>
                    <span v-html="feed.event"></span>
                </div>
                <div class="post-footer">
                    <button class="like-button" @click="toggleUserLike(feed.id)"><span>{{feed.like_count}}</span> Like</button>
                    <button class="comment-button" @click="toggleCommentBox(feed.id)"><span>{{feed.comment_count}}</span> Comment</button>
                    <div class="mt-3 commentSection" :id="'commentSection-'+feed.id" style="display:none;">
                        <div class="comments-list">
                            <div class="comment" v-for="(comment, cindex) in feed.comment" :key="cindex">
                                <div class="post-tool" v-if="feed.user.id == $page.props.auth.user.id" @click="destroyComment(comment.id, cindex, feed.id)">
                                    <i class="bi bi-x-lg"></i>
                                </div>
                                <div class="comment-author">
                                    <img :src="comment.user.avatar_path" :alt="comment.user.name">
                                    <h4>{{comment.user.name}} <br> 
                                        <span class="text-muted">{{humanTime(comment.created_at)}}</span>
                                    </h4>
                                </div>
                                <p class="comment-text" v-html="comment.description"></p>
                            </div>
                        </div>

                        <div class="comment-reply-box">
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    commentForm.post(route('admin.newsfeeds.comment', feed.id), {
                                        preserveScroll: true,
                                        onSuccess: () => resetCommentForm()
                                    })
                                "
                            >
                                <textarea v-model="commentForm.description" placeholder="Write a reply..."></textarea>
                                <button type="submit">Reply</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="post-body">
                <p class=" mt-3 mb-3 text-center">
                    No NewsFeed Found!
                </p>
            </div>
        </div>
        <div v-if="nextpage">
            <div class="card">
                <p class="mt-3 mb-3 text-center" @click="loadMoreFeed()" style="cursor:pointer;">
                    Load More <i class="bi bi-chevron-double-down"></i>
                </p>
            </div>
        </div>
        
    </div>
</template>
<style>
.post {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    background-color: #fff;
}

.post-header img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 10px;
}

.post-header h3 {
    margin: 0;
    font-size: 18px;
}

.post-header p {
    margin: 0;
    font-size: 14px;
    color: #999;
}

.post-header .post-date {
    color: #333;
}

.post-body img {
    width: 100%;
    max-height: 500px;
    margin-top: 10px;
}

.post-footer button {
    border: none;
    background-color: transparent;
    color: #999;
    margin-right: 10px;
    font-size: 14px;
    cursor: pointer;
}

.post-footer button:hover {
    color: #333;
}
.post-tool{
    float:right;
}
.post-tool:hover{
    color: red;
    font-size: 20px;
    cursor: pointer;
}

<!-- comment  -->
.comment-reply-box {
  margin-top: 16px;
}

.comment-reply-box form {
  display: flex;
  flex-direction: column;
}

.comment-reply-box textarea {
  height: 64px;
  margin-bottom: 8px;
  padding: 8px;
  font-size: 16px;
  line-height: 1.5;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.comment-reply-box button {
  align-self: flex-end;
  padding: 6px 12px;
  font-weight: bold;
  text-transform: uppercase;
  color: #fff;
  background-color: #4267b2;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.comment-reply-box button:hover {
  background-color: #385898;
}

.comments-list {
  margin-top: 16px;
}

.comment {
    flex-direction: column;
    padding: 6px;
    border-bottom: 1px solid #e5e5e5;
    background-color: #f5f5f5;
    border-radius: 4px;
}

.comment-author {
  display: flex;
  align-items: center;
  margin-bottom: 8px;
}

.comment-author img {
  width: 48px;
  height: 48px;
  margin-right: 8px;
  border-radius: 50%;
}

.comment-author h4 {
  margin: 0;
  font-size: 16px;
  font-weight: bold;
}

.comment-text {
  margin: 8px 0;
  font-size: 16px;
  line-height: 1.5;
}

.comment-reply-link {
  margin-top: 8px;
  font-size: 16px;
  font-weight: bold;
  text-transform: uppercase;
  color: #4267b2;
  text-decoration: none;
  cursor: pointer;
}

.comment-reply-link:hover {
  text-decoration: underline;
}

</style>
