import type { MissionDetailDto } from '../dtos/MissionDetailDto';
import type { CountryPreview } from '../../country/models/CountryPreview';
import type { AgentPreview } from '../../agent/models/AgentPreview';
import { CountryMapper } from '../../country/dtos/CountryMapper';
import { AgentMapper } from '../../agent/dtos/AgentMapper';
import type { DangerLevelEnum } from '../enums/DangerLevelEnum';
import type { MissionStatusEnum } from '../enums/MissionStatusEnum';

export class MissionDetail {
  public readonly id: number;
  public readonly name: string;
  public readonly danger: DangerLevelEnum;
  public readonly status?: MissionStatusEnum;
  public readonly description: string;
  public readonly startDate?: string;
  public readonly endDate?: string;
  public readonly country?: CountryPreview;
  public readonly objectives: string;
  public readonly agents: AgentPreview[];

  constructor(dto: MissionDetailDto) {
    this.id = dto.id;
    this.name = dto.name;
    this.danger = dto.danger as DangerLevelEnum;
    this.status = dto.status as MissionStatusEnum;
    this.description = dto.description;
    this.startDate = dto.startDate;
    this.endDate = dto.endDate;
    this.country = dto.country ? CountryMapper.fromCountryPreviewDto(dto.country) : undefined;
    this.objectives = dto.objectives;
    this.agents = AgentMapper.fromAgentPreviewDtoArray(dto.agents);
  }
}
