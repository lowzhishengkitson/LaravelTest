<template>
  <div>
    <TaskForm v-model="newTaskTitle" @create="createTask" />

    <div class="sort-buttons">
      <button @click="sortByName">Sort by Name</button>
      <button @click="sortByStatus">Sort by Status</button>
    </div>

    <TaskList
      :tasks="tasks"
      @delete="deleteTask"
      @toggle="toggleCompletion"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import TaskForm from './TaskForm.vue'
import TaskList from './TaskList.vue'

const tasks = ref([])
const newTaskTitle = ref('')

const loadTasks = () => {
  axios.get('/api/tasks')
    .then(res => tasks.value = res.data)
    .catch(err => console.error('Error loading tasks:', err))
}

const createTask = () => {
  const title = newTaskTitle.value.trim()
  if (!title) return

  axios.post('/api/tasks', { title })
    .then(res => {
      tasks.value.push(res.data)
      newTaskTitle.value = ''
    })
    .catch(err => console.error('Error creating task:', err))
}

const deleteTask = (task) => {
  axios.delete(`/api/tasks/${task.id}`)
    .then(() => tasks.value = tasks.value.filter(t => t.id !== task.id))
    .catch(err => console.error('Error deleting task:', err))
}

const toggleCompletion = (task) => {
  axios.put(`/api/tasks/${task.id}`, { completed: task.completed })
    .then(res => task.completed = res.data.completed)
    .catch(err => console.error('Error updating task:', err))
}

const sortByName = () => {
  tasks.value.sort((a, b) => a.title.localeCompare(b.title))
}
const sortByStatus = () => {
  tasks.value.sort((a, b) => a.completed - b.completed)
}

onMounted(loadTasks)
</script>

<style scoped>
.sort-buttons {
  margin: 1em 0;
}
</style>
