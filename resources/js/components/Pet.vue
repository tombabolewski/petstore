<template>
    <div class="row mb-2">
        <div class="col">
            <h2 v-if="loading">Loading...</h2>
            <h2 v-else-if="!pet.id">New pet</h2>
            <h2 v-else>{{ `#${pet.id} – ${pet?.name}` }}</h2>
            <router-link to="/">
                <div class="btn btn-secondary mr-2">Back to list</div>
            </router-link>
            <button
                v-if="!loading && pet.id"
                class="btn btn-primary"
                type="button"
                @click="loadPet"
            >
                Refresh
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <form ref="form" @submit.prevent="submit">
                <table v-if="!loading" class="table">
                    <tbody>
                        <tr>
                            <th scope="row">Name</th>
                            <td>
                                <input
                                    type="text"
                                    name="name"
                                    v-model="pet.name"
                                />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Category name</th>
                            <td>
                                <input
                                    type="text"
                                    name="category"
                                    v-model="pet.category"
                                />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Status</th>
                            <td>
                                <select name="status" v-model="pet.status">
                                    <option
                                        v-for="(status, i) in statuses"
                                        :value="status"
                                        :key="`status${i}`"
                                    >
                                        {{ status }}
                                    </option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Photo URLs</th>
                            <td>
                                <ul>
                                    <li
                                        v-for="(photo, j) in pet?.photoUrls"
                                        :key="`photo${j}`"
                                    >
                                        <input
                                            type="text"
                                            :v-model="pet.photoUrls[j]"
                                            class="mr-2 d-inline-block"
                                        />
                                        <button
                                            class="btn btn-danger ml-2"
                                            type="button"
                                            @click="removePhotoUrl(j)"
                                        >
                                            Remove
                                        </button>
                                    </li>
                                </ul>
                                <button
                                    class="btn btn-success ml-2"
                                    type="button"
                                    @click="addPhotoUrl"
                                >
                                    Add
                                </button>
                            </td>
                        </tr>
                        <tr v-if="pet?.id">
                            <th scope="row">Photo upload</th>
                            <td v-if="loadingUpload">Please wait...</td>
                            <td v-else>
                                <input
                                    class="form-control"
                                    type="file"
                                    ref="photoInput"
                                    accept="image/*"
                                />
                                <div
                                    class="btn btn-success"
                                    role="button"
                                    @click.prevent="uploadPhoto"
                                >
                                    Upload
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Tags</th>
                            <td>
                                <ul>
                                    <li
                                        v-for="(tag, j) in pet?.tags"
                                        :key="`tag${j}`"
                                    >
                                        <input
                                            type="text"
                                            v-model="pet.tags[j]"
                                            class="mr-2 d-inline-block"
                                        />
                                        <button
                                            class="btn btn-danger ml-2"
                                            type="button"
                                            @click="removeTag(j)"
                                        >
                                            Remove
                                        </button>
                                    </li>
                                </ul>
                                <button
                                    class="btn btn-success ml-2"
                                    type="button"
                                    @click="addTag"
                                >
                                    Add
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">
                                <button class="btn btn-success">Save</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data: () => ({
        loading: true,
        loadingUpload: false,
        pet: {
            id: null,
            name: "",
            category: "",
            status: "",
            tags: [],
            photoUrls: [],
        },
        statuses: [],
    }),
    mounted() {
        this.pet.id = this.$route.params?.id || null;
        this.loadStatuses();
        if (this.pet.id) {
            this.loadPet();
        } else {
            this.loading = false;
        }
    },
    methods: {
        loadStatuses() {
            this.loading = true;
            return axios.get("/api/petStatus").then(({ data }) => {
                this.statuses = data.data;
                if (this.statuses.length) {
                    this.pet.status = this.statuses[0];
                }
            });
        },
        mapPet(pet) {
            return {
                id: pet.id,
                name: pet.name,
                status: pet.status,
                category: pet?.category?.name || "",
                photoUrls: pet?.photoUrls || [],
                tags: pet?.tags.map((tag) => tag.name) || [],
            };
        },
        loadPet() {
            this.loading = true;
            axios
                .get(`/api/pet/${this.pet.id}`)
                .then(({ data }) => {
                    this.pet = this.mapPet(data?.data);
                })
                .catch((e) => {
                    alert(e.response.data.message);
                    this.$router.push("/");
                })
                .finally(() => (this.loading = false));
        },
        removePhotoUrl(j) {
            this.pet?.photoUrls.splice(j, 1);
        },
        addPhotoUrl() {
            if (typeof this.pet.photoUrls == "undefined") {
                this.pet.photoUrls = [];
            }
            this.pet.photoUrls.push("");
        },
        removeTag(j) {
            this.pet?.tags.splice(j, 1);
        },
        addTag() {
            if (!"tags" in this.pet) {
                this.pet.tags = [];
            }
            this.pet.tags.push("");
        },
        submit() {
            this.loading = true;
            let response;
            if (this.pet.id) {
                response = axios.put(`/api/pet/${this.pet.id}`, this.pet);
            } else {
                response = axios.post("/api/pet", this.pet);
            }

            response
                .then(({ data }) => {
                    alert(data.message);
                    this.pet = this.mapPet(data?.data);
                })
                .catch((e) => {
                    alert(e.response.data.message);
                })
                .finally(() => (this.loading = false));
        },
        uploadPhoto() {
            if (!this.$refs.photoInput.files.length) {
                alert("Choose a file first!");
            }
            this.loadingUpload = true;
            axios
                .postForm(`/api/pet/${this.pet.id}/uploadImage`, {
                    file: this.$refs.photoInput.files[0],
                })
                .then(({ data }) => {
                    alert(data.message);
                    this.loadPet();
                })
                .catch((e) => alert(e.response.data.message))
                .finally(() => (this.loadingUpload = false));
        },
    },
};
</script>
