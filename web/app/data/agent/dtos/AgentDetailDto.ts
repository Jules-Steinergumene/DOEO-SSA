import type { MissionPreviewDto } from '~/data/mission/dtos/MissionPreviewDto';
import type { AgentPreviewDto } from './AgentPreviewDto';
import type { CountryPreviewDto } from '~/data/country/dtos/CountryPreviewDto';

export interface AgentDetailDto extends AgentPreviewDto {
  missions: MissionPreviewDto[];
  currentMission?:MissionPreviewDto;
  enrolementDate?: string;
  infiltratedCountry?: CountryPreviewDto;
}
