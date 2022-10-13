<script>
import axios from "axios";
import UploadImages from "vue-upload-drop-images";

export default {
    components: {
        UploadImages,
    },
    props: {
        modelValue: String,
        changeImage: { type: Function },
        deleteFolder: Boolean,
        deleteFiles : Boolean,
        createFolder: Boolean,
        createFiles: Boolean,
        browserId: String
    },
    emits: ['update:modelValue'],
    data: () => {
        return {
            placeholder_img: "",
            placeholder_img_path: "",
            folder_count: 0,
            file_count: 0,
            file_select_index: "",
            folders: [],
            files: [],
            directory: "",
            new_folder_toggler: false,
            folder_name: "",
            showUploadModal: false,
            upload_files: [],
            isLoaded: true,
            numClicks: 0,
            model_id: '',
        };
    },
    methods: {
        async getDirectories() {
            let param = {
                directory: this.directory,
            };
            const response = await axios.get(route("filemanager.index"), {
                params: param,
            });
            this.files = response.data.data.files;
            this.folders = response.data.data.folders;
            this.directory = response.data.data.directory;
            this.folder_count = response.data.data.folder_count;
            this.file_count = response.data.data.file_count;
        },
        selectFolder(folder) {
            this.directory = this.directory + folder + "/";
            this.getDirectories();
        },
        refreshDirectory() {
            this.getDirectories();
        },
        homeDirectory() {
            this.directory = "image/";
            this.getDirectories();
        },
        backDirectory() {
            this.directory = this.directory.substring(
                0,
                this.directory.lastIndexOf("/")
            );
            this.directory = this.directory.substring(
                0,
                this.directory.lastIndexOf("/")
            );
            this.directory = this.directory + "/";
            this.getDirectories();
        },
        toggleUploadBrowser() {
            this.showUploadModal = !this.showUploadModal;
        },
        handleImages(files) {
            this.upload_files = files;
        },
        async submitFileUploader() {
            if (this.upload_files) {
                try {
                    let formData = new FormData();
                    Array.from(this.upload_files).forEach(function (file) {
                        formData.append("files[]", file);
                    });
                    formData.append("directory", this.directory);

                    await axios.post(
                        route("filemanager.upload_file"),
                        formData,
                        {
                            headers: {
                                "Content-Type":
                                    "application/x-www-form-urlencoded",
                            },
                        }
                    );
                    this.toggleUploadBrowser();
                    this.refreshDirectory();
                    alert("files are uploaded successfully!");
                } catch (ex) {
                    alert(ex.response.data.message);
                }
            } else {
                alert("No files are selected!");
            }
        },
        newFolder() {
            this.new_folder_toggler = !this.new_folder_toggler;
        },
        closeAddFolder() {
            this.folder_name = "";
        },
        saveFolderName() {
            if (this.folder_name != "") {
                try {
                    let folder = {
                        folder_name: this.folder_name,
                        directory: this.directory,
                    };
                    axios.post(route("filemanager.upload_folder"), {
                        folder_name: this.folder_name,
                        directory: this.directory,
                    });
                    this.new_folder_toggler = !this.new_folder_toggler;
                    this.getDirectories();
                    this.upload_files = [];
                    alert("Folder Created Successfully");
                } catch (ex) {
                    alert(ex.response.data.message);
                }
            } else {
                alert("Folder Name is Required!");
            }
        },
        async deleteDirectory() {
            try {
                let formData = new FormData();
                formData.append("directory_path", this.directory);
                let _this = this;
                if (
                    this.directory == "image/catalog/" ||
                    this.directory == "image/"
                ) {
                    alert("You cannot delete this directory!");
                } else {
                    await axios
                        .post(route("filemanager.delete_folder"), formData)
                        .then(function (response) {
                            _this.backDirectory();
                            alert("Directory Deleted Successfully!");
                        })
                        .catch(function (error) {
                            alert(error);
                        });
                }
            } catch (ex) {
                alert("something is wrong");
            }
        },
        async deleteFile(path, index) {
            try {
                let formData = new FormData();
                formData.append("file_path", path);
                let _this = this;
                await axios
                    .post(route("filemanager.delete_file"), formData)
                    .then(function (response) {
                        _this.files.splice(index, 1);
                    })
                    .catch(function (err) {
                        alert(err);
                    });
            } catch (ex) {
                alert(ex);
            }
        },
        selectedImage(file, index) {
            this.$emit('update:modelValue', file.image)
            this.placeholder_img = file.image;
            this.placeholder_img_path = file.path_name;
            this.file_select_index = index;
            this.numClicks++;
            if (this.numClicks === 1) {
                // the first click in .2s
                var self = this;
                setTimeout(function () {
                    switch (
                        self.numClicks // check the event type
                    ) {
                        case 1:
                            break;
                        default:
                            self.submitSelectFile();
                    }
                    self.numClicks = 0; // reset the first click
                }, 200); // wait 0.2s
            } // if
        },
        submitSelectFile() {
            let data = {
                placeholder_img: this.placeholder_img,
                placeholder_img_path: this.placeholder_img_path,
            };
            this.$emit("changeImage", data);
        },
    },
    mounted() {
        this.getDirectories();
        this.model_id = this.browserId
    },
};
</script>

<template>
    <div>
        <div
            class="modal fade"
            :id="browserId"
            aria-modal="true"
            role="dialog"
            backdrop="static"
        >
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Gallery Browser</h4>
                        <button
                            type="button"
                            class="close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div role="group" class="btn-group">
                                <button
                                    type="button"
                                    title="Back"
                                    class="btn btn-outline-info"
                                    @click="backDirectory"
                                >
                                    <i
                                        class="bi bi-skip-backward-fill"
                                        disbaled="disbaled"
                                    ></i>
                                </button>
                                <button
                                    type="button"
                                    title="Home"
                                    class="btn btn-outline-info"
                                    @click="homeDirectory"
                                >
                                    <i class="bi bi-house-fill"></i>
                                </button>
                                <button
                                    type="button"
                                    title="Refresh"
                                    class="btn btn-outline-info"
                                    @click="refreshDirectory"
                                >
                                    <i class="bi bi-arrow-repeat"></i>
                                </button>
                            </div>
                            <div role="group" class="btn-group">
                                <!-- <button type="button" title="New file" class="btn bg-blue"><i class="far fa-file"></i></button> -->
                                <button
                                    type="button"
                                    title="New folder"
                                    class="btn btn-outline-info"
                                    v-if="createFolder"
                                    @click="newFolder"
                                >
                                    <i class="bi bi-folder-plus"></i>
                                </button>
                                <button
                                    type="button"
                                    title="Upload"
                                    class="btn btn-outline-info"
                                    v-if="createFiles"
                                    @click.prevent="toggleUploadBrowser"
                                >
                                    <i class="bi bi-folder-symlink"></i>
                                </button>
                                <button
                                    type="button"
                                    title="Delete Directory"
                                    class="btn btn-outline-info"
                                    v-if="deleteFolder"
                                    @click.prevent="deleteDirectory"
                                >
                                    <i class="bi bi-folder-x"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <div
                                    class="input-group mb-3"
                                    v-if="new_folder_toggler"
                                >
                                
                                    <div class="input-group mb-3">
                                        <span
                                            class="input-group-text btn btn-outline-danger"
                                            id="basic-addon1"
                                            @click="closeAddFolder"
                                            ><i class="bi bi-trash"></i
                                        ></span>
                                        <input
                                            type="text"
                                            v-model="folder_name"
                                            class="form-control"
                                            placeholder="Folder Name"
                                            aria-label="Folder Name"
                                        />
                                        <span
                                            class="input-group-text btn btn-outline-success"
                                            id="basic-addon2"
                                            @click="saveFolderName"
                                            ><i class="bi bi-patch-check"></i
                                        ></span>
                                    </div>
                                </div>
                                <div class="list-group" v-if="folder_count > 0">
                                    <button
                                        type="button"
                                        class="list-group-item list-group-item-action"
                                        v-for="(folder, index) in folders"
                                        :key="index"
                                        @click="selectFolder(folder.name)"
                                    >
                                        {{ folder.name }}
                                    </button>
                                </div>
                                <div v-else>
                                    <button
                                        type="button"
                                        class="list-group-item list-group-item-action"
                                    >
                                        Root
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-8 form-group">
                                <div class="row" v-if="file_count > 0">
                                    <div
                                        class="col-md-2"
                                        v-for="(file, findex) in files"
                                        :key="findex"
                                        style="position:relative"
                                    >
                                        <img
                                            alt=""
                                            v-if="findex == file_select_index"
                                            class="active_list"
                                            :src="file.image"
                                            @click="selectedImage(file, findex)"
                                        />
                                        <img
                                            alt=""
                                            v-else
                                            class="in_active_list"
                                            :src="file.image"
                                            @click="selectedImage(file, findex)"
                                        />
                                        <span v-if="deleteFiles" >
                                        <a
                                            v-if="findex == file_select_index"
                                            class="trash_file text-danger"
                                            @click="
                                                deleteFile(
                                                    file.path_name,
                                                    findex
                                                )
                                            "
                                        >
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                        </span>
                                    </div>
                                </div>
                                <div v-else>
                                    <div class="callout callout-warning">
                                        <h5>No Files Found!</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button
                            type="button"
                            class="btn btn-default"
                            data-bs-dismiss="modal"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="modal fade show bd-example-modal-lg"
            v-if="showUploadModal"
            id="modal-uupload"
            style="display: block; padding-right: 17px"
            aria-modal="true"
        >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Uploader</h5>
                        <button
                            type="button"
                            class="close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                            @click.prevent="toggleUploadBrowser"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <UploadImages
                            @changed="handleImages"
                            :max="10"
                            uploadMsg="Images Uploaded"
                            maxError="Max files exceed"
                            fileError="images files only accepted"
                            clearAll="remove all images"
                        />
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-default"
                            data-bs-dismiss="modal"
                            @click.prevent="toggleUploadBrowser"
                        >
                            Close
                        </button>
                        <button
                            type="button"
                            class="btn btn-outline-primary"
                            @click="submitFileUploader"
                        >
                            Upload
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>

.in_active_list {
  border: 1px solid #e6e6e6;
  margin: 5px;
  width: 100%;
  height: 100%;
  object-fit: contain;
}
.active_list {
  border: 1px solid #3498db;
  margin: 5px;
  width: 100%;
  height: 100%;
  object-fit: contain;
}
.trash_file {
  position: absolute;
  bottom: 5px;
  left: 45%;
  border: 1px solid red;
  width: 30px;
  height: 30px;
  text-align: center;
  border-radius: 15px;
  background-color: #fff;
}
</style>