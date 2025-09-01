import type { CountryPreviewDto } from './CountryPreviewDto';
import type { CountryDetailDto } from './CountryDetailDto';
import { CountryPreview } from '../models/CountryPreview';
import { CountryDetail } from '../models/CountryDetail';

export class CountryMapper {
  public static fromCountryPreviewDto(dto: CountryPreviewDto): CountryPreview {
    return new CountryPreview(dto);
  }

  public static fromCountryPreviewDtoArray(dtos: CountryPreviewDto[]): CountryPreview[] {
    return dtos.map(dto => this.fromCountryPreviewDto(dto));
  }

  public static fromCountryDetailDto(dto: CountryDetailDto): CountryDetail {
    return new CountryDetail(dto);
  }
}
