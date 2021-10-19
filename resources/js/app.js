import { createApp } from 'vue'
import Home from './Components/Home.vue';
import App from './Components/App.vue';
import About from './Components/About.vue';
import SurveyForm from './Components/SurveyForm.vue';
import SurveyPlay from './Components/SurveyPlay.vue';
import VueProgressBar from 'vue-progressbar'

window.Vue = require('vue').default;

let linkFull = "http://localhost:8000";

import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const options = {
    color: '#3498db',
    failedColor: 'red',
    thickness: '5px',
    transition: {
        speed: '0.2s',
        opacity: '0.6s',
        termination: 300
    },
    autoRevert: true,
    location: 'top',
    inverse: false
}

Vue.use(VueProgressBar, options)

require('./bootstrap');

Vue.component('app', require('./components/App.vue').default);

const routes = [
    {
        path: "/",
        name: "Home",
        component: Home
    },
    {
        path: "/surveys/create",
        name: "SurveyForm",
        component: SurveyForm
    },
    {
        path: "/surveys/edit/:id",
        name: "SurveyFormEdit",
        component: SurveyForm
    },
    {
        path: "/surveys/play/:id",
        name: "SurveyPlay",
        component: SurveyPlay
    },
    {
        path: "/about",
        name: "About",
        component: About
    }
];

const router = new VueRouter({
    mode: 'history',
    routes: routes
})

window.addEventListener('load', function () {

    const app = new Vue({
        el: '#main',
        router: router
    });

})



// let div = document.getElementById('app');

// div.innerHTML = "Aquiii...";
