interface QueryParameters {
  [key: string]: string | number | boolean | undefined;
}

interface AuthenticationHeaders {
  [key: string]: string;
}

export abstract class ApiConnector {
  protected readonly baseUrl = 'https://localhost/api';

  protected async call(
    endpoint: string,
    options: RequestInit,
    queryParameters: QueryParameters = {}
  ): Promise<any> {
    const url = this.buildUrl(endpoint, queryParameters);
    const headers = await this.getAuthenticationHeaders();
    
         const requestOptions: RequestInit = {
       ...options,
       headers: {
         'Accept': 'application/ld+json',
         ...headers,
         ...options.headers
       }
     };
    
    const response = await fetch(url, requestOptions);

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    // Pour DELETE, pas de JSON à retourner
    if (options.method === 'DELETE') {
      return;
    }

    return await response.json();
  }

  protected async getData(
    endpoint: string,
    queryParameters: QueryParameters = {},
    abortSignal?: AbortSignal
  ): Promise<any> {
    return this.call(endpoint, { method: 'GET', signal: abortSignal }, queryParameters);
  }

     protected async postData(
     endpoint: string,
     data: any,
     abortSignal?: AbortSignal
   ): Promise<any> {
     return this.call(endpoint, {
       method: 'POST',
       headers: {
         'Content-Type': 'application/ld+json'
       },
       body: JSON.stringify(data),
       signal: abortSignal
     });
   }

  private buildUrl(endpoint: string, queryParameters: QueryParameters = {}): string {
    // Supprimer le slash initial de l'endpoint s'il existe pour éviter de remplacer le chemin complet
    const cleanEndpoint = endpoint.startsWith('/') ? endpoint.slice(1) : endpoint;
    const url = new URL(cleanEndpoint, this.baseUrl + '/');
    
    Object.entries(queryParameters).forEach(([key, value]) => {
      if (value !== undefined) {
        url.searchParams.append(key, String(value));
      }
    });
    
    return url.toString();
  }

  protected async getAuthenticationHeaders(): Promise<AuthenticationHeaders> {
    // TODO Mettre en palce un systeme d'authentification
    return {};
  }
}