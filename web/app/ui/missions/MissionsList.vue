<template>
  <div class="missions-list">
    <!-- Header -->
    <div class="row items-center q-mb-lg">
      <div class="col">
        <h4 class="text-h4 q-mb-none">Missions</h4>
        <p class="text-subtitle1 q-mt-sm q-mb-none text-grey-7">
          {{ viewModel.pagination.value.totalItems }} missions au total
        </p>
      </div>
      <div class="col-auto">
        <q-btn
          icon="mdi-refresh"
          color="primary"
          :loading="viewModel.loading.value"
          @click="viewModel.refresh()"
        >
          Actualiser
        </q-btn>
      </div>
    </div>

    <!-- Error Message -->
    <q-banner
      v-if="viewModel.error"
      class="text-white bg-red q-mb-md"
      icon="mdi-alert-circle"
    >
      {{ viewModel.error }}
    </q-banner>

    <!-- Loading State -->
    <div v-if="viewModel.loading.value" class="text-center q-pa-xl">
      <q-spinner-dots size="50px" color="primary" />
      <p class="q-mt-md text-grey-7">Chargement des missions...</p>
    </div>

    <!-- Empty State -->
    <div v-else-if="viewModel.isEmpty.value" class="text-center q-pa-xl">
      <q-icon name="mdi-mission" size="80px" color="grey-4" />
      <h5 class="q-mt-md q-mb-sm text-grey-7">Aucune mission</h5>
      <p class="text-grey-6">Aucune mission n'est disponible pour le moment.</p>
    </div>

    <!-- Missions Grid -->
    <div v-else class="row q-col-gutter-md">
      <div
        v-for="mission in viewModel.missions.value"
        :key="mission.id"
        class="col-12 col-sm-6 col-md-4 col-lg-3"
      >
        <MissionCard
          :mission="mission"
          :danger-color="viewModel.getDangerColor(mission.danger)"
          :danger-icon="viewModel.getDangerIcon(mission.danger)"
        />
      </div>
    </div>

    <!-- Load More Button -->
    <div v-if="viewModel.canLoadMore.value" class="text-center q-mt-lg">
      <q-btn
        :loading="viewModel.loading.value"
        color="primary"
        outline
        @click="viewModel.loadMore()"
      >
        <q-icon name="mdi-plus" class="q-mr-sm" />
        Charger plus de missions
      </q-btn>
    </div>

    <!-- Loading More Indicator -->
    <div v-if="viewModel.loading.value && viewModel.missions.value.length > 0" class="text-center q-mt-lg">
      <q-spinner-dots size="30px" color="primary" />
      <p class="q-mt-sm text-grey-7">Chargement...</p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { onMounted, onUnmounted } from 'vue';
import { MissionsListViewModel } from './MissionsListViewModel';
import MissionCard from '~/ui/missions/MissionCard.vue';

// ViewModel
const viewModel = new MissionsListViewModel();

// Exposer le viewModel pour les composants parents
defineExpose({
  viewModel
});

// Lifecycle
onMounted(() => {
  viewModel.onMounted();
});

onUnmounted(() => {
  viewModel.onUnmounted();
});
</script>

<style scoped>
.missions-list {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}
</style>
