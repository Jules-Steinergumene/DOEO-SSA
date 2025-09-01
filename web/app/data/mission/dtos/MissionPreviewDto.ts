import type { CountryPreviewDto } from "~/data/country/dtos/CountryPreviewDto";

export interface MissionPreviewDto {
  id: number;
  name: string;
  danger: string;
  description: string;
  country?: CountryPreviewDto;
  agentsCount: number;
}
