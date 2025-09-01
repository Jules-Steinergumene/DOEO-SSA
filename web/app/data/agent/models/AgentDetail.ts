import type { AgentDetailDto } from '../dtos/AgentDetailDto';
import { AgentStatusEnum } from '../enum/AgentStatusEnum';
import { CountryPreview } from '../../country/models/CountryPreview';
import type { MissionPreview } from '../../mission/models/MissionPreview';
import { CountryMapper } from '../../country/dtos/CountryMapper';
import { MissionMapper } from '../../mission/dtos/MissionMapper';

export class AgentDetail {
  public readonly id: number;
  public readonly codeName: string;
  public readonly status?: AgentStatusEnum;
  public readonly yearsOfExperience?: number;
  public readonly infiltratedCountry?: CountryPreview;
  public readonly missions: MissionPreview[];
  public readonly currentMission?: MissionPreview;
  public readonly enrolementDate?: string;

  constructor(dto: AgentDetailDto) {
    this.id = dto.id;
    this.codeName = dto.codeName;
    this.status = dto.status as AgentStatusEnum;
    this.yearsOfExperience = dto.yearsOfExperience;
    this.infiltratedCountry = dto.infiltratedCountry ? new CountryPreview(dto.infiltratedCountry) : undefined;
    this.missions = MissionMapper.fromMissionPreviewDtoArray(dto.missions);
    this.currentMission = dto.currentMission ? MissionMapper.fromMissionPreviewDto(dto.currentMission) : undefined;
    this.enrolementDate = dto.enrolementDate;
  }
}
