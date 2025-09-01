import type { MissionPreviewDto } from './MissionPreviewDto';
import type { MissionDetailDto } from './MissionDetailDto';
import { MissionPreview } from '../models/MissionPreview';
import { MissionDetail } from '../models/MissionDetail';


export const MissionMapper = {
  fromMissionPreviewDtoArray(dtos: MissionPreviewDto[]): MissionPreview[] {
    return dtos.map(dto => new MissionPreview(dto));
  },

  fromMissionPreviewDto(dto: MissionPreviewDto): MissionPreview {
    return new MissionPreview(dto);
  },

  fromMissionDetailDto(dto: MissionDetailDto): MissionDetail {
    return new MissionDetail(dto);
  }
};
