import type { CountryPreviewDto } from '../dtos/CountryPreviewDto';
import { DangerLevelEnum } from '../../mission/enums/DangerLevelEnum';

export class CountryPreview {
  public readonly id: number;
  public readonly name: string;
  public readonly danger?: DangerLevelEnum;
  public readonly currentMissionsCount: number;
  public readonly infiltratedAgentsCount: number;

  constructor(dto: CountryPreviewDto) {
    this.id = dto.id;
    this.name = dto.name;
    this.danger = dto.danger as DangerLevelEnum;
    this.currentMissionsCount = dto.currentMissionsCount;
    this.infiltratedAgentsCount = dto.infiltratedAgentsCount;
  }
}
