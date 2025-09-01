import type { CountryDetailDto } from '../dtos/CountryDetailDto';
import { DangerLevelEnum } from '../../mission/enums/DangerLevelEnum';
import type { MissionPreview } from '../../mission/models/MissionPreview';
import type { AgentPreview } from '../../agent/models/AgentPreview';
import { AgentMapper } from '../../agent/dtos/AgentMapper';
import { MissionMapper } from '../../mission/dtos/MissionMapper';

export class CountryDetail {
  public readonly id: number;
  public readonly name: string;
  public readonly danger?: DangerLevelEnum;
  public readonly missions: MissionPreview[];
  public readonly infiltratedAgents: AgentPreview[];
  public readonly cellLeader?: AgentPreview;

  constructor(dto: CountryDetailDto) {
    this.id = dto.id;
    this.name = dto.name;
    this.danger = dto.danger as DangerLevelEnum;
    this.missions = dto.missions.map(missionDto => MissionMapper.fromMissionPreviewDto(missionDto));
    this.infiltratedAgents = dto.infiltratedAgents.map(agentDto => AgentMapper.fromAgentPreviewDto(agentDto));
    this.cellLeader = dto.cellLeader ? AgentMapper.fromAgentPreviewDto(dto.cellLeader) : undefined;
  }
}
