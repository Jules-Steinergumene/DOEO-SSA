import type { AgentPreviewDto } from '../../agent/dtos/AgentPreviewDto';
import type { MissionPreviewDto } from '../../mission/dtos/MissionPreviewDto';

export interface CountryDetailDto {
  id: number;
  name: string;
  danger?: string;
  missions: MissionPreviewDto[];
  infiltratedAgents: AgentPreviewDto[];
  cellLeader?: AgentPreviewDto;
}
