// resources/js/app.js
import './bootstrap';
import { createApp } from 'vue';
import TaskManager from './components/TaskManager.vue';

createApp(TaskManager).mount('#app');
