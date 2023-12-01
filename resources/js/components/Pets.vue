<template>
    <div class="row mb-4">
        <div class="col">
            <h2>List of pets</h2>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col">
            <router-link to="/newPet">
                <div class="btn btn-success">New pet</div>
            </router-link>
        </div>
    </div>

    <div class="row mb-4" v-if="!loading">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Filter by status:</h6>
                    <div
                        class="form-check"
                        v-for="(status, i) in statuses"
                        :key="`status${i}`"
                    >
                        <input
                            class="form-check-input"
                            type="checkbox"
                            v-model="status.checked"
                        />
                        <label class="form-check-label" for="flexCheckDefault">
                            {{ status.value }}
                        </label>
                    </div>
                    <button
                        v-if="!loading"
                        class="btn btn-primary ml-3 mt-2"
                        role="button"
                        @click="loadPets"
                    >
                        Apply
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div v-if="loading">Loading...</div>
            <table v-else class="table">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(pet, i) in pets" :key="`pet${i}`">
                        <th scope="row">{{ pet.id }}</th>
                        <td>{{ pet.name }}</td>
                        <td>{{ pet.category?.name }}</td>
                        <td>{{ pet.status }}</td>
                        <td>
                            <router-link :to="`/pet/${pet.id}`">
                                <div class="btn btn-primary" role="button">
                                    Edit
                                </div>
                            </router-link>
                            <button
                                class="btn btn-danger ml-2"
                                type="button"
                                @click="deletePet(pet.id)"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data: () => ({
        loading: false,
        statuses: [],
        pets: [],
    }),
    mounted() {
        this.loadStatuses();
    },
    computed: {
        statusStr() {
            return this.statuses
                .filter((v) => v.checked)
                .map((v) => `status[]=${v.value}`)
                .join("&");
        },
    },
    methods: {
        loadStatuses() {
            this.loading = true;
            axios.get("/api/petStatus").then(({ data }) => {
                this.statuses = data.data.map((status) => ({
                    checked: true,
                    value: status,
                }));
                this.loadPets();
            });
        },
        loadPets() {
            this.loading = true;
            axios
                .get(`/api/pet?${this.statusStr}`)
                .catch((e) => alert(e.response.data.message))
                .then(({ data }) => {
                    this.pets = data?.data;
                })
                .finally(() => (this.loading = false));
        },
        deletePet(id) {
            this.loading = true;
            axios
                .delete(`api/pet/${id}`)
                .catch((e) => {
                    alert(e.response.data.message);
                    this.loading = false;
                })
                .then(({ data }) => {
                    alert(data.message);
                    this.loadPets();
                });
        },
    },
};
</script>
