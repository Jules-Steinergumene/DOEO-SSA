import type { CountryPreviewDto } from '../../country/dtos/CountryPreviewDto';

export interface MissionDto {
  id: number;
  name: string;
  danger: string;
  status?: string;
  description: string;
  startDate?: string;
  endDate?: string;
  country?: CountryPreviewDto;
  agentsCount: number;
}
