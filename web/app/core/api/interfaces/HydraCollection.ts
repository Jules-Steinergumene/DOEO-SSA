export interface HydraView {
  '@id': string;
  '@type': string;
  'hydra:first'?: string;
  'hydra:last'?: string;
  'hydra:next'?: string;
  'hydra:previous'?: string;
}

export interface HydraCollection<T> {
  '@context': string;
  '@id': string;
  '@type': string;
  member: T[];
  totalItems: number;
  view?: HydraView;
}
