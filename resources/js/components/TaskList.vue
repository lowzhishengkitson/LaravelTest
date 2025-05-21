<template>
  <div>
    <TaskItem
      v-for="task in tasks"
      :key="task.id"
      :task="task"
      @delete="emit('delete', $event)"
      @toggle="emit('toggle', $event)"
    />
  </div>
</template>

<script setup>
import TaskItem from './TaskItem.vue'

defineProps({ tasks: Array })
const emit = defineEmits(['delete', 'toggle'])
</script>
