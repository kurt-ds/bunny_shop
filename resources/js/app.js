import './bootstrap'; // This loads Axios automatically in Laravel
import { createApp } from 'vue';
import BunnyList from './components/BunnyList.vue';

const app = createApp({});

// Register your component
app.component('bunny-list', BunnyList);

// Mount it to the div with id="app"
app.mount('#app');