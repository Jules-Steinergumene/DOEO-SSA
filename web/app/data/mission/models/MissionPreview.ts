import type { MissionPreviewDto } from '../dtos/MissionPreviewDto';
import type { DangerLevelEnum } from '../enums/DangerLevelEnum';
import { CountryPreview } from '../../country/models/CountryPreview';

export class MissionPreview {
  public readonly id: number;
  public readonly name: string;
  public readonly danger: DangerLevelEnum;
  public readonly description: string;
  public readonly country?: CountryPreview;
  public readonly agentsCount: number;

  constructor(dto: MissionPreviewDto) {
    this.id = dto.id;
    this.name = dto.name;
    this.danger = dto.danger as DangerLevelEnum;
    this.description = dto.description;
    this.country = dto.country ? new CountryPreview(dto.country) : undefined;
    this.agentsCount = dto.agentsCount;
  }
}
