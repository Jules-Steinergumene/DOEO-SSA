<template>
  <q-card class="mission-card" clickable @click="navigateToMission">
    <!-- Danger Level Badge -->
    <div class="danger-badge">
      <q-badge
        :color="dangerColor"
        :icon="dangerIcon"
        class="text-weight-bold"
      >
        {{ mission.danger }}
      </q-badge>
    </div>

    <!-- Card Content -->
    <q-card-section class="q-pb-none">
      <div class="row items-center q-mb-sm">
        <q-icon name="mdi-target" size="24px" color="primary" class="q-mr-sm" />
        <h6 class="text-h6 q-mb-none text-weight-bold">{{ mission.name }}</h6>
      </div>
      
      <p class="text-body2 text-grey-7 q-mb-md line-clamp-2">
        {{ mission.description }}
      </p>
    </q-card-section>

    <!-- Card Actions -->
    <q-card-section class="q-pt-none">
      <div class="row items-center justify-between">
        <!-- Country Info -->
        <div v-if="mission.country" class="row items-center">
          <q-icon name="mdi-flag" size="16px" color="grey-6" class="q-mr-xs" />
          <span class="text-caption text-grey-7">{{ mission.country.name }}</span>
        </div>
        
        <!-- Agents Count -->
        <div class="row items-center">
          <q-icon name="mdi-account-group" size="16px" color="grey-6" class="q-mr-xs" />
          <span class="text-caption text-grey-7">{{ mission.agentsCount }} agents</span>
        </div>
      </div>


    </q-card-section>

    <!-- Hover Effect -->
    <q-card-section class="q-pa-none">
      <q-separator />
      <div class="text-center q-pa-sm">
        <q-btn
          flat
          color="primary"
          icon="mdi-arrow-right"
          size="sm"
          class="full-width"
        >
          Voir les détails
        </q-btn>
      </div>
    </q-card-section>
  </q-card>
</template>

<script setup lang="ts">
import type { MissionPreview } from '~/data/mission';

// Props
interface Props {
  mission: MissionPreview;
  dangerColor: string;
  dangerIcon: string;
}

const props = defineProps<Props>();



const navigateToMission = (): void => {
  // Navigation vers la page de détail de la mission
  // À implémenter selon votre routing
  console.log('Navigation vers la mission:', props.mission.id);
};
</script>

<style scoped>
.mission-card {
  height: 100%;
  transition: all 0.3s ease;
  border: 1px solid #e0e0e0;
}

.mission-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.danger-badge {
  position: absolute;
  top: 12px;
  right: 12px;
  z-index: 1;
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Responsive adjustments */
@media (max-width: 599px) {
  .mission-card {
    margin-bottom: 16px;
  }
}
</style>
