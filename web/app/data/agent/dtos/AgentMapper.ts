import type { AgentPreviewDto } from './AgentPreviewDto';
import type { AgentDetailDto } from './AgentDetailDto';
import { AgentPreview } from '../models/AgentPreview';
import { AgentDetail } from '../models/AgentDetail';

export class AgentMapper {
  public static fromAgentPreviewDto(dto: AgentPreviewDto): AgentPreview {
    return new AgentPreview(dto);
  }

  public static fromAgentPreviewDtoArray(dtos: AgentPreviewDto[]): AgentPreview[] {
    return dtos.map(dto => this.fromAgentPreviewDto(dto));
  }

  public static fromAgentDetailDto(dto: AgentDetailDto): AgentDetail {
    return new AgentDetail(dto);
  }
}
