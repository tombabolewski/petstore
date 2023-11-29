/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import App from './components/App.vue';
import { createRouter, createWebHistory } from 'vue-router';
import Pets from './components/Pets.vue';
import Pet from './components/Pet.vue';

const routes = [
    {
        path: '/',
        name: 'pets',
        component: Pets,
    },
    {
        path: '/pet/:pet_id',
        name: 'pet',
        component: Pet,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

createApp(App)
    .use(router)
    .mount('#app');