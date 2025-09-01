import { ref, computed, onMounted } from 'vue';
import { MissionApi } from '~/data/mission';
import type { MissionPreview } from '~/data/mission';
import type { PaginatedData } from '~/core/api/interfaces/PaginatedData';

export class MissionsListViewModel {
  private readonly missionApi = new MissionApi();
  private abortController: AbortController | null = null;
  
  // State
  public readonly missions = ref<MissionPreview[]>([]);
  public readonly loading = ref(false);
  public readonly error = ref<string | null>(null);
  public readonly pagination = ref({
    page: 1,
    limit: 12,
    totalItems: 0,
    totalPages: 0,
    hasNext: false,
    hasPrevious: false
  });

  // Computed
  public readonly hasMissions = computed(() => this.missions.value.length > 0);
  public readonly isEmpty = computed(() => !this.loading.value && this.missions.value.length === 0);
  public readonly canLoadMore = computed(() => this.pagination.value.hasNext);

  // Methods
  public async loadMissions(page: number = 1): Promise<void> {
    // Annuler la requête précédente si elle existe
    if (this.abortController) {
      this.abortController.abort();
    }
    
    // Créer un nouveau contrôleur d'abort
    this.abortController = new AbortController();
    
    try {
      this.loading.value = true;
      this.error.value = null;
      
      const result: PaginatedData<MissionPreview> = await this.missionApi.getMissions(page, this.pagination.value.limit, this.abortController.signal);
      
      if (page === 1) {
        this.missions.value = result.data;
      } else {
        this.missions.value.push(...result.data);
      }
      
      this.pagination.value = {
        page: result.pagination.page,
        limit: result.pagination.limit,
        totalItems: result.pagination.totalItems,
        totalPages: result.pagination.totalPages,
        hasNext: result.pagination.hasNext,
        hasPrevious: result.pagination.hasPrevious
      };
    } catch (err) {
      // Ignorer les erreurs d'abort (requête annulée)
      if (err instanceof Error && err.name === 'AbortError') {
        console.log('Requête annulée');
        return;
      }
      
      this.error.value = err instanceof Error ? err.message : 'Erreur lors du chargement des missions';
      console.error('Erreur lors du chargement des missions:', err);
    } finally {
      this.loading.value = false;
    }
  }

  public async loadMore(): Promise<void> {
    if (this.canLoadMore.value && !this.loading.value) {
      await this.loadMissions(this.pagination.value.page + 1);
    }
  }

  public async refresh(): Promise<void> {
    await this.loadMissions(1);
  }

  public getDangerColor(danger: string): string {
    switch (danger) {
      case 'Low': return 'green';
      case 'Medium': return 'orange';
      case 'High': return 'red';
      case 'Critical': return 'purple';
      default: return 'grey';
    }
  }

  public getDangerIcon(danger: string): string {
    switch (danger) {
      case 'Low': return 'mdi-shield-check';
      case 'Medium': return 'mdi-shield-alert';
      case 'High': return 'mdi-shield-cross';
      case 'Critical': return 'mdi-shield-off';
      default: return 'mdi-shield';
    }
  }

  // Lifecycle
  public onMounted(): void {
    this.loadMissions();
  }

  public onUnmounted(): void {
    // Annuler toutes les requêtes en cours lors du démontage
    if (this.abortController) {
      this.abortController.abort();
      this.abortController = null;
    }
  }
}
