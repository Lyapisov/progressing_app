import {Observable} from 'rxjs';
import { map } from 'rxjs/operators';
import { AuthToken } from './auth-token';
import {Inject, Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";

@Injectable({
  providedIn: 'root'
})

export class TokenService {

  constructor(
    private httpClient: HttpClient,
    @Inject('apiUrl') private apiUrl: string
  ) {
  }

  public login(
    loginValue: string,
    passwordValue: string
  ): Observable<AuthToken> {
    const url = `${this.apiUrl}/api/token`;

    const requestBody: any = {
      grant_type: 'password',
      username: loginValue,
      password: passwordValue,
      client_id: 'web',
      client_secret: 'secret'
    };

    return this.httpClient.post(url, requestBody).pipe(
      map((response: {
            token_type: string;
            expires_in: number;
            access_token: string;
            refresh_token: string;
          }
        ) => {
        return new AuthToken(
          response.token_type,
          response.expires_in,
          response.access_token,
          response.refresh_token,
        );
      })
    )
  };

  public refresh(refreshToken: string): Observable<AuthToken>
  {
    const url = `${this.apiUrl}/api/token`;

    const requestBody: any = {
      grant_type: 'refresh_token',
      refresh_token: refreshToken,
      client_id: 'web',
      client_secret: 'secret'
    };

    return this.httpClient.post(url, requestBody).pipe(
      map((response: {
             token_type: string;
             expires_in: number;
             access_token: string;
             refresh_token: string;
           }
      ) => {
        return new AuthToken(
          response.token_type,
          response.expires_in,
          response.access_token,
          response.refresh_token,
        );
      })
    )
  }
}
