<template>
    <h2>List of pets</h2>
    <button role="button" @click="loadPets">Refresh</button>
    <div v-if="loading">Loading...</div>
    <table v-else>
        <thead>
            <tr>
                <td>Id</td>
                <td>Name</td>
                <td>Category</td>
                <td>Status</td>
            </tr>
        </thead>
        <tbody>
            <router-link
                v-for="(pet, i) in pets"
                :key="`pet${i}`"
                :to="`/pet/${pet.id}`"
            >
                <tr>
                    <td>{{ pet.id }}</td>
                    <td>{{ pet.name }}</td>
                    <td>{{ pet.category?.name }}</td>
                    <td>{{ pet.status }}</td>
                </tr>
            </router-link>
        </tbody>
    </table>
</template>

<script>
import axios from "axios";

export default {
    data: () => ({
        loading: false,
        pets: [],
    }),
    mounted() {
        this.loadPets();
    },
    methods: {
        loadPets() {
            this.loading = true;
            axios
                .get("/api/pet")
                .then(({ data }) => {
                    this.pets = data?.data;
                })
                .finally(() => (this.loading = false));
        },
    },
};
</script>
