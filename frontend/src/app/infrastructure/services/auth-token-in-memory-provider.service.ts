import { Injectable } from '@angular/core';
import {AuthTokenProviderService} from './auth-token-provider.service';
import {AuthToken} from "../../application/login/auth-token";
import {RefreshHandlerService} from "../../application/login/refresh-handler.service";

@Injectable({
  providedIn: 'root'
})

export class AuthTokenInMemoryProviderService extends AuthTokenProviderService {
  private token: AuthToken|null = null;
  private isAuthorized: boolean = false;

  constructor(
    private refreshHandler: RefreshHandlerService,
  ) {
    super();
  }

  async setToken(authToken: AuthToken): Promise<void> {
    const lifeTime = authToken.expiresIn * 1000;
    const loginDate = new Date();
    const expirationDate = new Date(loginDate.getTime() + lifeTime);

    this.token = authToken;

    // localStorage.setItem('accessToken', authToken.accessToken);
    // localStorage.setItem('refreshToken', authToken.refreshToken);

    const timeout = setTimeout(async () => {
      await this.refreshToken()
      clearTimeout(timeout)
    }, expirationDate.getTime() - loginDate.getTime())

    this.isAuthorized = true;
  }

  public getToken(): string|null {
    // return localStorage.getItem('accessToken');
    if (!this.isAuthorized) return null;
    return `${this.token.type} ${this.token.accessToken}`;
  }

  private async refreshToken(): Promise<void> {
    if (!this.isAuthorized) return;

    this.refreshHandler.execute(this.token.refreshToken)
      .subscribe((authToken: AuthToken) =>
      {
        const lifeTime = authToken.expiresIn * 1000;
        const loginDate = new Date();
        const expirationDate = new Date(loginDate.getTime() + lifeTime);

        this.token = authToken;

        const timeout = setTimeout(async () => {
          await this.refreshToken()
          clearTimeout(timeout)
        }, expirationDate.getTime() - loginDate.getTime())

        this.isAuthorized = true;
      });
  }

  public logout() {
    this.token = null;
    this.isAuthorized = false;
  }
}
