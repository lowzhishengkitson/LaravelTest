<template>
  <div>
    <input v-model="title" placeholder="Enter task title" />
    <button @click="emitCreate">Save Task</button>
  </div>
</template>

<script setup>
import { watch, ref } from 'vue'

const props = defineProps(['modelValue'])
const emit = defineEmits(['update:modelValue', 'create'])

const title = ref(props.modelValue)

watch(title, (val) => emit('update:modelValue', val))
watch(() => props.modelValue, (val) => title.value = val)

const emitCreate = () => emit('create')
</script>
