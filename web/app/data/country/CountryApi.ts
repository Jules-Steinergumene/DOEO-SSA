
import { CountryPreview } from './models/CountryPreview';
import { CountryDetail } from './models/CountryDetail';
import { CountryMapper } from './dtos/CountryMapper';
import type { HydraCollection } from '~/core/api/interfaces/HydraCollection';
import type { CountryPreviewDto } from './dtos/CountryPreviewDto';
import type { CountryDetailDto } from './dtos/CountryDetailDto';
import { ApiConnector } from '~/core/api/service/ApiConnector';
import type { PaginatedData } from '~/core/api/interfaces/PaginatedData';

export class CountryApi extends ApiConnector {
  private readonly baseEndpoint = 'countries';

  public async getCountries(page: number = 1, limit: number = 30): Promise<PaginatedData<CountryPreview>> {
    const queryParameters = {
      page: page - 1,
      limit
    };
    
    const response: HydraCollection<CountryPreviewDto> = await this.getData(this.baseEndpoint, queryParameters);
    
    const countries = CountryMapper.fromCountryPreviewDtoArray(response.member);
    const totalItems = response.totalItems;
    const view = response.view;
    const totalPages = Math.ceil(totalItems / limit);
    
    return {
      data: countries,
      pagination: {
        page,
        limit,
        totalItems,
        totalPages,
        hasNext: !!view?.['hydra:next'],
        hasPrevious: !!view?.['hydra:previous']
      }
    };
  }

  public async getCountry(id: number): Promise<CountryPreview> {
    const response = await this.getData(`${this.baseEndpoint}/${id}`);
    const dto: CountryPreviewDto = response;
    return CountryMapper.fromCountryPreviewDto(dto);
  }

  public async getCountryDetail(id: number): Promise<CountryDetail> {
    const response = await this.getData(`${this.baseEndpoint}/${id}`);
    const dto: CountryDetailDto = response;
    return CountryMapper.fromCountryDetailDto(dto);
  }
}
