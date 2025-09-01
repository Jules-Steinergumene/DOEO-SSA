import type { CountryPreviewDto } from "~/data/country/dtos/CountryPreviewDto";

export interface AgentPreviewDto {
  id: number;
  codeName: string;
  status?: string;
  yearsOfExperience?: number;
}
