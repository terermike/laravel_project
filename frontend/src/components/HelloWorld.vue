<script setup>
import {
  ElRow,
  ElButton,
} from 'element-plus'; // Import Element UI components

import {
  Check,
  Delete,
  Edit,
  Message,
  Search,
  Star,
} from '@element-plus/icons-vue'; // Import Element UI icons

// Component setup
const plainButtons = [
  { text: 'Plain', plain: true },
  { text: 'Primary', type: 'primary', plain: true },
  { text: 'Success', type: 'success', plain: true },
  { text: 'Info', type: 'info', plain: true },
  { text: 'Warning', type: 'warning', plain: true },
  { text: 'Danger', type: 'danger', plain: true },
];


</script>

<template>
  <div>
    <ElRow class="mb-4">
      <!-- Render buttons with different types -->
      <ElButton :key="index" v-for="(button, index) in mb4Buttons" :type="button.type">{{ button.text }}</ElButton>
    </ElRow>

    <ElRow class="mb-4">
      <!-- Render plain buttons with different types -->
      <ElButton :key="index" v-for="(button, index) in plainButtons" :type="button.type" :plain="button.plain">{{ button.text }}</ElButton>
    </ElRow>

    <ElRow class="mb-4">
      <!-- Render round buttons with different types -->
      <ElButton :key="index" v-for="(button, index) in roundButtons" :type="button.type" :round="button.round">{{ button.text }}</ElButton>
    </ElRow>

    <ElRow>
      <!-- Render circle buttons with icons -->
      <ElButton :key="index" v-for="(button, index) in circleButtons" :type="button.type" :icon="button.icon" :circle="button.circle" />
    </ElRow>
  </div>
</template>

