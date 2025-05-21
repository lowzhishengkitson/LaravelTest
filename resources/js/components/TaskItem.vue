<template>
  <div class="task">
    <input type="checkbox" v-model="task.completed" @change="emit('toggle', task)" />
    <a :href="`/tasks/${task.id}`">{{ task.title }}</a>
    <a :href="`/tasks/${task.id}/edit`">Edit</a>
    <button @click="emit('delete', task)">Delete</button>
  </div>
</template>

<script setup>
defineProps({ task: Object })
const emit = defineEmits(['delete', 'toggle'])
</script>

<style scoped>
.task {
  margin-bottom: 10px;
}
</style>
