import { ApiConnector } from '../../core/api/service/ApiConnector';
import type { PaginatedData } from '../../core/api/interfaces/PaginatedData';
import { AgentPreview } from './models/AgentPreview';
import { AgentDetail } from './models/AgentDetail';
import { AgentMapper } from './dtos/AgentMapper';
import type { HydraCollection } from '~/core/api/interfaces/HydraCollection';
import type { AgentPreviewDto } from './dtos/AgentPreviewDto';
import type { AgentDetailDto } from './dtos/AgentDetailDto';

export class AgentApi extends ApiConnector {
  private readonly baseEndpoint = 'agents';

  public async getAgents(page: number = 1, limit: number = 30): Promise<PaginatedData<AgentPreview>> {
    const queryParameters = {
      page: page - 1,
      limit
    };
    
    const response: HydraCollection<AgentPreviewDto> = await this.getData(this.baseEndpoint, queryParameters);
    
    const agents = AgentMapper.fromAgentPreviewDtoArray(response.member);
    const totalItems = response.totalItems;
    const view = response.view;
    const totalPages = Math.ceil(totalItems / limit);
    
    return {
      data: agents,
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

  public async getAgent(id: number): Promise<AgentPreview> {
    const response = await this.getData(`${this.baseEndpoint}/${id}`);
    const dto: AgentPreviewDto = response;
    return AgentMapper.fromAgentPreviewDto(dto);
  }

  public async getAgentDetail(id: number): Promise<AgentDetail> {
    const response = await this.getData(`${this.baseEndpoint}/${id}`);
    const dto: AgentDetailDto = response;
    return AgentMapper.fromAgentDetailDto(dto);
  }
}
