import { ApiConnector } from '../../core/api/service/ApiConnector';
import type { MissionDetailDto } from './dtos/MissionDetailDto';
import type { PaginatedData } from '../../core/api/interfaces/PaginatedData';
import { MissionDetail } from './models/MissionDetail';
import { MissionMapper } from './dtos/MissionMapper';
import type { HydraCollection } from '~/core/api/interfaces/HydraCollection';
import type { MissionPreviewDto } from './dtos/MissionPreviewDto';
import type { MissionPreview } from './models/MissionPreview';

export class MissionApi extends ApiConnector {
  private readonly baseEndpoint = 'missions';

  public async getMissions(page: number = 1, limit: number = 30, signal?: AbortSignal): Promise<PaginatedData<MissionPreview>> {
    const queryParameters = {
      page: page,
      limit
    };
    
    const response: HydraCollection<MissionPreviewDto> = await this.getData(this.baseEndpoint, queryParameters, signal);
    
    const missions = MissionMapper.fromMissionPreviewDtoArray(response.member);
    const totalItems = response.totalItems;
    const view = response.view;
    const totalPages = Math.ceil(totalItems / limit);
    
    return {
      data: missions,
      pagination: {
        page,
        limit,
        totalItems,
        totalPages,
        hasNext: !!view?.['hydra:next'],
        hasPrevious: !!view?.['hydra:previous']
      }
    };
  }

  public async getMission(id: number): Promise<MissionDetail> {
    const response = await this.getData(`${this.baseEndpoint}/${id}`);
    const dto: MissionDetailDto = response;
    return MissionMapper.fromMissionDetailDto(dto);
  }
}
