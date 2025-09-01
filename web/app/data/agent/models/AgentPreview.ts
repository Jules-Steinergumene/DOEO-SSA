import type { AgentPreviewDto } from '../dtos/AgentPreviewDto';
import { AgentStatusEnum } from '../enum/AgentStatusEnum';

export class AgentPreview {
  public readonly id: number;
  public readonly codeName: string;
  public readonly status?: AgentStatusEnum;
  public readonly yearsOfExperience?: number;

  constructor(dto: AgentPreviewDto) {
    this.id = dto.id;
    this.codeName = dto.codeName;
    this.status = dto.status as AgentStatusEnum;
    this.yearsOfExperience = dto.yearsOfExperience;
  }
}
