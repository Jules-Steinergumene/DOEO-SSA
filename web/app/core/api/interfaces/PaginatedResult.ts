export interface PaginatedResult<T> {
  items: T[];
  totalItems: number;
  hasNext: boolean;
  hasPrevious: boolean;
  currentPage: number;
  totalPages: number;
  itemsPerPage: number;
}
