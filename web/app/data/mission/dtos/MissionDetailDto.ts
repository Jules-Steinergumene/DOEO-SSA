import type { AgentPreviewDto } from '../../agent/dtos/AgentPreviewDto';
import type { MissionPreviewDto } from './MissionPreviewDto';

export interface MissionDetailDto extends Omit<MissionPreviewDto, "agentsCount"> {
  objectives: string;
  agents: AgentPreviewDto[];
  startDate?: string;
  status?: string;
  endDate?: string;
}
