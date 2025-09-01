<template>
  <q-layout view="hHh lpR fFf">
    <!-- Top Bar -->
    <q-header elevated class="bg-primary text-white">
      <q-toolbar>
        <q-btn flat round icon="mdi-arrow-left" @click="goBack" />
        <q-toolbar-title class="text-h5 text-weight-bold">
          🕵️ SSA - Missions
        </q-toolbar-title>
        <q-space />
        <q-btn flat round icon="mdi-refresh" @click="refreshMissions" />
      </q-toolbar>
    </q-header>

    <!-- Main Content -->
    <q-page-container>
      <MissionsList ref="missionsListRef" />
    </q-page-container>
  </q-layout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import MissionsList from '~/ui/missions/MissionsList.vue';

const router = useRouter();
const missionsListRef = ref<InstanceType<typeof MissionsList> | null>(null);

const goBack = () => {
  router.push('/');
};

const refreshMissions = () => {
  if (missionsListRef.value?.viewModel) {
    missionsListRef.value.viewModel.refresh();
  }
};
</script>

<style scoped>
.q-header {
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.q-toolbar-title {
  font-family: 'Roboto', sans-serif;
  letter-spacing: 1px;
}
</style>
